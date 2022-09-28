<?php if (APGPAY_PAYMENT_METHOD == 'iframe') { ?>
    <table class="table table-bordered" width="95%">
        <tr>
            <td height="350"><?php echo Apgpay_Front_Core::request($apgpay_params);?></td>
        </tr>
    </table>
    <script type="text/javascript">apgpay_iframe_submit();</script>
<?php } else { ?>
  <div class="buttons">
    <div class="right">
      <?php
        $apgpay_button = '<input type="submit" class="btn btn-primary" data-loading-text="Loading..." id="button-payment-apgpay" value="' . $button_confirm . '"/>';
        Apgpay_Front_Core::button($apgpay_button);
        echo Apgpay_Front_Core::request($apgpay_params);
      ?>
    </div>
  </div>
<?php } ?>