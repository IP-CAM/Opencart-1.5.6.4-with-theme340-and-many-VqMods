<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($shipping_methods) { 
if(!empty($shipping_method_msg)) { ?>
<div class="shipping-method-msg"><?php echo $shipping_method_msg; ?></div>
<?php } ?>
<?php if(count($shipping_methods) > 1) { ?>
<p><?php echo $text_shipping_method; ?></p>
<?php } ?>
	<div>
		
	</div>

  <?php foreach ($shipping_methods as $shipping_method) { ?>
	<div><b><?php echo $shipping_method['title']; ?></b></div>
  <?php if (!$shipping_method['error']) { ?>
  <?php foreach ($shipping_method['quote'] as $quote) { ?>
  <div class="highlight">
	<label class="radio" for="<?php echo $quote['code']; ?>"><?php echo $quote['title']; ?>
		<?php if ($quote['code'] == $code || !$code) { ?>
	  <?php $code = $quote['code']; ?>
          <?php if(count($shipping_methods) > 1) { ?>
	  <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" />
          <?php } else { ?>
          <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" style="display:none;"/>
          <?php }?>
	  <?php } else { ?>
          <?php if(count($shipping_methods) > 1) { ?>
	  <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" />
          <?php } else { ?>
          <input type="radio" name="shipping_method" value="<?php echo $quote['code']; ?>" id="<?php echo $quote['code']; ?>" checked="checked" style="display:none;"/>
          <?php } ?>
	  <?php } ?>
	  <span for="<?php echo $quote['code']; ?>"><?php echo $quote['text']; ?></span>
	</label>
	
  </div>
  <?php } ?>
  <?php } else { ?>
  <div>
	<div><div class="error"><?php echo $shipping_method['error']; ?></div></div>
  </div>
  <?php } ?>
  <?php } ?>

<br />
<?php } ?>
<label><?php echo $text_comments; ?></label>
<textarea name="comment" rows="8" style="width: 93%;"><?php echo $comment; ?></textarea>
<br />
<br />
<div class="buttons">
  <div class="right">
	<a id="button-shipping-method" class="button-cont-right fright" ><?php echo $button_continue; ?><i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
