<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($error_warning) { ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="success"><?php echo $success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">

                <table class="form">
                    <tr>
                        <td><span class="required">*</span><?php echo $entry_zipcode; ?></td>
                        <td><input type="text" name="zipcode" value="<?php echo $zipcode; ?>" />
                            <?php if(isset($zipcode_required) && $zipcode_required) { ?>
                            <span class="error"><?php echo $zipcode_required; ?></span>
                            <?php } ?>
                            <?php if(isset($id) && !empty($id)) { ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td><?php if($status == 1) { ?>
                            <input type="checkbox" name="status" checked id="input-status" class="form-control" />
                            <?php }else { ?>
                            <input type="checkbox" name="status" id="input-status" class="form-control" />
                            <?php } ?></td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
</div>