<?php
/**
 * Plugin Name: Give - PayPal Pro Gateway
 * Plugin URI:  https://givewp.com/addons/paypal-pro-gateway/
 * Description: A payment gateway for PayPal Website Payments Pro (NVP and REST APIs) and PayPal Payments Pro (PayFlow).
 * Version:     1.2.2
 * Author:      GiveWP
 * Author URI:  https://givewp.com/
 * Text Domain: give-paypal-pro
 * Domain Path: /languages
 *
 * Important links:
 *
 * @see https://www.angelleye.com/paypal-payments-pro-dodirectpayment-vs-payflow/ - explains the messy PayPal integrations
 *
 * DoDirectPayment API Operation (NVP)
 * https://developer.paypal.com/docs/classic/api/merchant/DoDirectPayment_API_Operation_NVP/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'GIVEPP_VERSION' ) ) {
	define( 'GIVEPP_VERSION', '1.2.2' );
}
if ( ! defined( 'GIVEPP_MIN_GIVE_VERSION' ) ) {
	define( 'GIVEPP_MIN_GIVE_VERSION', '2.4.0' );
}

if ( ! defined( 'GIVEPP_PRODUCT_NAME' ) ) {
	define( 'GIVEPP_PRODUCT_NAME', 'PayPal Pro Gateway' );
}
if ( ! defined( 'GIVEPP_PLUGIN_FILE' ) ) {
	define( 'GIVEPP_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'GIVEPP_PLUGIN_DIR' ) ) {
	define( 'GIVEPP_PLUGIN_DIR', dirname( GIVEPP_PLUGIN_FILE ) );
}
if ( ! defined( 'GIVEPP_BASENAME' ) ) {
	define( 'GIVEPP_BASENAME', plugin_basename( GIVEPP_PLUGIN_FILE ) );
}

if ( ! defined( 'GIVEPP_STORE_API_URL' ) ) {
	define( 'GIVEPP_STORE_API_URL', 'https://givewp.com' );
}

if ( ! defined( 'GIVEPP_MIN_PHP_VERSION' ) ) {
	define( 'GIVEPP_MIN_PHP_VERSION', '5.3.0' );
}


if ( ! class_exists( 'Give_PayPal_Gateway' ) ) :

	/**
	 * Class Give_PayPal_Gateway
	 */
	class Give_PayPal_Gateway {

		/**
		 * Give_PayPal_Gateway instance.
		 *
		 * @since  1.0
		 * @access private
		 * @static
		 *
		 * @var $instance Give_PayPal_Gateway
		 */
		private static $instance;

		/**
		 * Notices (array)
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * Get active object instance
		 *
		 * @since  1.0
		 * @access public
		 * @static
		 *
		 * @return object
		 */
		public static function get_instance() {

			if ( ! self::$instance ) {
				self::$instance = new Give_PayPal_Gateway();
				self::$instance->setup();
			}

			return self::$instance;
		}


		/**
		 * Private clone method to prevent cloning of the instance of the
		 * *Singleton* instance.
		 *
		 * @return void
		 */
		private function __clone() {
		}

		/**
		 * Give_PayPal_Gateway constructor.
		 *
		 * Includes constants, includes and init method.
		 *
		 * @since  1.2.0
		 * @access public
		 */
		public function setup() {

			register_activation_hook( GIVEPP_PLUGIN_FILE, array( $this, 'version_check' ) );

			add_action( 'give_init', array( $this, 'init' ) );
			add_action( 'admin_init', array( $this, 'check_environment' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ), 15 );
			add_action( 'give_loaded', array( $this, 'give_loaded' ), 15 );
		}

		/**
		 * Fire when Give class is loaded
		 *
		 * @since 1.2.0
		 */
		public function give_loaded() {
			if ( ! has_action( 'activate_' . GIVE_PLUGIN_BASENAME, array( $this, 'version_check' ), 15 ) ) {
				add_action( 'activate_' . GIVE_PLUGIN_BASENAME, array( $this, 'version_check' ), 15 );
			}
		}


		/**
		 * Version check
		 *
		 * @since 1.2.0
		 */
		public function version_check() {

			if ( $this->get_environment_warning() && class_exists( 'Give' ) ) {

				$previous_version = get_option( 'give_paypal_pro_version' );

				//No version option saved
				if ( version_compare( '2.0', $previous_version, '>' ) || empty( $previous_version ) ) {
					$this->update_v20_default_billing_fields();
				}

				//Update the version # saved in DB after version checks above
				update_option( 'give_paypal_pro_version', GIVEPP_VERSION );
			}
		}

		/**
		 * Allow this class and other classes to add notices.
		 *
		 * @param $slug
		 * @param $class
		 * @param $message
		 */
		public function add_admin_notice( $slug, $class, $message ) {
			$this->notices[ $slug ] = array(
				'class'   => $class,
				'message' => $message,
			);
		}

		/**
		 * Display admin notices.
		 */
		public function admin_notices() {

			$allowed_tags = array(
				'a'      => array(
					'href'  => array(),
					'title' => array(),
					'class' => array(),
					'id'    => array(),
				),
				'br'     => array(),
				'em'     => array(),
				'span'   => array(
					'class' => array(),
				),
				'strong' => array(),
			);

			foreach ( (array) $this->notices as $notice_key => $notice ) {
				echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
				echo wp_kses( $notice['message'], $allowed_tags );
				echo '</p></div>';
			}

		}

		/**
		 * Environment warnings.
		 *
		 * Checks the environment for compatibility problems.
		 * Returns a string with the first incompatibility found or false if the environment has no problems.
		 *
		 * @return bool|mixed|string
		 */
		public function get_environment_warning() {

			// Flag to check whether plugin file is loaded or not.
			$is_working = true;

			// Verify dependency cases.
			if ( defined( 'GIVE_VERSION' ) && version_compare( GIVE_VERSION, GIVEPP_MIN_GIVE_VERSION, '<' ) ) {

				/* Min. Give. plugin version. */
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> core version %s for the Give - PayPal Pro add-on to activate.', 'give-paypal-pro' ), 'https://givewp.com', GIVEPP_MIN_GIVE_VERSION ) );

				$is_working = false;
			}

			if ( ! function_exists( 'curl_init' ) ) {
				$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">cURL</a> installed for the Give - PayPal Pro add-on to activate.', 'give-paypal-pro' ), 'https://givewp.com/documentation/core/requirements/' ) );

				$is_working = false;
			}

			if ( version_compare( phpversion(), GIVEPP_MIN_PHP_VERSION, '<' ) ) {
				$this->add_admin_notice( 'prompt_give_incompatible', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">PHP</a> version %s or above for the Give - PayPal Pro add-on to activate.', 'give-paypal-pro' ), 'https://givewp.com/documentation/core/requirements/', GIVEPP_MIN_PHP_VERSION ) );

				$is_working = false;
			}

			return $is_working;
		}

		/**
		 * Check the server environment.
		 *
		 * The backup sanity check, in case the plugin is activated in a weird way,
		 * or the environment changes after activation.
		 */
		public function check_environment() {

			// Flag to check whether plugin file is loaded or not.
			$is_working = true;

			// Load plugin helper functions.
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . '/wp-admin/includes/plugin.php';
			}

			/* Check to see if Give is activated, if it isn't deactivate and show a banner. */
			// Check for if give plugin activate or not.
			$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

			if ( empty( $is_give_active ) ) {
				// Show admin notice.
				$this->add_admin_notice( 'prompt_give_activate', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" target="_blank">Give</a> plugin installed and activated for Give - Paypal Pro to activate.', 'give-paypal-pro' ), 'https://givewp.com' ) );
				$is_working = false;
			}

			return $is_working;

		}

		/**
		 * Initialize Give_Paypal_Pro
		 *
		 * @access private
		 * @since  1.1
		 *
		 * @return bool
		 */
		public function init() {

			if ( ! $this->get_environment_warning() ) {
				return;
			}

			$this->load_textdomain();
			$this->includes();

			new Give_PayPal_Pro_Payflow();
			new Give_PayPal_Pro_Rest();
			new Give_PayPal_Pro_NVP();

			// Licensing
			if ( class_exists( 'Give_License' ) ) {
				new Give_License( GIVEPP_PLUGIN_FILE, GIVEPP_PRODUCT_NAME, GIVEPP_VERSION, 'WordImpress', 'paypal_pro_license_key' );
			}

			return true;
		}

		/**
		 * Include required files
		 *
		 * @access private
		 * @since  1.1
		 */
		private function includes() {

			require_once GIVEPP_PLUGIN_DIR . '/includes/give-paypalpro-helper-functions.php';
			require_once GIVEPP_PLUGIN_DIR . '/includes/class-give-paypalpro-nvp.php';
			require_once GIVEPP_PLUGIN_DIR . '/includes/class-give-paypalpro-payflow.php';
			require_once GIVEPP_PLUGIN_DIR . '/includes/class-give-paypalpro-rest.php';

			if ( file_exists( GIVEPP_PLUGIN_DIR . '/includes/give-paypalpro-activation.php' ) ) {
				require_once GIVEPP_PLUGIN_DIR . '/includes/give-paypalpro-activation.php';
			}
		}


		/**
		 * Load the text domain.
		 *
		 * @access private
		 * @since  1.1
		 *
		 * @return void
		 */
		public function load_textdomain() {

			// Set filter for plugin's languages directory
			$lang_dir = dirname( GIVEPP_BASENAME ) . '/languages/';

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'give-paypal-pro' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'give-paypal-pro', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/givepp/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/give-paypal-pro folder
				load_textdomain( 'give-paypal-pro', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/give-paypal-pro/languages/ folder
				load_textdomain( 'give-paypal-pro', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'give-paypal-pro', false, $lang_dir );
			}

		}

		/**
		 * Update 2.0 Collect Billing Details
		 *
		 * Sets the default option to display Billing Details as to not mess with any donation forms without consent
		 *
		 * @since 1.2.0
		 *
		 * @see https://github.com/impress-org/give-paypal-pro/issues/1
		 */
		private function update_v20_default_billing_fields() {

			give_update_option( 'paypal_classic_collect_billing', 'on' );
			give_update_option( 'paypal_rest_collect_billing', 'on' );

		}

	}


	if ( ! function_exists( 'Give_PayPal_Gateway' ) ) {
		/**
		 * Loads a single instance of Give PayPal Pro.
		 *
		 * This follows the PHP singleton design pattern.
		 *
		 * Use this function like you would a global variable, except without needing
		 * to declare the global.
		 *
		 * @example <?php $give_fee_recovery = givepp_gateway(); ?>
		 *
		 * @since   1.2.0
		 *
		 * @see     Give_PayPal_Gateway::get_instance()
		 *
		 * @return object Give_PayPal_Gateway Returns an instance of the  class
		 */
		function Give_PayPal_Gateway() {
			return Give_PayPal_Gateway::get_instance();
		}
	}

	$GLOBALS['give_paypalpro_gateway'] = Give_PayPal_Gateway();

endif; // End if class_exists check.




