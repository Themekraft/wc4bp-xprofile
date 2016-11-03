<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( dirname( __FILE__ ) . '/../includes/wc4bp-xprofile-data.php' );
require_once( 'admin-xprofile-util.php' );

add_action( 'wc4bp_add_submenu_page', 'wc4bp_add_xprofile_menu' );
add_action( 'admin_enqueue_scripts', 'wc4bp_admin_enqueue_scripts' );

// Add the option page to the WC4BP Integration menu
function wc4bp_add_xprofile_menu() {
	if( ! has_action('wc4bp_add_submenu_page') ) {
		add_action( 'admin_notices', create_function( '', 'printf(\'<div id="message" class="error"><p><strong>\' . __(\'xProfile Checkout Manager needs WooCommerce BuddyPress Integration to be installed. <a target="_blank" href="%s">--> Get it now</a>!\', " wc4bp_xprofile" ) . \'</strong></p></div>\', "http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/" );' ) );
		return;
	}
	add_submenu_page( 'wc4bp-options-page', 'BuddyPress Profile' , 'BuddyPress xProfile' , 'manage_options', 'wc4bp-options-page-xprofile', 'wc4bp_screen_xprofile' );
}

/**
 * The Admin Page
 *
 * @author Sven Lehnert
 * @package WC4BP
 * @since 1.3
 */

function wc4bp_screen_xprofile() { ?>

	<div class="wrap">
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<?php
			if ( isset( $_POST['bf_xprofile_conditional_visibility'] ) && is_array( $_POST['bf_xprofile_conditional_visibility'] ) ) {
				foreach ( $_POST['bf_xprofile_conditional_visibility'] as $group_id => $group_options ) {
					// Check that group ID is valid
					if ( ! is_array( $group_options ) || ! ctype_digit( (string) $group_id ) ) {
						continue;
					}

					$group_id = intval( $group_id );

					// Check that group exists
					if ( ! wc4bp_xprofile_group_exists( $group_id ) ) {
						continue;
					}

					if ( array_key_exists( 'enabled', $group_options ) && $group_options['enabled'] == 'on' ) {
						bp_xprofile_update_fieldgroup_meta( $group_id, 'bf_xprofile_conditional_visibility_enabled', '1' );
					} else {
						bp_xprofile_delete_meta( $group_id, 'group', 'bf_xprofile_conditional_visibility_enabled' );
					}

					// Update list of products that allow group to be displayed
					if ( array_key_exists( 'products', $group_options ) ) {
						if ( $group_options['products'] === '' ) {
							bp_xprofile_delete_meta( $group_id, 'group', 'bf_xprofile_conditional_visibility_products' );

						} else {
							$safe_product_ids = array();
							$product_ids      = explode( ',', $group_options['products'] );
							foreach ( $product_ids as $product_id ) {
								$trimmed_product_id = (string) trim( $product_id );
								if ( ctype_digit( $trimmed_product_id ) ) {
									$trimmed_product_empty = wc_get_product( $trimmed_product_id );
									if ( ! empty( $trimmed_product_empty ) ) {
										$safe_product_ids[] = $trimmed_product_id;
									}
								}
							}

							$updated_product_ids  = implode( ',', $safe_product_ids );
							$existing_product_ids = bp_xprofile_get_meta( $group_id, 'group',
								'bf_xprofile_conditional_visibility_products' );

							if ( $existing_product_ids != $updated_product_ids ) {
								if ( bp_xprofile_update_fieldgroup_meta( $group_id,
										'bf_xprofile_conditional_visibility_products', $updated_product_ids ) === false
								) {
									error_log( "Failed to update group $group_id with new product IDs for conditional visibility" );
								}
							}
						}
					}

					// Update list of categories that allow group to be displayed
					if ( array_key_exists( 'categories', $group_options ) ) {
						if ( $group_options['categories'] === '' ) {
							bp_xprofile_delete_meta( $group_id, 'group', 'bf_xprofile_conditional_visibility_categories' );

						} else {
							$safe_category_ids = array();
							$category_ids      = explode( ',', $group_options['categories'] );
							foreach ( $category_ids as $category_id ) {
								$trimmed_category_id = (string) trim( $category_id );
								if ( ctype_digit( $trimmed_category_id ) ) {
									$term = get_term( $category_id );
									if ( ! empty( $term ) && $term->taxonomy == 'product_cat' ) {
										$safe_category_ids[] = $trimmed_category_id;
									}
								}
							}

							$updated_category_ids  = implode( ',', $safe_category_ids );
							$existing_category_ids = bp_xprofile_get_meta( $group_id, 'group',
								'bf_xprofile_conditional_visibility_categories' );

							if ( $existing_category_ids != $updated_category_ids ) {
								if ( bp_xprofile_update_fieldgroup_meta( $group_id,
										'bf_xprofile_conditional_visibility_categories', $updated_category_ids ) === false
								) {
									error_log( "Failed to update group $group_id with new category IDs for conditional visibility" );
								}
							}
						}
					}
				}
			}

			if ( isset( $_POST['bf_xprofile_options'] ) ) {
				update_option( 'bf_xprofile_options', $_POST['bf_xprofile_options'] );
			}

			if ( isset( $_POST['wc4bp_sync_mail'] ) ) {
				update_option( 'wc4bp_sync_mail', $_POST['wc4bp_sync_mail'] );
			} else {
				delete_option( 'wc4bp_sync_mail' );
			}

			$wc4bp_sync_mail = get_option( 'wc4bp_sync_mail' );
			?>

			<form method="post" action="?page=wc4bp-options-page-xprofile">
				<h2>WooCommerce BuddyPress Integration Settings</h2>
				<div id="post-body-content">

					<div id="icon-options-general" class="icon32"><br></div>

					<?php wp_nonce_field( 'update-options' ); ?>
					<?php wc4bp_xprofile_tabs() ?>

				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div id="submitdiv" class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3><span>Save WC xProfile Setting</span></h3>
						<div class="inside">
							<div class="submitbox" id="submitpost">

								<div style="padding: 10px;"><input type="submit" value="Save" class="button"></div>
								<div class="clear"></div>
							</div>

						</div>
					</div>

					<div id="submitdiv" class="postbox ">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3><span>Email Address Synchronisation</span></h3>
						<div class="inside">
							<div class="submitbox" id="submitpost">
								<div style="padding: 10px;">
									<p>Sync BuddyPress signup email address with WooCommerce billing email address</p>
									<input type="checkbox" id="wc4bp_sync_mail"
									       name="wc4bp_sync_mail" <?php checked( 'on', $wc4bp_sync_mail ) ?>></div>
								<div class="clear"></div>
							</div>

						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	</div><?php

}

