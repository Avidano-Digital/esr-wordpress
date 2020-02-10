<?php
/**
 * PayPal Pro Helper Functions
 *
 * @package     Give
 * @copyright   Copyright (c) 2016, GiveWP
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Parsed Return Query
 *
 * @param $post_data
 *
 * @return array
 */
function givepp_parsed_return_query( $post_data ) {
	$post_data = array(
		'billing_address'   => $post_data['card_address'],
		'billing_address_2' => $post_data['card_address_2'],
		'billing_city'      => $post_data['card_city'],
		'billing_country'   => $post_data['card_country'],
		'billing_zip'       => $post_data['card_zip'],
		'card_cvc'          => $post_data['card_cvc'],
		'card_exp_month'    => $post_data['card_exp_month'],
		'card_exp_year'     => $post_data['card_exp_year'],
	);
	$post_data = array_filter( $post_data );

	return $post_data;
}

/**
 * Validate Post Fields
 *
 * @param $purchase_data
 *
 * @return bool
 */
function givepp_validate_post_fields( $purchase_data ) {
	$validate = true;
	$number   = 0;
	foreach ( $purchase_data as $k => $v ) {
		if ( $v == '' ) {
			switch ( $k ) {
				case 'card_address':
					$k = __( 'Billing Address', 'give-paypal-pro' );
					break;
				case 'card_city':
					$k = __( 'Billing City', 'give-paypal-pro' );
					break;
				case 'card_zip':
					$k = __( 'Billing Zip', 'give-paypal-pro' );
					break;
				case 'card_number':
					$k = __( 'Credit Card Number', 'give-paypal-pro' );
					break;
				case 'card_cvc':
					$k = __( 'CVC Code', 'give-paypal-pro' );
					break;
				case 'card_exp_month':
					$k = __( 'Credit Card Expiration Month', 'give-paypal-pro' );
					break;
				case 'card_exp_year':
					$k = __( 'Credit Card Expiration Year', 'give-paypal-pro' );
					break;
				default:
					$k = false;
					break;
			}
			if ( $k != false ) {
				give_set_error( $number, sprintf( __( 'Invalid %s.', 'give-paypal-pro' ), $k ) );
				$validate = false;
				$number ++;
			}
		}
	}

	return $validate;
}

/**
 * Get Card Type
 *
 * @param $card_number
 *
 * @return string
 */
function givepp_get_card_type( $card_number ) {

	$card_number = preg_replace( '/[^\d]/', '', $card_number );

	if ( preg_match( '/^3[47][0-9]{13}$/', $card_number ) ) {
		return 'amex';
	} elseif ( preg_match( '/^6(?:011|5[0-9][0-9])[0-9]{12}$/', $card_number ) ) {
		return 'discover';
	} elseif ( preg_match( '/^5[1-5][0-9]{14}$/', $card_number ) ) {
		return 'mastercard';
	} elseif ( preg_match( '/^4[0-9]{12}(?:[0-9]{3})?$/', $card_number ) ) {
		return 'visa';
	} else {
		return 'unknown';
	}
}

/**
 * Given a Payment ID, extract the transaction ID
 *
 * @param string $payment_id Payment ID.
 *
 * @return string                   Transaction ID
 */
function givepp_pro_get_payment_transaction_id( $payment_id ) {

	$notes          = give_get_payment_notes( $payment_id );
	$transaction_id = null;
	foreach ( $notes as $note ) {
		if ( preg_match( '/^PayPal Pro Transaction ID: ([^\s]+)/', $note->comment_content, $match ) ) {
			$transaction_id = $match[1];
			continue;
		}
	}

	return apply_filters( 'givepp_set_payment_transaction_id', $transaction_id, $payment_id );
}

add_filter( 'give_get_payment_transaction_id-paypalpro', 'givepp_pro_get_payment_transaction_id', 10, 1 );


/**
 * Given a transaction ID, generate a link to the Stripe transaction ID details
 *
 * @since  1.0
 *
 * @param  string $transaction_id The Transaction ID.
 * @param  int    $payment_id     The payment ID for this transaction.
 *
 * @return string                 A link to the Transaction details
 */
