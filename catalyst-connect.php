<?php
/**
 * Catalyst Connect is a simple plugin that makes integrating the BuddyPress, BBPress and WooCommerce Plugins with Catalyst a breeze.
 *
 * @author The Catalyst Team <info@catalysttheme.com>
 * @version 1.0.1
 * @package catalyst-connect
 */

/*
	Plugin Name:  Catalyst Connect
	Plugin URI:   http://catalysttheme.com/plugins/catalyst-connect/
	Description:  Catalyst Connect is a simple, yet powerful Plugin that makes integrating the BuddyPress, BBPress and WooCommerce Plugins with Catalyst a breeze.
	Version:      1.0.1
	Author:       The Catalyst Team
	Author URI:   http://catalysttheme.com
	Text Domain:  catalyst-connect
	Domain Path:  catalyst-connect/localization
	License:      GPL2
*/

define( 'CATALYSTCONNECT_OPTIONS_NAME', 'catalyst_connect' );
define( 'CATALYSTCONNECT_VERSION', '1.0.1' );
define( 'CATALYSTCONNECT_MIN_WP_VERSION', '3.0' );

// Option default values
define( 'CATALYSTCONNECT_DISABLE_BUDDYPRESS_CSS', 0 );
define( 'CATALYSTCONNECT_DISABLE_BUDDYPRESS', 0 );
define( 'CATALYSTCONNECT_DISABLE_BBPRESS_CSS', 0 );
define( 'CATALYSTCONNECT_DISABLE_BBPRESS', 0 );
define( 'CATALYSTCONNECT_WOOCOMMERCE_BREADCRUMBS', 'cat' );
define( 'CATALYSTCONNECT_DISABLE_WOOCOMMERCE_CSS', 0 );
define( 'CATALYSTCONNECT_DISABLE_WOOCOMMERCE', 0 );