/**
 * Handles all actions for the admin area for creating, editing and deleting
 * profile groups and fields.
 */
function wc4bp_xprofile_tabs( $message = '', $type = 'error' ) {

	$groups = BP_XProfile_Group::get( array(
		'fetch_fields' => true
	) ); ?>

	<div id="tabs">
		<ul id="field-group-tabs" class="nav tabs" style="display: block;">

			<?php if ( ! empty( $groups ) ) : foreach ( $groups as $group ) : ?>
				<li id="group_<?php echo $group->id; ?>"><a href="#tabs-<?php echo $group->id; ?>"
				                                            class="ui-tab"><?php echo esc_attr( $group->name ); ?><?php if ( ! $group->can_delete ) : ?><?php _e( '(Primary)', 'wc4bp' ); endif; ?></a>
				</li>

			<?php endforeach; endif; ?>

		</ul>

		<?php if ( ! empty( $groups ) ) : foreach ( $groups as $group ) : ?>

			<div id="tabs-<?php echo $group->id; ?>" class="tab-wrapper">

				<?php if ( $group->name == 'Billing Address' || $group->name == 'Shipping Address' ) { ?>
					<h3><?php echo $group->name ?> WooCommerce fields are already in the checkout and get synced with
						BuddyPress.</h3>
				<?php } ?>

				<fieldset id="<?php echo $group->id; ?>" class="field-group">

					<?php if ( $group->description ) : ?>

						<legend><?php echo esc_attr( $group->description ) ?></legend>

					<?php endif;

					if ( ! empty( $group->fields ) ) :
						foreach ( $group->fields as $field ) {

							// Load the field
							$field = new BP_XProfile_Field( $field->id );


							$class = '';
							if ( ! $field->can_delete ) {
								$class = ' core nodrag';
							}

							/* This function handles the WYSIWYG profile field
							* display for the xprofile admin setup screen
							*/
							buddyforms_xprofile_admin_field( $field, $group, $class );

						} // end for

					else : // !$group->fields
						?>

						<p class="nodrag nofields"><?php _e( 'There are no fields in this group.', 'wc4bp' ); ?></p>

					<?php endif; // end $group->fields ?>

					<div class="wc4bp-conditional-visibility-container">
						<h2><span><?php echo esc_html( __( 'Conditional Visibility' ) ); ?></span></h2>
						<?php
						$feature_enabled         = wc4bp_xprofile_conditional_visibility_enabled( $group->id, 'group' );
						$group_visibility_prefix = "bf_xprofile_conditional_visibility[{$group->id}]";
						$products                = wc4bp_xprofile_conditional_visibility_products( $group->id, 'group', array() );
						$product_data            = wc4bp_xprofile_fetch_product_names( $products );
						$categories              = wc4bp_xprofile_conditional_visibility_categories( $group->id, 'group', array() );
						$category_data           = wc4bp_xprofile_fetch_category_names( $categories );
						?>
						<div class="fields">
							<div class="field cv-enabled">
								<label>
									<input name="<?php echo esc_attr( $group_visibility_prefix . "[enabled]" ); ?>"
									       type="checkbox" <?php checked( $feature_enabled ); ?>
									       data-checked="<?php echo $feature_enabled ? 'true' : 'false'; ?>"/>
                                    <span><?php echo
	                                    esc_html( __( 'Make this group hidden on the checkout page, unless at least ' .
	                                                  'one of the following criteria are met:' ) ); ?></span>
								</label>
							</div>
							<div class="field cv-products<?php if ( ! $feature_enabled ) {
								echo ' disabled';
							} ?>">
								<label>
                                    <span><?php echo
	                                    esc_html( __( 'Display this group if the cart contains any of the following ' .
	                                                  'products:' ) ); ?></span>
									<input type="hidden" class="wc-search"
									       name="<?php echo esc_attr( $group_visibility_prefix . "[products]" ); ?>"
									       data-action="woocommerce_json_search_products_and_variations"
									       data-value="<?php echo esc_attr( implode( ',', array_keys( $product_data ) ) ); ?>"
									       data-nonce="<?php echo esc_attr( wc4bp_xprofile_get_nonce( 'search-products' ) ); ?>"
									       data-placeholder="<?php echo esc_attr( __( 'Choose a product...' ) ); ?>"
									       data-selected="<?php echo esc_attr( json_encode( $product_data ) ); ?>"
										<?php if ( ! $feature_enabled ) {
											echo 'readonly';
										} ?>/>
								</label>
							</div>
							<div class="field cv-categories<?php if ( ! $feature_enabled ) {
								echo ' disabled';
							} ?>">
								<label>
                                    <span><?php echo
	                                    esc_html( __( 'Display this group if the cart contains a product from any of ' .
	                                                  'the following categories:' ) ); ?></span>
									<input type="hidden" class="wc-search"
									       name="<?php echo esc_attr( $group_visibility_prefix . "[categories]" ); ?>"
									       data-action="wc4bp_xprofile_search_categories"
									       data-value="<?php echo esc_attr( implode( ',', array_keys( $category_data ) ) ); ?>"
									       data-nonce="<?php echo esc_attr( wc4bp_xprofile_get_nonce( 'search-categories' ) ); ?>"
									       data-placeholder="<?php echo esc_attr( __( 'Choose a category...' ) ); ?>"
									       data-selected="<?php echo esc_attr( json_encode( $category_data ) ); ?>"
										<?php if ( ! $feature_enabled ) {
											echo 'readonly';
										} ?>/>
								</label>
							</div>
						</div>
					</div>

				</fieldset>
			</div>

		<?php endforeach;
		else : ?>

			<div id="message" class="error"><p><?php _e( 'You have no groups.', 'wc4bp' ); ?></p></div>
			<p><a href="users.php?page=bp-profile-setup&amp;mode=add_group"><?php _e( 'Add New Group', 'wc4bp' ); ?></a>
			</p>

		<?php endif; ?>

	</div>
