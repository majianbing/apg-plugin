<?php

/**
 * apgpay_core.php.
 *
 * @author zhuna<zhuna@yonyou.com>
 * @date   15/12/23
 */
class Apgpay_Admin_Core
{
    static $field = array(
        'APGPAY_MERCHANT_ID',
        'APGPAY_PRIVATE_KEY',
        'APGPAY_STYLE_TITLE',
        'APGPAY_STYLE_BUTTON',
        'APGPAY_STYLE_LAYOUT',
        'APGPAY_STYLE_BODY',
        'APGPAY_MODE',
        'APGPAY_PAYMENT_METHOD',
        'APGPAY_STATUS',
        'APGPAY_ORDER_STATUS_ID',
        'APGPAY_ORDER_STATUS_FAIL_ID',
        'APGPAY_ORDER_STATUS_PROCESSING_ID'
    );

    public static function initConfig($config)
    {
        foreach ($config as $key => $row) {
            if (in_array($key, self::$field)) {
                defined($key) || define($key, $row);
            }
        }
    }
}