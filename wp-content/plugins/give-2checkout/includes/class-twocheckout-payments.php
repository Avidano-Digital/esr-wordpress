<?php

/**
 *  Give_Twocheckout_Payments
 *
 * @description:
 * @copyright  : http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since      : 1.0
 */
class Give_Twocheckout_Payments {

	/**
	 * Give_Twocheckout_Payments constructor.
	 */
	function __construct() {

		add_action( 'give_gateway_twocheckout', array( $this, 'give_process_twocheckout_payment' ), 10, 1 );

	}

	/**
	 * 2Checkout Payments
	 *
	 * @param $purchase_data
	 */
	public function give_process_twocheckout_payment( $purchase_data ) {

		$twocheckout_private_key = give_get_option( 'twocheckout-private-key' );
		$twocheckout_sellerID    = give_get_option( 'twocheckout-sellerId' );

		//Error checks
		if ( ! isset( $_POST['card_number'] ) || $_POST['card_number'] == '' ) {
			give_set_error( 'empty_card', __( 'You must enter a card number', 'give' ) );
		}
		if ( ! isset( $_POST['card_name'] ) || $_POST['card_name'] == '' ) {
			give_set_error( 'empty_card_name', __( 'You must enter the name on your card', 'give' ) );
		}
		if ( ! isset( $_POST['card_exp_month'] ) || $_POST['card_exp_month'] == '' ) {
			give_set_error( 'empty_month', __( 'You must enter an expiration month', 'give' ) );
		}
		if ( ! isset( $_POST['card_exp_year'] ) || $_POST['card_exp_year'] == '' ) {
			give_set_error( 'empty_year', __( 'You must enter an expiration year', 'give' ) );
		}
		if ( ! isset( $_POST['card_cvc'] ) || $_POST['card_cvc'] == '' || strlen( $_POST['card_cvc'] ) < 3 ) {
			give_set_error( 'empty_cvc', __( 'You must enter a valid CVC', 'give' ) );
		}
		if ( ! isset( $_POST['token'] ) || $_POST['token'] == '' ) {
			give_set_error( 'missing_token', __( 'Invalid request: missing token. Check payment gateway in the plugin settings.', 'give' ) );
		}
		if ( ! isset( $twocheckout_private_key ) || $twocheckout_private_key == '' ) {
			give_set_error( 'private_key', __( 'Missing API account number or keys. Check the plugin settings.', 'give-authorize' ) );
		}

		$errors = give_get_errors();

		//No errors: Continue with payment processing
		if ( ! $errors ) {

			//Include 2Checkout API
			require_once( GIVE_TWOCHECKOUT_PLUGIN_DIR . '/includes/2checkout-php/lib/Twocheckout.php' );

			//Pass credentials to Twocheckout object
			Twocheckout::privateKey( $twocheckout_private_key );
			Twocheckout::sellerId( $twocheckout_sellerID );
			Twocheckout::verifySSL( false ); // Take out in production
			Twocheckout::format( 'json' );

			//Check for sandbox
			if ( give_is_test_mode() ) {
				Twocheckout::sandbox( true );
			}

			$form_id  = intval( $purchase_data['post_data']['give-form-id'] );
			$price_id = isset( $purchase_data['post_data']['give-price-id'] ) ? intval( $purchase_data['post_data']['give-price-id'] ) : 0;

			//Begin 2Checkout API Request
			$payment_data = array(
				'price'           => $purchase_data['price'],
				'give_form_title' => $purchase_data['post_data']['give-form-title'],
				'give_form_id'    => $form_id,
				'price_id'        => $price_id,
				'date'            => $purchase_data['date'],
				'user_email'      => $purchase_data['user_email'],
				'purchase_key'    => $purchase_data['purchase_key'],
				'currency'        => give_get_currency(),
				'user_info'       => $purchase_data['user_info'],
				'status'          => 'pending',
				'gateway'         => '2Checkout'
			);

			$total      = $purchase_data['price'];
			$currency   = $payment_data['currency'];
			$card_info  = $purchase_data['card_info'];
			$card_names = explode( ' ', $card_info['card_name'] );
			$first_name = isset( $card_names[0] ) ? $card_names[0] : $purchase_data['user_info']['first_name'];

			//Format name
			if ( ! empty( $card_names[1] ) ) {
				unset( $card_names[0] );
				$last_name = implode( ' ', $card_names );
			} else {
				$last_name = $purchase_data['user_info']['last_name'];
			}

			$name    = $first_name . ' ' . $last_name;
			$address = $card_info['card_address'] . ' ' . $card_info['card_address_2'];
			$city    = $card_info['card_city'];
			$country = $card_info['card_country'];
			$state   = $card_info['card_state'];
			$zip     = $card_info['card_zip'];
			$email   = $purchase_data['user_email'];

			try {
				$charge = Twocheckout_Charge::auth( array(
					'sellerId'        => $twocheckout_sellerID,
					'merchantOrderId' => '0',
					'token'           => $_POST['token'],
					'currency'        => $currency,
					'lineItems'       => array(
						array(
							'type'      => 'product',
							'price'     => $total,
							'name'      => $this->generate_payment_name( $form_id, $price_id ),
							'productId' => $form_id
						)
					),
					'billingAddr'     => array(
						'name'      => $name,
						'addrLine1' => $address,
						'city'      => $city,
						'state'     => $state,
						'zipCode'   => $zip,
						'country'   => $country,
						'email'     => $email
					),
				) );

				$payment = give_insert_payment( $payment_data );

				if ( $payment ) {
					give_update_payment_status( $payment, 'publish' );
					give_send_to_success_page();
				} else {
					give_set_error( 'twocheckout_error', __( 'Your payment could not be recorded. Please try again.', 'give' ) );
					give_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['give-gateway'] );
				}

			}
			catch ( Twocheckout_Error $e ) {
				if ( strpos( $e->getMessage(), 'Payment Authorization Failed' ) !== false ) {
					give_set_error( 'invalid_card', __( 'Authorization failed. Please verify your credit card information, or try another payment method.', 'give' ) );
				} else if ( 'Unauthorized' === $e->getMessage() ) {
					give_set_error( 'keys_error', __( 'Incorrect API account number or keys. Check the plugin settings.', 'give' ) );
				} else {
					give_set_error( 'api_error', $e->getMessage() );
				}
				give_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['give-gateway'] );
			}

		} else {
			give_send_back_to_checkout( '?payment-mode=' . $purchase_data['post_data']['give-gateway'] );
		}
	}


	/**
	 * Generates payment name
	 *
	 * @param  integer $form_id
	 * @param  integer $price_id
	 *
	 * @return string
	 */
	public function generate_payment_name( $form_id, $price_id = 0 ) {

		$payment_name = get_post_field( 'post_title', $form_id );

		if ( 0 !== $price_id ) {
			$payment_name .= ' - ' . give_get_price_option_name( $form_id, $price_id );
		}

		return apply_filters( 'twocheckout_payment_name', $payment_name );

	}


}
