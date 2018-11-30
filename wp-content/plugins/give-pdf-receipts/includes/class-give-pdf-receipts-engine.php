<?php

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Class Give_PDF_Receipts_Engine
 *
 * @since 2.0.4
 */
class Give_PDF_Receipts_Engine {

	/**
	 * Give_PDF_Receipts_Engine constructor.
	 */
	public function __construct() {

		add_action( 'give_generate_pdf_receipt', array( $this, 'generate_pdf_receipt' ) );
		add_action( 'give_donation_history_header_after', array( $this, 'donation_history_header' ) );
		add_action( 'give_donation_history_row_end', array( $this, 'donation_history_link' ), 10, 2 );
		add_action( 'give_payment_receipt_after', array( $this, 'receipt_shortcode_link' ), 10 );
		add_action( 'init', array( $this, 'verify_receipt_link' ), 10 );
		add_filter( 'give_payment_row_actions', array( $this, 'receipt_link' ), 10, 2 );

	}

	/**
	 * Generate PDF Receipt
	 *
	 * Loads and stores all of the data for the payment.  The HTML2PDF class is
	 * instantiated and do_action() is used to call the receipt template which goes
	 * ahead and renders the receipt.
	 *
	 * @since 1.0
	 * @uses  HTML2PDF
	 * @uses  wp_is_mobile()
	 */
	public function generate_pdf_receipt() {

		$give_options = give_get_settings();

		//Sanity check: need transaction ID
		if ( ! isset( $_GET['transaction_id'] ) ) {
			return;
		}

		//Sanity check: Make sure the the receipt link is allowed.
		if ( ! $this->is_receipt_link_allowed( $_GET['transaction_id'] ) ) {
			return;
		}

		do_action( 'give_pdf_generate_receipt', $_GET['transaction_id'] );

		$give_pdf_payment      = get_post( $_GET['transaction_id'] );
		$give_pdf_payment_meta = give_get_payment_meta( $_GET['transaction_id'] );

		// If url parameters has _wpnonce=give_pdf_generate_receipt.
		$give_pdf_receipt_nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : null;
		$is_nonce               = is_admin() && wp_verify_nonce( $give_pdf_receipt_nonce, 'give_pdf_generate_receipt' );

		if ( $is_nonce ) {
			$give_pdf_buyer_info      = maybe_unserialize( $give_pdf_payment_meta['user_info'] );
			$give_pdf_payment_gateway = get_post_meta( $give_pdf_payment->ID, '_give_payment_gateway', true );
		} else {
			$give_pdf_buyer_info      = give_get_payment_meta_user_info( $give_pdf_payment->ID );
			$give_pdf_payment_gateway = give_get_payment_gateway( $give_pdf_payment->ID );
		}
		$give_pdf_payment_method = give_get_gateway_checkout_label( $give_pdf_payment_gateway );

		$company_name = isset( $give_options['give_pdf_company_name'] ) ? $give_options['give_pdf_company_name'] : '';

		$give_pdf_payment_date   = date_i18n( get_option( 'date_format' ), strtotime( $give_pdf_payment->post_date ) );
		$give_pdf_payment_status = give_get_payment_status( $give_pdf_payment, true );

		// WPML Support.
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$lang = get_post_meta( $_GET['transaction_id'], 'wpml_language', true );
			if ( ! empty( $lang ) ) {
				global $sitepress;
				$sitepress->switch_lang( $lang );
			}
		}

