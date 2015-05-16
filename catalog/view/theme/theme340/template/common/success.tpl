<?php echo $header; ?>
<?php echo $column_left; ?>
		<div class="<?php if ($column_left or $column_right) { ?>col-sm-9<?php } ?> <?php if (!$column_left & !$column_left) { ?>col-sm-12  <?php } ?> <?php if ($column_left & $column_right) { ?>col-sm-6<?php } ?>" id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <div><?php echo $email_confirmation; ?></div>
  <div class="box-container">
      <br>
      <table class="list table table-bordered">
          <thead>
              <tr>
                  <td class="left" colspan="2">Order Details</td>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td class="left" style="width: 50%;">
                      <b>Order ID:</b>
                      #<?php echo $order_info['order_id']; ?>
                      <br>
                      <b>Order Placed On:</b>
                      <?php echo date('d/m/Y', strtotime($order_info['date_added'])); ?>
                  </td>
                  <td class="left" style="width: 50%;">
                      <b>Payment Method:</b>
                      <?php echo $order_info['payment_method']; ?>
                      <br>
                      <!--<b>Shipping Method:</b>
                      <?php echo $order_info['shipping_method']; ?>-->
                      <b>Estimated Delivery Date:</b>
                      <?php echo date('d/m/Y', strtotime($order_info['estimated_delivery_date'])); ?>
                  </td>
              </tr>
          </tbody>
      </table>
      <table class="list table table-bordered">
          <thead>
              <tr>
                  <!--<td class="left">Payment Address</td>-->
                  <td class="left">Shipping Address</td>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td class="left">
                      <?php
                      echo $order_info['shipping_firstname']." ".$order_info['shipping_lastname'].'<br>';
                      echo $order_info['shipping_address_1'].'<br>';
                      echo $order_info['shipping_city']." ".$order_info['shipping_poctcode'].'<br>';
                      echo $order_info['shipping_zone'].'<br>';
                      echo $order_info['shipping_country'].'<br>';
                      ?>
                  </td>
                  <!--<td class="left"></td>-->
              </tr>
          </tbody>
      </table>
      <table class="list table table-bordered">
          <thead>
              <tr>
                  <td class="left">Product Name</td>
                  <!--<td class="left">Model</td>-->
                  <td class="right">Quantity</td>
                  <td class="right">Price</td>
                  <td class="right">Total</td>                  
              </tr>
          </thead>
          <tbody>
              <?php foreach($products as $product) { ?>
              <tr>
                  <td class="left"><?php echo $product['name']; ?> </td>
                  <td class="right"><?php echo $product['quantity']; ?> </td>
                  <td class="right"><?php echo $product['price']; ?> </td>
                  <td class="right"><?php echo $product['total']; ?> </td>
              </tr>
              <?php } ?>
          </tbody>
          <tfoot>
              <?php foreach($totals as $total) { ?>
              <tr>
                  <td colspan="2"></td>
                  <td class="right"><b><?php echo $total['title']; ?></b></td>
                  <td class="right"><b><?php echo $total['text']; ?></b></td>
              </tr>
              <?php } ?>
          </tfoot>
      </table>
      </div>
    <!--<?php echo $text_message; ?>
    <div class="buttons">
      <div class="right"><a href="<?php echo $continue; ?>" class="button"><span><?php echo $button_continue; ?></span></a></div>
    </div>-->
  </div>
  <?php echo $content_bottom; ?></div>

<?php echo $column_right; ?>

<?php echo $footer; ?>