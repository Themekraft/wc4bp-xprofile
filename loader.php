<?php

/**
 * Plugin Name: WC4BP -> BuddyPress xProfile Checkout Manager
 * Plugin URI:  http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/
 * Description: WooCommerce BuddyPress Integration - Add BuddyPress xProfile Fields to the WooCommerce Checkout and remove WooCommerce Fields from the Checkout
 * Author:      Sven Lehnert
 * Version:     1.2.1
 *
 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */
class WC4BP_xProfile {

	/**
	 * @var string
	 */
	public $version = '1.2.1';

	/**
	 * Initiate the class
	 *
	 * @package wc4bp_xprofile
	 * @since 1.0
	 */
	public function __construct() {

		define( 'WC4BP_XPROFILE_VERSION', $this->version );

		add_action( 'init', array( $this, 'includes' ), 4, 1 );
		add_action( 'init', array( $this, 'load_plugin_textdomain' ), 10, 1 );

	}

	public static function plugin_base_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Load the language file
	 *
	 * @since    1.0
	 * @uses    load_plugin_textdomain()
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'wc4bp_xprofile', false, dirname( plugin_basename( __FILE__ ) ) . "/languages" );
	}

	/**
	 * Include files needed by wc4bp_xprofile
	 *
	 * @package wc4bp_xprofile
	 * @since 1.0
	 */
	public function includes() {

		require_once( plugin_dir_path( __FILE__ ) . '/includes/wc4bp-xprofile-checkout.php' );

		if ( is_admin() ) {
			require_once( plugin_dir_path( __FILE__ ) . 'admin/admin-xprofile.php' );
			require_once( plugin_dir_path( __FILE__ ) . 'admin/admin-xprofile-ajax.php' );
		}

	}

}

$GLOBALS['wc4bp_xprofile_new'] = new WC4BP_xProfile();
