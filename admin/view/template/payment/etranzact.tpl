<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('view/image/payment.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_terminal_id; ?></td>
          <td><input type="text" name="etranzact_terminal_id" value="<?php echo $etranzact_terminal_id; ?>" />
            <?php if ($error_terminal_id) { ?>
            <span class="error"><?php echo $error_terminal_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_test; ?></td>
          <td><?php if ($etranzact_test) { ?>
            <input type="radio" name="etranzact_test" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="etranzact_test" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="etranzact_test" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="etranzact_test" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_geo_zone; ?></td>
          <td><select name="etranzact_geo_zone_id">
              <option value="0"><?php echo $text_all_zones; ?></option>
              <?php foreach ($geo_zones as $geo_zone) { ?>
              <?php if ($geo_zone['geo_zone_id'] == $etranzact_geo_zone_id) { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="etranzact_status">
              <?php if ($etranzact_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_sort_order; ?></td>
          <td><input type="text" name="etranzact_sort_order" value="<?php echo $etranzact_sort_order; ?>" size="1" /></td>
        </tr>

      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>
