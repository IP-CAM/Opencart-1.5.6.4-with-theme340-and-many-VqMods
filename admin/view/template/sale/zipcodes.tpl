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
            <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').attr('action', '<?php echo $delete; ?>');
                    $('#form').attr('target', '_self');
                    $('#form').submit();" class="button"><?php echo $button_delete; ?></a></div>
        </div>
        <div class="content">
            <form action="" method="post" enctype="multipart/form-data" id="form">
                <table class="list">
                    <thead>
                        <tr>
                            <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                            <td class="left"><?php echo $entry_zipcode; ?></td>
                            <td class="left"><?php echo $entry_status; ?></td>
                            <td class="left"><?php echo $column_date_created; ?></td>                            
                            <td class="left"><?php echo $column_date_modified; ?></td>
                            <td class="right"><?php echo $column_action; ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="filter">
                            <td></td>
                            <td><input type="text" name="filter_zipcode" value="<?php echo $filter_zipcode; ?>" /></td>
                            <td><input type="text" name="filter_status" value="<?php echo $filter_status; ?>" /></td>
                            <td></td>
                            <td></td>
                            <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
                        </tr>
                        <?php if ($zipcodes) { ?>
                        <?php foreach ($zipcodes as $zipcode) { ?>
                        <tr>
                            <td class="text-center"><?php if (in_array($zipcode['id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $zipcode['id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $zipcode['id']; ?>" />
                                <?php } ?>
                            </td>                           
                            <td class="left"><?php echo $zipcode['zipcode']; ?></td>
                            <td class="left"><?php if($zipcode['status'] == 1) { echo $text_enabled; } else { echo $text_disabled; } ?></td>
                            <td class="left"><?php echo date('d/m/Y',$zipcode['date_created']); ?></td>
                            <td class="left"><?php echo date('d/m/Y',$zipcode['date_modified']); ?></td>
                            <td class="right"><?php foreach ($zipcode['action'] as $action) { ?>
                                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                                <?php } ?></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>

        <div class="pagination"><?php echo $pagination; ?></div>
    </div>
</div>  <script type="text/javascript"><!--
function filter() {
        url = 'index.php?route=sale/zipcodes&token=<?php echo $token; ?>';

        var filter_zipcode = $('input[name=\'filter_zipcode\']').val();

        if (filter_zipcode) {
            url += '&filter_zipcode=' + filter_zipcode;
        }
        var filter_status = $('input[name=\'filter_status\']').val();

        if (filter_status) {
            url += '&filter_status=' + filter_status;
        }
        location = url;
    }
//--></script> 