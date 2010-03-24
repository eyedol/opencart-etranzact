<?php
class ControllerPaymentEtranzact extends Controller {
    protected function index() {
        //get the buttons at the checkout pages
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['button_back'] = $this->language->get('button_back');
        $this->load->model('checkout/order');
        
        //get order id
        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        
        // etranzact requires a terminal id, get it from the settings page
        $this->data['terminal_id'] = $this->config->get('etranzact_terminal_id');
        

        //load the encryption library. good practice to encrypts values passed via GET
        $this->load->library('encryption');

        $encryption = new Encryption($this->config->get('config_encryption'));

        $this->data['response_url'] = HTTP_SERVER . 'index.php?route=payment/etranzact/callback&oid='.base64_encode($encryption->encrypt($order_info['order_id'])).'&conf='. base64_encode($encryption->encrypt($order_info['payment_firstname'].$order_info['payment_lastname']));
        $this->data['transaction_id'] = $order_info['order_id'];

        // reference 
        if ($this->config->get('paymate_include_order')) {
	    $this->data['ref'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . " (#" . $order_info['order_id'] . ")";
	} else {
	    $this->data['ref'] = html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
	}


        $this->data['amount'] = $order_info['total']; 
        
        //now here lets check if its a demo server
        if( $this->config->get('etranzact_test')) {
            $this->data['action'] = 'http://demo.etranzact.com/WebConnect/
';
        }else {
            $this->data['action'] = 'https://www.etranzact.net
';        
        }

        $this->data['pmt_contact_firstname'] = html_entity_decode($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8');
	$this->data['pmt_contact_surname'] = html_entity_decode($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8');
	$this->data['pmt_contact_phone'] = $order_info['telephone'];
	$this->data['pmt_sender_email'] = $order_info['email'];
	$this->data['regindi_address1'] = html_entity_decode($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8');
	$this->data['regindi_address2'] = html_entity_decode($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8');
	$this->data['regindi_sub'] = html_entity_decode($order_info['payment_city'], ENT_QUOTES, 'UTF-8');
	$this->data['regindi_state'] = html_entity_decode($order_info['payment_zone'], ENT_QUOTES, 'UTF-8');
        $this->data['regindi_pcode'] = html_entity_decode($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8');
        
	$this->data['pmt_country'] = $order_info['payment_iso_code_2'];

       
        $this->data['back'] =  HTTP_SERVER . 'index.php?route=checkout/payment';

        $this->id = 'payment';

        // check if etranzact template file exists
        if( file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/etranzact.tpl')) {
            $this->template = $this->config->get('config_template').'/template/payment/etranzact.tpl';
        
        }else {
            $this->template = 'default/template/payment/etranzact.tpl';
        }

        $this->render();

    }

    /**
     * Callback function when transaction is complete
     */
    public function callback() {
        $this->load->language('payment/etranzact');

        $error = '';

        if( isset($this->request->post['SUCCESS'])) {
            if( $this->request->post['SUCCESS'] == 0 ) {
                if( $this->request->get['oid'] && isset($this->request->get['conf'])) {
                    $this->load->model('checkout/order');
                    $this->load->library('encryption');
					
		    $encryption = new Encryption($this->config->get('config_encryption'));

		    $order_id = $encryption->decrypt(base64_decode($this->request->get['oid']));

		    $this->load->model('checkout/order');
					
                    $order_info = $this->model_checkout_order->getOrder($order_id);

                    if((isset($order_info['payment_firstname']) && isset($order_info['payment_lastname'])) && strcmp($encryption->decrypt(base64_decode($this->request->get['conf'])),$order_info['payment_firstname'] . $order_info['payment_lastname']) == 0) {
		        $this->model_checkout_order->confirm($order_id, $this->config->get('etranzact_order_status_id'));
		    } else {
		        $error = $this->language->get('text_unable');
		    }


                }else {
                    $error = $this->language->get('text_unable');
                }
            } else {
                $error = $this->language->get('text_declined');
            }
        } else{
            $error = $this->language->get('text_unable');
        }

        if( $error != '' ) {
            $this->data['heading_title'] = $this->language->get('text_failed');
            $this->data['text_message'] = sprintf($this->language->get('text_failed_message'), $error, HTTP_SERVER . 'index.php?route=information/contact');
            $this->data['button_continue'] = $this->language->get('button_continue');
            $this->data['continue'] = HTTP_SERVER . 'index.php?route=common/home';
            $this->template = $this->config->get('config_template'). '/template/common/success.tpl';
            $this->response->setOutput($this->render(TRUE),$this->config->get('config_compression'));

        } else {
            $this->redirect(HTTP_SERVER . 'index.php?route=checkout/success');
        }

    }
}
?>
