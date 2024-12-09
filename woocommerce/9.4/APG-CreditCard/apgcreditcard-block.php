<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class APGcreditcard_Gateway_Blocks extends AbstractPaymentMethodType {

    private $gateway;
    protected $name = 'apgcreditcard';
    public function initialize() {
        $this->settings = get_option( 'woocommerce_apgcreditcard_settings', [] );
        $this->gateway = new WC_Gateway_APGcreditcard();
    }

    public function is_active() {
        return $this->gateway->is_available();
    }

    public function get_payment_method_script_handles() {

        wp_register_script(
            'apgcreditcard-blocks-integration',
            plugin_dir_url(__FILE__) . 'js/apgcreditcard-block.js',
            [
                'wc-blocks-registry',
                'wc-settings',
                'wp-element',
                'wp-html-entities',
                'wp-i18n',
            ],
            null,
            true
        );
        if( function_exists( 'wp_set_script_translations' ) ) {            
            wp_set_script_translations( 'apgcreditcard-blocks-integration');
            
        }


        return [ 'apgcreditcard-blocks-integration' ];
    }


    public function get_payment_method_data() {
        $icons = [];
        if(isset($this->settings['logo'])){
            $logo = $this->settings['logo'];
            if(!empty($logo)) {
                foreach ($logo as $vo) {
                    $icons[] = array(
                        'id' => $vo . '_icon',
                        'alt' => $vo,
                        'src' => WC_HTTPS::force_https_url(plugins_url('images/' . $vo . '.png', __FILE__))
                    );
                }
            }
        }

        return [
            'title' => $this->gateway->title,
            'description' => $this->gateway->description,
            'icons'=>$icons
        ];
    }

}
?>