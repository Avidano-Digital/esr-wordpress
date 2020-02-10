<?php
/**
 * Give PayPal Pro Rest
 *
 * @package     Give
 * @copyright   Copyright (c) 2016, GiveWP
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Give_PayPal_Pro_Rest
 *
 * PayPal Pro REST Gateway for GiveWP.
 */
class Give_PayPal_Pro_Rest {

	/**
	 * PayPal Pro REST gateway ID.
	 *
	 * @var string
	 */
	public $id = 'paypalpro_rest';

	/**
	 * Give_PayPal_Pro_Rest constructor.
	 */
	public function __construct() {

		$this->billing_fields = give_get_option( 'paypal_rest_collect_billing' );

		add_filter( 'give_payment_gateways', array( $this, 'register_gateway' ) );
		add_filter( 'give_get_sections_gateways', array( $this, 'register_sections' ) );
		add_filter( 'give_get_settings_gateways', array( $this, 'add_settings' ) );
		add_action( 'give_gateway_' . $this->id, array( $this, 'process_payment' ) );
		add_action( 'give_donation_form_before_cc_form', array( $this, 'optional_billing_fields' ), 10, 1 );
	}

	/**
	 * Registers the PayPal REST gateway.
	 *
	 * @param array $gateways
	 *
	 * @return array
	 */
	public function register_gateway( $gateways ) {

		// Format: ID => Name
		$gateways[ $this->id ] = array(
			'admin_label'    => __( 'PayPal Website Payments Pro (REST API)', 'give-paypal-pro' ),
			'checkout_label' => __( 'Credit Card', 'give-paypal-pro' ),
		);

		return $gateways;
	}

	/**
	 * Register sections.
	 *
	 * @since  1.2.2
	 * @access public
	 *
	 * @param array $sections List of sections.
	 *
	 * @return array
	 */
	public function register_sections( $sections ) {
		$sections['paypal-website-payments-pro-rest-api'] = __( 'PayPal Website Payments Pro (REST API)', 'give-paypal-pro' );

		return $sections;
	}
	
	/**
	 * Register the gateway settings.
	 *
	 * Adds the settings to the Payment Gateways section (CMB2).
	 *
	 * @param $settings
	 *
	 * @access       public
	 * @since        1.0
	 * @return      array
	 */
	public function add_settings( $settings ) {

		switch ( give_get_current_setting_section() ) {

			case 'paypal-website-payments-pro-rest-api':
				$settings = array(
					array(
						'id'   => 'give_title_paypal_pro_rest',
						'type' => 'title',
						'desc' => '<p style="background: #FFF; padding: 15px;border-radius: 5px;">' . sprintf( __( 'This gateway supports single donations, and recurring donations for accounts that have DPRP enabled. To enable DPRP on your account you have to contact PayPal Support directly. This method communicates with PayPal more quickly than the NVP method. <a href="%s" target="_blank">Learn</a> which account type you currently have.', 'give-paypal-pro' ), 'http://docs.givewp.com/add-on-paypal-nvp' ) . '</p>',
					),
					array(
						'id'   => 'live_paypal_api_client_id',
						'name' => __( 'Live REST API Client ID', 'give-paypal-pro' ),
						'desc' => __( 'Enter your live REST API Client ID', 'give-paypal-pro' ),
						'type' => 'text',
						'size' => 'regular',
					),
					array(
						'id'   => 'live_paypal_api_secret',
						'name' => __( 'Live REST API Secret', 'give-paypal-pro' ),
						'desc' => __( 'Enter your live REST API Secret', 'give-paypal-pro' ),
						'type' => 'api_key',
						'size' => 'regular',
					),
					array(
						'id'   => 'sandbox_paypal_api_client_id',
						'name' => __( 'Sandbox REST API Client ID', 'give-paypal-pro' ),
						'desc' => __( 'Enter your Sandbox REST API Client ID', 'give-paypal-pro' ),
						'type' => 'text',
						'size' => 'regular',
					),
					array(
						'id'   => 'sandbox_paypal_api_secret',
						'name' => __( 'Sandbox REST API Secret', 'give-paypal-pro' ),
						'desc' => __( 'Enter your Sandbox REST API Secret', 'give-paypal-pro' ),
						'type' => 'api_key',
						'size' => 'regular',
					),
					array(
						'id'   => 'paypal_rest_collect_billing',
						'name' => __( 'Collect Billing Details', 'give-paypal-pro' ),
						'desc' => __( 'This option enables the billing details section for PayPal which requires the donor to fill in their address to complete a donation. These fields are not required by PayPal to process the transaction.', 'give-paypal-pro' ),
						'type' => 'checkbox',
					),
					array(
						'id'      => 'paypal_rest_invoice_prefix',
						'name'    => esc_html__( 'Invoice ID Prefix', 'give-paypal-pro' ),
						'desc'    => esc_html__( 'Please enter a prefix for your invoice numbers. If you use your PayPal account for multiple stores ensure this prefix is unique as PayPal will not allow orders with the same invoice number.', 'give-paypal-pro' ),
						'type'    => 'text',
						'default' => 'GIVE-',
					),
					array(
						'id'   => 'give_title_paypal_pro_rest',
						'type' => 'sectionend',
					),
				);
				break;
			} // End switch().

		return $settings;
	}

