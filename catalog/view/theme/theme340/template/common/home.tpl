<?php echo $header; ?>
<?php echo $column_left; ?>
		<div class="<?php if ($column_left or $column_right) { ?>col-sm-9<?php } ?> <?php if (!$column_left & !$column_left) { ?>col-sm-12  <?php } ?> <?php if ($column_left & $column_right) { ?>col-sm-6<?php } ?>" id="content"><?php echo $content_top; ?>
		<h1 style="display: none;"><?php echo $heading_title; ?></h1>
		<?php echo $content_bottom; ?></div>
<?php echo $column_right; ?>
<?php echo $footer; ?>
<div id="home-blocks-popup" class="popup-box">
     <a class="b-close"><i class="fa fa-times-circle"></i></a>
    <div id="zipcode-content">
       <h1>Delivery Supported Zip Codes</h1>   
       <table class="table">
        <thead class="table">
            <tr>
                <td>Sr No.</td>
                <td>Zip Code</td>
            </tr>
        </thead>
        <tbody>
        <?php if($zipcodes) {  
    $inc = 1;
    foreach($zipcodes->rows as $row) { ?>
    <tr>
        <td><?php echo $inc; ?></td>
        <td><?php echo $row['zipcode']; ?></td>
    </tr>              
    <?php $inc++;
      }
    }
    else { ?>
    <tr>
        <td colspan="2">No Zip Codes Available !</td>
    </tr>
    <?php } ?>
        </tbody>
        </table>
    </div>
 <div id="free-shipping-content">
         <?php echo $config_free_shipping_content; ?>
     </div>
    <div id="reward-points-content">zczxcc</div>
</div>
