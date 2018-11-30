<?php
/**
 * Plugin Name: Give - 2Checkout Gateway
 * Plugin URL: http://givewp.com/addons/2checkout
 * Description: Give add-on gateway for 2Checkout
 * Version: 1.0
 * Author: WordImpress
 * Author URI: http://wordimpress.com
 * Contributors: dlocc, webdevmattcrom, pippinwilliamson, mordauk, joshcummingsdesign
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


final class Give_Twocheckout {

	/** Singleton *************************************************************/

	/**
	 * @var Give_Twocheckout The one true Give_Twocheckout
	 * @since 1.0
	 */
	private static $instance;


	public $id = 'give-twocheckout';
	public $basename;

	// Setup objects for each class
	public $admin_form;

	/**
	 * Main Give_Twocheckout Instance
	 *
	 * Insures that only one instance of Give_Twocheckout exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @staticvar array $instance
	 * @return The one true Give_Twocheckout
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Give_Twocheckout ) ) {
			self::$instance = new Give_Twocheckout;
			self::$instance->define_globals();
			self::$instance->includes();
			self::$instance->init();


			//Class Instances
			self::$instance->payments = new Give_Twocheckout_Payments();


			//Admin only
			if ( is_admin() ) {


			}


		}

		return self::$instance;
	}

	/**
	 * Defines all the globally used constants
	 *
	 * @since 1.0
	 * @return void
	 */
	private function define_globals() {

		if ( ! defined( 'GIVE_TWOCHECKOUT_PLUGIN_FILE' ) ) {
			define( 'GIVE_TWOCHECKOUT_PLUGIN_FILE', __FILE__ );
		}
		if ( ! defined( 'GIVE_TWOCHECKOUT_PLUGIN_DIR' ) ) {
			define( 'GIVE_TWOCHECKOUT_PLUGIN_DIR', dirname( GIVE_TWOCHECKOUT_PLUGIN_FILE ) );
		}
		if ( ! defined( 'GIVE_TWOCHECKOUT_PLUGIN_URL' ) ) {
			define( 'GIVE_TWOCHECKOUT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		}
		if ( ! defined( 'GIVE_TWOCHECKOUT_VERSION' ) ) {
			define( 'GIVE_TWOCHECKOUT_VERSION', '1.0' );
		}

	}

	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'give_after_cc_fields', array( $this, 'errors_div' ) );
	}

	/**
	 * Plugin Scripts
	 */
	public function scripts() {

		//Check for sandbox
		if ( give_is_test_mode() ) {
			$environment = 'sandbox';
		} else {
			$environment = 'production';
		}

		wp_register_script( 'give-twocheckout-tokenization', 'https://www.2checkout.com/checkout/api/2co.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'give-twocheckout-tokenization' );
		wp_register_script( 'give-twocheckout-js', GIVE_TWOCHECKOUT_PLUGIN_URL . '/assets/js/give-twocheckout.js', array(
			'jquery',
			'give-twocheckout-tokenization'
		) );
		wp_enqueue_script( 'give-twocheckout-js' );

		wp_localize_script( 'give-twocheckout-js', 'give_twocheckout_js', array(
			'sellerId'       => give_get_option( 'twocheckout-sellerId' ),
			'publishableKey' => give_get_option( 'twocheckout-public-key' ),
			'env'            => $environment,
			'api_error'      => __( 'Your payment could not be recorded. Please try again.', 'give' ),
			'keys_error'     => __( 'Incorrect API account number or keys. Check the plugin settings.', 'give' ),
			'error'          => __( 'Error' )
		) );

	}

	/**
	 * Add an errors div
	 *
	 * @access      public
	 * @since       1.0
	 * @return      void
	 */
	public function errors_div() {
		echo '<div id="give-twocheckout-errors"></div>';
	}

	/**
	 * Include all files
	 *
	 * @since 1.0
	 * @return void
	 */
	private function includes() {
		self::includes_general();
		self::includes_admin();
	}

	/**
	 * Load general files
	 *
	 * @return void
	 */
	private function includes_general() {
		$files = array(
			'class-twocheckout-payments.php',
		);

		foreach ( $files as $file ) {
			require( sprintf( '%s/includes/%s', untrailingslashit( GIVE_TWOCHECKOUT_PLUGIN_DIR ), $file ) );
		}
	}

	/**
	 * Load admin files
	 *
	 * @return void
	 */
	private function includes_admin() {
		if ( is_admin() ) {
			$files = array(
				'give-twocheckout-settings.php',
			);

			foreach ( $files as $file ) {
				require( sprintf( '%s/includes/admin/%s', untrailingslashit( GIVE_TWOCHECKOUT_PLUGIN_DIR ), $file ) );
			}
		}
	}

}

