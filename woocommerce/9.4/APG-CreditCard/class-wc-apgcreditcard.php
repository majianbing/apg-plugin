<?php

use Automattic\WooCommerce\Blocks\Assets\AssetDataRegistry;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * APGpayment CreditCard Payment Gateway
 *
 * Provides a APGpayment CreditCard Payment Gateway, mainly for testing purposes.
 *
 * @class 		WC_Gateway_APGcreditcard
 * @extends		WC_Payment_Gateway
 * @version		1.4
 * @package		WooCommerce/Classes/Payment
 * @author 		APGpayment
 */
class WC_Gateway_APGcreditcard extends WC_Payment_Gateway {

    const SEND			= "[Sent to APGpayment]";
    const PUSH			= "[PUSH]";
    const BrowserReturn	= "[Browser Return]";


    protected $_precisionCurrency = array(
        'BIF','BYR','CLP','CVE','DJF','GNF','ISK','JPY','KMF','KRW',
        'PYG','RWF','UGX','UYI','VND','VUV','XAF','XOF','XPF'
    );


    /**
     * Constructor for the gateway.
     */
    public function __construct() {
        $this->id                 = 'apgcreditcard';
//        $this->icon               = apply_filters('woocommerce_apgcreditcard_icon', plugins_url( 'images/VISA.png', __FILE__ ));
        $this->has_fields         = true;
        $this->method_title       = __( 'APGpayment CreditCard', 'apgpayment-creditcard-gateway' );
        $this->method_description = __( '', 'apgpayment-creditcard-gateway' );
        $this->supports           = [
            'products',
//            'tokenization',
//            'add_payment_method',
        ];

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables
        $this->title        = $this->get_option( 'title' );
        $this->description  = $this->get_option( 'description' );
        $this->instructions = $this->get_option( 'instructions', $this->description );
        $this->enabled      = $this->get_option( 'enabled' );

        $this->Title = $this->get_option('_apgcreditcard_title') ? $this->get_option('_apgcreditcard_title') : '';
        $this->Body = $this->get_option('_apgcreditcard_description') ? $this->get_option('_apgcreditcard_description') : '';

        // Actions
        add_action( 'woocommerce_api_wc_gateway_apgcreditcard', array( $this, 'check_ipn_response' ) );
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
        add_action( 'valid-apgcreditcard-standard-itn-request', array( $this, 'successful_request' ) );
        add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'receipt_page' ) );
        add_action( 'woocommerce_thankyou_apgcreditcard', array( $this, 'thankyou_page' ) );
        add_action( 'woocommerce_api_return_' . $this->id, array( $this, 'return_payment' ) );
        add_action( 'woocommerce_api_notice_' . $this->id, array( $this, 'notice_payment' ) );

        // Customer Emails
        add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );


