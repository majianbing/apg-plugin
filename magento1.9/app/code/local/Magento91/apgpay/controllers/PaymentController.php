<?php
/**
 * E: test@test.com
 * W:www.magento.con
 */
 
class Magento91_apgpay_PaymentController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Order instance
	 */
	protected $_order;
	protected $_tradeNo;
		//ƽ̨���׺�
	protected $_orderNo;
		//֪ͨʱ��
	protected $_notifyTime;
	
		//֧��״̬
	protected $_tradeStatus;
		//ǩ������
	protected $_signType;
		//״̬
	protected $_success;

	/**
	 *  Get order
	 *
	 *  @param    none
	 *  @return	  Mage_Sales_Model_Order
	 */
	public function getOrder()
	{
		if ($this->_order == null) {
			$session = Mage::getSingleton('checkout/session');
			$this->_order = Mage::getModel('sales/order');
			$this->_order->loadByIncrementId($session->getLastRealOrderId());
		}
		return $this->_order;
	}

	/**
	 * When a customer chooses CreditCard on Checkout/Payment page
	 *
	 */
	public function redirectAction()
	{
		$session = Mage::getSingleton('checkout/session');
		$session->setCreditCardPaymentQuoteId($session->getQuoteId());

		$order = $this->getOrder();

		if (!$order->getId()) {
			$this->norouteAction();
			return;
		}

		$order->addStatusToHistory(
		$order->getStatus(),
		Mage::helper('apgpay')->__('Customer was redirected to apgpay')
		);
		$order->save();
		//$order->sendNewOrderEmail();
		
		$this->getResponse()
		->setBody($this->getLayout()
		->createBlock('apgpay/redirect')
		->setOrder($order)
		->toHtml());

		//$session->unsQuoteId();
	}

	

	
	public function generateErrorResponse() {
		die ( $this->getErrorResponse () );
	}
	
	private function _validated()
	{
		$model = Mage::getModel('dgpay/payment');
		
		if ($this->getRequest()->isPost()) {
			$rData = $this->getRequest()->getPost();
        	$method = 'post';

		} else if ($this->getRequest()->isGet()) {
			$rData = $this->getRequest()->getQuery();
			$method = 'get';

		} else {
			$model->generateErrorResponse();
		}
		
		//������
		$tradeNo = $rData["tradeNo"];
		//ƽ̨���׺�
		$orderNo = $rData["orderNo"];
		//֪ͨʱ��
		$notifyTime = $rData["notifyTime"];
		//֧��״̬
		$tradeStatus = $rData["tradeStatus"];
		//ǩ������
		$signType = $rData["signType"];
		//״̬
		$success = $rData["success"];
		//ǩ��
		$sign = $rData["sign"];
		//md5
	    $MD5key = $model->getConfigData('md5_msg');
		
		$this->_tradeNo = $tradeNo;
			//ƽ̨���׺�
		$this->_orderNo = $orderNo;
			//֪ͨʱ��
		$this->_notifyTime = $notifyTime;
			//֧��״̬
		$this->_tradeStatus = $tradeStatus;
			//ǩ������
		$this->_signType = $signType;
			//״̬
		$this->_success = $success;

		
		$mydata["tradeNo"] = $tradeNo;
		$mydata["orderNo"] = $orderNo;
		$mydata["notifyTime"] = $notifyTime;
		$mydata["tradeStatus"] = $tradeStatus;
		$mydata["signType"] = $signType;
		$mydata["success"] = $success;
		
		ksort($mydata);
		$sourcestr = "";
		foreach($mydata as $k=>$v){
				$sourcestr .= $k."=".$v."&";
		}
		
		$sourcestr = substr($sourcestr,0,strlen($sourcestr)-1);
		$myhis = $sourcestr;
		//echo "ԭ��:<input type=text value='".$sourcestr ."' />";
		$sourcestr .= $MD5key;
		//echo "���ܴ�:<input type=text value='".$sourcestr ."' />";
		//echo "md5:<input type=text value='". $MD5key ."' /><br>";
		$myjm = md5($sourcestr);
		//echo "<br>";
		//echo $sign;
		$this->writeLog('./apgpaylog.txt',date('Y-m-d H:i:s').'---'.'Customer back from apgpay:'.$myhis);
		if ($sign == $myjm && $tradeStatus<>'TRADE_CLOSE'){
			return true;
		}else{
			return false;
		}
	}
