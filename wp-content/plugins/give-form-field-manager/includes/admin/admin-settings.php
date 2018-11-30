<?php
/**
 * Give Form Field Manager Admin Settings.
 *
 * @package     Give
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.1.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Settings.
 *
 *
 * @param $settings
 *
 * @return array
 */
function give_ffm_admin_settings( $settings ) {

	$give_aweber_settings = array(
		array(
			'name' => __( 'Form Field Manager', 'give-form-field-manager' ),
			'desc' => '<hr>',
			'id'   => 'give_title_ffm',
			'type' => 'give_title'
		),
		array(
			'id'      => 'ffm_datepicker_css',
			'name'    => __( 'Datepicker CSS', 'give-form-field-manager' ),
			'desc'    => __( 'Would you like to output the datepicker CSS provided by the Form Field Manager? Some themes may provide their own styling to the datepicker. If that is the case, you may disable the CSS output to use your theme\'s styles.', 'give-form-field-manager' ),
			'options' => array(
				'enabled'  => __( 'Enabled', 'give-form-field-manager' ),
				'disabled' => __( 'Disabled', 'give-form-field-manager' ),
			),
			'default' => 'enabled',
			'type'    => 'radio_inline'
		),
	);

	return array_merge( $settings, $give_aweber_settings );
}

add_filter( 'give_settings_display', 'give_ffm_admin_settings' );