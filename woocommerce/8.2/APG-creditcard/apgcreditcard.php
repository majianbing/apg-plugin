<?php
/*
	Plugin Name: WooCommerce Apgpayment CreditCard Gateway
	Plugin URI: https://doc.next-api.com/web/#/5/40
	Description: WooCommerce Apgpayment CreditCard Gateway.
	Version: 1.2
	Author: Apgpayment
	Author URI: https://doc.next-api.com/web/#/5/40
	Requires at least: 1.0
	Tested up to: 1.0
*/


/**
 * Plugin updates
 */

load_plugin_textdomain( 'wc_apgcreditcard', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );

add_action( 'plugins_loaded', 'woocommerce_apgcreditcard_init', 0 );

/**
 * Initialize the gateway.
 *
 * @since 2.4.1
 */
function woocommerce_apgcreditcard_init() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

	require_once( plugin_basename( 'class-wc-apgcreditcard.php' ) );

	add_filter('woocommerce_payment_gateways', 'woocommerce_apgcreditcard_add_gateway' );

} // End woocommerce_apgcreditcard_init()

/**
 * Add the gateway to WooCommerce
 *
 * @since 2.4.1
 */
function woocommerce_apgcreditcard_add_gateway( $methods ) {
	$methods[] = 'WC_Gateway_Apgcreditcard';
	return $methods;
} // End woocommerce_apgcreditcard_add_gateway()