public function writeLog($file,$msg){
   $file = @fopen($file,"a+");
   @fputs($file,$msg. "\n");
   @fclose($file);
}
	
 /**
	 *  Success payment page
	 *
	 *  @param    none
	 *  @return	  void
	 */
	public function returnAction()
	{
		 $model = Mage::getModel('apgpay/payment');
		
		if ($this->getRequest()->isPost()) {
			$rData = $this->getRequest()->getPost();
        	$method = 'post';

		} else if ($this->getRequest()->isGet()) {
			$rData = $this->getRequest()->getQuery();
			$method = 'get';

		} else {
			$model->generateErrorResponse();
		}
		
		
		//������
		$order_no= $rData["order_no"];
		
		$order = Mage::getModel('sales/order')->loadByIncrementId($order_no);
		if (!$order){
			die('wrong orderno');
		}
		
		$hash = $rData["hash"];
		$amount = $rData["amount"];
		$failure_reason = $rData["failure_reason"];
		$trans_date = $rData["trans_date"];
		$trans_time = $rData["trans_time"];
		$status = $rData["status"];
		$ref_no = $rData["ref_no"];
		$invoice_id = $rData["invoice_id"];		
		$merchant_id = $rData["merchant_id"];
		$order_no = $rData["order_no"];
		
		//״̬
		$currency = $rData["currency"];
		//ǩ��
		
		//md5
	    $MD5key = $model->getConfigData('md5_msg');
		
		$jmyc =  $MD5key.$amount.$currency.$failure_reason.$invoice_id.$merchant_id.$order_no.$ref_no.$status.$trans_date.$trans_time;
		$jmh = hash('sha256', $jmyc);
		/*echo $jmyc;
		echo "<br>";
		$jmh = hash('sha256', $jmyc);
		echo $hash;
		echo "<br>";
		echo $jmh;
		echo "<br>";*/
		//var_dump($order->getPayment());exit;
		if (strtoupper($jmh) == $hash){

			/*
				if (...){
					$this->_redirect('checkout/onepage/success');
				}else{
				$this->_redirect('checkout/onepage/failure');
				}
			*/
			
			if ($status == '01'){
				if ($order->state <> $model->getConfigData('order_status_payment_success')){
				  $order->addStatusToHistory(
						$model->getConfigData('order_status_payment_success'),//$order->getStatus(),
						Mage::helper('apgpay')->__('Payment success by apgpay!')
					);
					$order->setState($model->getConfigData('order_status_payment_success'), true);
					$order->save();
				}
					$this->saveInvoice($order);
					$this->_redirect('checkout/onepage/success');
					
			}
			if ($status == '02'){
				if ($order->state <> Mage_Sales_Model_Order::STATE_CANCELED){
					$order->addStatusToHistory(
						Mage_Sales_Model_Order::STATE_CANCELED,//$order->getStatus(),
						Mage::helper('apgpay')->__('Payment failed by apgpay!reason:'.$failure_reason)
					);
					$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
					$order->save();
				}
					$this->_redirect('checkout/onepage/failure');
					
			}
			if ($status == '00'){
				
					$this->_redirect('checkout/onepage/success');
					
			}
		}else{
			$this->_redirect('checkout/onepage/failure');
			
		}
	}
	
	public function notifyAction()
	{
	   $model = Mage::getModel('apgpay/payment');
		
		if ($this->getRequest()->isPost()) {
			$rData = $this->getRequest()->getPost();
        	$method = 'post';

		} else if ($this->getRequest()->isGet()) {
			$rData = $this->getRequest()->getQuery();
			$method = 'get';

		} else {
			$model->generateErrorResponse();
		}
		
		
		//������
		$order_no= $rData["order_no"];
		
		$order = Mage::getModel('sales/order')->loadByIncrementId($order_no);
		if (!$order){
			die('wrong orderno');
		}
		
		$hash = $rData["hash"];
		$amount = $rData["amount"];
		$failure_reason = $rData["failure_reason"];
		$trans_date = $rData["trans_date"];
		$trans_time = $rData["trans_time"];
		$status = $rData["status"];
		$ref_no = $rData["ref_no"];
		$invoice_id = $rData["invoice_id"];		
		$merchant_id = $rData["merchant_id"];
		$order_no = $rData["order_no"];
		
		//״̬
		$currency = $rData["currency"];
		//ǩ��
		
		//md5
	    $MD5key = $model->getConfigData('md5_msg');
		
		$jmyc =  $MD5key.$amount.$currency.$failure_reason.$invoice_id.$merchant_id.$order_no.$ref_no.$status.$trans_date.$trans_time;
		$jmh = hash('sha256', $jmyc);
		/*echo $jmyc;
		echo "<br>";
		$jmh = hash('sha256', $jmyc);
		echo $hash;
		echo "<br>";
		echo $jmh;
		echo "<br>";*/
		//var_dump($order->getPayment());exit;
		if (strtoupper($jmh) == $hash){
			/*
				if (...){
					$this->_redirect('checkout/onepage/success');
				}else{
				$this->_redirect('checkout/onepage/failure');
				}
			*/
			if ($status == '01'){
				if ($order->state <> $model->getConfigData('order_status_payment_success')){
				  $order->addStatusToHistory(
						$model->getConfigData('order_status_payment_success'),//$order->getStatus(),
						Mage::helper('apgpay')->__('Payment success by apgpay!')
					);
					$order->setState($model->getConfigData('order_status_payment_success'), true);
					$order->save();
				}
					$this->saveInvoice($order);
					echo "success";
					exit;
			}
			if ($status == '02'){
				if ($order->state <> Mage_Sales_Model_Order::STATE_CANCELED){
					$order->addStatusToHistory(
						Mage_Sales_Model_Order::STATE_CANCELED,//$order->getStatus(),
						Mage::helper('apgpay')->__('Payment failed by apgpay!reason:'.$failure_reason)
					);
					$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
					$order->save();
				}
					echo "success";
					exit;
			}
			if ($status == '00'){
				
					echo "success";
					exit;
			}
		}else{
			echo "sign is error";
			exit;	
		}
	}
	protected function saveInvoice(Mage_Sales_Model_Order $order)
    {    
        if ($order->canInvoice() && !$order->hasInvoices()) {
			$invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();
			if (!$invoice->getTotalQty()) {
				Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
			}
			$invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
			$invoice->register();
			$transactionSave = Mage::getModel('core/resource_transaction')
				->addObject($invoice)
				->addObject($invoice->getOrder());
			$transactionSave->save();
			return true;
        }

        return false;
    }
		
	/**
	 *  Failure payment page
	 *
	 *  @param    none
	 *  @return	  void
	 */
	public function errorAction()
	{
		$session = Mage::getSingleton('checkout/session');
		$errorMsg = Mage::helper('apgpay')->__(' There was an error occurred during paying process.');

		$order = $this->getOrder();

		if (!$order->getId()) {
			$this->norouteAction();
			return;
		}
		if ($order instanceof Mage_Sales_Model_Order && $order->getId()) {
			$order->addStatusToHistory(
			Mage_Sales_Model_Order::STATE_CANCELED,//$order->getStatus(),
			Mage::helper('apgpay')->__('Customer returned from CreditCard.') . $errorMsg
			);

			$order->save();
		}

		$this->loadLayout();
		$this->renderLayout();
		Mage::getSingleton('checkout/session')->unsLastRealOrderId();
	}
}