function give_payflow_link_transaction_id( $transaction_id, $payment_id ) {

	if ( (int) $transaction_id === (int) $payment_id ) {
		return $payment_id;
	}

	$payment_mode = give_get_payment_meta( $payment_id, '_give_payment_mode', true );
	$test         = 'live' === $payment_mode ? '' : '&transReportMode=Test';

	$url = sprintf(
		'<a href="https://manager.paypal.com/getStandardDetails.do?subaction=transDetailsWithSB%1$s&reportName=DailyActivityReport&id=%2$s" target="_blank">%2$s</a>',
		$test,
		$transaction_id
	);

	return apply_filters( 'give_paypalpro_payflow_link_donation_details_transaction_id', $url, $payment_id );

}

add_filter( 'give_payment_details_transaction_id-paypalpro_payflow', 'give_payflow_link_transaction_id', 10, 2 );

/**
 * This function will show warning message to donor that their donation payment is set to review as fraudulent activity is detected.
 *
 * @param mixed  $notice      Donation notice text.
 * @param int    $id          ID.
 * @param string $status      Donation Status.
 * @param int    $donation_id Donation ID.
 *
 * @since 1.1.6
 *
 * @return string
 */
function give_payflow_receipt_fraud_status_notice( $notice, $id, $status, $donation_id ) {

	$fraud_activity = isset( $_GET['fraud_activity'] ) ? give_clean( $_GET['fraud_activity'] ) : false; // WPCS: input var ok, sanitization ok, CSRF ok.

	// Show this error message only when payment is pending and fraud activity is detected.
	if ( 'pending' === $status && $fraud_activity ) {
		remove_action( 'give_complete_donation', 'give_trigger_donation_receipt', 999, 1 );

		$notice_message = __( 'Payment Pending: This donation is under review. You will receive the donation receipt once the payment has been reviewed and charged.', 'give-paypal-pro' );
		$notice_type    = 'warning';

		return Give()->notices->print_frontend_notice( $notice_message, false, $notice_type );
	}

	return $notice;

}
add_filter( 'give_receipt_status_notice', 'give_payflow_receipt_fraud_status_notice', 10, 4 );

/**
 * Load Transaction-specific admin javascript.
 *
 * Allows the user to refund non-recurring donations.
 *
 * @since 1.2
 *
 * @param int $payment_id Payment ID.
 */
function give_payflow_admin_payment_js( $payment_id = 0 ) {

	$gateway = give_get_payment_gateway( $payment_id );
	if ( 'paypalpro_payflow' === $gateway ) {
		?>
		<script type="text/javascript">
					jQuery( function( $ ) {
						$( 'select[name="give-payment-status"]' ).on( 'change', function( e ) {
							if ( 'refunded' === $( this ).val() ) {
								$( this ).parents('.give-admin-box-inside').append( '<p class="give-paypalpro_payflow-refund"><input type="checkbox" ' +
								  'id="give_refund_in_paypalpro_payflow" ' +
									'name="give_refund_in_paypalpro_payflow" value="1"/><label for="give_refund_in_paypalpro_payflow"><?php esc_html_e( 'Refund Charge in PayPal PayFlow?', 'give-paypal-pro' ); ?></label></p>' );
							} else {
								$( '.give-paypalpro_payflow-refund' ).remove();
							}
						} );
					} );
		</script>
		<?php
	} else if ( 'paypalpro' === $gateway ) {
		?>
		<script type="text/javascript">
					jQuery( function( $ ) {
						$( 'select[name="give-payment-status"]' ).on( 'change', function() {
							if ( 'refunded' === $( this ).val() ) {
								$( this ).parents('.give-admin-box-inside').append( '<p class="give-paypalpro-refund"><input type="checkbox" id="give_refund_in_paypalpro" ' +
									'name="give_refund_in_paypalpro" value="1"/><label for="give_refund_in_paypalpro"><?php esc_html_e( 'Refund Charge in Paypal Pro ?', 'give-paypal-pro' ); ?></label></p>' );
							} else {
								$( '.give-paypalpro-refund' ).remove();
							}
						} );
					} );
		</script>
		<?php
	} else if( 'paypalpro_rest' === $gateway  ) {
		?>
		<script type="text/javascript">
					jQuery( function( $ ) {
						$( 'select[name="give-payment-status"]' ).on( 'change', function() {
							if ( 'refunded' === $( this ).val() ) {
								$( this ).parents('.give-admin-box-inside').append( '<p class="give-paypalpro-rest-refund"><input type="checkbox" ' +
								  'id="give_refund_in_paypalpro_rest" ' +
									'name="give_refund_in_paypalpro_rest" value="1"/><label for="give_refund_in_paypalpro_rest"><?php esc_html_e( 'Refund Charge in Paypal Pro Rest?', 'give-paypal-pro' ); ?></label></p>' );
							} else {
								$( '.give-paypalpro-rest-refund' ).remove();
							}
						} );
					} );
		</script>
	<?php
	} else {
		return;
	}
}

