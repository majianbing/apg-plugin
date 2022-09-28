<?php
require_once 'apgpay/apgpay_front_core.php';
require_once 'apgpay/apgpay_admin_core.php';
require_once 'apgpay/apgpay_ipn.php';

class ModelExtensionPaymentApgpay extends Model {


    public function initConfig(){
        $config = array();
        foreach(Apgpay_Admin_Core::$field as $field){
            $key = strtolower($field);
            $config[$field] = $this->config->get($key);

        }
        Apgpay_Admin_Core::initConfig($config);
    }

    /**
     *
     * 该方法必须有，payment_method.php中调用获取是否显示该支付方式.
     *
     * @param $address 地址
     * @param $total   支付金额
     *
     * @return array
     */
	public function getMethod($address, $total) {
        $this->initConfig();

        $method_data = array(
            'code' => 'apgpay',
            'title' => '<img src="https://www.apgpay.com/merchantaccount/zh_CN/v2/image/download/pay-3.jpg" />' . $this->config->get('apgpay_title'),
            'terms'      => '',
            'sort_order' => $this->config->get('apgpay_sort_order')
        );
        return $method_data;
	}



    public function ipn($data){
        $this->initConfig();
        $ipn = new ApgpayReturn($this->registry);
        return $ipn->init($data, APGPAY_ORDER_STATUS_PROCESSING_ID, APGPAY_ORDER_STATUS_FAIL_ID,APGPAY_ORDER_STATUS_ID);
    }

}