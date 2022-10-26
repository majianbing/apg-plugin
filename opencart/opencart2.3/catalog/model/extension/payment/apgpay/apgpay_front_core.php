<?php

/**
 * apgpay_core.php.
 *
 * @author zhuna<zhuna@yonyou.com>
 * @date   15/12/23
 */
class Apgpay_Front_Core
{
    // request host
    const APGPAY_REDIRECT_URL_PROD = 'https://test.next-api.com/payment/page/v4/pay';
    const APGPAY_REDIRECT_URL_TEST = 'https://test.next-api.com/payment/page/v4/pay';
    const APGPAY_IFRAME_URL = 'https://www.apgpay.com/merchant/web/cashier/iframe/before?';

    static $fields = array(
        'product_name',
        'product_quantity',
        'product_price',
        'merchant_id',
        'invoice_id',
        'order_no',
        'merOrderNo',
        'currency',
        'payCurrency',
        'amount',
        'payAmount',
        'return_url',
        'returnUrl',
        'remark',
        'goods',
        'first_name',
        'last_name',
        'address_line',
        'country',
        'state',
        'city',
        'buyer_email',
        'zipcode',
        'shipping_country',
        'hash',
        'sign',
        'body_style',
        'title_style',
        'language',
        'layout',
        'button_style',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_state',
        'shipping_phone',
        'shipping_city',
        'shipping_address_line',
        'shipping_zipcode',
        'shipping_email'
    );

    public static $supportCurrency = array('CAD', 'GBP', 'EUR', 'USD', 'CNY', 'SEK', 'SGD', 'RUB', 'JPY', 'AUD');
    public static $supportLanguage = array('de', 'fr', 'it', 'es', 'pt', 'en');

    public static function show($currency)
    {
        if (APGPAY_STATUS != 'Active' || !in_array($currency, self::$supportCurrency)) {
            return false;
        }
        return true;
    }

    public static function env($params)
    {
        if (APGPAY_MODE == 'Test') {
            $params['env'] = 'apgpaysandbox';
        }
        return $params;
    }

    public static function language($params)
    {
        if (isset($params['language']) && in_array($params['language'], self::$supportLanguage)) {
            return $params;
        }

        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        if (preg_match("/en/i", $lang))
            $strlang = 'en';//英文
        elseif (preg_match("/fr/i", $lang))
            $strlang = 'fr';//法语
        elseif (preg_match("/de/i", $lang))
            $strlang = 'de';//德语
        elseif (preg_match("/ja/i", $lang))
            $strlang = 'ja';//日语
        elseif (preg_match("/ko/i", $lang))
            $strlang = 'en';//'ko-kr';//韩语
        elseif (preg_match("/es/i", $lang))
            $strlang = 'es';//西班牙语
        elseif (preg_match("/it/i", $lang))
            $strlang = 'en';//'it-it';//意大利语
        else
            $strlang = 'en';//英文

        $params['language'] = $strlang;
        return $params;
    }

    public static function account($params)
    {
        $params['merchantNo'] = APGPAY_MERCHANT_ID;
        // 收银台的交易代码
        $params['tranCode'] = "TA002";
        return $params;
    }

    public static function style($params)
    {
        $params['body_style'] = APGPAY_STYLE_BODY;
        $params['layout'] = strtolower(APGPAY_STYLE_LAYOUT);
        $params['button_style'] = APGPAY_STYLE_BUTTON;
        $params['title_style'] = APGPAY_STYLE_TITLE;
        return $params;
    }

    public static function data($data)
    {
        $params = array();
        foreach ($data as $key => $row) {
            if (in_array($key, self::$fields)) {
                switch ($key) {
                    case 'product_price':
                    case 'payAmount':
                        $row = sprintf('%.2f', $row);
                        break;
                    default:
                        $row = self::filter($row);
                }

                $params[$key] = $row;
            }

        }
        $params = self::account($params);
        $params = self::env($params);
        $params = self::language($params);
        $params = self::style($params);
        $params = self::request_hash($params);
        return $params;

    }

    public static function form($data, $url, $method, $target = '_self')
    {

        $params = self::data($data);

        $html = array('<form action="' . $url . '" method="' . $method . '" id="apgpay_payment_form" target="' . $target . '">');
        foreach ($params as $name => $val) {
            $html[] = '<input type="hidden" name="' . $name . '" value="' . $val . '" />';
        }
        $html[] = self::button();
        $html[] = '</form>';
        $html[] = '<script type="text/javascript">function apgpay_iframe_submit(){document.getElementById("apgpay_payment_form").submit()}</script>';
        return join('', $html);
    }

    public static function redirect($data)
    {
        $url = self::APGPAY_REDIRECT_URL_PROD;
        if (APGPAY_MODE == 'Test') {
            $url = self::APGPAY_REDIRECT_URL_TEST;
        }
        return self::form($data, $url, 'post');
    }

    public static function iframe($data, $width = '95%', $height = '95%')
    {
        $html = '<iframe frameborder="0" width="' . $width . '" height="' . $height . '" scrolling="no" name="apgpay_payment_iframe"></iframe>';
        $html .= self::form($data, self::APGPAY_IFRAME_URL, 'get', 'apgpay_payment_iframe');
        return $html;
    }

    public static function request_hash($data)
    {
        $sourcestr_2 = $data['merchantNo'] . $data['merOrderNo'] . $data['payCurrency'] . $data['payAmount'] . $data['returnUrl'] . APGPAY_PRIVATE_KEY;
//        echo $sourcestr_2;
        $hash2 = hash('sha512', $sourcestr_2);
        $data['sign'] = strtolower($hash2);
        return $data;
    }

    public static function response_hash($data)
    {

        $befor_sign = $data['merOrderNo'] .$data['referenceNo'].$data['payCurrency'].$data['respStatus'].APGPAY_PRIVATE_KEY;
        $jmh = hash('sha512', $befor_sign);

        return strtolower($jmh);
    }

    public static function getFormUrl()
    {
        $url = APGPAY_PAYMENT_METHOD == 'Redirect' ? self::APGPAY_REDIRECT_URL : self::APGPAY_IFRAME_URL;
        if (APGPAY_MODE == 'Test') {
            $url .= '?env=apgpaysandbox';
        }
        return $url;
    }

    public static function request($data)
    {
        $method = APGPAY_PAYMENT_METHOD;
        if (method_exists('Apgpay_Front_Core', $method)) {
            return call_user_func_array(array('Apgpay_Front_Core', $method), array($data));
        } else {
            echo 'Payment Method is invalid.';
            exit;
        }
    }

    public static function response($data)
    {
        if ($data['sign'] != self::response_hash($data)) {
            echo "sign failed ";
            return 'fail';
        }

        if ($data['respStatus'] == '1') { // 成功
            return 'success';
        } else if ($data['respStatus'] == '0') { // 失败
            return 'fail';
        } else {
            return 'process';
        }
    }

    public static function filter($str)
    {
        $str = trim($str);
        $str = str_replace("&", "&amp;", $str);
        $str = str_replace("\"", "&quot;", $str);
        $str = str_replace("<", "&lt;", $str);
        $str = str_replace(">", "&gt;", $str);
        $str = str_replace("'", "&#39;", $str);
        return $str;
    }

    public static function button($html = ''){
        static $button = '';
        if ($html){
            $button = $html;
        }
        return $button;
    }
}