if ( !class_exists("CatalystConnect") ) {

	class CatalystConnect {

		var $options;
		var $options_name = "catalyst_connect";

		var $plugin_dir = "";
		var $css_dir = "";
		var $js_dir = "";
		var $images_dir = "";

		var $css_url = "";
		var $js_url = "";
		var $images_url = "";
		
		var $admin_css = array("catalyst-connect-admin.css");
		var $admin_js = array("catalyst-connect-admin.js");
		var $frontend_css = array();
		var $frontend_js = array();
		
		function CatalystConnect() {

			// Full path and plugin basename of the main plugin file
			$this->plugin_file = dirname ( dirname ( __FILE__ ) ) . '/catalyst-connect.php';
			$this->plugin_basename = plugin_basename ( $this->plugin_file );

			// Plugin directory names
			$this->plugin_path = dirname ( __FILE__ );			
			$this->css_dir = $this->plugin_path . '/css/';
			$this->js_dir = $this->plugin_path . '/scripts/';
			$this->images_dir = $this->plugin_path . '/images/';

			// Plugin URLs
			$this->css_url = plugins_url( 'css' , __FILE__ );
			$this->js_url = plugins_url( 'scripts' , __FILE__ );
			$this->images_url = plugins_url( 'images' , __FILE__ );
			
			// Load localizations if available
			load_plugin_textdomain ( 'catalystconnect' , false , 'catalyst-connect/localization' );

			// Make sure our options are setup in the db
			$this->setup_options();
			$this->options = get_option ( CATALYSTCONNECT_OPTIONS_NAME );
		} 
		/**
		 * init
		 * Actions that need to occur each time the plugin is started should go here
		 */
		function init() {

			// Instantiate the CatalystConnectFrontend or CatalystConnectAdmin Class
			// Deactivate and die if files can not be included
			if ( is_admin () ) {
				// Load the admin page code
				if ( @include ( dirname ( __FILE__ ) . '/inc/admin.php' ) ) {
					$CatalystConnectAdmin = new CatalystConnectAdmin ();
				} else {
					CatalystConnect::deactivate_and_die ( dirname ( __FILE__ ) . '/inc/admin.php' );
				}
			} else {
				// Load the frontend code
				if ( @include ( dirname ( __FILE__ ) . '/inc/frontend.php' ) ) {
					$CatalystConnectFrontend = new CatalystConnectFrontend ();
				} else {
					CatalystConnect::deactivate_and_die ( dirname ( __FILE__ ) . '/inc/frontend.php' );
				}
			}
		}
	
		/**
		 * Callback for the register_activation_hook
		 * Actions that need to occur when the plugin is activated should go here
		 */
		function plugin_activation() {
		}

		/***
		 * Callback for register_deactivation_hook
		 * Actions that need to occur when the plugin is deactivated should go here
		 */
		function plugin_deactivation() {
		}
		
		/***
		 * Callback for register_uninstall_hook
		 * Clean up the db when the plugin is uninstalled
		 */
		function plugin_uninstall() {
			delete_option( CATALYSTCONNECT_OPTIONS_NAME );
		}

		/**
		 * Return the default option values
		 */
		function default_options() {
			$defaults = array (
				'disable_buddypress_connect_css'	=> CATALYSTCONNECT_DISABLE_BUDDYPRESS_CSS,
				'disable_buddypress_connect'	=> CATALYSTCONNECT_DISABLE_BUDDYPRESS,
				'disable_bbpress_connect_css' => CATALYSTCONNECT_DISABLE_BBPRESS_CSS,
				'disable_bbpress_connect'		=> CATALYSTCONNECT_DISABLE_BBPRESS,
				'woocommerce_breadcrumbs'	=> CATALYSTCONNECT_WOOCOMMERCE_BREADCRUMBS,
				'disable_woocommerce_connect_css' => CATALYSTCONNECT_DISABLE_WOOCOMMERCE_CSS,
				'disable_woocommerce_connect' => CATALYSTCONNECT_DISABLE_WOOCOMMERCE
			);
			return $defaults;
		}
		
		/**
		 * Setup shared functionality for Admin and Front End
		 */

		// If any of the necessary files are not found we come here to deactivate the plugin and show an error message.
		function deactivate_and_die() {
			load_plugin_textdomain ( 'catalyst-connect' , false , 'catalyst-connect/localization' );
			$message = sprintf ( __( "Catalyst Connect has been automatically deactivated because the file <strong>%s</strong> is missing. Please reinstall the plugin and reactivate." ) , $file );
			if ( ! function_exists ( 'deactivate_plugins' ) )
				include ( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins ( __FILE__ );
			wp_die ( $message );
		}


		// Set default options if they don't already exisit
		function setup_options() {
			if ( ! get_option ( CATALYSTCONNECT_OPTIONS_NAME ) ) {
				$this->options = $this->default_options();
				add_option ( CATALYSTCONNECT_OPTIONS_NAME , $this->options );
			}
		}

		/**
		 * Get specific option from the options array
		 */
		function get_option( $option ) {
			if ( isset ( $this->options[$option] ) ) {
				return $this->options[$option];
			} else {
				return false;
			}
		}

		/**
		 * Set specific option from the options array
		 */
		function set_option( $option, $value ) {
			$this->options[$option] = $value;
			update_option( CATALYSTCONNECT_OPTIONS_NAME , $this->options );
		}
		
		/**
		 * Get the full URL to the plugin
		 */
		function plugin_url() {
			$plugin_url = plugins_url ( plugin_basename ( dirname ( __FILE__ ) ) );
			return $plugin_url;
		}
		
	} // End CatalystConnect class

} // End if CatalystConnect

/**
 * Setup initial hooks and actions for CatalystConnect plugin
 * 
 */

//register_deactivation_hook( __FILE__, array('CatalystConnect', 'plugin_deactivate' ) );
//register_uninstall_hook( __FILE__ , array( 'CatalystConnect', 'plugin_uninstall' ) );

add_action( 'init', array( 'CatalystConnect', 'init' ) );
