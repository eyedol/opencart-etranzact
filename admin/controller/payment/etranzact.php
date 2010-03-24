<?php 
class ControllerPaymentEtranzact extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/etranzact');

		$this->document->title = $this->language->get('heading_title');
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('etranzact', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment');
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
	        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
	
		$this->data['entry_terminal_id'] = $this->language->get('entry_terminal_id');
                $this->data['entry_test'] = $this->language->get('entry_test');
                $this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');

		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['terminal_id'])) { 
			$this->data['error_terminal_id'] = $this->error['terminal_id'];
		} else {
			$this->data['error_terminal_id'] = '';
		}
		
		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTP_SERVER . 'index.php?route=common/home',
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTP_SERVER . 'index.php?route=extension/payment',
       		'text'      => $this->language->get('text_payment'),
      		'separator' => ' :: '
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTP_SERVER . 'index.php?route=payment/etranzact',
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = HTTP_SERVER . 'index.php?route=payment/etranzact';
		
		$this->data['cancel'] = HTTP_SERVER . 'index.php?route=extension/payment';

		if (isset($this->request->post['etranzact_terminal_id'])) {
			$this->data['etranzact_terminal_id'] = $this->request->post['etranzact_terminal_id'];
		} else {
			$this->data['etranzact_terminal_id'] = $this->config->get('etranzact_terminal_id');
		}
				
		if (isset($this->request->post['etranzact_test'])) {
			$this->data['etranzact_test'] = $this->request->post['etranzact_test'];
		} else {
			$this->data['etranzact_test'] = $this->config->get('etranzact_test');
		}
		
		if (isset($this->request->post['etranzact_order_status_id'])) {
			$this->data['etranzact_order_status_id'] = $this->request->post['etranzact_order_status_id'];
		} else {
			$this->data['etranzact_order_status_id'] = $this->config->get('etranzact_order_status_id');
                }

                if (isset($this->request->post['etranzact_geo_zone_id'])) {
			$this->data['etranzact_geo_zone_id'] = $this->request->post['etranzact_geo_zone_id'];
		} else {
			$this->data['etranzact_geo_zone_id'] = $this->config->get('etranzact_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
                $this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

                	if (isset($this->request->post['etranzact_status'])) {
			$this->data['etranzact_status'] = $this->request->post['etranzact_status'];
		} else {
			$this->data['etranzact_status'] = $this->config->get('etranzact_status');
		}
		
		if (isset($this->request->post['etranzact_sort_order'])) {
			$this->data['etranzact_sort_order'] = $this->request->post['etranzact_sort_order'];
		} else {
			$this->data['etranzact_sort_order'] = $this->config->get('etranzact_sort_order');
		}



                $this->load->model('localisation/order_status');
                $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->id       = 'content';
		$this->template = 'payment/etranzact.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
 		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/etranzact')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['etranzact_terminal_id']) {
			$this->error['terminal_id'] = $this->language->get('error_terminal_id');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>