//        add_action( 'woocommerce_receipt_apgcreditcard', array( $this, 'apgcreditcard_receipt_page' ) );
    }






    function payment_fields() {
        global $woocommerce;


        strpos($this->settings['submiturl'],'test') != false ? $testnote = '<br><span style="color:red">Note: In the test state all transactions are not deducted and cannot be shipped or services provided. The interface needs to be closed in time after the test is completed to avoid consumers from placing orders.</span><br>' : $testnote = '';

        $html_array = array();
        if(!empty($this->settings['logo'])){
            foreach ($this->settings['logo'] as $key => $value){
                $url = 'images/'.$value.'.png';
                $html_array[] = '<img style="height:40px;" src="' . WC_HTTPS::force_https_url( plugins_url($url , __FILE__ ) ) . '" />';
            }
        }
        $html = implode('', $html_array);
        $description = str_replace(array("\r\n","\r","\n"), ' ', $this->description);

        ?>
        <fieldset id='payment-icon'>
            <script>
                document.getElementById('payment-icon').innerHTML='<?php echo '<div class="status-box">'.$description.$testnote.'</div>'.$html ?>';
            </script>
        </fieldset>
        <?php
    }


    /**
     * Initialise Gateway Settings Form Fields
     */
    public function init_form_fields() {

        $this->form_fields = array(
            'enabled' => array(
                'title'   => __( 'Enable/Disable', 'woocommerce' ),
                'type'    => 'checkbox',
                'label'   => __( 'Enable APGpayment Credit Card Payment', 'woocommerce' ),
                'default' => 'yes'
            ),
            'title' => array(
                'title'       => __( 'Title', 'woocommerce' ),
                'type'        => 'text',
                'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
                'default'     => __( 'Credit Card Payment', 'woocommerce' ),
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => __( 'Description', 'woocommerce' ),
                'type'        => 'textarea',
                'css'         => 'width: 400px;',
                'description' => __( 'Payment method description that the customer will see on your checkout.', 'woocommerce' ),
                'default'     => __( '', 'woocommerce' ),
                'desc_tip'    => true,
            ),
            'account' => array(
                'title'       => __( 'Account', 'woocommerce' ),
                'type'        => 'text',
                'description' => __( 'APGpayment\'s Account.', 'woocommerce' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'terminal' => array(
                'title'       => __( 'Terminal', 'woocommerce' ),
                'type'        => 'text',
                'description' => __( 'APGpayment\'s Terminal.', 'woocommerce' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'securecode' => array(
                'title'       => __( 'SecureCode', 'woocommerce' ),
                'type'        => 'text',
                'description' => __( 'APGpayment\'s SecureCode.', 'woocommerce' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'submiturl' => array(
                'title'       => __( 'Submiturl', 'woocommerce' ),
                'type'        => 'select',
                'description' => __( 'Note: In the test state all transactions are not deducted and cannot be shipped or services provided. The interface needs to be closed in time after the test is completed to avoid consumers from placing orders.', 'woocommerce' ),
                'desc_tip'    => true,
                'options'     => array(
                    'https://payment.gloprocessor.com/payment/page/v5/prepay' => __( 'Production', 'woocommerce' ),
                    'https://test-payment.gloprocessor.com/payment/page/v5/prepay'   => __( 'Sandbox', 'woocommerce' ),
                ),
            ),

            'mode' => array(
                'title'       => __( 'Pay page Mode', 'woocommerce' ),
                'type'        => 'select',
                'description' => __( 'Iframe or Redirect', 'woocommerce' ),
                'desc_tip'    => true,
                'options'     => array(
                    'redirect' => __( 'Redirect', 'woocommerce' ),
                    'iframe'   => __( 'Iframe', 'woocommerce' ),
                ),
            ),
            'logo' => array(
                'title' => __('Payment Logos', 'woocommerce'),
                'type' => 'multiselect',
                'description' => __( 'Accept Payment Logos.', 'woocommerce' ),
                'class' => 'chosen_select',
                'css' => 'width: 350px;',

                'options' => array(
                    'VISA' => 'VISA',
                    'Mastercard' => 'Mastercard',
                    'American' => 'American Express',
                    'Discover' => 'Discover',
                    'UnionPay'=>'UnionPay'
                ),
                'default' => array(
                    'VISA',
                    'Mastercard',
                    'American',
                    'Discover',
                    'UnionPay',
                ),
            ),
            'log' => array(
                'title'       => __( 'Write The Logs', 'woocommerce' ),
                'type'        => 'select',
                'description' => __( 'Whether to write logs', 'woocommerce' ),
                'desc_tip'    => true,
                'options'     => array(
                    'true'    => __( 'True', 'woocommerce' ),
                    'false'   => __( 'False', 'woocommerce' ),
                ),
            ),

        );
    }

    /**
     * Add content to the WC emails.
     *
     * @param WC_Order $order Order object.
     * @param bool     $sent_to_admin  Sent to admin.
     * @param bool     $plain_text Email format: plain text or HTML.
     */
    public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
        if ( $this->instructions && ! $sent_to_admin && 'apgcreditcard' === $order->get_payment_method() && $order->has_status( 'on-hold' ) ) {
            echo wp_kses_post( wpautop( wptexturize( $this->instructions ) ) . PHP_EOL );
        }
    }

    /**
     * 跳转到支付url
     */
    public function process_payment( $order_id ) {
        $order = new WC_Order( $order_id );
        return array(
            'result' 	=> 'success',
            'redirect'	=> $order->get_checkout_payment_url( true )
        );


    }



    /**
     * 生成Form表单
     */
    function receipt_page($order) {
        // Get payment URL and redirect
        $payment_url = $this->get_payment_url($order);

        if (is_wp_error($payment_url)) {
            wc_add_notice($payment_url->get_error_message(), 'error');
            wp_redirect(wc_get_checkout_url());
            exit;
        }

        // Redirect to payment URL
        wp_redirect($payment_url);
        exit;
    }

    /**
     * Get payment URL from API
     */
    private function get_payment_url($order_id) {
        $order = wc_get_order($order_id);
        //产品名称
        $productName       = $this->get_product($order,'name');
        //产品数量
        $billing_address   = $order->get_billing_address_1();
        //支付币种
        $order_currency    = $order->get_currency();
        //金额
        $order_amount      = $order->get_total();

        //账户号
        $account           = $this->settings['account'];
        //终端号
        $terminal          = $this->settings['terminal'];
        //securecode
        $securecode        = $this->settings['securecode'];
        //支付方式
        $methods           = 'Credit Card';
        //订单号
        $order_number      = $order_id;
        //返回地址
        $backUrl			= WC()->api_request_url( 'return_' . $this->id );
        //服务器响应地址
        $noticeUrl			= WC()->api_request_url( 'notice_' . $this->id );
        //备注
        $order_notes       = '';
        //账单人名
        if(!empty($order->get_billing_first_name())){
            $billing_firstName = substr($this->ApgHtmlSpecialChars($order->get_billing_first_name()),0,50);
        }elseif(!empty($order->get_billing_last_name())){
            $billing_firstName  = substr($this->ApgHtmlSpecialChars($order->get_billing_last_name()),0,50);
        }else{
            $billing_firstName  = 'N/A';
        }
        //账单人姓
        if(!empty($order->get_billing_last_name())){
            $billing_lastName  = substr($this->ApgHtmlSpecialChars($order->get_billing_last_name()),0,50);
        }elseif(!empty($order->get_billing_first_name())){
            $billing_lastName = substr($this->ApgHtmlSpecialChars($order->get_billing_first_name()),0,50);
        }else{
            $billing_lastName  = 'N/A';
        }
        //账单人email
        $billing_email     = !empty($order->get_billing_email()) ? $order->get_billing_email() : $order_number.'@'.wp_parse_url( home_url(), PHP_URL_HOST );
        //账单人电话
        $billing_phone     = str_replace( array( '(', '-', ' ', ')', '.' ), '', $order->get_billing_phone() );
        //账单人国家
        $billing_country   = !empty($order->get_billing_country()) ? $order->get_billing_country() : 'N/A';
        //账单人州(可不提交)
        $billing_state     = $this->get_creditcard_state( $order->get_billing_country(), $order->get_billing_state() );
        //账单人城市
        $billing_city      = $order->get_billing_city();
        //账单人地址
        $billing_address   = $order->get_billing_address_1();
        //账单人邮编
        $billing_zip       = $order->get_billing_postcode();
        //产品名称
        $productName       = $this->get_product($order,'name');
        //产品数量
        $productNum        = $this->get_product($order,'num');
        //收货人的名
        $ship_firstName	   = empty(substr($this->ApgHtmlSpecialChars($order->get_shipping_first_name()),0,50)) ? $billing_firstName : substr($this->ApgHtmlSpecialChars($order->get_shipping_first_name()),0,50);
        //收货人的姓
        $ship_lastName 	   = empty(substr($this->ApgHtmlSpecialChars($order->get_shipping_last_name()),0,50)) ? $billing_lastName : substr($this->ApgHtmlSpecialChars($order->get_shipping_last_name()),0,50);
        //收货人的电话
        $ship_phone 	   = empty(str_replace( array( '(', '-', ' ', ')', '.' ), '', $order->get_billing_phone())) ? $billing_phone : str_replace( array( '(', '-', ' ', ')', '.' ), '', $order->get_billing_phone());
        //收货人的国家
        $ship_country 	   = empty($order->get_shipping_country()) ? $billing_country : $order->get_shipping_country();
        //收货人的州（省、郡）
        $ship_state 	   = empty($this->get_creditcard_state( $order->get_shipping_country(), $order->get_shipping_state())) ? $billing_state : $this->get_creditcard_state( $order->get_shipping_country(), $order->get_shipping_state());
        //收货人的城市
        $ship_city 		   = empty($order->get_shipping_city()) ? $billing_city : $order->get_shipping_city();
        //收货人的详细地址
        $ship_addr 		   = empty($order->get_shipping_address_1()) ? $billing_address : $order->get_shipping_address_1();
        //收货人的邮编
        $ship_zip 		   = empty($order->get_shipping_postcode()) ? $billing_zip : $order->get_shipping_postcode();
        //收货人email
        $ship_email        = empty($order->get_billing_email()) ? $billing_email : $order->get_billing_email();

        //支付页面样式
        $pages			    = $this->isMobile() ? 1 : 0;
        //网店程序类型
        $isMobile			= $this->isMobile() ? 'Mobile' : 'PC';
        $cart_info			= 'Woocommerce|V1.2.0|'.$isMobile;
        //接口版本
        $cart_api          = 'TA002';

        $order_amount        = $this->formatAmount($order->get_total(), $order->get_currency());
        $goods = array(array(
            'name' => $productName,
            'description' => $productName,
            'price' => $order_amount,
            'num' => $productNum
        ));
        // Prepare request data
        $request_data = array(
            'integration' => "CHECK_OUT",
            'merchantNo' => $account,
            'merOrderNo' => $order_id,
            'payCurrency' => $order->get_currency(),
            'payAmount' => $order_amount,
            'returnUrl' => $backUrl,
            'notifyUrl' => $noticeUrl,
            'firstName' => $ship_firstName,
            'lastName' => $ship_lastName,
            'goods' => $goods,
            'street' => $ship_addr,
            'cityOrTown' => $ship_city,
            'countryOrRegion' => $this->get_country_code_3($ship_country),
            'stateOrProvince' => $ship_state,
            'postCodeOrZip' => $ship_zip,
            'email' => $ship_email,
            'telephone' => $ship_phone,
            'sourceUrl' => rtrim(home_url(), '/'),
            'cartInfo' => $cart_info,
            'pages' => $pages,
            'tranCode' => 'TA002',
            'ip' => '127.0.0.1',
            'remark' => $order_notes,
        );

        // Calculate signature
        $sourcestr_2 = $account . $order_number . $order_currency . $order_amount . $backUrl . $securecode;
        $request_data['sign'] = hash('sha512', $sourcestr_2);
        // Log request if enabled
        if ($this->settings['log'] == 'true') {
            $this->postLog($request_data, self::SEND);
        }

        // Make API request
        $response = wp_remote_post($this->settings['submiturl'], array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ),
            'body' => json_encode($request_data),
            'cookies' => array()
        ));
        // Handle response
        if (is_wp_error($response)) {
            return new WP_Error('api_error', 'Payment gateway API error: ' . $response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        // Log response if enabled
        if ($this->settings['log'] == 'true') {
            $this->postLog($body, '[API Response]');
        }
        if (!isset($body['paymentUrl'])) {
            return new WP_Error('api_error', 'Invalid response from payment gateway. '.$body['respCode'] .'  '. $body['respDesc']);
        }
        return $body['paymentUrl'];
    }


    /**
     * 异步通知
     */
    function notice_payment( $order ) {

            //返回账户
            $account          = $this->settings['account'];
            //返回终端号
            $terminal         = $this->settings['terminal'];
            $securecode         = $this->settings['securecode'];
            //返回APGpayment 的支付唯一号
            $payment_id       = sanitize_text_field($_REQUEST['referenceNo']);
            //返回网站订单号
            $order_number     = sanitize_text_field($_REQUEST['merOrderNo']);
            //返回交易币种
            $order_currency   = sanitize_text_field($_REQUEST['payCurrency']);
            //返回支付金额
            $order_amount     = sanitize_text_field($_REQUEST['payAmount']);
            //返回支付状态
            $payment_status   = sanitize_text_field($_REQUEST['respStatus']);
            //返回详情
            $payment_details  = sanitize_text_field($_REQUEST['respDesc']);

            //返回交易安全签名
            $back_signValue   = sanitize_text_field($_REQUEST['sign']);
            //返回备注
            $order_notes      = sanitize_text_field($_REQUEST['remark']);
            //返回支付信用卡卡号
            $card_number      = sanitize_text_field($_REQUEST['cardBin']) . '****' . sanitize_text_field($_REQUEST['cardLast4']);


            $befor_sign = $order_number . $payment_id. $order_currency.$payment_status.$securecode;
            $jmh = hash('sha512', $befor_sign);
            $local_signValue = strtolower($jmh);
            if($this->settings['log'] === 'true') {
                $this->postLog($_REQUEST, self::BrowserReturn);
            }

            $order = wc_get_order( $order_number );
            $order_id = $order->get_id();
            if ( isset( $payment_id ) ) {
                $order->set_transaction_id( $payment_id );
            }


            strpos($this->settings['submiturl'],'test') != false ? $testorder = 'TEST ORDER - ' : $testorder = '';


            //加密校验
            if(strtoupper($local_signValue) == strtoupper($back_signValue)){

                //支付状态
                if ($payment_status == 1) {
                    //成功
                    $order->update_status( 'processing', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
                    wc_reduce_stock_levels( $order_id );
                    WC()->cart->empty_cart();
                } elseif ($payment_status == -1) {
                    //待处理
                    if(empty($this->completed_orders()) || !in_array($order_number, $this->completed_orders())){
                        $order->update_status( 'on-hold', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
                    }
                } elseif ($payment_status == 0) {
                    //失败
                    if(empty($this->completed_orders()) || !in_array($order_number, $this->completed_orders())){
                        $order->update_status( 'failed', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
                    }
                }

            }else{
                $order->update_status( 'failed', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
            }
            echo "success";
        exit;

    }

    /**
     * 浏览器返回
     */
    function return_payment( $order ) {
        //返回账户
        $account          = $this->settings['account'];
        //返回终端号
        $terminal         = $this->settings['terminal'];
        $securecode         = $this->settings['securecode'];
        //返回APGpayment 的支付唯一号
        $payment_id       = sanitize_text_field($_REQUEST['referenceNo']);
        //返回网站订单号
        $order_number     = sanitize_text_field($_REQUEST['merOrderNo']);
        //返回交易币种
        $order_currency   = sanitize_text_field($_REQUEST['payCurrency']);
        //返回支付金额
        $order_amount     = sanitize_text_field($_REQUEST['payAmount']);
        //返回支付状态
        $payment_status   = sanitize_text_field($_REQUEST['respStatus']);
        //返回详情
        $payment_details  = sanitize_text_field($_REQUEST['respDesc']);

        //返回交易安全签名
        $back_signValue   = sanitize_text_field($_REQUEST['sign']);
        //返回备注
        $order_notes      = sanitize_text_field($_REQUEST['remark']);
        //返回支付信用卡卡号
        $card_number      = sanitize_text_field($_REQUEST['cardBin']) . '****' . sanitize_text_field($_REQUEST['cardLast4']);


        $befor_sign = $order_number . $payment_id. $order_currency.$payment_status.$securecode;
        $jmh = hash('sha512', $befor_sign);
        $local_signValue = strtolower($jmh);
        if($this->settings['log'] === 'true') {
            $this->postLog($_REQUEST, self::BrowserReturn);
        }
 
        $order = wc_get_order( $order_number );
        if ( isset( $payment_id ) ) {
            $order->set_transaction_id( $payment_id );
        }


        strpos($this->settings['submiturl'],'test') != false ? $testorder = 'TEST ORDER - ' : $testorder = '';
        //加密校验
        if(strtoupper($local_signValue) == strtoupper($back_signValue)){

            //支付状态
            if ($payment_status == 1) {
                //成功
                $order->update_status( 'processing', __( $testorder. $payment_details, 'apgpayment-creditcard-gateway' ) );
                WC()->cart->empty_cart();
                $url = $this->get_return_url( $order );
                wc_add_notice( $testorder. $payment_details, 'success' );
            } elseif ($payment_status == -1) {
                //待处理               
                if(empty($this->completed_orders()) || !in_array($_REQUEST['order_number'], $this->completed_orders())){
                    $order->update_status( 'on-hold', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
                }
                $url = $this->get_return_url( $order );
                wc_add_notice( $testorder.$payment_details, 'success' );
            } elseif ($payment_status == 0) {
                //失败
                if(empty($this->completed_orders()) || !in_array($_REQUEST['order_number'], $this->completed_orders())){
                    $order->update_status( 'failed', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
                }
                $url = esc_url( wc_get_checkout_url() );
                wc_add_notice( $testorder.$payment_details, 'error' );
                wc_add_notice( '', 'error' );
            }

        }else{
            $order->update_status( 'failed', __( $testorder.$payment_details, 'apgpayment-creditcard-gateway' ) );
            $url = esc_url( wc_get_checkout_url() );
            wc_add_notice( $testorder.$payment_details, 'error' );
        }


        //页面跳转
        $this->getJslocationreplace($url);
        exit;

    }




    /**
     * thankyou_page
     */
    public function thankyou_page($order_id) {


    }

    /**
     * 是否存在相同订单号
     * @return unknown
     */
    function completed_orders(){

        global $wpdb;

        $query = $wpdb->get_results("
            SELECT *
            FROM {$wpdb->prefix}wc_order_stats
            WHERE status IN ('wc-completed','wc-processing')
            ORDER BY order_id DESC
            ");

        // We format the array by user ID
        $results = [];
        foreach($query as $result){
            $results[] = $result->order_id;
        }

        return $results;
    }


    /**
     * 获取产品信息
     * @param unknown $order
     * @param unknown $sort
     * @return multitype:NULL
     */
    public function get_product($order,$type){
        $product_array = array();
        foreach ($order->get_items() as $item_key => $item ){
            $item_data = $item->get_data();
            $product = $item->get_product();
            if($type == 'num'){
                $item_data['quantity'] != '' ? $product_array[] = substr($item_data['quantity'], 0,50) : $product_array[] = 'N/A';
            }elseif($type == 'sku'){
                $product->get_sku() != '' ? $product_array[] = substr($product->get_sku(), 0,500) : $product_array[] = 'N/A';
            }elseif($type == 'name'){
                $product->get_name() != '' ? $product_array[] = substr($product->get_name(), 0,500) : $product_array[] = 'N/A';
            }
        }
        return implode(';', $product_array);
    }


    /**
     * 获取州/省
     */
    public function get_creditcard_state( $cc, $state ) {
        $iso_cn = ["北京"=>"BJ","天津"=>"TJ","河北"=>"HB","内蒙古"=>"NM","辽宁"=>"LN","黑龙江"=>"HL","上海"=>"SH","浙江"=>"ZJ","安徽"=>"AH","福建"=>"FJ","江西"=>"JX","山东"=>"SD","河南"=>"HA","湖北"=>"HB","湖南"=>"HN","广东"=>"GD","广西"=>"GX","海南"=>"HI","四川"=>"SC","贵州"=>"GZ","云南"=>"YN","西藏"=>"XZ","重庆"=>"CQ","陕西"=>"SN","甘肃"=>"GS","青海"=>"QH","宁夏"=>"NX","新疆"=>"XJ"];
        $states = WC()->countries->get_states( $cc );

        if('CN' === $cc){
            if ( isset( $iso_cn[$states[$state]] ) ) {
                return $iso_cn[$states[$state]];
            }
        }

        return $state;
    }

    /**
     * log
     */
    public function postLog($data, $logType){

        //记录发送到apgpayment的post log
        $filedate = date('Y-m-d');
        $newfile  = fopen( dirname( __FILE__ )."/apgpayment_log/" . $filedate . ".log", "a+" );
        $post_log = date('Y-m-d H:i:s').$logType."\r\n";
        foreach ($data as $k=>$v){
            $post_log .= $k . " = " . $v . "\r\n";
        }
        $post_log = $post_log . "*************************************\r\n";
        $post_log = $post_log.file_get_contents( dirname( __FILE__ )."/apgpayment_log/" . $filedate . ".log");
        $filename = fopen( dirname( __FILE__ )."/apgpayment_log/" . $filedate . ".log", "r+" );
        fwrite($filename,$post_log);
        fclose($filename);
        fclose($newfile);

    }


    /**
     * 检验是否需要3D验证
     */
    public function validate3D($order_currency, $order_amount){

        //是否需要3D验证
        $is_3d = 0;

        //获取3D功能下各个的币种
        $currencies_value_str = $this->settings['secure_currency'];
        $currencies_value = explode(';', $currencies_value_str);
        //获取3D功能下各个的金额
        $amount_value_str = $this->settings['secure_amount'];
        $amount_value = explode(';', $amount_value_str);
        $amountValidate = array_combine($currencies_value, $amount_value);
        if($amountValidate){
            //判断金额是否为空
            if(isset($amountValidate[$order_currency])){
                //判断3D金额不为空
                //判断订单金额是否大于3d设定值
                if($order_amount >= $amountValidate[$order_currency]){
//				    echo '<pre>';
//				    print_r($amountValidate[$order_currency]);exit;
                    //需3D
                    $is_3d = 1;
                }
            }else{
                //其他币种是否需要3D
                if($this->settings['secure_other_currency'] == 1){
                    //需要3D
                    $is_3d = 1;
                }

            }
        }



        if($is_3d ==  0){
            $validate_arr['terminal'] = $this->settings['terminal'];
            $validate_arr['securecode'] = $this->settings['securecode'];
        }elseif($is_3d == 1){
            //3D
            $validate_arr['terminal'] = $this->settings['secure_terminal'];
            $validate_arr['securecode'] = $this->settings['secure_securecode'];
        }
        return $validate_arr;

    }


    /**
     * 格式化金额
     */
    function formatAmount($order_amount, $order_currency){

        if(in_array($order_currency, $this->_precisionCurrency)){
            $order_amount = round($order_amount, 0);
        }else{
            $order_amount = round($order_amount, 2);
        }

        return $order_amount;

    }

    /**
     * 检验是否移动端
     */
    function isMobile(){
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])){
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 判断手机发的客户端标志
        if (isset ($_SERVER['HTTP_USER_AGENT'])){
            $clientkeywords = array (
                'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel',
                'lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm',
                'operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))){
                return true;
            }
        }
        // 判断协议
        if (isset ($_SERVER['HTTP_ACCEPT'])){
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))){
                return true;
            }
        }
        return false;
    }


    /**
     * 钱海支付Html特殊字符转义
     */
    function APGHtmlSpecialChars($parameter){

        //去除前后空格
        $parameter = trim($parameter);

        //转义"双引号,<小于号,>大于号,'单引号
        $parameter = str_replace(array("<",">","'","\""),array("&lt;","&gt;","&#039;","&quot;"),$parameter);

        return $parameter;

    }


    /**
     *  通过JS跳转出iframe
     */
    public function getJslocationreplace($url)
    {
        echo '<script type="text/javascript">parent.location.replace("'.$url.'");</script>';

    }


    /**
     *  判断是否为xml
     */
    function xml_parser($str){
        $xml_parser = xml_parser_create();
        if(!xml_parse($xml_parser,$str,true)){
            xml_parser_free($xml_parser);
            return false;
        }else {
            return true;
        }
    }

    /**
     * Convert 2-letter country code to 3-letter country code
     */
    private function get_country_code_3($country_code_2) {
        $countries = array(
            'AF' => 'AFG', 'AX' => 'ALA', 'AL' => 'ALB', 'DZ' => 'DZA', 'AS' => 'ASM',
            'AD' => 'AND', 'AO' => 'AGO', 'AI' => 'AIA', 'AQ' => 'ATA', 'AG' => 'ATG',
            'AR' => 'ARG', 'AM' => 'ARM', 'AW' => 'ABW', 'AU' => 'AUS', 'AT' => 'AUT',
            'AZ' => 'AZE', 'BS' => 'BHS', 'BH' => 'BHR', 'BD' => 'BGD', 'BB' => 'BRB',
            'BY' => 'BLR', 'BE' => 'BEL', 'BZ' => 'BLZ', 'BJ' => 'BEN', 'BM' => 'BMU',
            'BT' => 'BTN', 'BO' => 'BOL', 'BA' => 'BIH', 'BW' => 'BWA', 'BV' => 'BVT',
            'BR' => 'BRA', 'IO' => 'IOT', 'BN' => 'BRN', 'BG' => 'BGR', 'BF' => 'BFA',
            'BI' => 'BDI', 'KH' => 'KHM', 'CM' => 'CMR', 'CA' => 'CAN', 'CV' => 'CPV',
            'KY' => 'CYM', 'CF' => 'CAF', 'TD' => 'TCD', 'CL' => 'CHL', 'CN' => 'CHN',
            'CX' => 'CXR', 'CC' => 'CCK', 'CO' => 'COL', 'KM' => 'COM', 'CG' => 'COG',
            'CD' => 'COD', 'CK' => 'COK', 'CR' => 'CRI', 'CI' => 'CIV', 'HR' => 'HRV',
            'CU' => 'CUB', 'CY' => 'CYP', 'CZ' => 'CZE', 'DK' => 'DNK', 'DJ' => 'DJI',
            'DM' => 'DMA', 'DO' => 'DOM', 'EC' => 'ECU', 'EG' => 'EGY', 'SV' => 'SLV',
            'GQ' => 'GNQ', 'ER' => 'ERI', 'EE' => 'EST', 'ET' => 'ETH', 'FK' => 'FLK',
            'FO' => 'FRO', 'FJ' => 'FJI', 'FI' => 'FIN', 'FR' => 'FRA', 'GF' => 'GUF',
            'PF' => 'PYF', 'TF' => 'ATF', 'GA' => 'GAB', 'GM' => 'GMB', 'GE' => 'GEO',
            'DE' => 'DEU', 'GH' => 'GHA', 'GI' => 'GIB', 'GR' => 'GRC', 'GL' => 'GRL',
            'GD' => 'GRD', 'GP' => 'GLP', 'GU' => 'GUM', 'GT' => 'GTM', 'GG' => 'GGY',
            'GN' => 'GIN', 'GW' => 'GNB', 'GY' => 'GUY', 'HT' => 'HTI', 'HM' => 'HMD',
            'VA' => 'VAT', 'HN' => 'HND', 'HK' => 'HKG', 'HU' => 'HUN', 'IS' => 'ISL',
            'IN' => 'IND', 'ID' => 'IDN', 'IR' => 'IRN', 'IQ' => 'IRQ', 'IE' => 'IRL',
            'IM' => 'IMN', 'IL' => 'ISR', 'IT' => 'ITA', 'JM' => 'JAM', 'JP' => 'JPN',
            'JE' => 'JEY', 'JO' => 'JOR', 'KZ' => 'KAZ', 'KE' => 'KEN', 'KI' => 'KIR',
            'KP' => 'PRK', 'KR' => 'KOR', 'KW' => 'KWT', 'KG' => 'KGZ', 'LA' => 'LAO',
            'LV' => 'LVA', 'LB' => 'LBN', 'LS' => 'LSO', 'LR' => 'LBR', 'LY' => 'LBY',
            'LI' => 'LIE', 'LT' => 'LTU', 'LU' => 'LUX', 'MO' => 'MAC', 'MK' => 'MKD',
            'MG' => 'MDG', 'MW' => 'MWI', 'MY' => 'MYS', 'MV' => 'MDV', 'ML' => 'MLI',
            'MT' => 'MLT', 'MH' => 'MHL', 'MQ' => 'MTQ', 'MR' => 'MRT', 'MU' => 'MUS',
            'YT' => 'MYT', 'MX' => 'MEX', 'FM' => 'FSM', 'MD' => 'MDA', 'MC' => 'MCO',
            'MN' => 'MNG', 'ME' => 'MNE', 'MS' => 'MSR', 'MA' => 'MAR', 'MZ' => 'MOZ',
            'MM' => 'MMR', 'NA' => 'NAM', 'NR' => 'NRU', 'NP' => 'NPL', 'NL' => 'NLD',
            'AN' => 'ANT', 'NC' => 'NCL', 'NZ' => 'NZL', 'NI' => 'NIC', 'NE' => 'NER',
            'NG' => 'NGA', 'NU' => 'NIU', 'NF' => 'NFK', 'MP' => 'MNP', 'NO' => 'NOR',
            'OM' => 'OMN', 'PK' => 'PAK', 'PW' => 'PLW', 'PS' => 'PSE', 'PA' => 'PAN',
            'PG' => 'PNG', 'PY' => 'PRY', 'PE' => 'PER', 'PH' => 'PHL', 'PN' => 'PCN',
            'PL' => 'POL', 'PT' => 'PRT', 'PR' => 'PRI', 'QA' => 'QAT', 'RE' => 'REU',
            'RO' => 'ROU', 'RU' => 'RUS', 'RW' => 'RWA', 'BL' => 'BLM', 'SH' => 'SHN',
            'KN' => 'KNA', 'LC' => 'LCA', 'MF' => 'MAF', 'PM' => 'SPM', 'VC' => 'VCT',
            'WS' => 'WSM', 'SM' => 'SMR', 'ST' => 'STP', 'SA' => 'SAU', 'SN' => 'SEN',
            'RS' => 'SRB', 'SC' => 'SYC', 'SL' => 'SLE', 'SG' => 'SGP', 'SK' => 'SVK',
            'SI' => 'SVN', 'SB' => 'SLB', 'SO' => 'SOM', 'ZA' => 'ZAF', 'GS' => 'SGS',
            'ES' => 'ESP', 'LK' => 'LKA', 'SD' => 'SDN', 'SR' => 'SUR', 'SJ' => 'SJM',
            'SZ' => 'SWZ', 'SE' => 'SWE', 'CH' => 'CHE', 'SY' => 'SYR', 'TW' => 'TWN',
            'TJ' => 'TJK', 'TZ' => 'TZA', 'TH' => 'THA', 'TL' => 'TLS', 'TG' => 'TGO',
            'TK' => 'TKL', 'TO' => 'TON', 'TT' => 'TTO', 'TN' => 'TUN', 'TR' => 'TUR',
            'TM' => 'TKM', 'TC' => 'TCA', 'TV' => 'TUV', 'UG' => 'UGA', 'UA' => 'UKR',
            'AE' => 'ARE', 'GB' => 'GBR', 'US' => 'USA', 'UM' => 'UMI', 'UY' => 'URY',
            'UZ' => 'UZB', 'VU' => 'VUT', 'VE' => 'VEN', 'VN' => 'VNM', 'VG' => 'VGB',
            'VI' => 'VIR', 'WF' => 'WLF', 'EH' => 'ESH', 'YE' => 'YEM', 'ZM' => 'ZMB',
            'ZW' => 'ZWE'
        );

        return isset($countries[$country_code_2]) ? $countries[$country_code_2] : $country_code_2;
    }

}