		// If generation method is custom pdf template
		if ( isset( $give_options['give_pdf_generation_method'] )
		     && $give_options['give_pdf_generation_method'] == 'custom_pdf_builder'
		) {

			// Enable images in pdf.
			define( 'DOMPDF_ENABLE_REMOTE', true );
			// Include dompdf library.
			include_once( GIVE_PDF_PLUGIN_DIR . 'lib/dompdf/autoload.inc.php' );

			$template_id = $give_options['give_pdf_receipt_template'];
			$template    = get_post( $template_id );

			// Set options.
			$options = new Options();
			$options->set('isRemoteEnabled', true);
			$options->set('isHtml5ParserEnabled', true);
			$options->set('setIsRemoteEnabled', true);

			// Initialize Dompdf.
			$dompdf = new Dompdf($options);
			$dompdf->setPaper( apply_filters( 'give_dompdf_paper_size', array( 0, 0, 595.28, 841.89 ) ) );

			$html = give_pdf_get_compile_html(
				$template->post_content,
				$give_pdf_payment,
				$give_pdf_payment_method,
				$give_pdf_payment_status,
				$give_pdf_payment_meta,
				$give_pdf_buyer_info,
				$give_pdf_payment_date,
				$_GET['transaction_id'],
				$this->get_pdf_receipt_url( $give_pdf_payment->ID )
			);

			$dompdf->loadHtml( $html );
			$dompdf->render();
			$dompdf->stream(
				apply_filters( 'give_pdf_receipt_filename_prefix', 'Receipt-' ) . give_pdf_get_payment_number( $give_pdf_payment->ID ),
				array( 'Attachment' => ! wp_is_mobile() )
			);

		} else {
			/**
			 * TCPDF Generation Method.
			 *
			 * Generate pdf using legacy TCPDF default template.
			 */
			include_once( GIVE_PDF_PLUGIN_DIR . 'lib/tcpdf/tcpdf.php' );
			include_once( GIVE_PDF_PLUGIN_DIR . 'includes/class-give-tcpdf.php' );

			$give_pdf = new Give_PDF_Receipt( 'P', 'mm', 'A4', true, 'UTF-8', false );

			$give_pdf->SetDisplayMode( 'real' );
			$give_pdf->setJPEGQuality( 100 );

			$give_pdf->SetTitle( __( ( $is_nonce ? 'Receipt ' : 'Donation Receipt' ) . give_pdf_get_payment_number( $give_pdf_payment->ID ), 'give-pdf-receipts' ) );
			$give_pdf->SetCreator( __( 'Give' ) );
			$give_pdf->SetAuthor( get_option( 'blogname' ) );

			$address_line_2_line_height = isset( $give_options['give_pdf_address_line2'] ) ? 6 : 0;

			if ( ! isset( $give_options['give_pdf_templates'] ) ) {
				$give_options['give_pdf_templates'] = 'default';
			}

			do_action( 'give_pdf_template_' . $give_options['give_pdf_templates'], $give_pdf, $give_pdf_payment, $give_pdf_payment_meta, $give_pdf_buyer_info, $give_pdf_payment_gateway, $give_pdf_payment_method, $address_line_2_line_height, $company_name, $give_pdf_payment_date, $give_pdf_payment_status );

			if ( ob_get_length() ) {
				if ( $is_nonce ) {
					ob_clean();
				}
				ob_end_clean();
			}

			$give_pdf->Output( apply_filters( 'give_pdf_receipt_filename_prefix', 'Receipt-' ) . give_pdf_get_payment_number( $give_pdf_payment->ID ) . '.pdf', wp_is_mobile() ? 'I' : 'D' );
		}

