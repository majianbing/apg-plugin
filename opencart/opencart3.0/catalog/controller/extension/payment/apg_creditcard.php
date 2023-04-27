<?php

class ControllerExtensionPaymentAPGCreditCard extends Controller {
	
	const PUSH 			= "[PUSH]";
	const BrowserReturn = "[Browser Return]";	
	
	public function index() {
		

		$this->load->model('checkout/order');
		
		
		$data['button_confirm'] = $this->language->get('button_confirm');
		$data['action'] = 'index.php?route=extension/payment/apg_creditcard/apg_creditcard_form';
		
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		return $this->load->view('extension/payment/apg_creditcard', $data);
	}

	
	public function apg_creditcard_form() {
		
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('payment_apg_creditcard_default_order_status_id'), '', false);

		
		//判断是否为空订单
		if (!empty($order_info)) {
			
			$this->load->model('extension/payment/apg_creditcard');
			$product_info = $this->model_extension_payment_apg_creditcard->getOrderProducts($this->session->data['order_id']);
			
			//获取订单详情
			$productDetails = $this->getProductItems($product_info);
			//获取消费者详情
			$customer_info = $this->model_extension_payment_apg_creditcard->getCustomerDetails($order_info['customer_id']);
			
			
			if (!$this->request->server['HTTPS']) {
				$base_url = $this->config->get('config_url');
			} else {
				$base_url = $this->config->get('config_ssl');
			}
			
			//提交网关
			$action = $this->config->get('payment_apg_creditcard_transaction');
			$data['action'] = $action;
			
			//订单号
			$order_number = trim($order_info['order_id']);
			$data['merOrderNo'] = $order_number;
			
			//订单金额
			$order_amount = trim($this->currency->format($order_info['total'], $order_info['currency_code'], '', FALSE));
			$data['payAmount'] = sprintf('%.2f', $order_amount);;

			//币种
			$order_currency = trim($order_info['currency_code']);
			$data['payCurrency'] = $order_currency;
		
			//商户号
			$account = $this->config->get('payment_apg_creditcard_account');
			$data['merchantNo'] = trim($account);

			//securecode
			$securecode = trim($this->config->get('payment_apg_creditcard_securecode'));

			//返回地址
			$returnUrl = trim($base_url.'index.php?route=extension/payment/apg_creditcard/callback&');
			$data['returnUrl'] = $returnUrl;
			
			//服务器响应地址
			$noticeUrl = $base_url.'index.php?route=extension/payment/apg_creditcard/notice&';
			$data['noticeUrl'] = $noticeUrl;
			
			//备注
			$order_notes = '';
			$data['order_notes'] = $order_notes;
			
			//支付方式
			$methods = "Credit Card";
			$data['methods'] = $methods;
			
			//账单人名
			$billing_firstName = substr(urlencode($this->ApgHtmlSpecialChars($order_info['payment_firstname'])),0,50);
			$data['billing_firstName'] = $billing_firstName;
			
			//账单人姓
			$billing_lastName = substr(urlencode($this->ApgHtmlSpecialChars($order_info['payment_lastname'])),0,50);
			$data['billing_lastName'] = $billing_lastName;
			 
			//账单人邮箱
			$billing_email = $this->ApgHtmlSpecialChars($order_info['email']);
			$data['billing_email'] = $billing_email;
			 
			//账单人手机
			$billing_phone = $order_info['telephone'];
			$data['billing_phone'] = $billing_phone;
			 
			//账单人国家
			$billing_country = $order_info['payment_iso_code_2'];
			$data['billing_country'] = $billing_country;
			
			//账单人州
			$billing_state = $order_info['payment_zone_code'];
			$data['billing_state'] = $billing_state;
			 
			//账单人城市
			$billing_city = $order_info['payment_city'];
			$data['billing_city'] = $billing_city;
			 
			//账单人地址
			if (!$order_info['payment_address_2']) {
				$billing_address = $order_info['payment_address_1'] ;
			} else {
				$billing_address = $order_info['payment_address_1'] . ',' . $order_info['payment_address_2'];
			}
			$data['billing_address'] = $billing_address;
			 
			//账单人邮编
			$billing_zip = $order_info['payment_postcode'];
			$data['billing_zip'] = $billing_zip;

			//收货人名
			$ship_firstName = substr(urlencode($this->ApgHtmlSpecialChars($order_info['shipping_firstname'])),0,50);
			$data['ship_firstName'] = $ship_firstName;
			
			//收货人姓
			$ship_lastName = substr(urlencode($this->ApgHtmlSpecialChars($order_info['shipping_lastname'])),0,50);
			$data['ship_lastName'] = $ship_lastName;
			
			//收货人手机
			$ship_phone = $order_info['telephone'];
			$data['ship_phone'] = $ship_phone;
				
			//收货人国家
			$ship_country = $order_info['shipping_iso_code_2'];
			$data['ship_country'] = $ship_country;
				
			//收货人州
			$ship_state = $order_info['shipping_zone_code'];
			$data['ship_state'] = $ship_state;
				
			//收货人城市
			$ship_city = $order_info['shipping_city'];
			$data['ship_city'] = $ship_city;
				
			//收货人地址
			if (!$order_info['shipping_address_2']) {
				$ship_addr = $order_info['shipping_address_1'] ;
			} else {
				$ship_addr = $order_info['shipping_address_1'] . ',' . $order_info['shipping_address_2'];
			}
			$data['ship_addr'] = $ship_addr;
				
			//收货人邮编
			$ship_zip = $order_info['shipping_postcode'];
			$data['ship_zip'] = $ship_zip;
			
			//产品名称
			$productName = $productDetails['productName'];
			$data['productName'] = $productName;
			
			//产品SKU
			$productSku	= $productDetails['productSku'];
			$data['productSku'] = $productSku;
			
			//产品数量
			$productNum = $productDetails['productNum'];
			$data['productNum'] = $productNum;
			
			//购物车信息
			$cart_info = 'opencart3.0 above';
			$data['cart_info'] = $cart_info;
			
			//API版本
			$cart_api = 'V4';
			$data['cart_api'] = $cart_api;
			// 收银台的交易代码
			$data['tranCode'] = "TA002";

			$data['goods'] = "[{}]";

			//签名加入
			$data = self::request_hash($data, $securecode);
			
			 
			if ($this->request->get['route'] != 'checkout/guest_step_3') {
				$data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
			} else {
				$data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
			}
			
			$this->id = 'payment';
			
			
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			
			//支付模式Pay Mode
			if($this->config->get('payment_apg_creditcard_pay_mode') == 1){
				//内嵌Iframe
				$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_iframe', $data));
			}else{
				//跳转Redirect
				$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_form', $data));
			}

		}else{		
			$this->response->redirect($this->url->link('checkout/cart'));
		}
		
		
	}
	
	
	public function callback() {
		if (isset($this->request->get['merOrderNo']) && !(empty($this->request->get['merOrderNo']))) {
			$this->language->load('extension/payment/apg_creditcard');
		
			$data['title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));

			if (!$this->request->server['HTTPS']) {
				$data['base'] = $this->config->get('config_url');
			} else {
				$data['base'] = $this->config->get('config_ssl');
			}
			
	
			$data['charset'] = $this->language->get('charset');
			$data['language'] = $this->language->get('code');
			$data['direction'] = $this->language->get('direction');
			$data['heading_title'] = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));		
			
			$data['text_response'] = $this->language->get('text_response');
			$data['text_success'] = $this->language->get('text_success');
			$data['text_success_wait'] = sprintf($this->language->get('text_success_wait'), $this->url->link('checkout/success'));
            $data['text_success_url'] = $this->url->link('checkout/success');
			$data['text_failure_url'] = $this->url->link('checkout/checkout');
			$data['text_failure'] = $this->language->get('text_failure');			
			$data['text_failure_wait'] = sprintf($this->language->get('text_failure_wait'), $this->url->link('checkout/checkout'));
			
			$data['text_order_number'] ='<font color="green">'.$this->request->get['merOrderNo'].'</font>';
			$data['text_result'] ='<font color="green">'.$this->request->get['respStatus'].'</font>';
			
	
			//返回信息
			$account = $this->config->get('payment_apg_creditcard_account');
			$data['merchantNo'] = $account;
			$referenceNo = $this->request->get['referenceNo'];
			$data['referenceNo'] = $referenceNo;
			$order_number = $this->request->get['merOrderNo'];
			$data['merOrderNo'] = $order_number;
			$order_currency =$this->request->get['payCurrency'];
			$data['payCurrency'] = $order_currency;
			$order_amount =$this->request->get['payAmount'];
			$data['payAmount'] = $order_amount;
			$payment_status =$this->request->get['respStatus'];
			$data['respStatus'] = $payment_status;
			$ErrorCode =$this->request->get['respCode'];
			$data['respCode'] = $ErrorCode;
			$respDesc =$this->request->get['respDesc'];
			$data['respDesc'] = $respDesc;
			$sign = $this->request->get['sign'];
			$data['sign'] = $sign;

			//用于支付结果页面显示响应代码
			$data['op_errorCode'] = $ErrorCode;

			
			//匹配终端号
			$securecode = $this->config->get('payment_apg_creditcard_securecode');

			//签名数据		
			$local_signValue = self::response_hash($data, $securecode);

			$message = self::BrowserReturn ;
			if($this->config->get('payment_apg_creditcard_transaction') == 'https://test.next-api.com/payment/page/v4/pay'){
				$message .= 'TEST ORDER - '.$data['merOrderNo'];
				$data['payment_details'] = ' IT IS TEST ORDER '.$data['merOrderNo'];
			}
			if ($payment_status == 1){           //交易状态
				$message .= 'PAY:Success.';
			}elseif ($payment_status == 0){
				$message .= 'PAY:Failure.';
			}else {
				$message .= 'PAY:Processing.';
			}
			$message .= ' | ' . $order_number . ' | ' . $order_currency . ':' . $order_amount . ' | ' . $ErrorCode . "\n";
			header("Set-Cookie:".$referenceNo."path=/");
			$this->load->model('checkout/order');
			if (strtoupper($local_signValue) == strtoupper($sign)) {     //数据签名对比
				//正常浏览器跳转
				if($ErrorCode == 20061){
					//排除订单号重复(20061)的交易
					$data['continue'] = $this->url->link('checkout/cart');
					$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_failure', $data));

				}else{
					if ($payment_status == 1 ){
						//交易成功
						//清除coupon
						unset($this->session->data['coupon']);

						$this->model_checkout_order->addOrderHistory($this->request->get['merOrderNo'], $this->config->get('payment_apg_creditcard_success_order_status_id'), $message, true);

						$data['continue'] = HTTPS_SERVER . 'index.php?route=checkout/success';
						$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_success', $data));

					}elseif ($payment_status == 0 ){

						//交易失败
						$this->model_checkout_order->addOrderHistory($this->request->get['merOrderNo'], $this->config->get('payment_apg_creditcard_failed_order_status_id'), $message, false);

						$data['continue'] = $this->url->link('checkout/cart');
						$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_failure', $data));
					}else{
						//交易待处理
						//是否预授权交易
						$this->model_checkout_order->addOrderHistory($this->request->get['merOrderNo'], $this->config->get('payment_apg_creditcard_pending_order_status_id'), $message, false);

						$data['continue'] = $this->url->link('checkout/cart');
						$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_failure', $data));
					}
				}
			}else {     
				//数据签名对比失败
				$this->model_checkout_order->addOrderHistory($this->request->get['merOrderNo'], $this->config->get('apg_creditcard_failed_order_status_id'), $message, false);
							
				$data['continue'] = $this->url->link('checkout/cart');
				$this->response->setOutput($this->load->view('extension/payment/apg_creditcard_failure', $data));
					
			}
		}


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

	
	public function notice() {
		if (isset($this->request->get['merOrderNo']) && !(empty($this->request->get['merOrderNo']))) {
			//返回信息
			$account = $this->config->get('payment_apg_creditcard_account');
			$data['merchantNo'] = $account;
			$referenceNo = $this->request->get['referenceNo'];
			$data['referenceNo'] = $referenceNo;
			$order_number = $this->request->get['merOrderNo'];
			$data['merOrderNo'] = $order_number;
			$order_currency = $this->request->get['payCurrency'];
			$data['payCurrency'] = $order_currency;
			$order_amount = $this->request->get['payAmount'];
			$data['payAmount'] = $order_amount;
			$payment_status = $this->request->get['respStatus'];
			$data['respStatus'] = $payment_status;
			$ErrorCode = $this->request->get['respCode'];
			$data['respCode'] = $ErrorCode;
			$respDesc = $this->request->get['respDesc'];
			$data['respDesc'] = $respDesc;
			$sign = $this->request->get['sign'];
			$data['sign'] = $sign;

			//用于支付结果页面显示响应代码
			$data['op_errorCode'] = $ErrorCode;
			$securecode = $this->config->get('payment_apg_creditcard_securecode');

			//签名数据
			$local_signValue = self::response_hash($data, $securecode);

			//响应代码
			$errorCode = $ErrorCode;

			//数据签名对比
			if (strtoupper($local_signValue) == strtoupper($sign)) {

				$this->load->model('checkout/order');
				$message = self::PUSH;
				if ($this->config->get('payment_apg_creditcard_transaction') == 'https://test.next-api.com/payment/page/v4/pay') {
					$message .= 'TEST ORDER - ';
				}
				if ($payment_status == 1) {           //交易状态
					$message .= 'PAY:Success.';
				} elseif ($payment_status == 0) {
					$message .= 'PAY:Failure.';
				} else {
					$message .= 'PAY:Pending.';
				}
				$message .= ' | ' . $order_number . ' | ' . $order_currency . ':' . $order_amount . ' | ' . $ErrorCode. "\n";

				if ($payment_status == 1) {
					//交易成功
					$this->model_checkout_order->addOrderHistory($order_number, $this->config->get('payment_apg_creditcard_success_order_status_id'), $message, false);
				} elseif ($payment_status == 0) {
					//交易失败
					$this->model_checkout_order->addOrderHistory($order_number, $this->config->get('payment_apg_creditcard_failed_order_status_id'), $message, false);
				} else {
					//交易待处理
					$this->model_checkout_order->addOrderHistory($order_number, $this->config->get('payment_apg_creditcard_pending_order_status_id'), $message, false);
				}

			}

			echo "success.";

		}
	}


	
	/**
	 * 获取订单详情
	 */
	function getProductItems($AllItems){
	
		$productDetails = array();
		$productName = array();
		$productSku = array();
		$productNum = array();
			
		foreach ($AllItems as $item) {
			$productName[] = $item['name'];
			$productSku[] = $item['product_id'];
			$productNum[] = $item['quantity'];
		}
	
		$productDetails['productName'] = implode(';', $productName);
		$productDetails['productSku'] = implode(';', $productSku);
		$productDetails['productNum'] = implode(';', $productNum);
	
		return $productDetails;
	
	}
	
	
	
	/**
	 * Html特殊字符转义
	 */
	function ApgHtmlSpecialChars($parameter){
	
		//去除前后空格
		$parameter = trim($parameter);
	
		//转义"双引号,<小于号,>大于号,'单引号
		$parameter = str_replace(array("<",">","'","\""),array("&lt;","&gt;","&#039;","&quot;"),$parameter);
	
		return $parameter;
	
	}
	

}
?>
