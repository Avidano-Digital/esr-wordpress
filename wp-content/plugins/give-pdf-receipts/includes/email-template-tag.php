<?php
/**
 * Template Tags
 *
 * Creates and renders the additional template tags for the PDF receipt.
 *
 * @package Give - PDF Receipts
 * @since   1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function give_pdf_register_email_tag() {
	give_add_email_tag( 'pdf_receipt', __( 'Creates a link to a downloadable PDF receipt', 'give-pdf-receipts' ), 'give_pdf_email_template_tags' );
}

add_action( 'give_add_email_tags', 'give_pdf_register_email_tag' );

/**
 *
 * Email Template Tags
 *
 * Additional template tags for the Donation Receipt.
 *
 * @since       1.0
 * @uses        give_pdf_receipts()->engine->get_pdf_receipt_url()
 *
 * @param $payment_id
 *
 * @return bool|string Receipt Link.
 */

function give_pdf_email_template_tags( $payment_id ) {

	if ( ! give_pdf_receipts()->engine->is_receipt_link_allowed( $payment_id ) ) {
		return false;
	}

	return '<a href="' . give_pdf_receipts()->engine->get_pdf_receipt_url( $payment_id ) . '">' . __( 'Download Receipt', 'give-pdf-receipts' ) . ' &raquo;</a>';
}