	/**
	 * Give PayPal Pro API Credentials.
	 *
	 * @return array
	 */
	public function api_credentials() {

		// TEST MODE
		if ( give_is_test_mode() ) {
			$sandbox_client_id_option = give_get_option( 'sandbox_paypal_api_client_id' );
			$sandbox_secret_option    = give_get_option( 'sandbox_paypal_api_secret' );

			$client_id = ! empty( $sandbox_client_id_option ) ? trim( $sandbox_client_id_option ) : null;
			$secret    = ! empty( $sandbox_secret_option ) ? trim( $sandbox_secret_option ) : null;

		} else {
			// LIVE MODE
			$live_client_id_option = give_get_option( 'live_paypal_api_client_id' );
			$live_secret_option    = give_get_option( 'live_paypal_api_secret' );

			$client_id = ! empty( $live_client_id_option ) ? trim( $live_client_id_option ) : null;
			$secret    = ! empty( $live_secret_option ) ? trim( $live_secret_option ) : null;
		}

		return apply_filters(
			'give_paypalpro_api_credentials', array(
				'client_id' => $client_id,
				'secret'    => $secret,
			)
		);

	}

	/**
	 * Processes the payment.
	 *
	 * @param array $payment_data
	 */
	public function process_payment( $payment_data ) {

		require_once GIVEPP_PLUGIN_DIR . '/lib/paypal/autoload.php';

		if ( ! wp_verify_nonce( $payment_data['gateway_nonce'], 'give-gateway' ) ) {
			wp_die( __( 'Nonce verification has failed.', 'give-paypal-pro' ), __( 'Error', 'give-paypal-pro' ), array( 'response' => 403 ) );
		}

		$validate = givepp_validate_post_fields( $payment_data['post_data'] );

		// Valid data?
		if ( $validate != true ) {
			give_send_back_to_checkout( '?payment-mode=' . $this->id );
		}

		// Give Form ID.
		$give_form_id = (int) $payment_data['post_data']['give-form-id'];

		$data = apply_filters(
			'give_paypalpro_rest_payment_args', array(
				'card_data'     => array(
					'number'          => $payment_data['card_info']['card_number'],
					'exp_month'       => $payment_data['card_info']['card_exp_month'],
					'exp_year'        => $payment_data['card_info']['card_exp_year'],
					'cvc'             => $payment_data['card_info']['card_cvc'],
					'card_type'       => givepp_get_card_type( $payment_data['card_info']['card_number'] ),
					'first_name'      => $payment_data['user_info']['first_name'],
					'last_name'       => $payment_data['user_info']['last_name'],
					'billing_address' => $payment_data['card_info']['card_address'] . ' ' . $payment_data['card_info']['card_address_2'],
					'billing_city'    => $payment_data['card_info']['card_city'],
					'billing_state'   => $payment_data['card_info']['card_state'],
					'billing_zip'     => $payment_data['card_info']['card_zip'],
					'billing_country' => $payment_data['card_info']['card_country'],
					'email'           => $payment_data['post_data']['give_email'],
				),
				'currency_code' => give_get_currency( $give_form_id ),
				'price'         => round( $payment_data['price'], 2 ),
				'form_title'    => $payment_data['post_data']['give-form-title'],
				'form_id'       => $give_form_id,
			)
		);

		$cardDetails = array(
			'type'         => $data['card_data']['card_type'],
			'number'       => $data['card_data']['number'],
			'expire_month' => $data['card_data']['exp_month'],
			'expire_year'  => $data['card_data']['exp_year'],
			'cvv2'         => $data['card_data']['cvc'],
			'first_name'   => $data['card_data']['first_name'],
			'last_name'    => $data['card_data']['last_name'],
		);

		$card = $this->create_card( $cardDetails );

		// ### FundingInstrument
		// A resource representing a Payer's funding instrument.
		// For direct credit card payments, set the CreditCard
		// field on this object.
		$fi = new \PayPal\Api\FundingInstrument();
		$fi->setCreditCard( $card );

		// ### Payer
		// A resource representing a Payer that funds a payment
		// For direct credit card payments, set payment method
		// to 'credit_card' and add an array of funding instruments.
		$payer = new \PayPal\Api\Payer();

		// Payer Info
		$payerInfoArray = apply_filters( 'give_paypal_rest_payer_info_args', array(
			'first_name' => isset( $payment_data['user_info']['first_name'] ) ? $payment_data['user_info']['first_name'] : '',
			'last_name'  => isset( $payment_data['user_info']['last_name'] ) ? $payment_data['user_info']['last_name'] : '',
			'email'      => isset( $payment_data['user_info']['email'] ) ? $payment_data['user_info']['email'] : '',
		) );
		$payerInfo      = new \PayPal\Api\PayerInfo( $payerInfoArray );

		$payer->setPaymentMethod( 'credit_card' )
		      ->setFundingInstruments( array( $fi ) )
		      ->setPayerInfo( $payerInfo );

		// Add Payers Billing Address if Enabled.
		$collect_billing_info = give_get_option( 'paypal_rest_collect_billing' );
		if ( give_is_setting_enabled( $collect_billing_info ) ) {
			$billingAddress = new \PayPal\Api\Address();
			$billingAddress->setLine1( isset( $payment_data['user_info']['line1'] ) ? $payment_data['user_info']['line1'] : '' )
			               ->setLine2( isset( $payment_data['user_info']['line2'] ) ? $payment_data['user_info']['line2'] : '' )
			               ->setCity( isset( $payment_data['user_info']['city'] ) ? $payment_data['user_info']['city'] : '' )
			               ->setState( isset( $payment_data['user_info']['state'] ) ? $payment_data['user_info']['state'] : '' )
			               ->setPostalCode( isset( $payment_data['user_info']['zip'] ) ? $payment_data['user_info']['zip'] : '' )
			               ->setCountryCode( isset( $payment_data['user_info']['country'] ) ? $payment_data['user_info']['country'] : '' );
		}

		// ### Amount
		// Lets you specify a payment amount.
		// You can also specify additional details
		// such as shipping, tax.
		$amount = new \PayPal\Api\Amount();
		$amount->setCurrency( $data['currency_code'] )
		       ->setTotal( $data['price'] );

		// ### Transaction
		// A transaction defines the contract of a
		// payment - what is the payment for and who
		// is fulfilling it.
		$transaction     = new \PayPal\Api\Transaction();
		$description     = give_payment_gateway_item_title( $payment_data );
		$soft_descriptor = $this->get_soft_descriptor( $description );

		// Proceed with transaction
		$transaction->setAmount( $amount )
		            ->setDescription( $description )// Limited to 127 chars
		            ->setSoftDescriptor( $soft_descriptor )// Limited to 22 chars
		            ->setInvoiceNumber( $payment_data['purchase_key'] );

		// ### Payment
		// A Payment Resource; create one using
		// the above types and intent set to sale 'sale'
		$payment = new \PayPal\Api\Payment();
		$payment->setIntent( 'sale' )
		        ->setPayer( $payer )
		        ->setTransactions( array( $transaction ) );

		// ### Create Payment
		// Create a payment by calling the payment->create() method
		// with a valid ApiContext; the return object contains the state.
		$apiContext = $this->get_token();

		// ### Create Payment
		// Create a payment by calling the payment->create() method
		// with a valid ApiContext; the return object contains the state.
		try {

			$response = $payment->create( $apiContext );

		} catch ( PayPal\Exception\PayPalConnectionException $ex ) {

			$gateway_error = array(
				'error_code'    => $ex->getCode(),
				'error_message' => $ex->getData(),
			);

			give_set_error( 'payment_error', sprintf( __( 'There was an issue processing your donation: %1$s Please try again.', 'give-paypal-pro' ), $ex->getData() ) );
			give_record_gateway_error( __( 'PayPal Pro REST Error', 'give-paypal-pro' ), sprintf( __( 'PayPal Pro REST returned an error while processing a donation. Details: %s', 'give-paypal-pro' ), json_encode( $gateway_error ) ) );
			give_send_back_to_checkout( '?payment-mode=' . $this->id );

		} catch ( Exception $ex ) {

			$gateway_error = array(
				'error_code'    => $ex->getCode(),
				'error_message' => $ex->getMessage(),
			);

			give_set_error( 'payment_error', sprintf( __( 'There was an issue processing your donation: %1$s. Please try again.', 'give-paypal-pro' ), $ex->getMessage() ) );
			give_record_gateway_error( __( 'PayPal Pro REST Error', 'give-paypal-pro' ), sprintf( __( 'PayPal Pro REST returned an error while processing a donation. Details: %s', 'give-paypal-pro' ), json_encode( $gateway_error ) ) );
			give_send_back_to_checkout( '?payment-mode=' . $this->id );

		}

		if ( 'failed' === $response->state ) {

			give_set_error( 'payment_error', sprintf( __( 'An error occurred while processing the donation: %1$s. Please try again.', 'give-paypal-pro' ), $response->failure_reason ) );
			give_record_gateway_error( __( 'PayPal Pro REST Error', 'give-paypal-pro' ), sprintf( __( 'PayPal Pro REST returned an error while processing a donation. Details: %s', 'give-paypal-pro' ), json_encode( $response->failure_reason ) ) );
			give_send_back_to_checkout( '?payment-mode=' . $this->id );

		} elseif ( in_array(
			$response->state,
			array(
				'created',
				'approved',
			)
		)
		) {
			// Payment complete, log to Give and return user to success page.
			// Setup the payment details.
			$payment_data = array(
				'price'           => $payment_data['price'],
				'give_form_title' => $payment_data['post_data']['give-form-title'],
				'give_form_id'    => intval( $payment_data['post_data']['give-form-id'] ),
				'date'            => $payment_data['date'],
				'user_email'      => $payment_data['post_data']['give_email'],
				'purchase_key'    => $payment_data['purchase_key'],
				'currency'        => give_get_currency( $give_form_id ),
				'user_info'       => $payment_data['user_info'],
				'status'          => 'pending',
			);

			// record this payment.
			$payment_id = give_insert_payment( $payment_data );

			$transactions      = $response->getTransactions();
			$related_resources = $transactions[0]->getRelatedResources();
			$sale              = $related_resources[0]->getSale();
			$transaction_id    = $sale->getId();

			give_insert_payment_note( $payment_id, sprintf( __( 'PayPal Pro REST Transaction ID: %s', 'give-paypal-pro' ), $transaction_id ) );
			give_set_payment_transaction_id( $payment_id, $transaction_id );
			// complete the purchase.
			give_update_payment_status( $payment_id, 'publish' );
			give_send_to_success_page(); // this function redirects and exits itself
		}
	}

