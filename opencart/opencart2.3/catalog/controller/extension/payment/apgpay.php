<?php

class ControllerExtensionPaymentApgpay extends Controller{

    public function index()
    {
        $this->load->model('checkout/order');
        $this->load->model('extension/payment/apgpay');
        $this->load->model('localisation/country');
        $this->load->model('localisation/zone');
        $this->load->model('account/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $shipping_country = $this->model_localisation_country->getCountry($order_info['shipping_country_id']);
        $payment_country = $this->model_localisation_country->getCountry($order_info['payment_country_id']);
        $payment_zone = $this->model_localisation_zone->getZone($order_info['payment_zone_id']);
        $shipping_zone = $this->model_localisation_zone->getZone($order_info['shipping_zone_id']);
        $order_product = $this->model_account_order->getOrderProducts($order_info['order_id']);

        $this->model_extension_payment_apgpay->initConfig();

        $data['apgpay_params'] = array(
            'product_name'=>$order_product[0]['name'],
            'product_quantity'=>$order_product[0]['quantity'],
            'product_price'=>$this->currency->format($order_product[0]['price'], $order_info['currency_code'], false, false),
            'invoice_id'=>$order_info['order_id'],
            'merOrderNo'=>$order_info['order_id'],
            'payCurrency'=>$order_info['currency_code'],
            'payAmount'=>$this->currency->format($order_info['total'], $order_info['currency_code'], false, false),
            'returnUrl'=>HTTPS_SERVER . 'index.php?route=extension/payment/apgpay/ipn&dh_rt=real_time',
            'notifyUrl'=>HTTPS_SERVER . 'index.php?route=extension/payment/apgpay/ipn&dh_rt=real_time',
            'remark'=>'',
            'goods'=>'[{"name":"product1","price":"0.01","num":1}]',
            'first_name'=>$order_info['payment_firstname'],
            'last_name'=>$order_info['payment_lastname'],
            'address_line'=>$order_info['payment_address_1'] . "\n" . $order_info['payment_address_2'],
//            'country'=>$payment_country['iso_code_2'],
//            'state'=>$payment_zone['code'],
            'city'=> $order_info['payment_city'],
            'buyer_email'=>$order_info['email'],
            'zipcode'=>$order_info['payment_postcode'],
//            'shipping_country'=>@$shipping_country['iso_code_2'],
            'shipping_first_name'=>$order_info['shipping_firstname'],
            'shipping_last_name'=>$order_info['shipping_lastname'],
//            'shipping_state'=>$shipping_zone['code'],
            'shipping_phone'=>$order_info['telephone'],
            'shipping_city'=>$order_info['shipping_city'],
            'shipping_address_line'=>$order_info['shipping_address_1'] . "\n" . $order_info['shipping_address_2'],
            'shipping_zipcode'=>$order_info['shipping_postcode'],
            'shipping_email'=>$order_info['email']
        );
        $data['button_confirm'] = $this->language->get('button_confirm');

        if (file_exists(DIR_APPLICATION . 'view/theme/' . $this->config->get('config_template') . '/extension/payment/apgpay.tpl')) {
            return $this->load->view(DIR_APPLICATION . 'view/theme/' . $this->config->get('config_template') . '/extension/payment/apgpay.tpl', $data);
        } else {
            return $this->load->view('extension/payment/apgpay.tpl', $data);
        }

    }

    public function ipn()
    {
        $this->load->model('extension/payment/apgpay');
        $this->load->model('checkout/order');

        $this->model_extension_payment_apgpay->ipn($this->request->get);
    }

}