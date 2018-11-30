<?php
/**
 * Plugin Name: Give - PDF Receipts
 * Plugin URI:  https://givewp.com/addons/pdf-receipts/
 * Description: Creates PDF Receipts for each donation that is downloadable via email and donation history.
 * Author: WordImpress
 * Author URI: https://wordimpress.com
 * Contributors: wordimpress
 * Version: 2.0.4
 * Text Domain: give-pdf-receipts
 * Domain Path: /languages
 *
 * Copyright 2016 WordImpress
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define Plugin Version.
 */
if ( ! defined( 'GIVE_PDF_PLUGIN_VERSION' ) ) {
	define( 'GIVE_PDF_PLUGIN_VERSION', '2.0.4' );
}

/**
 * Define the Minimum Give Plugin Version.
 */
if ( ! defined( 'GIVE_PDF_MIN_GIVE_VERSION' ) ) {
	define( 'GIVE_PDF_MIN_GIVE_VERSION', '1.7' );
}

/**
 * Define Plugin Directory.
 */
if ( ! defined( 'GIVE_PDF_PLUGIN_DIR' ) ) {
	define( 'GIVE_PDF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Define Plugin URL.
 */
if ( ! defined( 'GIVE_PDF_PLUGIN_URL' ) ) {
	define( 'GIVE_PDF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Define Plugin File Name.
 */
if ( ! defined( 'GIVE_PDF_PLUGIN_FILE' ) ) {
	define( 'GIVE_PDF_PLUGIN_FILE', __FILE__ );
}

/**
 * Define Plugin Basename.
 */
if ( ! defined( 'GIVE_PDF_PLUGIN_BASENAME' ) ) {
	define( 'GIVE_PDF_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}


if ( ! class_exists( 'Give_PDF_Receipts' ) ) :

	/**
	 * Give_PDF_Receipts Class
	 *
	 * @package Give_PDF_Receipts
	 * @since   1.0
	 */
	final class Give_PDF_Receipts {

		/**
		 * Holds the instance
		 *
		 * Ensures that only one instance of Give_PDF_Receipts exists in memory at any one
		 * time and it also prevents needing to define globals all over the place.
		 *
		 * TL;DR This is a static property property that holds the singleton instance.
		 *
		 * @var object
		 * @static
		 */
		private static $instance;

		/**
		 * Notices (array).
		 *
		 * @var array
		 */
		public $notices = array();

		/**
		 * Get the instance and store the class inside it. This plugin utilises
		 * the PHP singleton design pattern.
		 *
		 * @since     1.0
		 * @static
		 * @staticvar array $instance
		 * @access    public
		 * @see       give_pdf_receipts();
		 * @uses      Give_PDF_Receipts::includes() Loads all the classes
		 * @uses      Give_PDF_Receipts::hooks() Setup hooks and actions
		 *
		 * @return object self::$instance Instance
		 */
		public static function get_instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Give_PDF_Receipts ) ) {
				self::$instance = new Give_PDF_Receipts();
				self::$instance->hooks();
				self::$instance->licensing();

				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since  1.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'give' ), '1.6' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since  1.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'give' ), '1.0' );
		}

		/**
		 * Constructor Function
		 *
		 * @since  1.0
		 * @access protected
		 * @see    Give_PDF_Receipts::init()
		 */
		public function __construct() {
			self::$instance = $this;

			add_action( 'init', array( $this, 'init' ), - 1 );
		}

		/**
		 * Reset the instance of the class
		 *
		 * @since  1.0
		 * @access public
		 * @static
		 */
		public static function reset() {
			self::$instance = null;
		}

		/**
		 * Function fired on init.
		 *
		 * This function is called on WordPress 'init'. It's triggered from the
		 * constructor function.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @uses   Give_PDF_Receipts::load_plugin_textdomain()
		 *
		 * @return void
		 */
		public function init() {

			do_action( 'give_pdf_before_init' );

			$this->load_plugin_textdomain();

			do_action( 'give_pdf_after_init' );

		}

		/**
		 * Includes.
		 *
		 * @since  1.0
		 * @access private
		 * @return bool
		 */
		private function includes() {

			if ( ! class_exists( 'Give' ) ) {
				return false;
			}

			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/templates/template-blue-stripe.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/templates/template-colors.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/templates/template-default.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/templates/template-lines.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/templates/template-minimal.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/templates/template-traditional.php' );

			do_action( 'give_pdf_load_templates' );

			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/class-give-pdf-receipts-engine.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/email-template-tag.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/email-templates.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/i18n.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/settings.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/template-functions.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/scripts.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/ajax-functions.php' );
			require_once( GIVE_PDF_PLUGIN_DIR . 'includes/plugin-compatibility.php' );

			self::$instance->engine = new Give_PDF_Receipts_Engine();

		}

		/**
		 * Hooks.
		 */
		public function hooks() {

			add_action( 'admin_init', array( $this, 'check_plugin_requirements' ) );
			add_action( 'admin_init', array( $this, 'activation_banner' ) );
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
			add_filter( 'plugin_action_links', array( $this, 'give_plugin_action_links' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
		}

		/**
		 * Implement Give Licensing
		 */
		private function licensing() {
			if ( class_exists( 'Give_License' ) ) {
				new Give_License( __FILE__, 'PDF Receipts', GIVE_PDF_PLUGIN_VERSION, 'WordImpress' );
			}
		}

		/**
		 * Load Plugin Text Domain
		 *
		 * Looks for the plugin translation files in certain directories and loads
		 * them to allow the plugin to be localised
		 *
		 * @since  1.0
		 * @access public
		 * @return bool True on success, false on failure
		 */
		public function load_plugin_textdomain() {
			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'give-pdf-receipts' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'give-pdf-receipts', $locale );

			// Setup paths to current locale file
			$mofile_local = trailingslashit( plugin_dir_path( __FILE__ ) . 'languages' ) . $mofile;

			if ( file_exists( $mofile_local ) ) {
				// Look in the /wp-content/plugins/give-pdf-receipts/languages/ folder
				load_textdomain( 'give-pdf-receipts', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'give-pdf-receipts', false, trailingslashit( plugin_dir_path( __FILE__ ) . 'languages' ) );
			}

			return false;
		}

		/**
		 * Insert default template
		 *
		 * @param string $template_name Name of template
		 * @param string $filename      Filename of the template
		 */
		private static function add_default_template( $template_name, $filename ) {

			if ( ! file_exists( plugin_dir_path( __FILE__ ) . 'templates/' . $filename ) ) {
				return;
			}

			ob_start();

			include( plugin_dir_path( __FILE__ ) . 'templates/' . $filename );

			$content = ob_get_clean();

			// Replace placeholders
			$content = str_replace( '%assets_url%', get_site_url() . '/wp-content/plugins/Give-PDF-Receipts/assets', $content );

			$template = array(
				'post_title'     => $template_name,
				'post_content'   => $content,
				'post_type'      => 'Give_PDF_Template',
				'ping_status'    => 'closed',
				'comment_status' => 'closed'
			);

			// Insert template
			$post_id = wp_insert_post( $template );

			//Flag this post as a template so we delete these only on deactivation
			add_post_meta( $post_id, '_give_pdf_receipts_template', true );

			//Set default option if not set already
			$set_template = give_get_option( 'give_pdf_receipt_template' );
			if ( ! $set_template ) {
				give_update_option( 'give_pdf_receipt_template', $post_id );
				give_update_option( 'give_pdf_receipt_template_name', get_the_title( $post_id ) );
			}

		}

		/**
		 * Check Plugin Requirements.
		 *
		 * @return bool
		 */
		public function check_plugin_requirements() {

			//Check for Give - if not active, deactivate/bail
			if ( ! class_exists( 'Give' ) ) {

				$this->add_admin_notice( 'prompt_connect', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" title="Visit the Give website" target="_blank">Give</a> core plugin installed and activated for the PDF Receipts add-on to activate.', 'give-pdf-receipts' ), 'https://givewp.com' ) );

				deactivate_plugins( GIVE_PDF_PLUGIN_BASENAME );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}

			}

			//Min. Give. plugin version.
			if ( defined( 'GIVE_VERSION' ) && version_compare( GIVE_VERSION, GIVE_PDF_MIN_GIVE_VERSION, '<' ) ) {

				$this->add_admin_notice( 'prompt_connect', 'error', sprintf( __( '<strong>Activation Error:</strong> You must have the <a href="%s" title="Visit the Give website" target="_blank">Give</a> core version %s+ for the PDF Receipts add-on to activate.', 'give-pdf-receipts' ), 'https://givewp.com', GIVE_PDF_MIN_GIVE_VERSION ) );

				deactivate_plugins( GIVE_PDF_PLUGIN_BASENAME );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}

				return false;
			}

			return true;

		}

		/**
		 * Activation banner.
		 *
		 * Uses Give's core activation banners.
		 *
		 * @since 2.0.4
		 */
		public function activation_banner() {

			if ( ! defined( 'GIVE_PLUGIN_DIR' ) ) {
				//Now that is passes move to activation
				return false;
			};

			//Check for activation banner inclusion.
			$activation_banner_file = GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
			if ( ! class_exists( 'Give_Addon_Activation_Banner' ) && file_exists( $activation_banner_file ) ) {
				include $activation_banner_file;
			}

			//Show activation banner.
			$args = array(
				'file'              => __FILE__,
				'name'              => esc_html__( 'PDF Receipts', 'give-pdf-receipts' ),
				'version'           => GIVE_PDF_PLUGIN_VERSION,
				'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=pdf_receipts' ),
				'documentation_url' => 'https://givewp.com/documentation/add-ons/pdf-receipts/',
				'support_url'       => 'https://givewp.com/support/',
				'testing'           => false
			);

			new Give_Addon_Activation_Banner( $args );

		}

		/**
		 * Activation function fires when the plugin is activated.
		 *
		 * This function is fired when the activation hook is called by WordPress,
		 * it flushes the rewrite rules and disables the plugin if Give isn't active
		 * and throws an error.
		 *
		 * @since  1.0
		 * @access public
		 *
		 * @return mixed
		 */
		public static function activation() {

			// Define Give_PDF_Template post type.
			$template_args = array(
				'labels'      => array(
					'name'          => 'Give_PDF_Template',
					'singular_name' => 'Give_PDF_Template'
				),
				'public'      => false,
				'has_archive' => false,
			);

			// Register Give_PDF_Template post type.
			register_post_type( 'give_pdf_template', $template_args );

			// Insert default templates.
			Give_PDF_Receipts::add_default_template( 'Receipt Template 1', 'receipt-1.php' );

			Give_PDF_Receipts::add_default_template( 'Receipt Template 2', 'receipt-2.php' );

			Give_PDF_Receipts::add_default_template( 'Receipt Template 3', 'receipt-3.php' );

			Give_PDF_Receipts::add_default_template( 'Receipt Template 4', 'receipt-4.php' );

			//Flush rewrite rules because we created a new CPT.
			flush_rewrite_rules();

			return true;

		}


		/**
		 * Activation Check.
		 *
		 * @return bool
		 */
		public static function activation_check() {

			//Check for PHP version - if not 5.3+, deactivate/bail w/ message.
			if ( version_compare( phpversion(), '5.3', '<' ) ) {

				deactivate_plugins( GIVE_PDF_PLUGIN_BASENAME );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
				wp_die( __( 'Activation Error: The Give PDF Receipts Add-on requires PHP version 5.3 or newer in order to activate. We recommend PHP 5.5 for best performance and stability. Please contact your host to upgrade your server to PHP 5.3+ in order to use the plugin.', 'give-pdf-receipts' ) );

				return false;
			}

			//Run plugin activation if all checks out.
			self::activation();

		}

		/**
		 * Deactivation function.
		 *
		 * Delete all default templates from database.
		 *
		 * @since      1.0
		 * @access     public
		 *
		 * @return void
		 */
		public static function deactivation() {

			$args = array(
				'post_type'      => 'Give_PDF_Template',
				'post_status'    => array( 'draft', 'publish' ),
				'posts_per_page' => - 1,
				'meta_key'       => '_give_pdf_receipts_template'
			);

			$posts = get_posts( $args );

			foreach ( $posts as $post ) {
				wp_delete_post( $post->ID, true );
			}
		}

		/**
		 * Allow this class and other classes to add notices.
		 *
		 * @since 2.0.4
		 *
		 * @param $slug
		 * @param $class
		 * @param $message
		 */
		public function add_admin_notice( $slug, $class, $message ) {
			$this->notices[ $slug ] = array(
				'class'   => $class,
				'message' => $message
			);
		}

		/**
		 * Handles the displaying of any notices in the admin area.
		 *
		 * @since  1.0
		 * @access public
		 * @return mixed
		 */
		public function admin_notices() {

			$allowed_tags = array(
				'a'      => array(
					'href'  => array(),
					'title' => array()
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
			);

			foreach ( (array) $this->notices as $notice_key => $notice ) {
				echo "<div class='" . esc_attr( $notice['class'] ) . "'><p>";
				echo wp_kses( $notice['message'], $allowed_tags );
				echo "</p></div>";
			}
		}

		/**
		 * Plugins row action links.
		 *
		 * @param array  $links Already defined action links.
		 * @param string $file  Plugin file path and name being processed.
		 *
		 * @return array $links
		 */
		function give_plugin_action_links( $links, $file ) {

			$settings_link = '<a href="' . admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=pdf_receipts' ) . '">' . esc_html__( 'Settings', 'give-pdf-receipts' ) . '</a>';

			if ( $file == 'give-pdf-receipts/give-pdf-receipts.php' ) {
				array_unshift( $links, $settings_link );
			}

			return $links;

		}

		/**
		 * Plugin row meta links.
		 *
		 * @since 2.0.4
		 *
		 * @param array  $plugin_meta An array of the plugin's metadata.
		 * @param string $plugin_file Path to the plugin file, relative to the plugins directory.
		 *
		 * @return array
		 */
		function plugin_row_meta( $plugin_meta, $plugin_file ) {

			if ( $plugin_file != GIVE_PDF_PLUGIN_BASENAME ) {
				return $plugin_meta;
			}

			$new_meta_links = array(
				sprintf(
					'<a href="%1$s" target="_blank">%2$s</a>',
					esc_url( add_query_arg( array(
							'utm_source'   => 'plugins-page',
							'utm_medium'   => 'plugin-row',
							'utm_campaign' => 'admin',
						), 'https://givewp.com/documentation/add-ons/pdf-receipts/' )
					),
					esc_html__( 'Documentation', 'give-pdf-receipts' )
				),
				sprintf(
					'<a href="%1$s" target="_blank">%2$s</a>',
					esc_url( add_query_arg( array(
							'utm_source'   => 'plugins-page',
							'utm_medium'   => 'plugin-row',
							'utm_campaign' => 'admin',
						), 'https://givewp.com/addons/' )
					),
					esc_html__( 'Add-ons', 'give-pdf-receipts' )
				),
			);

			return array_merge( $plugin_meta, $new_meta_links );

		}


	} //End Give_PDF_Receipts Class

	/**
	 * Loads a single instance of Give PDF Receipts
	 *
	 * This follows the PHP singleton design pattern.
	 *
	 * Use this function like you would a global variable, except without needing
	 * to declare the global.
	 *
	 * @example <?php $give_pdf_receipts = give_pdf_receipts(); ?>
	 *
	 * @since   1.0
	 *
	 * @see     Give_PDF_Receipts::get_instance()
	 *
	 * @return object Give_PDF_Receipts Returns an instance of the  class
	 */
	function give_pdf_receipts() {
		return Give_PDF_Receipts::get_instance();
	}

	/**
	 * Loads plugin after all the others have loaded and have registered their
	 * hooks and filters
	 */
	add_action( 'plugins_loaded', 'give_pdf_receipts', apply_filters( 'give_pdf_action_priority', 10 ) );

	register_deactivation_hook( __FILE__, array( 'Give_PDF_Receipts', 'deactivation' ) );
	register_activation_hook( __FILE__, array( 'Give_PDF_Receipts', 'activation_check' ) );

endif;

