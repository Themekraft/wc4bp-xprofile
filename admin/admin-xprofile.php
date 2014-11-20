<?php

if(has_action('wc4bp_add_submenu_page')) {
    add_action( 'wc4bp_add_submenu_page', 'wc4bp_add_xprofile_menu' );
} else {
    add_action( 'admin_notices', create_function( '', 'printf(\'<div id="message" class="error"><p><strong>\' . __(\'xProfile Checkout Manager needs WooCommerce BuddyPress Integration to be installed. <a target="_blank" href="%s">--> Get it now</a>!\', " wc4bp_xprofile" ) . \'</strong></p></div>\', "http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/" );' ) );
    return;
}

// Add the option page to the WC4BP Integration menu
function wc4bp_add_xprofile_menu() {
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

                <?php if(isset($_POST['bf_xprofile_options']))
                    update_option('bf_xprofile_options',$_POST['bf_xprofile_options']); ?>

                <form method="post" action="?page=wc4bp-options-page-xprofile">
                <h2>WooCommerce BuddyPress Integration Settings</h2>
                <div id="post-body-content">

                <div id="icon-options-general" class="icon32"><br></div>

                    <?php wp_nonce_field( 'update-options' ); ?>
                    <?php wc4bp_xprofile_tabs() ?>

                </div>
                <div id="postbox-container-1" class="postbox-container">
                    <div id="submitdiv" class="postbox ">
                        <div class="handlediv" title="Click to toggle"><br></div><h3><span>Save WC xProfile Setting</span></h3>
                        <div class="inside">
                            <div class="submitbox" id="submitpost">

                               <div style="padding: 10px;"><input type="submit" value="Save" class="button"></div>
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

    $groups = BP_XProfile_Group::get(array(
        'fetch_fields' => true
    )); ?>

    <div id="tabs">
        <ul id="field-group-tabs" class="nav tabs" style="display: block;">

            <?php if ( !empty( $groups ) ) : foreach ( $groups as $group ) : ?>
                    <li id="group_<?php echo $group->id; ?>"><a href="#tabs-<?php echo $group->id; ?>" class="ui-tab"><?php echo esc_attr( $group->name ); ?><?php if ( !$group->can_delete ) : ?> <?php _e( '(Primary)', 'wc4bp'); endif; ?></a></li>

            <?php endforeach; endif; ?>

        </ul>

        <?php if ( !empty( $groups ) ) : foreach ( $groups as $group ) : ?>

            <div id="tabs-<?php echo $group->id; ?>" class="tab-wrapper">

                <?php if($group->name == 'Billing Address' || $group->name == 'Shipping Address') { ?>
                    <h3><?php echo $group->name ?> WooCommerce fields are already in the checkout and get synced with BuddyPress.</h3>
                <?php } ?>

                <fieldset id="<?php echo $group->id; ?>" class="field-group">

                    <?php if ( $group->description ) : ?>

                        <legend><?php echo esc_attr( $group->description ) ?></legend>

                    <?php endif;

                    if ( !empty( $group->fields ) ) :
                        foreach ( $group->fields as $field ) {

                            // Load the field
                            $field = new BP_XProfile_Field( $field->id );


                            $class = '';
                            if ( !$field->can_delete )
                                $class = ' core nodrag';

                            /* This function handles the WYSIWYG profile field
                            * display for the xprofile admin setup screen
                            */
                            buddyforms_xprofile_admin_field( $field, $group, $class );

                        } // end for

                    else : // !$group->fields ?>

                        <p class="nodrag nofields"><?php _e( 'There are no fields in this group.', 'wc4bp' ); ?></p>

                    <?php endif; // end $group->fields ?>

                </fieldset>
            </div>

        <?php endforeach; else : ?>

            <div id="message" class="error"><p><?php _e( 'You have no groups.', 'wc4bp' ); ?></p></div>
            <p><a href="users.php?page=bp-profile-setup&amp;mode=add_group"><?php _e( 'Add New Group', 'wc4bp' ); ?></a></p>

        <?php endif; ?>

    </div>
<?php }


/**
 * Handles the WYSIWYG display of each profile field on the edit screen
 */
function buddyforms_xprofile_admin_field( $admin_field, $admin_group, $class = '' ) {
    global $field;

    $bf_xprofile_options = get_option('bf_xprofile_options');

    $field = $admin_field; ?>

    <fieldset id="field_<?php echo esc_attr( $field->id ); ?>" class="sortable<?php echo ' ' . $field->type; if ( !empty( $class ) ) echo ' ' . $class; ?>">
        <legend><span><b><?php bp_the_profile_field_name(); ?> </b><?php if( !$field->can_delete ) : ?> <?php _e( '(Primary)', 'wc4bp' ); endif; ?> <?php if ( bp_get_the_profile_field_is_required() ) : ?><?php _e( '(Required)', 'wc4bp' ) ?><?php endif; ?></span></legend>
        <div class="field-wrapper"><p>

                <input type="hidden" value="<?php echo $admin_group->id; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][group_id]">
                <input type="hidden" value="<?php echo $admin_group->name; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][group_name]">
                <input type="hidden" value="<?php echo $field->id; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_id]">
                <input type="hidden" value="<?php echo $field->name; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_name]">
                <input type="hidden" value="<?php echo $field->type; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_type]">
                <input type="hidden" value="<?php echo $field->is_required; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][field_is_required]">
                <input type="hidden" value="<?php echo $field->description; ?>" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][description]">

        <?php if($admin_group->name == 'Billing Address' || $admin_group->name == 'Shipping Address') { ?>

            <p>WooCommerce default field - Automatically Synced with BuddyPress</p>
            Remove from Checkout: <input <?php isset($bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['hide']) ? checked('hide',$bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['hide']): ''; ?> type="checkbox" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][hide]" value="hide">
        <?php } else { ?>

            Add to Checkout: <input <?php isset($bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['checkout']) ? checked('checkout',$bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['checkout']): ''; ?> type="checkbox" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][checkout]" value="checkout">
            Add to order emails: <input <?php isset($bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['email']) ? checked('email',$bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['email']): ''; ?> type="checkbox" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][email]" value="email">
            Display field value on the order edit page: <input <?php isset($bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['order_edit']) ? checked('order_edit',$bf_xprofile_options[esc_attr( $admin_group->id )][esc_attr( $field->id )]['order_edit']): ''; ?> type="checkbox" name="bf_xprofile_options[<?php echo esc_attr( $admin_group->id ); ?>][<?php echo esc_attr( $field->id ); ?>][order_edit]" value="order_edit">

        <?php } ?>

            <a target="_blank" href="?page=bp-profile-setup&group_id=<?php echo $admin_group->id; ?>&field_id=<?php echo $field->id; ?>&mode=edit_field">Edit this field</a>
            </p>
        </div>
    </fieldset>

<?php
}
?>