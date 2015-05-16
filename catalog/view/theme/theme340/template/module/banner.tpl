<div id="banner<?php echo $module; ?>" class="banner row">
    <div class="col-sm-4" style="height: 284px;">
        <div class="static-block green" id="supported-zipcodes">
            <span><br>DELIVERY SUPPORTED ZIPCODES</span>
            
        </div>            
    </div>
    <div class="col-sm-4" style="height: 284px;">
        <div class="static-block blue" id="free-shipping">
            <span><br>FREE SHIPPING </span>
            <div class="inr-div">
            <div>ON ORDERS OVER <?php echo $fs_order_amount; ?></div>
            <div>PLACE ORDER BEFORE <?php echo $place_order_before; ?></div>
            </div>
        </div>            
    </div>
    <div class="col-sm-4" style="height: 284px;">
        <div class="static-block grey" id="reward-points">
            <span><br>ONE REWARD POINT</span>
            <div class="inr-div">
            <div>ON EVERY PURCHASE OF 10$</div>
            </div>
        </div>            
    </div>
    <div class="clear" style="height:10px;"></div>
  <?php foreach ($banners as $banner) { ?>
  <?php if ($banner['link']) { ?>
  <div class="col-sm-4"><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /><div class="s-desc"><?php echo $banner['description']; ?></div></a></div>
  <?php } else { ?>
  <div class="col-sm-4"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /><div class="s-desc"><?php echo $banner['description']; ?></div></div>
  <?php } ?>
  <?php } ?>
</div>