	/**
	 * Get OAUTH2 access token from Paypal.
	 *
	 * @return \PayPal\Rest\ApiContext
	 */
	public function get_token() {

		$credentials = $this->api_credentials();

		$apiContext = new \PayPal\Rest\ApiContext(
			new \PayPal\Auth\OAuthTokenCredential(
				$credentials['client_id'],     // ClientID.
				$credentials['secret']      // ClientSecret.
			)
		);

		// PP Partner ID.
		$apiContext->addRequestHeader( 'PayPal-Partner-Attribution-Id', 'givewp_SP' );

		// PP is always in test mode, must pass flag if doing live transactions.
		if ( ! give_is_test_mode() ) {
			$apiContext->setConfig(
				array(
					'mode' => 'live',
				)
			);
		}

		return $apiContext;
	}

	/**
	 * Instantiate a new CC object for use with PayPal API.
	 *
	 * @param array $data
	 *
	 * @return \PayPal\Api\CreditCard
	 */
	public function create_card( $data = array() ) {
		$defaults = array(
			'type'         => '',
			'number'       => '',
			'expire_month' => '',
			'expire_year'  => '',
			'cvv2'         => '',
			'first_name'   => '',
			'last_name'    => '',
		);

		$data = wp_parse_args( $data, $defaults );

		$creditCard = new \PayPal\Api\CreditCard( $data );

		return $creditCard;
	}

	/**
	 * Get Soft Descriptor.
	 *
	 * Uses the payment description & sanitizes according to PayPal's requirements.
	 *
	 * @param $description
	 *
	 * @return string
	 */
	private function get_soft_descriptor( $description ) {

		// Limited to 22 characters.
		$descriptor = substr( get_bloginfo( 'name' ) . '-' . $description, 0, 22 );

		$descriptor = preg_replace( '/[^A-Za-z0-9\-]/', '', $descriptor ); // Removes special chars.

		return apply_filters( 'givepp_rest_soft_descriptor', $descriptor );
	}

	/**
	 * Optional Billing Fields.
	 *
	 * @param $form_id
	 *
	 * @return void
	 */
	public function optional_billing_fields( $form_id ) {

		$chosen_gateway = give_get_chosen_gateway( $form_id );

		// Remove Address Fields if user has option enabled
		if ( ! $this->billing_fields && $chosen_gateway == $this->id ) {
			remove_action( 'give_after_cc_fields', 'give_default_cc_address_fields' );
		}

	}

}
