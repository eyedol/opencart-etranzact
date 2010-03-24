<form action="<?php echo str_replace('&', '&amp;', $action); ?>" method="post" id="checkout">
  <input type="hidden" name="TERMINAL_ID" value="<?php echo $terminal_id; ?>" />
  <input type="hidden" name="AMOUNT" value="<?php echo $amount; ?>" />
  <input type="hidden" name="RESPONSE_URL" value="<?php echo $response_url; ?>" />
  <input type="hidden" name="TRANSACTION_ID" value="<?php echo $transaction_id;?>" />
  <input type="hidden" name="DESCRIPTION" value="<?php echo $ref;?>" />
  <input type="hidden" name="LOGO_URL" value="http://shop.agbena.com/themes/agbena/logo.png" />
  <input type="hidden" name="ref" value="<?php echo $ref; ?>" />
  <input type="hidden" name="pmt_sender_email" value="<?php echo $pmt_sender_email; ?>" />
  <input type="hidden" name="pmt_contact_firstname" value="<?php echo $pmt_contact_firstname; ?>" />
  <input type="hidden" name="pmt_contact_surname" value="<?php echo $pmt_contact_surname; ?>" />
  <input type="hidden" name="pmt_contact_phone" value="<?php echo $pmt_contact_phone; ?>" />
  <input type="hidden" name="pmt_country" value="<?php echo $pmt_country; ?>" />
  <input type="hidden" name="regindi_address1" value="<?php echo $regindi_address1; ?>" />
  <input type="hidden" name="regindi_address2" value="<?php echo $regindi_address2; ?>" />
  <input type="hidden" name="regindi_sub" value="<?php echo $regindi_sub; ?>" />
  <input type="hidden" name="regindi_state" value="<?php echo $regindi_state; ?>" />
  <input type="hidden" name="regindi_pcode" value="<?php echo $regindi_pcode; ?>" />
  <input type="hidden" name="return" value="<?php echo $return; ?>" />

  </form>
<div class="buttons">
  <table>
    <tr>
      <td align="left"><a onclick="location = '<?php echo str_replace('&', '&amp;', $back); ?>'" class="button"><span><?php echo $button_back; ?></span></a></td>
      <td align="right"><a onclick="$('#checkout').submit();" class="button"><span><?php echo $button_confirm; ?></span></a></td>
    </tr>
  </table>
</div>