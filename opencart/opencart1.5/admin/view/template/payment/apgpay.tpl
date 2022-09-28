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
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><span class="required">*</span> <?php echo $entry_apgpay_title; ?></td>
                        <td><input type="text" name="apgpay_title" value="<?php echo $apgpay_title; ?>" />
                            <?php if ($error_apgpay_title) { ?>
                            <span class="error"><?php echo $error_apgpay_title; ?></span>
                            <?php } ?></td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> <?php echo $entry_apgpay_merchant_id; ?></td>
                        <td><input type="text" name="apgpay_merchant_id" value="<?php echo $apgpay_merchant_id; ?>" />
                            <?php if ($error_apgpay_merchant_id) { ?>
                            <span class="error"><?php echo $error_apgpay_merchant_id; ?></span>
                            <?php } ?></td>
                    </tr>
                    <tr>
                        <td><span class="required">*</span> <?php echo $entry_apgpay_private_key; ?></td>
                        <td><input type="text" name="apgpay_private_key" value="<?php echo $apgpay_private_key; ?>" />
                            <?php if ($error_apgpay_private_key) { ?>
                            <span class="error"><?php echo $error_apgpay_private_key; ?></span>
                            <?php } ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_mode; ?></td>
                        <td>
                            <select name="apgpay_mode" id="input-apgpay_mode" class="form-control">
                                <?php if ($apgpay_mode == 'Test') { ?>
                                <option value="Test" selected="selected"><?php echo $text_test; ?></option>
                                <option value="Live"><?php echo $text_live; ?></option>
                                <?php } else { ?>
                                <option value="Test"><?php echo $text_test; ?></option>
                                <option value="Live" selected="selected"><?php echo $text_live; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_payment_method; ?></td>
                        <td>
                            <select name="apgpay_payment_method" id="input-apgpay_payment_method" class="form-control">
                                <?php if ($apgpay_payment_method == 'iframe') { ?>
                                <option value="iframe" selected="selected"><?php echo $text_iframe ?></option>
                                <option value="redirect"><?php echo $text_redirect ?></option>
                                <?php } else { ?>
                                <option value="iframe"><?php echo $text_iframe ?></option>
                                <option value="redirect" selected="selected"><?php echo $text_redirect ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_order_status_id; ?></td>
                        <td>
                            <select name="apgpay_order_status_id" id="input-apgpay_order_status_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $apgpay_order_status_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_order_status_processing_id; ?></td>
                        <td>
                            <select name="apgpay_order_status_processing_id" id="input-apgpay_order_status_processing_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $apgpay_order_status_processing_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_order_status_fail_id; ?></td>
                        <td>
                            <select name="apgpay_order_status_fail_id" id="input-apgpay_order_status_fail_id" class="form-control">
                                <?php foreach ($order_statuses as $order_status) { ?>
                                <?php if ($order_status['order_status_id'] == $apgpay_order_status_fail_id) { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order; ?></td>
                        <td>
                            <input type="text" name="apgpay_sort_order" value="<?php echo $apgpay_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-apgpay_sort_order" class="form-control" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_status; ?></td>
                        <td>
                            <select name="apgpay_status" id="input-apgpay_status" class="form-control">
                                <?php if ($apgpay_status == 'Active') { ?>
                                <option value="Active" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="Disable"><?php echo $text_disabled; ?></option>
                                <?php } else { ?>
                                <option value="Active"><?php echo $text_enabled; ?></option>
                                <option value="Disable" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_style_layout; ?></td>
                        <td>
                            <select name="apgpay_style_layout" id="input-apgpay_style_layout" class="form-control">
                                <?php if (empty($apgpay_style_layout) || $apgpay_style_layout == $text_vertical) { ?>
                                <option value="<?php echo $text_vertical;?>" selected="selected"><?php echo $text_vertical; ?></option>
                                <option value="<?php echo $text_horizontal;?>"><?php echo $text_horizontal; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $text_vertical;?>"><?php echo $text_vertical; ?></option>
                                <option value="<?php echo $text_horizontal;?>" selected="selected"><?php echo $text_horizontal; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_style_body; ?></td>
                        <td>
                            <input type="text" name="apgpay_style_body" value="<?php echo $apgpay_style_body ?>" class="form-control" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_style_title; ?></td>
                        <td>
                            <input type="text" name="apgpay_style_title" value="<?php echo $apgpay_style_title ?>" class="form-control" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_apgpay_style_button; ?></td>
                        <td>
                            <input type="text" name="apgpay_style_button" value="<?php echo $apgpay_style_button ?>" class="form-control" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>