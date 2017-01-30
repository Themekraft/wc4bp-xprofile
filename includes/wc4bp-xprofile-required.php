<?php

/**
 * @package        WordPress
 * @subpackage     BuddyPress, Woocommerce
 * @author         GFireM
 * @copyright      2017, Themekraft
 * @link           http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/
 * @license        http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

// No direct access is allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC4BP_Xprofile_Required {
	
	public function __construct() {
		add_action( 'init', array( $this, 'setup_init' ), 1, 1 );
	}
	
	public function setup_init() {
		// Only Check for requirements in the admin
		if ( ! is_admin() ) {
			return;
		}
		add_action( 'tgmpa_register', array( $this, 'setup_and_check' ) );
	}
	
	public static function load_plugins_dependency() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}
	
	public static function is_woocommerce_active() {
		self::load_plugins_dependency();
		return is_plugin_active( 'woocommerce/woocommerce.php' );
	}
	
	public static function is_buddypress_active() {
		self::load_plugins_dependency();
		return is_plugin_active( 'buddypress/bp-loader.php' );
	}
	
	public static function is_wc4bp_active() {
		self::load_plugins_dependency();
		return is_plugin_active( 'wc4bp/wc4bp-basic-integration.php' );
	}
	
	public static function is_current_active() {
		self::load_plugins_dependency();
		return is_plugin_active( 'wc4bp-xprofile/loader.php' );
	}
	
	public function setup_and_check() {
		// Create the required required_plugins array
		$required_plugins = array(
			array(
				'name'             => 'BuddyPress',
				'slug'             => 'buddypress',
				'version'          => '2.2',
				'required'         => true,
			),
			array(
				'name'             => 'WooCommerce',
				'slug'             => 'woocommerce',
				'version'          => '2.4',
				'required'         => true,
			),
			array(
				'name'             => 'WC4BP -> Checkout Manager',
				'slug'             => 'wc4bp',
				'version'          => '2.5',
				'required'         => true,
			),
		);
		
		$config = array(
			'id'           => 'wc4bp_xprofile',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'wc4bp-xprofile-install-plugins', // Menu slug.
			'parent_slug'  => 'admin.php',            // Parent menu slug.
			'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		);
		
		// Call the tgmpa function to register the required required_plugins
		tgmpa( $required_plugins, $config );
	}
	
}