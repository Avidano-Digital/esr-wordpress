<?php
/**
 * Form Field Manager Frontend Form
 *
 * @package     Give_FFM
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Give_FFM_Frontend_Form
 */
class Give_FFM_Frontend_Form extends Give_FFM_Render_Form {

	/**
	 * @var
	 */
	private static $_instance;

	/**
	 * Get things started
	 */
	function __construct() {

		//Add FFM to donation forms.
		add_action( 'give_insert_payment', array( $this, 'submit_post' ), 10, 2 );
		add_action( 'give_pre_form_output', array( $this, 'place_fields' ), 10, 1 );
		//Used to place fields after the donor AJAX switches payment methods.
		add_action( 'give_donation_form_top', array( $this, 'place_fields' ), 10, 1 );

		//Donation Receipt.
		add_filter( 'shortcode_atts_give_receipt', array( $this, 'add_donation_receipt_attr' ), 10, 3 );
		add_action( 'give_payment_receipt_after', array( $this, 'donation_receipt' ), 10, 2 );
	}

	/**
	 * Init
	 *
	 * @return Give_FFM_Frontend_Form
	 */
	public static function init() {
		if ( ! self::$_instance ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Place Fields
	 *
	 * Uses various Give forms actions to output the custom fields.
	 *
	 * @param $form_id
	 */
	public function place_fields( $form_id ) {

		$ffm_placement = get_post_meta( $form_id, '_give_ffm_placement', true );

		if ( empty( $ffm_placement ) ) {
			return;
		}

		//dynamic action to add fields based on user's choice.
		if ( ! did_action( $ffm_placement, array( $this, 'add_fields' ), 10 ) ) {
			add_action( $ffm_placement, array( $this, 'add_fields' ), 10, 1 );
		}

	}

	/**
	 * Add Fields.
	 *
	 * @param $form_id
	 */
	public function add_fields( $form_id ) {
		ob_start();
		$this->render_form( $form_id );
		$content = ob_get_contents();
		ob_end_clean();
		echo $content;
	}

	/**
	 * Submit Post.
	 *
	 * @param $payment
	 * @param $payment_data
	 */
	public function submit_post( $payment, $payment_data ) {

		$form_id       = $payment_data['give_form_id'];
		$form_vars     = $this->get_input_fields( $form_id );
		$form_settings = get_post_meta( $form_id, 'give-form-fields_settings', true );

		list( $post_vars, $tax_vars, $meta_vars ) = $form_vars;

		$post_id = $payment;

		self::update_post_meta( $meta_vars, $post_id, $form_vars );

		// set the post form_id for later usage.
		update_post_meta( $post_id, self::$config_id, $form_id );

	}

	/**
	 * Update Post Meta.
	 *
	 * Updates individual meta fields and _give_payment_meta as
	 * an array of all meta fields combined.
	 *
	 * @param $meta_vars
	 * @param $post_id
	 * @param $form_vars
	 */
	public static function update_post_meta( $meta_vars, $post_id, $form_vars ) {
		// prepare the meta vars
		list( $meta_key_value, $multi_repeated, $files ) = self::prepare_meta_fields( $meta_vars );

		// get default payment meta so we can add to it below
		$default_meta = get_post_meta( $post_id, '_give_payment_meta', true );

		// array of file fields formatted as key-value pairs
		$files_key_value = array();

		// save custom fields
		foreach ( $form_vars[2] as $key => $value ) {
			if ( isset( $_POST[ $value['name'] ] ) ) {
				update_post_meta( $post_id, $value['name'], $_POST[ $value['name'] ] );
			}
		}
		// save all custom fields
		foreach ( $meta_key_value as $meta_key => $meta_value ) {
			update_post_meta( $post_id, $meta_key, $meta_value );
		}
		// save any multicolumn repeatable fields
		foreach ( $multi_repeated as $repeat_key => $repeat_value ) {
			// first, delete any previous repeatable fields
			delete_post_meta( $post_id, $repeat_key );
			// now add them
			foreach ( $repeat_value as $repeat_field ) {
				add_post_meta( $post_id, $repeat_key, $repeat_field );
			}
		}
		// save any files attached
		foreach ( $files as $file_input ) {
			// delete any previous value
			delete_post_meta( $post_id, $file_input['name'] );
			foreach ( $file_input['value'] as $attachment_id ) {
				ffm_associate_attachment( $attachment_id, $post_id );
				add_post_meta( $post_id, $file_input['name'], $attachment_id );
				$files_key_value[ $file_input['name'] ] = $file_input['value'];
			}
		}

		// combine all meta fields
		$all_meta = array_merge(
			$default_meta, // meta associated with all Give donations (user_info, email, date, etc.)
			$meta_key_value, // singular custom fields added via FFM
			$multi_repeated, // multi-column repeatable custom fields added via FFM
			$files_key_value // file fields added via FFM
		);

		// update one meta field with array of all meta fields combined
		update_post_meta( $post_id, '_give_payment_meta', $all_meta );
	}

	/**
	 * Required Fields
	 *
	 * @param bool|false $fields
	 *
	 * @return array|bool
	 */
	public static function req_fields( $fields = false ) {
		$form_id   = get_option( 'give_ffm_id' );
		$form_vars = Give_FFM_Render_Form::get_input_fields( $form_id );
		$new_req   = array();

		foreach ( $form_vars[2] as $key => $value ) {
			if ( isset ( $value['required'] ) && $value['required'] == 'yes' ) {
				$new_req[ $value['name'] ] = array(
					'error_id'      => 'invalid_' . $value['name'],
					'error_message' => __( 'Please enter ', 'give' ) . strtolower( $value['label'] )
				);
			}
		}

		$fields = array_merge( $fields, $new_req );

		return $fields;
	}


	/**
	 *
	 * @param $payment
	 * @param $give_receipt_args
	 */
	public function donation_receipt( $payment, $give_receipt_args ) {

	}

	/**
	 * Add Donation Receipt Args
	 *
	 * Adds the `custom_fields` attribute to the [give_receipt] shortcode so that custom fields can be output if admin desires.
	 *
	 * @param $atts
	 *
	 * @return mixed
	 */
	public function add_donation_receipt_attr( $out, $pairs, $atts ) {

		$out['custom_fields'] = false;

		return $out;

	}

}