<?php
/**
 *  Give 2Checkout Settings
 *
 * @description:
 * @copyright  : http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      : 1.0
 * @created    : 11/24/2015
 */


// adds the settings to the Payment Gateways section
function give_add_twocheckout_settings( $settings ) {

	$give_settings = array(
		array(
			'name' => '<strong>' . __( '2Checkout Gateway', 'give-twocheckout' ) . '</strong>',
			'desc' => '<hr>',
			'type' => 'give_title',
			'id'   => 'give_title_twocheckout',
		),
		array(
			'id'   => 'twocheckout-sellerId',
			'name' => __( 'Account Number', 'give-twocheckout' ),
			'desc' => __( 'Please enter your 2Checkout account number.', 'give-twocheckout' ),
			'type' => 'text'
		),
		array(
			'id'   => 'twocheckout-public-key',
			'name' => __( 'API Publishable Key', 'give-twocheckout' ),
			'desc' => __( 'Please enter your 2Checkout API publishable key.', 'give-twocheckout' ),
			'type' => 'text'
		),
		array(
			'id'   => 'twocheckout-private-key',
			'name' => __( 'API Private Key', 'give-twocheckout' ),
			'desc' => __( 'Please enter your 2Checkout API private key.', 'give-twocheckout' ),
			'type' => 'text'
		)
	);

	return array_merge( $settings, $give_settings );
}

add_filter( 'give_settings_gateways', 'give_add_twocheckout_settings' );