add_action( 'give_view_donation_details_before', 'give_payflow_admin_payment_js', 100, 1 );


/**
 * PayFlow refund process.
 *
 * @access public
 * @since  1.2
 *
 * @param int    $payment_id Donation payment id.
 * @param string $new_status New payment status.
 * @param string $old_status Old payment status.
 *
 * @return bool
 */
function payflow_process_refund( $payment_id, $new_status, $old_status ) {

	// Only move forward if refund requested.
	if ( empty( $_POST['give_refund_in_paypalpro_payflow'] ) ) {
		return;
	}

	// Get all posted data.
	$payment_data = give_clean( $_POST ); // WPCS: input var ok, sanitization ok, CSRF ok.

	// Bail out if new status is not refunded.
	if ( 'refunded' !== $new_status || ! isset( $payment_data ) ) {
		return false;
	}

	// Get PayFlow transaction id.
	$transaction_id = give_get_payment_transaction_id( $payment_id );

	// If no charge ID, look in the payment notes.
	if ( empty( $transaction_id ) ) {

		give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund Donation #%s. Donation does not have transaction_id. Make sure donation has set transaction_id.', 'give-paypal-pro' ), $payment_id ) );

		// Change it to previous status.
		give_update_payment_status( $payment_id, $old_status );

		return false;
	}

	$payflow = new Give_PayPal_Pro_Payflow();

	// Calculate the total.
	$payment_total = give_maybe_sanitize_amount( $payment_data['give-payment-total'] );

	$refund_params              = array();
	$refund_params['USER']      = $payflow->paypal_user;
	$refund_params['VENDOR']    = $payflow->paypal_vendor;
	$refund_params['PARTNER']   = $payflow->paypal_partner;
	$refund_params['PWD']       = $payflow->paypal_password;
	$refund_params['TENDER']    = 'C'; // Credit card.
	$refund_params['TRXTYPE']   = 'C'; // Credit card.
	$refund_params['AMT']       = $payment_total;
	$refund_params['ORIGID']    = $transaction_id;
	$refund_params['VERBOSITY'] = 'HIGH';

	$url = give_is_test_mode() ? $payflow->testurl : $payflow->liveurl;

	$response = wp_remote_post( $url, array(
		'method'      => 'POST',
		'body'        => urldecode( http_build_query( apply_filters( 'give_paypal_pro_payflow_refund_request', $refund_params ), null, '&' ) ),
		'timeout'     => 90,
		'user-agent'  => 'GiveWP',
		'httpversion' => '1.1',
	) );

	// Only move forward if response set.
	if ( isset( $response ) && empty( $response ) ) {
		give_insert_payment_note( $payment_id, __( 'Unable to refund via PayFlow.', 'give-paypal-pro' ) );

		// Change it to previous status.
		give_update_payment_status( $payment_id, $old_status );

		return false;
	}

	// Get response body.
	$response_message = wp_remote_retrieve_body( $response );

	// Only move forward if response has no error.
	if ( empty( $response_message ) ) {

		give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund via PayFlow: %s', 'give-paypal-pro' ), $response->get_error_message() ) );

		// Change it to previous status.
		give_update_payment_status( $payment_id, $old_status );

		return false;
	}

	parse_str( $response_message, $parsed_response );

	// Only move forward if refund has success status.
	if ( isset( $parsed_response['RESULT'] ) && '0' !== $parsed_response['RESULT'] ) {
		give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund via PayFlow: %1$s. (PNREF: %2$s)', 'give-paypal-pro' ), $parsed_response['RESPMSG'], $parsed_response['PNREF'] ) );

		// Change it to previous status.
		give_update_payment_status( $payment_id, $old_status );

		return false;
	}

	// Update refund id into donation meta and add note.
	if (
		isset( $parsed_response['RESULT'] )
		&& '0' === $parsed_response['RESULT']
		&& isset( $parsed_response['PNREF'] )
	) {
		// Add refund id into payment.
		give_update_meta( $payment_id, 'payflow_pro_refunded_id', $parsed_response['PNREF'] );

		give_insert_payment_note( $payment_id, sprintf( __( 'PayFlow Refund ID: (%s)', 'give-paypal-pro' ), $parsed_response['PNREF'] ) );
	}

	return true;
}

