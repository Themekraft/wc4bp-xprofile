<?php



class wc4bp_xprofile_freemius_integration{

/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;
	
	public function __construct() {
		if ( $this->wc4bp_xprofile_check_parent() ) {
			// If parent already included, init add-on.
			$this->wc4bp_xprofile_fs_init();
		} else if ( $this->wc4bp_xprofile_fs_is_parent_active() ) {
			// Init add-on only after the parent is loaded.
			add_action( 'wc4bp_core_fs_loaded', array( $this, 'wc4bp_xprofile_fs_init' ) );
		} else {
			// Even though the parent is not activated, execute add-on for activation / uninstall hooks.
			$this->wc4bp_xprofile_fs_init();
		}
	}

    public function wc4bp_xprofile_check_parent() {
		// Check if the parent's init SDK method exists.
		return method_exists( 'WC4BP_Loader', 'wc4bp_fs' );
	}

    public function wc4bp_xprofile_fs_is_parent_active() {
		$xp_active_plugins_basenames = get_option( 'active_plugins' );
		
		foreach ( $xp_active_plugins_basenames as $xp_plugin_basename ) {
			if ( 0 === strpos( $xp_plugin_basename, 'wc4bp/' ) ||
			     0 === strpos( $xp_plugin_basename, 'wc4bp-premium/' )
			) {
				return true;
			}
		}
		
		return false;
	}

    public function wc4bp_xprofile_fs_init() {
		if ( $this->wc4bp_xprofile_check_parent() ) {
			// Init Freemius.
			$this->start_freemius();
		}
	}

    public function start_freemius() {
		global $wc4bp_xprofile_fs;
		
		if ( ! isset( $wc4bp_xprofile_fs ) ) {
			// Include Freemius SDK.
			require_once WC4BP_ABSPATH_CLASS_PATH . 'includes/freemius/start.php';
			
			$wc4bp_xprofile_fs = fs_dynamic_init( array(
				'id'                  => '429',
				'slug'                => 'woocommerce-buddypress-integration-xprofile-checkout-manager',
				'type'                => 'plugin',
				'public_key'          => 'pk_04f1129cac1084a016de2dedd6f21',
				'is_premium'          => false,
				'has_premium_version' => false,
				'has_paid_plans'      => false,
				'parent'              => array(
					'id'         => '425',
					'slug'       => 'wc4bp',
					'public_key' => 'pk_71d28f28e3e545100e9f859cf8554',
					'name'       => 'WooBuddy -> WooCommerce BuddyPress Integration',
				),
                'menu'                => array(
                    'slug'           => 'edit.php?post_type=woocommerce-buddypress-integration-xprofile-checkout-manager',
                    'first-path'     => 'edit.php?post_type=buddyforms&page=buddyforms_welcome_screen',
                    'contact'        => false,
                    'support'        => false,
                ),
			) );
		}
		
		return $wc4bp_xprofile_fs;
	}

    public static function getFreemius() {
		
		global $wc4bp_xprofile_fs;
		return $wc4bp_xprofile_fs;
	}

}