<?php }


/**
 * Handles the WYSIWYG display of each profile field on the edit screen
 */
function buddyforms_xprofile_admin_field( $admin_field, $admin_group, $class = '' ) {
	global $field;

	$bf_xprofile_options = get_option( 'bf_xprofile_options' );
	$shipping            = bp_get_option( 'wc4bp_shipping_address_ids' );
	$billing             = bp_get_option( 'wc4bp_billing_address_ids' );

	$field = $admin_field; ?>

	<fieldset id="field_<?php echo esc_attr( $field->id ); ?>" class="sortable<?php echo ' ' . $field->type;
	if ( ! empty( $class ) ) {
		echo ' ' . $class;
	} ?>">
		<legend>
			<span><b><?php bp_the_profile_field_name(); ?> </b><?php if ( ! $field->can_delete ) : ?><?php _e( '(Primary)', 'wc4bp' ); endif; ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(Required)', 'wc4bp' ) ?><?php endif; ?></span>
		</legend>
		<div class="field-wrapper"><p>

				<input type="hidden" value="<?php echo $admin_group->id; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][group_id]">
				<input type="hidden" value="<?php echo $admin_group->name; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][group_name]">
				<input type="hidden" value="<?php echo $field->id; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_id]">
				<input type="hidden" value="<?php echo $field->name; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_name]">
				<input type="hidden" value="<?php echo $field->type; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_type]">
				<input type="hidden" value="<?php echo $field->is_required; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_is_required]">
				<input type="hidden" value="<?php echo $field->description; ?>"
				       name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][description]">

				<?php if ( ( is_array( $billing ) && array_search( $field->id, $billing ) ) || ( is_array( $shipping ) && array_search( $field->id, $shipping ) ) ) { ?>
			<p>WooCommerce default field - Automatically Synced with BuddyPress</p>
			Remove from Checkout:
			<input <?php isset( $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['hide'] ) ? checked( 'hide', $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['hide'] ) : ''; ?>
				type="checkbox"
				name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][hide]"
				value="hide">
			<?php } else { ?>
				Add to Checkout:
				<input <?php isset( $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['checkout'] ) ? checked( 'checkout', $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['checkout'] ) : ''; ?>
					type="checkbox"
					name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][checkout]"
					value="checkout">
				Add to order emails:
				<input <?php isset( $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['email'] ) ? checked( 'email', $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['email'] ) : ''; ?>
					type="checkbox"
					name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][email]"
					value="email">
				Display field value on the order edit page:
				<input <?php isset( $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['order_edit'] ) ? checked( 'order_edit', $bf_xprofile_options[ esc_attr( $admin_group->id ) ][ esc_attr( $field->id ) ]['order_edit'] ) : ''; ?>
					type="checkbox"
					name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][order_edit]"
					value="order_edit">
			<?php } ?>


			<a target="_blank"
			   href="?page=bp-profile-setup&group_id=<?php echo $admin_group->id; ?>&field_id=<?php echo $field->id; ?>&mode=edit_field">Edit
				this field</a>
			</p>
		</div>
	</fieldset>

	<?php
}

/**
 * Enqueue scripts and styles that support the WooCommerce BuddyPress Integration Settings page
 */
function wc4bp_admin_enqueue_scripts() {

	$wc_assets_path = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';

	wp_enqueue_style( 'select2', $wc_assets_path . 'css/select2.css' );
	wp_enqueue_style( 'admin-xprofile.css', WC4BP_xProfile::plugin_base_url() . 'assets/css/admin-xprofile.css', array(
		'select2',
		'woocommerce_admin_styles'
	) );

	wp_register_script( 'admin-xprofile.js', WC4BP_xProfile::plugin_base_url() . 'assets/js/admin-xprofile.js',
		array( 'select2' ),  // Dependencies
		false,               // Version (default)
		true );              // Include in footer (default is header)

	wp_localize_script( 'admin-xprofile.js', 'wc4bp_admin_xprofile_params', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	) );

	wp_enqueue_script( 'admin-xprofile.js' );
}