// Register hooks for PayFlow refund.
add_action( 'give_update_payment_status', 'payflow_process_refund', 200, 3 );

/**
 * PayPal Pro Rest refund process.
 *
 * @access public
 * @since  1.2
 *
 * @param int    $payment_id Donation payment id.
 * @param string $new_status New payment status.
 * @param string $old_status Old payment status.
 *
 * @return bool
 */
function paypal_pro_rest_process_refund( $payment_id, $new_status, $old_status ) {

	// Only move forward if refund requested.
	if ( empty( $_POST['give_refund_in_paypalpro_rest'] ) ) {
		return;
	}

	require_once GIVEPP_PLUGIN_DIR . '/lib/paypal/autoload.php';

	// Get all posted data.
	$payment_data = give_clean( $_POST ); // WPCS: input var ok, sanitization ok, CSRF ok.

	if ( 'refunded' !== $new_status || ! isset( $payment_data ) ) {
		return false;
	}

	$paypal_pro_rest = new Give_PayPal_Pro_Rest();
	$apiContext      = $paypal_pro_rest->get_token();

	// Get PayPal Rest API transaction id.
	$transaction_id = give_get_payment_transaction_id( $payment_id );

	// Get Correct transaction_id stored wrong like `PAY-4454548654545646`
	if ( false !== strpos( $transaction_id, 'PAY-' ) ) {
		$payment             = new PayPal\Api\Payment();
		$payment_transaction = $payment::get( $transaction_id, $apiContext );
		$check_state         = $payment_transaction->getState();

		// Check if transaction status is valid.
		if ( in_array( $check_state,
			array(
				'created',
				'approved',
			) )
		) {
			$transactions     = $payment_transaction->getTransactions();
			$relatedResources = $transactions[0]->getRelatedResources();
			$Sale             = $relatedResources[0]->getSale();
			$transaction_id   = $Sale->getId();

			// Update correct transaction_id.
			give_update_meta( $payment_id, '_give_payment_transaction_id', $transaction_id );
		}
	}// End if().

	// If no charge ID, look in the payment notes.
	if ( empty( $transaction_id ) ) {
		give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund Donation #%s. Donation does not have transaction_id. Make sure donation has set transaction_id.', 'give-paypal-pro' ), $payment_id ) );

		// Change it to previous status.
		give_update_payment_status( $payment_id, $old_status );

		return false;
	}

	// Refund AMT.
	$refund_amount = give_maybe_sanitize_amount( give_clean( $payment_data['give-payment-total'] ) );
	$currency_code = give_get_payment_currency_code( $payment_id );

	// ### Amount
	// Lets you specify a refund amount.
	// You can also specify additional details
	$amount = new \PayPal\Api\Amount();
	$amount->setCurrency( $currency_code )
	       ->setTotal( $refund_amount );

	// Create refund object and set refund amount.
	$refund = new \PayPal\Api\Refund();
	$refund->setAmount( $amount );

	// Create sale object and get transaction.
	$sale        = new \PayPal\Api\Sale();
	$transaction = $sale::get( $transaction_id, $apiContext );

	try {
		// Process refund.
		$refunded_sale = $transaction->refund( $refund, $apiContext );
		if ( 'completed' === $refunded_sale->state ) {
			// Add refund id into payment.
			give_update_meta( $payment_id, 'paypal_pro_rest_refunded_id', $refunded_sale->getId() );

			$check_refund_url = give_paypal_get_refund_url( $refunded_sale->getId() );

			// Insert Refund note with URL.
			give_insert_payment_note( $payment_id, sprintf( '%1$s: (<a target="_blank" href="%2$s">%3$s</a>)',
					__('PayPal Pro Rest API Refund ID','give-paypal-pro'),
					esc_url( $check_refund_url ),
					$refunded_sale->getId()
				)
			);
		}
	} catch ( PayPal\Exception\PayPalConnectionException $ex ) {
		$error_data = json_decode( $ex->getData() );

		if ( is_object( $error_data ) && ! empty( $error_data ) ) {
			$error_message = ( $error_data->message ) ? $error_data->message : $error_data->information_link;
			give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund via PayPal Rest API: (%s)', 'give-paypal-pro' ), $error_message ) );
		} else {
			give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund via PayPal Rest API: (%s)', 'give-paypal-pro' ), $ex->getData() ) );
		}

		give_update_payment_status( $payment_id, $old_status );

		return false;

	} catch ( Exception $ex ) {
		give_insert_payment_note( $payment_id, sprintf( __( 'Unable to refund via PayPal Rest API: (%s)', 'give-paypal-pro' ), $ex->getMessage() ) );

		// Change it to previous status.
		give_update_payment_status( $payment_id, $old_status );

		return false;
	}

	return true;

}

