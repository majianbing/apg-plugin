<?php
/**
 * E: sales@gloprocessor.com
 * W:www.magento.con
 */
 
class Magento91_Apgpay_PaymentController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Order instance
	 */
	protected $_order;
	protected $_tradeNo;
	protected $_orderNo;
	protected $_notifyTime;
	protected $_tradeStatus;
	protected $_signType;
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
		Mage::helper('apgpay')->__('Customer was redirected to APG')
		);
		$order->save();
		//$order->sendNewOrderEmail();
		
		$this->getResponse()
		->setBody($this->getLayout()
		->createBlock('apgpay/redirect')
		->setOrder($order)
		->toHtml());
	}

	

	
	public function generateErrorResponse() {
		die ( $this->getErrorResponse () );
	}
	
	private function _validated()
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
		

		$tradeNo = $rData["tradeNo"];
		$orderNo = $rData["orderNo"];
		$notifyTime = $rData["notifyTime"];
		$tradeStatus = $rData["tradeStatus"];
		$signType = $rData["signType"];
		$success = $rData["success"];
		$sign = $rData["sign"];
	    $MD5key = $model->getConfigData('md5_msg');
		$this->_tradeNo = $tradeNo;
		$this->_orderNo = $orderNo;
		$this->_notifyTime = $notifyTime;
		$this->_tradeStatus = $tradeStatus;
		$this->_signType = $signType;
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
		$sourcestr .= $MD5key;
		$myjm = md5($sourcestr);
		$this->writeLog('./apgpaylog.txt',date('Y-m-d H:i:s').'---'.'Customer back from APG:'.$myhis);
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
		
		

        $merOrderNo= $rData["merOrderNo"];
		
		$order = Mage::getModel('sales/order')->loadByIncrementId($merOrderNo);
		if (!$order){
			die('wrong orderno');
		}
		
		$hash = $rData["sign"];
		$amount = $rData["payAmount"];
		$failure_reason = $rData["failure_reason"];
        $failure_reason_desc = $rData["respDesc"];
		$tranCode = $rData["tranCode"];
		$trans_time = $rData["trans_time"];
		$respStatus = $rData["respStatus"];
		$ref_no = $rData["ref_no"];
        $referenceNo = $rData["referenceNo"];
		$merchant_id = $rData["merchantNo"];

		$payCurrency = $rData["payCurrency"];

	    $MD5key = $model->getConfigData('md5_msg');

		$befor_sign =  $merOrderNo.$referenceNo.$payCurrency.$respStatus.$MD5key;

        $jmh2 = hash('sha512', $befor_sign);

		if (strtolower($jmh2) == $hash){

			// = 1
			if ($respStatus == '1'){
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
			if ($respStatus == '0' || $respStatus == '3'){
				if ($order->state <> Mage_Sales_Model_Order::STATE_CANCELED){
					$order->addStatusToHistory(
						Mage_Sales_Model_Order::STATE_CANCELED,
						Mage::helper('apgpay')->__('Payment failed by APG ! reason:'.$failure_reason_desc)
					);
					$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
					$order->save();
				}
					$this->_redirect('checkout/onepage/failure');
					
			}
			if ($respStatus == '2'){
				
					$this->_redirect('checkout/onepage/success');
					
			}
		}else{
			$this->_redirect('checkout/onepage/failure');
			echo "sign check failed \n";
			echo $jmh2. "\n";
			echo $hash.  "\n";
		}
	}

    /**
     * �첽֪ͨ
     */
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
		

        $merOrderNo= $rData["merOrderNo"];
		
		$order = Mage::getModel('sales/order')->loadByIncrementId($merOrderNo);
		if (!$order){
			die('wrong orderno');
		}

        $hash = $rData["sign"];
		$amount = $rData["amount"];
		$failure_reason = $rData["respCode"];
		$failure_reason_desc = $rData["respDesc"];
		$respStatus = $rData["respStatus"];
		$ref_no = $rData["ref_no"];
		$referenceNo = $rData["referenceNo"];
		$merchant_id = $rData["merchant_id"];

		$payCurrency = $rData["payCurrency"];

		//md5
	    $MD5key = $model->getConfigData('md5_msg');

        $befor_sign =  $merOrderNo.$referenceNo.$payCurrency.$respStatus.$MD5key;
		$jmh = hash('sha512', $befor_sign);

		if (strtolower($jmh) == $hash){

			if ($respStatus == '1'){
				if ($order->state <> $model->getConfigData('order_status_payment_success')){
				  $order->addStatusToHistory(
						$model->getConfigData('order_status_payment_success'),//$order->getStatus(),
						Mage::helper('apgpay')->__('Payment success by APG!')
					);
					$order->setState($model->getConfigData('order_status_payment_success'), true);
					$order->save();
				}
					$this->saveInvoice($order);
					echo "success";
					exit;
			}
			if ($respStatus == '0'){
				if ($order->state <> Mage_Sales_Model_Order::STATE_CANCELED){
					$order->addStatusToHistory(
						Mage_Sales_Model_Order::STATE_CANCELED,//$order->getStatus(),
						Mage::helper('apgpay')->__('Payment failed by APG! Reason:'.$failure_reason_desc)
					);
					$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, true);
					$order->save();
				}
					echo "success";
					exit;
			}
			if ($respStatus == '2'){
				
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