/**
 * The main function responsible for returning the one true Give_Twocheckout
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * @since 1.0
 * @return object The one true Give_Form_Fields_Manager Instance
 */

function Give_Twocheckout() {

	//Check for Give
	if ( ! class_exists( 'Give' ) ) {
		return false;
	}

	return Give_Twocheckout::instance();
}

add_action( 'plugins_loaded', 'Give_Twocheckout' );


/**
 * Give 2Checkout Activation Banner
 *
 * @description: Includes and initializes the activation banner class; only runs in WP admin
 * @hook       admin_init
 */
function give_twocheckout_activation_banner() {

	//Check to see if Give is activated, if it isn't deactivate and show a banner
	if ( is_admin() && current_user_can( 'activate_plugins' ) && ! is_plugin_active( 'give/give.php' ) ) {
		add_action( 'admin_notices', 'give_twocheckout_plugin_notice' );

		//Don't let this plugin activate
		deactivate_plugins( plugin_basename( __FILE__ ) );

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		return false;

	}


	//Check for activation banner inclusion
	if ( ! class_exists( 'Give_Addon_Activation_Banner' ) && file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' ) ) {
		include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
	}

	//Only runs on admin
	$args = array(
		'file'              => __FILE__,
		//Directory path to the main plugin file
		'name'              => __( '2Checkout Gateway', 'give-stripe' ),
		//name of the Add-on
		'version'           => GIVE_TWOCHECKOUT_VERSION,
		//The most current version
		'documentation_url' => 'https://givewp.com/documentation/add-ons/2checkout-gateway/',
		'support_url'       => 'https://givewp.com/support/',
		//Location of Add-on settings page, leave blank to hide
		'testing'           => false,
		//Never leave as "true" in production!!!
	);

	new Give_Addon_Activation_Banner( $args );

	return false;

}

add_action( 'admin_init', 'give_twocheckout_activation_banner' );

/**
 * 2Checkout Licensing
 */
function give_add_2checkout_licensing() {
	if ( class_exists( 'Give_License' ) && is_admin() ) {
		$give_2checkout_license = new Give_License( __FILE__, '2Checkout Gateway', GIVE_TWOCHECKOUT_VERSION, 'Devin Walker', '2checkout_license_key' );
	}
}

add_action( 'plugins_loaded', 'give_add_2checkout_licensing' );

/**
 * Notice for No Core Activation
 */
function give_twocheckout_child_plugin_notice() {

	echo '<div class="error"><p>' . __( '<strong>Activation Error:</strong> We noticed Give is not active. Please activate Give in order to use the 2Checkout Gateway.', 'give-twocheckout' ) . '</p></div>';
}


// registers the gateway
function give_register_twocheckout_gateway( $gateways ) {
	// Format: ID => Name
	$gateways['twocheckout'] = array(
		'admin_label'    => __( '2Checkout', 'give' ),
		'checkout_label' => __( 'Credit Card', 'give' )
	);

	return $gateways;
}

add_filter( 'give_payment_gateways', 'give_register_twocheckout_gateway' );
