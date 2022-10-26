<?php
class ControllerPaymentApgpay extends Controller {
	private $error = array();

    public function index() {
        $this->load->language('payment/apgpay');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('apgpay', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['text_edit'] = $this->language->get('text_edit');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_all_zones'] = $this->language->get('text_all_zones');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_authorization'] = $this->language->get('text_authorization');
        $this->data['text_sale'] = $this->language->get('text_sale');
        $this->data['text_iframe'] = $this->language->get('text_iframe');
        $this->data['text_redirect'] = $this->language->get('text_redirect');
        $this->data['text_vertical'] = $this->language->get('text_vertical');
        $this->data['text_horizontal'] = $this->language->get('text_horizontal');
        $this->data['text_live'] = $this->language->get('text_live');
        $this->data['text_test'] = $this->language->get('text_test');


        $this->data['entry_apgpay_merchant_id'] = $this->language->get('entry_apgpay_merchant_id');
        $this->data['entry_apgpay_private_key'] = $this->language->get('entry_apgpay_private_key');
        $this->data['entry_apgpay_mode'] = $this->language->get('entry_apgpay_mode');
        $this->data['entry_apgpay_status'] = $this->language->get('entry_apgpay_status');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_apgpay_payment_method'] = $this->language->get('entry_apgpay_payment_method');
        $this->data['entry_apgpay_order_status_id'] = $this->language->get('entry_apgpay_order_status_id');
        $this->data['entry_apgpay_order_status_fail_id'] = $this->language->get('entry_apgpay_order_status_fail_id');
        $this->data['entry_apgpay_order_status_processing_id'] = $this->language->get('entry_apgpay_order_status_processing_id');
        $this->data['entry_apgpay_style_body'] = $this->language->get('entry_apgpay_style_body');
        $this->data['entry_apgpay_style_title'] = $this->language->get('entry_apgpay_style_title');
        $this->data['entry_apgpay_style_button'] = $this->language->get('entry_apgpay_style_button');
        $this->data['entry_apgpay_style_layout'] = $this->language->get('entry_apgpay_style_layout');
        $this->data['entry_apgpay_title'] = $this->language->get('entry_apgpay_title');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['action'] = $this->url->link('payment/apgpay', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['breadcrumbs'] = array(
            array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
                'separator'=>'',
            ),
            array(
                'text' => $this->language->get('text_payment'),
                'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
                'separator'=>'::',
            ),
            array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('payment/apgpay', 'token=' . $this->session->data['token'], 'SSL'),
                'separator'=>'::',
            )
        );

        $this->data['error_apgpay_merchant_id'] = isset($this->error['apgpay_merchant_id']) ? $this->error['apgpay_merchant_id'] : '';
        $this->data['error_apgpay_private_key'] = isset($this->error['apgpay_private_key']) ? $this->error['apgpay_private_key'] : '';
        $this->data['error_apgpay_title'] = isset($this->error['apgpay_title']) ? $this->error['apgpay_title'] : '';
        $this->data['error_warning'] = isset($this->error['warning']) ? $this->error['warning'] : '';

        $this->data['apgpay_title'] = isset($this->request->post['apgpay_title']) ? $this->request->post['apgpay_title'] : $this->config->get('apgpay_title');
        $this->data['apgpay_merchant_id'] = isset($this->request->post['apgpay_merchant_id']) ? $this->request->post['apgpay_merchant_id'] : $this->config->get('apgpay_merchant_id');
        $this->data['apgpay_private_key'] = isset($this->request->post['apgpay_private_key']) ? $this->request->post['apgpay_private_key'] : $this->config->get('apgpay_private_key');
        $this->data['apgpay_mode'] = isset($this->request->post['apgpay_mode']) ? $this->request->post['apgpay_mode'] : $this->config->get('apgpay_mode');
        $this->data['apgpay_style_body'] = isset($this->request->post['apgpay_style_body']) ? $this->request->post['apgpay_style_body'] : $this->config->get('apgpay_style_body');
        $this->data['apgpay_style_title'] = isset($this->request->post['apgpay_style_title']) ? $this->request->post['apgpay_style_title'] : $this->config->get('apgpay_style_title');
        $this->data['apgpay_style_button'] = isset($this->request->post['apgpay_style_button']) ? $this->request->post['apgpay_style_button'] : $this->config->get('apgpay_style_button');
        $this->data['apgpay_style_layout'] = isset($this->request->post['apgpay_style_layout']) ? $this->request->post['apgpay_style_layout'] : $this->config->get('apgpay_style_layout');
        $this->data['apgpay_status'] = isset($this->request->post['apgpay_status']) ? $this->request->post['apgpay_status'] : $this->config->get('apgpay_status');
        $this->data['apgpay_sort_order'] = isset($this->request->post['apgpay_sort_order']) ? $this->request->post['apgpay_sort_order'] : $this->config->get('apgpay_sort_order');
        $this->data['apgpay_payment_method'] = isset($this->request->post['apgpay_payment_method']) ? $this->request->post['apgpay_payment_method'] : $this->config->get('apgpay_payment_method');

        $this->load->model('localisation/order_status');
        $this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->data['apgpay_order_status_id'] = isset($this->request->post['apgpay_order_status_id']) ? $this->request->post['apgpay_order_status_id'] : $this->config->get('apgpay_order_status_id');
        $this->data['apgpay_order_status_processing_id'] = isset($this->request->post['apgpay_order_status_processing_id']) ? $this->request->post['apgpay_order_status_processing_id'] : $this->config->get('apgpay_order_status_processing_id');
        $this->data['apgpay_order_status_fail_id'] = isset($this->request->post['apgpay_order_status_fail_id']) ? $this->request->post['apgpay_order_status_fail_id'] : $this->config->get('apgpay_order_status_fail_id');

        $this->template = 'payment/apgpay.tpl';
        $this->children = array('common/header', 'common/footer');

        $this->response->setOutput($this->render());
    }

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/apgpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['apgpay_merchant_id']) {
			$this->error['apgpay_merchant_id'] = $this->language->get('error_apgpay_merchant_id');
		}

		if (!$this->request->post['apgpay_private_key']) {
			$this->error['apgpay_private_key'] = $this->language->get('error_apgpay_private_key');
		}

        if (!$this->request->post['apgpay_title']) {
            $this->error['apgpay_title'] = $this->language->get('error_apgpay_title');
        }

		return !$this->error;
	}

	public function install(){
        return true;
	}

    public function uninstall(){
        return true;
    }
}