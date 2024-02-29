<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Apgpayment CreditCard Payment Gateway
 *
 * Provides a Apgpayment CreditCard Payment Gateway, mainly for testing purposes.
 *
 * @class 		WC_Gateway_Apgcreditcard
 * @extends		WC_Payment_Gateway
 * @version		2.4.1
 * @package		WooCommerce/Classes/Payment
 * @author 		Apgpayment
 */
class WC_Gateway_Apgcreditcard extends WC_Payment_Gateway {

    const SEND			= "[Sent to Apgpayment]";
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
        //$this->icon               = apply_filters('woocommerce_apgcreditcard_icon', plugins_url( 'images/icon.php', __FILE__ ));  
        $this->has_fields         = true;
        $this->method_title       = __( 'Apgpayment CreditCard', 'woocommerce' );
        $this->method_description = __( 'APG payment gateway, include credit card, digital wallet, bank transfer, etc.', 'woocommerce' );

        // Load the settings.
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables
        $this->title        = $this->get_option( 'title' );
        $this->description  = $this->get_option( 'description' );
        $this->instructions = $this->get_option( 'instructions', $this->description );

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

        add_action( 'woocommerce_receipt_apgcreditcard', array( $this, 'receipt_page' ) );
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
        $description = $this->ApgTextSpecialChars($this->description);
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
                'label'   => __( 'Enable Apgpayment Credit Card Payment', 'woocommerce' ),
                'default' => 'yes',
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
                'description' => __( 'Apgpayment\'s Account.', 'woocommerce' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'terminal' => array(
                'title'       => __( 'Terminal', 'woocommerce' ),
                'type'        => 'text',
                'description' => __( 'Apgpayment\'s Terminal.', 'woocommerce' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'securecode' => array(
                'title'       => __( 'SecureCode', 'woocommerce' ),
                'type'        => 'text',
                'description' => __( 'Apgpayment\'s SecureCode.', 'woocommerce' ),
                'default'     => '',
                'desc_tip'    => true,
            ),
            'submiturl' => array(
                'title'       => __( 'Submiturl', 'woocommerce' ),
                'type'        => 'select',
                'description' => __( 'Note: In the test state all transactions are not deducted and cannot be shipped or services provided. The interface needs to be closed in time after the test is completed to avoid consumers from placing orders.', 'woocommerce' ),
                'desc_tip'    => true,
                'options'     => array(
                    'https://payment.gloprocessor.com/payment/page/v4/pay' => __( 'Production', 'woocommerce' ),
                    'https://test-payment.gloprocessor.com/payment/page/v4/pay'   => __( 'Sandbox', 'woocommerce' ),
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
                    'JCB' => 'JCB',
                    'Diners' => 'Diners Club',
                    'Discover' => 'Discover'
                ),
                'default' => array(
                    'VISA',
                    'Mastercard',
                    'American',
                    'JCB',
                    'Diners',
                    'Discover',
                ),
            ),
			'log' => array(
                'title'       => __( 'Write The Logs', 'woocommerce' ),
                'type'        => 'select',
                'description' => __( 'Whether to write logs', 'woocommerce' ),
                'desc_tip'    => false,
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
    function receipt_page( $order ) {
        echo $this->generate_creditcard_form( $order );
    }




    /**
     * 生成 Credit Card form.
     */
    public function generate_creditcard_form( $order_id ) {
        $order = wc_get_order( $order_id );

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
        //产品sku
        $productSku        = $this->get_product($order,'sku');        
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

        $sourcestr_2 = $account . $order_number . $order_currency . $order_amount . $backUrl . $securecode;
        $hash2 = hash('sha512', $sourcestr_2);

        $goods             = "[{\"name\":\"".$productName."\",\"price\":\"".$order_amount."\",\"num\":1}]";



        //记录发送到apgpayment的post log
        $apgpayment_log_url = dirname( __FILE__ ).'/apgpayment_log/';

        $filedate = date('Y-m-d');

        $postdate = date('Y-m-d H:i:s');

        $newfile  = fopen( $apgpayment_log_url . $filedate . ".log", "a+" );

        $post_log = $postdate."[POST to Apgpayment]\r\n" .
            "account = "           .$account . "\r\n".
            "terminal = "          .$terminal . "\r\n".
            "backUrl = "           .$backUrl . "\r\n".
            "order_number = "      .$order_number . "\r\n".
            "order_currency = "    .$order_currency . "\r\n".
            "order_amount = "      .$order_amount . "\r\n".
            "billing_firstName = " .$billing_firstName . "\r\n".
            "billing_lastName = "  .$billing_lastName . "\r\n".
            "billing_email = "     .$billing_email . "\r\n".
            "billing_phone = "     .$billing_phone . "\r\n".
            "billing_country = "   .$billing_country . "\r\n".
            "billing_state = "     .$billing_state . "\r\n".
            "billing_city = "      .$billing_city . "\r\n".
            "billing_address = "   .$billing_address . "\r\n".
            "billing_zip = "       .$billing_zip . "\r\n".
            "productName = "       .$productName . "\r\n".            
            "productNum = "        .$productNum . "\r\n".            
            "productSku = "        .$productSku . "\r\n".            
            "ship_firstName = "    .$ship_firstName . "\r\n".
            "ship_lastName = "     .$ship_lastName . "\r\n".
            "ship_phone = "        .$ship_phone . "\r\n".
            "ship_country = "      .$ship_country . "\r\n".
            "ship_state = "        .$ship_state . "\r\n".
            "ship_city = "         .$ship_city . "\r\n".
            "ship_addr = "         .$ship_addr . "\r\n".
            "ship_zip = "          .$ship_zip . "\r\n".
            "ship_email = "        .$ship_email . "\r\n".
            "methods = "           .$methods . "\r\n".
            "signValue = "         .$hash2 . "\r\n".
            "cart_info = "         .$cart_info . "\r\n".
            "cart_api = "          .$cart_api . "\r\n".
            "order_notes = "       .$order_notes . "\r\n";

        $post_log = $post_log . "*************************************\r\n";

        $post_log = $post_log.file_get_contents( $apgpayment_log_url . $filedate . ".log");

        $filename = fopen( $apgpayment_log_url . $filedate . ".log", "r+" );

        fwrite($filename,$post_log);

        fclose($filename);

        fclose($newfile);


        $data_to_send  = "<div id='loading' style='position: relative;'>";
        $data_to_send .= "<div style='position: absolute;background:#FFF; padding: 20px; border: #000 1px solid; width: 320px;margin:130px auto 0;left: 0;right:0;' id='loading'>";
        $data_to_send .= "<img src='".plugins_url( 'images/opc-ajax-loader.gif', __FILE__ )."' />Loading...Please do not refresh the page";
        $data_to_send .= "</div>";
        $data_to_send .= "</div>";
        $data_to_send .= "<form  method='post' name='creditcard_checkout' action='".$this->settings['submiturl']."'  >";
        $data_to_send .= "<input type='hidden' name='merchantNo' value='" . $account . "' />";
        $data_to_send .= "<input type='hidden' name='terminal' value='" . $terminal . "' />";
        $data_to_send .= "<input type='hidden' name='merOrderNo' value='" . $order_number . "' />";
        $data_to_send .= "<input type='hidden' name='payCurrency' value='" . $order_currency . "' />";
        $data_to_send .= "<input type='hidden' name='payAmount' value='" . $order_amount . "' />";
        $data_to_send .= "<input type='hidden' name='returnUrl' value='" . $backUrl . "' />";
		$data_to_send .= "<input type='hidden' name='notifyUrl' value='" . $noticeUrl . "' />";
        $data_to_send .= "<input type='hidden' name='sign' value='" . $hash2 . "' />";
        $data_to_send .= "<input type='hidden' name='order_notes' value='" . $order_notes . "' />";
        $data_to_send .= "<input type='hidden' name='methods' value='" . $methods . "' />";
        $data_to_send .= "<input type='hidden' name='billing_firstName' value='" . $billing_firstName . "' />";
        $data_to_send .= "<input type='hidden' name='billing_lastName' value='" . $billing_lastName . "' />";
        $data_to_send .= "<input type='hidden' name='billing_email' value='" . $billing_email . "' />";
        $data_to_send .= "<input type='hidden' name='billing_phone' value='" . $billing_phone . "' />";
        $data_to_send .= "<input type='hidden' name='billing_country' value='" . $billing_country . "' />";
        $data_to_send .= "<input type='hidden' name='billing_state' value='" . $billing_state . "' />";
        $data_to_send .= "<input type='hidden' name='billing_city' value='" . $billing_city . "' />";
        $data_to_send .= "<input type='hidden' name='billing_address' value='" . $billing_address . "' />";
        $data_to_send .= "<input type='hidden' name='billing_zip' value='" . $billing_zip . "' />";
        $data_to_send .= "<input type='hidden' name='productName' value='" . $productName . "' />";
        $data_to_send .= "<input type='hidden' name='productNum' value='" . $productNum . "' />";
        $data_to_send .= "<input type='hidden' name='productSku' value='" . $productSku . "' />";        
        $data_to_send .= "<input type='hidden' name='firstName' value='" . $ship_firstName . "' />";
        $data_to_send .= "<input type='hidden' name='lastName' value='" . $ship_lastName . "' />";
        $data_to_send .= "<input type='hidden' name='telephone' value='" . $ship_phone . "' />";
        $data_to_send .= "<input type='hidden' name='countryOrRegion' value='" . $ship_country . "' />";
        $data_to_send .= "<input type='hidden' name='stateOrProvince' value='" . $ship_state . "' />";
        $data_to_send .= "<input type='hidden' name='cityOrTown' value='" . $ship_city . "' />";
        $data_to_send .= "<input type='hidden' name='street' value='" . $ship_addr . "' />";
        $data_to_send .= "<input type='hidden' name='postCodeOrZip' value='" . $ship_zip . "' />";
        $data_to_send .= "<input type='hidden' name='email' value='" . $ship_email . "' />";
        $data_to_send .= "<input type='hidden' name='remark' value='" . $cart_info . "' />";
        $data_to_send .= "<input type='hidden' name='goods' value='" . $goods . "' />";
        $data_to_send .= "<input type='hidden' name='tranCode' value='" . $cart_api . "' />";
        $data_to_send .= "<input type='hidden' name='pages' value='" . $pages . "' />";
        $data_to_send .= "</form>";

        if($this->settings['mode'] == 'redirect'){
            $data_to_send .= '<script type="text/javascript">' . "\n";
            $data_to_send .= 'document.creditcard_checkout.submit();' . "\n";
            $data_to_send .= '</script>' . "\n";

        }elseif($this->settings['mode'] == 'iframe'){
            $data_to_send .= '<iframe width="100%" height="800px"  scrolling="auto" style="border:none ; margin: 0 auto; overflow:hidden;" id="ifrm_creditcard_checkout" name="ifrm_creditcard_checkout"></iframe>' . "\n";

            $data_to_send .= '<script type="text/javascript">' . "\n";
            $data_to_send .= 'document.creditcard_checkout.target="ifrm_creditcard_checkout";' . "\n";
            $data_to_send .= 'document.creditcard_checkout.submit();' . "\n";
            $data_to_send .= 'var ifrm_cc  = document.getElementById("ifrm_creditcard_checkout");' . "\n";
            $data_to_send .= 'var loading  = document.getElementById("loading");' . "\n";
            $data_to_send .= 'if (ifrm_cc.attachEvent){' . "\n";
            $data_to_send .= '	ifrm_cc.attachEvent("onload", function(){' . "\n";
            $data_to_send .= '		loading.style.display = "none";' . "\n";
            $data_to_send .= '	});' . "\n";
            $data_to_send .= '} else {' . "\n";
            $data_to_send .= '	ifrm_cc.onload = function(){' . "\n";
            $data_to_send .= '		loading.style.display = "none";' . "\n";
            $data_to_send .= '	};' . "\n";
            $data_to_send .= '}' . "\n";
            $data_to_send .= '</script>' . "\n";
        }


        return $data_to_send;
    }

    public static function request_hash($data, $secureCode)
    {
        $sourcestr_2 = $data['merchantNo'] . $data['merOrderNo'] . $data['payCurrency'] . $data['payAmount'] . $data['returnUrl'] . $secureCode;
        $hash2 = hash('sha512', $sourcestr_2);
        $data['sign'] = strtolower($hash2);
        return $data;
    }

    public static function response_hash($data, $secureCode)
    {
        $befor_sign = $data['merOrderNo'] .$data['referenceNo'].$data['payCurrency'].$data['respStatus'].$secureCode;
        $jmh = hash('sha512', $befor_sign);
        return strtolower($jmh);
    }

    /**
     * 异步通知
     */
    function notice_payment( $order ) {
        if (isset($_REQUEST['merOrderNo']) && !(empty($_REQUEST['merOrderNo']))) {
            $account = $this->settings['account'];
            $data['merchantNo'] = $account;
            $referenceNo = $_REQUEST['referenceNo'];;
            $data['referenceNo'] = $referenceNo;
            $order_number = $_REQUEST['merOrderNo'];;
            $data['merOrderNo'] = $order_number;
            $order_currency = $_REQUEST['payCurrency'];;
            $data['payCurrency'] = $order_currency;
            $order_amount = $_REQUEST['payAmount'];;
            $data['payAmount'] = $order_amount;
            $payment_status = $_REQUEST['respStatus'];;
            $data['respStatus'] = $payment_status;
            $ErrorCode = $_REQUEST['respCode'];;
            $data['respCode'] = $ErrorCode;
            $respDesc =  $_REQUEST['respDesc'];;
            $data['respDesc'] = $respDesc;
            $sign =  $_REQUEST['sign'];;
            $data['sign'] = $sign;

            $data['op_errorCode'] = $ErrorCode;
            $errorCode			= $ErrorCode;
            $securecode = $this->settings['securecode'];

            $order = wc_get_order( $order_number );
            $order_id = $order->get_id();
            if ( isset( $_REQUEST['payment_id'] ) ) {
                $order->set_transaction_id( $_REQUEST['payment_id'] );
            }
            if($this->settings['log'] == 'true'){
                $this->postLog($_REQUEST, self::PUSH);
            }
            strpos($this->settings['submiturl'],'test') != false ? $testorder = 'TEST ORDER - ' : $testorder = '';
            //签名数据
            $local_signValue = self::response_hash($data, $securecode);
            if (strtoupper($local_signValue) == strtoupper($sign)) {
                //支付状态
                if ($payment_status == 1) {
                    //成功
                    $order->update_status( 'processing', __( $testorder.$errorCode, 'woocommerce' ) );
                    wc_reduce_stock_levels( $order_id );
                    WC()->cart->empty_cart();
                }  elseif ($payment_status == 0) {
                    //失败
                    if(empty($this->completed_orders()) || !in_array($order_number, $this->completed_orders())){
                        $order->update_status( 'failed', __( $testorder.$errorCode, 'woocommerce' ) );
                    }
                } else {
                    //待处理
                    if(empty($this->completed_orders()) || !in_array($order_number, $this->completed_orders())){
                        $order->update_status( 'on-hold', __( $testorder.$errorCode, 'woocommerce' ) );
                    }
                }
            }
            echo "success.";
        } else {
            echo "params error.";
        }
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
        //返回Apgpayment 的支付唯一号
        $payment_id       = $_REQUEST['referenceNo'];
        //返回网站订单号
        $order_number     = $_REQUEST['merOrderNo'];
        //返回交易币种
        $order_currency   = $_REQUEST['payCurrency'];
        //返回支付金额
        $order_amount     = $_REQUEST['payAmount'];
        //返回支付状态
        $payment_status   = $_REQUEST['respStatus'];
        //返回支付详情
        $payment_details  = $_REQUEST['respCode'];

        //用于支付结果页面显示响应代码
        $getErrorCode		= explode(':', $payment_details);
        $errorCode			= $getErrorCode[0];

        //返回交易安全签名
        $back_signValue   = $_REQUEST['sign'];
        //返回备注
        $order_notes      = $_REQUEST['order_notes'];
        //未通过的风控规则
        $payment_risk     = $_REQUEST['payment_risk'];
        //返回支付信用卡卡号
        $card_number      = $_REQUEST['card_number'];
        //返回交易类型
        $payment_authType = $_REQUEST['payment_authType'];
        //解决方案
        $payment_solutions = $_REQUEST['payment_solutions'];

        //匹配终端号   判断是否3D交易
        if($terminal == $this->settings['terminal']){
            $secureCode = $this->settings['securecode'];
        }elseif($terminal == $this->settings['secure_terminal']){
            //3D
            $secureCode = $this->settings['secure_securecode'];
        }else{
            $secureCode = '';
        }


        $befor_sign = $order_number . $payment_id. $order_currency.$payment_status.$secureCode;
        $jmh = hash('sha512', $befor_sign);
        $local_signValue = strtolower($jmh);


        $order = wc_get_order( $order_number );
        //没有数据返回拦截跳转首页
        if($order === false){
            wp_redirect(home_url());exit;
        }
        if ( isset( $payment_id ) ) {
            $order->set_transaction_id( $payment_id );
        }
        if($this->settings['log'] === 'true') {
            $this->postLog($_REQUEST, self::BrowserReturn);
        }

        strpos($this->settings['submiturl'],'test') != false ? $testorder = 'TEST ORDER - ' : $testorder = '';
        //加密校验
        if(strtoupper($local_signValue) == strtoupper($back_signValue)){
            //支付状态
            if ($payment_status == 1) {
                //成功
                $order->update_status( 'processing', __( $testorder.$payment_details, 'woocommerce' ) );
                WC()->cart->empty_cart();
                $url = $this->get_return_url( $order );
                wc_add_notice( $testorder.$payment_details, 'success' );
            } elseif ($payment_status == 0) {
                //失败
                if(empty($this->completed_orders()) || !in_array($order_number, $this->completed_orders())){
                    $order->update_status( 'failed', __( $testorder.$payment_details, 'woocommerce' ) );
                }
                $url = esc_url( wc_get_checkout_url() );
                wc_add_notice( $testorder.$payment_details, 'error' );
                wc_add_notice( $payment_solutions, 'error' );

            } else {
                //待处理
                if(empty($this->completed_orders()) || !in_array($order_number, $this->completed_orders())){
                    $order->update_status( 'on-hold', __( $testorder.$payment_details, 'woocommerce' ) );
                }
                $url = $this->get_return_url( $order );
                wc_add_notice( $testorder.$payment_details, 'success' );
            }

        }else{
            $order->update_status( 'failed', __( $testorder.$payment_details, 'woocommerce' ) );
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
    
            SELECT pm.meta_value AS user_id, pm.post_id AS order_id
            FROM {$wpdb->prefix}postmeta AS pm
            LEFT JOIN {$wpdb->prefix}posts AS p
            ON pm.post_id = p.ID
            WHERE p.post_type = 'shop_order'
            AND p.post_status IN ('wc-completed','wc-Processing')
            AND pm.meta_key = '_customer_user'
            ORDER BY pm.meta_value ASC, pm.post_id DESC
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
                    //需要3D
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
        // 判断手机发送的客户端标志
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
     * 支付Html特殊字符转义
     */
    function ApgHtmlSpecialChars($parameter){

        //去除前后空格
        $parameter = trim($parameter);

        //转义"双引号,<小于号,>大于号,'单引号
        $parameter = str_replace(array("<",">","'","\""),array("&lt;","&gt;","&#039;","&quot;"),$parameter);

        return $parameter;

    }

    /**
     * 支付Html特殊字符转义
     */
    function ApgTextSpecialChars($parameter){

        //去除前后空格
        $parameter = trim($parameter);

        //转义"双引号,<小于号,>大于号,'单引号
        $parameter = str_replace(array("\r","\n","\r\n"),array("","",""),$parameter);

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

}