		die(); // Stop the rest of the page from processing and being sent to the browser.
	}


	/**
	 * Donation History Page Table Heading
	 *
	 * Appends to the table header (<thead>) on the Purchase History page for the
	 * Receipt column to be displayed
	 *
	 * @since 1.0
	 */
	function donation_history_header() {
		echo '<th class="give_receipt">' . __( 'Receipt', 'give-pdf-receipts' ) . '</th>';
	}


	/**
	 * Outputs the Receipt link.
	 *
	 * Adds the receipt link to the [donation_history] shortcode underneath the previously created "Receipt" header.
	 *
	 * @since 1.0
	 *
	 * @param int   $post_id       Payment post ID.
	 * @param array $donation_data All the donation data.
	 */
	function donation_history_link( $post_id, $donation_data ) {
		if ( ! $this->is_receipt_link_allowed( $post_id ) ) {
			echo '<td>-</td>';

			return;
		}

		echo '<td class="give_receipt"><a class="give_receipt_link" title="' . __( 'Download Receipt', 'give-pdf-receipts' ) . '" href="' . esc_url( $this->get_pdf_receipt_url( $post_id ) ) . '">' . __( 'Download Receipt', 'give-pdf-receipts' ) . '</td>';
	}

	/**
	 * Verify Receipt Link.
	 *
	 * Verifies the receipt link submitted from the front-end.
	 *
	 * @since 1.0
	 */
	public function verify_receipt_link() {

		if ( isset( $_GET['transaction_id'] ) && isset( $_GET['email'] ) && isset( $_GET['purchase_key'] ) ) {

			if ( ! $this->is_receipt_link_allowed( $_GET['transaction_id'] ) ) {
				return;
			}

			$key   = $_GET['purchase_key'];
			$email = $_GET['email'];

			$meta_query = array(
				'relation' => 'OR',
				array(
					'key'   => '_give_payment_purchase_key',
					'value' => $key
				),
				array(
					'key'   => '_give_payment_user_email',
					'value' => $email
				)
			);

			$payments = get_posts( array(
				'meta_query' => $meta_query,
				'post_type'  => 'give_payment'
			) );

			if ( $payments ) {
				$this->generate_pdf_receipt();
			} else {
				wp_die( __( 'The receipt that you requested was not found.', 'give-pdf-receipts' ), __( 'Receipt Not Found', 'give-pdf-receipts' ) );
			}
		}
	}

	/**
	 * Receipt Shortcode Receipt Link.
	 *
	 * Adds the receipt link to the [give_receipt] shortcode.
	 *
	 * @since 1.0.4
	 *
	 * @param object $payment All the payment data
	 */
	public function receipt_shortcode_link( $payment ) {

		//Sanity check
		if ( ! $this->is_receipt_link_allowed( $payment->ID ) ) {
			return;
		} ?>
		<tr>
			<td><strong><?php _e( 'Receipt', 'give-pdf-receipts' ); ?>:</strong></td>
			<td>
				<a class="give_receipt_link" title="<?php _e( 'Download Receipt', 'give-pdf-receipts' ); ?>"
				   href="<?php echo esc_url( $this->get_pdf_receipt_url( $payment->ID ) ); ?>"><?php _e( 'Download Receipt', 'give-pdf-receipts' ); ?></a>
			</td>
		</tr>
		<?php
	}

	/**
	 * Check is receipt link is allowed.
	 *
	 * @since  1.0
	 * @access private
	 * @global    $give_options
	 *
	 * @param int $id Payment ID to verify total
	 *
	 * @return bool
	 */
	public function is_receipt_link_allowed( $id = null ) {

		$ret = true;

		if ( ! give_is_payment_complete( $id ) ) {
			$ret = false;
		}

		return apply_filters( 'give_pdf_is_receipt_link_allowed', $ret, $id );
	}


	/**
	 * Gets the Receipt URL.
	 *
	 * Generates an receipt URL and adds the necessary query arguments.
	 *
	 * @since 1.0
	 *
	 * @param int $payment_id Payment post ID
	 *
	 * @return string $receipt Receipt URL
	 */
	public function get_pdf_receipt_url( $payment_id ) {

		$give_pdf_params = array(
			'transaction_id' => $payment_id,
			'email'          => urlencode( give_get_payment_user_email( $payment_id ) ),
			'purchase_key'   => give_get_payment_key( $payment_id ),
		);

		$receipt = esc_url( add_query_arg( $give_pdf_params, home_url() ) );

		return $receipt;
	}


	/**
	 * Creates Link to Download the Receipt.
	 *
	 * Creates a link on the Payment History admin page for each payment to
	 * allow the ability to download a receipt for that payment.
	 *
	 * @since 1.0
	 *
	 * @param array  $row_actions      All the row actions on the Payment History page
	 * @param object $give_pdf_payment Payment object containing all the payment data
	 *
	 * @return array Modified row actions with Download Receipt link
	 */
	public function receipt_link( $row_actions, $give_pdf_payment ) {
		$row_actions_pdf_receipt_link = array();

		$give_pdf_generate_receipt_nonce = wp_create_nonce( 'give_pdf_generate_receipt' );

		if ( $this->is_receipt_link_allowed( $give_pdf_payment->ID ) ) {
			$row_actions_pdf_receipt_link = array(
				'receipt' => '<a href="' . esc_url( add_query_arg( array(
						'give-action'    => 'generate_pdf_receipt',
						'transaction_id' => $give_pdf_payment->ID,
						'_wpnonce'       => $give_pdf_generate_receipt_nonce
					) ) ) . '">' . __( 'Download Receipt', 'give-pdf-receipts' ) . '</a>',
			);
		}

		return array_merge( $row_actions, $row_actions_pdf_receipt_link );
	}

}