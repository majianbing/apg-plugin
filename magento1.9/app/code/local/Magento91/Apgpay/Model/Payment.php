<?php

/**
 * E: jj632293@gmail.com
 * W:www.91magento.net
 */
class Magento91_Apgpay_Model_Payment extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'apgpay_payment';
    protected $_formBlockType = 'apgpay/form';


    // Order instance
    protected $_order = null;

    public function writeLog($file, $msg)
    {
        $file = @fopen($file, "a+");
        @fputs($file, $msg . "\n");
        @fclose($file);
    }

    public function canUseForCurrency($currencyCode)
    {

        return true;
    }

    /**
     * Return Order Place Redirect URL
     *
     * @return      string Order Redirect URL
     */
    public function getOrderPlaceRedirectUrl()
    {
        return Mage::getUrl('apgpay/payment/redirect', array('_secure' => true));
    }

    public function generateErrorResponse()
    {
        echo "error";
        exit;
    }

    /**
     * Return Standard Checkout Form Fields for request to 95EPAY
     *
     * @return      array Array of hidden form fields
     */
    public function getStandardCheckoutFormFields()
    {
        $session = Mage::getSingleton('checkout/session');
        $orderIncrementId = $session->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderIncrementId);
        if (!($order instanceof Mage_Sales_Model_Order)) {
            Mage::throwException($this->_getHelper()->__('Cannot retrieve order object'));
        }
        $sourcestr = "";

        $merchant_id = $this->getConfigData('merchantid');//合作伙伴ID

        $order_no = $invoice_id = $orderIncrementId;

        $currency = $order->getOrderCurrencyCode();//支付币种

        $amount = sprintf('%.2f', $order->getGrandTotal());//交易金额

        $storeCurrency = Mage::getSingleton('directory/currency')->load($order->order_currency_code);
        // user the exchange rate from system.
        $buyer_email = $order->getData('customer_email'); //账单地址用户邮箱

        $return_url = $errorNotifyUrl = Mage::getUrl('apgpay/payment/return', array('_secure' => true));
        $remark = Mage::getStoreConfig("web/unsecure/base_url") . ":" . $order_no;
        //$this->getConfigData ("notifyurl");//页面跳转同步通知页面路
        $configInfomations = Mage::getModel('apgpay/payment');
        $notifyUrl = $configInfomations->getConfigData('notifyurl');    //服务器异步通知页面路径
        $billingAddress = $order->getBillingAddress();

        $shipping_country = $billingAddress->getCountry();//账单地址国家
        $first_name = trim($billingAddress->getFirstname());//	账单地址用户姓
        $last_name = trim($billingAddress->getLastname());//账单地址用户名
        $zipcode = $billingAddress->getPostcode();//账单邮编

        $product_name = 'product-' . $order_no;//商品名称

        $product_quantity = 1;//商品数量
        $product_price = $amount;//商品单价
        //break;
        //}


        $address_line = trim($billingAddress->getStreetFull());//账单地址街道一
        $city = trim($billingAddress->getCity());//账单地址城市
        $country = $shipping_country;
        $state = trim($billingAddress->getRegion());//账单地址州
        $billToState = trim($billingAddress->getRegion());//账单地址国家

        $md5 = $this->getConfigData('md5_msg');

        $sourcestr_2 = $merchant_id . $invoice_id . $currency . $amount . $return_url . $md5;

        $hash2 = hash('sha512', $sourcestr_2);

        $submitdatas['merchantNo'] = $merchant_id;
        $submitdatas["merOrderNo"] = $invoice_id;
        $submitdatas["order_no"] = $order_no;
        $submitdatas["payCurrency"] = $currency;
        $submitdatas["payAmount"] = $amount;
        $submitdatas["email"] = $buyer_email;
        $submitdatas["returnUrl"] = $return_url;
        $submitdatas["notifyUrl"] = $notifyUrl;
        // 交易代码，目前只接入收银台支付，交易码固定TA002；API支付后期再接入
        $submitdatas["tranCode"] = "TA002";
        $submitdatas["goods"] = "[{\"name\":\"".$product_name."\",\"price\":\"".$product_price."\",\"nums\":10}]";
        $submitdatas["remark"] = $remark;
        $submitdatas["shipping_country"] = $shipping_country;
        $submitdatas["first_name"] = $first_name;
        $submitdatas["last_name"] = $last_name;
        $submitdatas["product_name"] = $product_name;
        $submitdatas["product_price"] = $product_price;
        $submitdatas["product_quantity"] = $product_quantity;
        $submitdatas["address_line"] = $address_line;
        $submitdatas["city"] = $city;
        // 妥投结算必填字段 begin
        $submitdatas["street"] = $address_line;
        $submitdatas["cityOrTown"] = $city;
        $submitdatas["countryOrRegion"] = $country;
        $submitdatas["stateOrProvince"] = $state;
        $submitdatas["postCodeOrZip"] = $zipcode;
        // 妥投结算必填字段 end
        $submitdatas["country"] = $country;
        $submitdatas["state"] = $state;
        $submitdatas["zipcode"] = $zipcode;
        $submitdatas["sign"] = strtoupper($hash2);
        return $submitdatas;
    }
}