add_action( 'give_update_payment_status', 'paypal_pro_rest_process_refund', 200, 3 );

/**
 * Refund URL for check Refund status for PayPal Rest and NVP.
 *
 * @since  1.2
 *
 * @param string $refund_id
 *
 * @return string $refund_url
 */
function give_paypal_get_refund_url( $refund_id ) {
	$paypal_end_point = give_is_test_mode() ? 'https://www.sandbox.paypal.com' : 'https://www.paypal.com';
	$refund_url       = "$paypal_end_point/cgi-bin/webscr?cmd=_history-details-from-hub&show_legacy=true&id=$refund_id";

	return $refund_url;
}

/**
 * Update Purchase key for specific gateway.
 *
 * @since 1.2.1
 *
 * @param string $custom_purchase_key
 * @param string $gateway
 * @param string $purchase_key
 *
 * @return string
 */
function give_paypal_pro_update_purchase_key( $custom_purchase_key, $gateway, $purchase_key ) {

	switch ( $gateway ) {

		case 'paypalpro_rest':
			$paypal_rest_invoice_prefix = give_get_option( 'paypal_rest_invoice_prefix', 'GIVE-' );
			$custom_purchase_key        = $paypal_rest_invoice_prefix . $purchase_key;
			break;
		case 'paypalpro':
			$paypal_nvp_invoice_prefix = give_get_option( 'paypal_nvp_invoice_prefix', 'GIVE-' );
			$custom_purchase_key       = $paypal_nvp_invoice_prefix . $purchase_key;
			break;
		case 'paypalpro_payflow':
			$payflow_invoice_prefix = give_get_option( 'paypalpro_payflow_invoice_prefix', 'GIVE-' );
			$custom_purchase_key    = $payflow_invoice_prefix . $purchase_key;
			break;
	}

	return $custom_purchase_key;
}

add_filter( 'give_donation_purchase_key', 'give_paypal_pro_update_purchase_key', 10, 3 );