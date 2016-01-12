<?php

/**
 * Add the field to the checkout
 */
add_action( 'woocommerce_after_order_notes', 'wc4bp_custom_checkout_field' );

function wc4bp_custom_checkout_field( $checkout ) {
    global $field;

    $bf_xprofile_options    = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return;

    if(!is_array($bf_xprofile_options))
      return;

    $shipping               = bp_get_option( 'wc4bp_shipping_address_ids' );
    $billing                = bp_get_option( 'wc4bp_billing_address_ids'  );

    foreach( $bf_xprofile_options as $group_id => $fields){

        $group_fields_included = 0;
        $display_group_name = true;

        foreach($fields as $field_id => $field_attr){

            if( ( ! empty( $billing ) && array_search( $field_id, $billing )) || ( ! empty( $shipping ) && array_search( $field_id, $shipping) ) )
                continue;

            if( isset($field_attr['checkout']) ){
                $field = new BP_XProfile_Field( $field_id );

                if(!empty($field->id)){
                    if( $group_fields_included == 0 ) {
                        echo '<div class="wc4bp_custom_checkout_fields_group" id="wc4bp_checkout_field_group_'.$group_id.'">';
                    }
                    if( $display_group_name ){
                        echo '<h4>' . $field_attr['group_name'] . ' INFORMATION</h4>';
                        $display_group_name = false;
                    }
                    $row_class = 'form-row';
                    if ($field->is_required) {
                        $row_class .= ' validate-required';
                    }
                    if ($field->type_obj instanceof Bxcft_Field_Type_Email) {
                        $row_class .= ' validate-email';
                    }
                    if ($field->type_obj instanceof Bxcft_Field_Type_Web) {
                        $row_class .= ' validate-url';
                    }
                    echo '<p class="'.$row_class.'">';
                    $field->type_obj->edit_field_html();
                    echo '</p>';
                    $group_fields_included++;
                }

            }

        }
        if( $group_fields_included > 0 ) {
            echo '</div>';
        }
    }

}

/**
 * Update the field for the checkout to include Woocommerce classes and pattern
 */
add_filter('bp_xprofile_field_edit_html_elements', 'wc4bp_woo_class_for_xprofile_checkout_fields');

function wc4bp_woo_class_for_xprofile_checkout_fields($elements) {
    if (is_checkout() && array_key_exists('type', $elements)) {
        switch($elements['type']) {
            case 'select':
            case 'multiselect':
            case 'multiple':
                $class = 'select';
                break;
            case 'checkbox':
                $class = 'input-checkbox';
                break;
            case 'radio':
                $class = 'input-radio';
                break;
            case 'day':
            case 'month':
            case 'year':
            case 'date':
            case 'color':
            case 'file':
            case 'number':
            case 'text':
            case 'textbox':
            case 'textarea':
            case 'tel':
            case 'phone':
            case 'email':
            case 'mail':
            case 'url':
            case 'web':
            default:
                $class = 'input-text';
        }
        if (array_key_exists('class', $elements) && ! empty($elements['class'])) {
            $elements['class'] .= ' ' . $class;
        } else {
            $elements['class'] = $class;
        }
    }
    return $elements;
}

/**
 * Add Javascript to replace Buddypress (required) with Woocommerce required asterisk (*)
 */
add_action('woocommerce_after_checkout_form', 'wc4bp_woo_replace_required_for_xprofile_checkout_fields');

function wc4bp_woo_replace_required_for_xprofile_checkout_fields() {
    echo '<script>jQuery(document).ready(function($){$(".wc4bp_custom_checkout_fields_group label").each(function(i){$(this).html($(this).html().replace("(required)","<abbr class=\"required\" title=\"required\">*</abbr>"));});});</script>';
}

/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'wc4bp_custom_checkout_field_process');

function wc4bp_custom_checkout_field_process() {

    $bf_xprofile_options    = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return;

    if(!is_array($bf_xprofile_options))
      return;

    $shipping = bp_get_option( 'wc4bp_shipping_address_ids' );
    $billing  = bp_get_option( 'wc4bp_billing_address_ids'  );

    foreach( $bf_xprofile_options as $group_id => $fields){

        foreach($fields as $field_id => $field){

            if( array_search( $field['field_id'], $billing ) || array_search( $field['field_id'], $shipping) )
                continue;

            if (isset($field['checkout'])) {

                $field_slug = sanitize_title('field_' . $field_id);

                if ($field['field_is_required'] && !$_POST[$field_slug])
                    wc_add_notice('<b>' . $field['field_name'] . ' </b>' . __('is a required field.'), 'error');

            }

        }

    }

}

/**
 * Update the user meta with field value
 **/
add_action('woocommerce_checkout_update_user_meta', 'wc4bp_custom_checkout_field_update_user_meta');

function wc4bp_custom_checkout_field_update_user_meta( $user_id ) {

    $bf_xprofile_options = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return;

    if(!is_array($bf_xprofile_options))
      return;

    foreach( $bf_xprofile_options as $group_id => $fields){

        foreach($fields as $field_id => $field){

            if( isset($field['checkout']) ){

                $field_slug = sanitize_title('field_'.$field_id);

                if ($user_id && ! empty( $_POST[$field_slug] ))
                    update_user_meta( $user_id, $field_slug, esc_attr($_POST[$field_slug]) );
                    xprofile_set_field_data($field_id, $user_id, esc_attr($_POST[$field_slug]));
            }

        }

    }

}

/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'wc4bp_custom_checkout_field_update_order_meta' );

function wc4bp_custom_checkout_field_update_order_meta( $order_id ) {

    $bf_xprofile_options = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return;

    if(!is_array($bf_xprofile_options))
      return;

    foreach( $bf_xprofile_options as $group_id => $fields){

        foreach($fields as $field_id => $field){

            if( isset($field['checkout']) ){

                $field_slug = sanitize_title('field_'.$field_id);

                if ( ! empty( $_POST[$field_slug] ) ) {
                    update_post_meta( $order_id, $field_slug, sanitize_text_field( $_POST[$field_slug] ) );
                }

            }

        }

    }
}

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'wc4bp_custom_checkout_field_display_admin_order_meta', 10, 1 );

function wc4bp_custom_checkout_field_display_admin_order_meta($order){

    $bf_xprofile_options = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return;

    if(!is_array($bf_xprofile_options))
      return;

    foreach( $bf_xprofile_options as $group_id => $fields){

        foreach($fields as $field_id => $field){

            if( isset($field['checkout']) && isset($field['order_edit'] ) ){

                $field_slug = sanitize_title('field_'.$field_id);
                echo '<p><strong>'.$field['field_name'].':</strong> ' . get_post_meta( $order->id, $field_slug, true ) . '</p>';

            }

        }

    }

}

/**
 * Add the field to order emails
 **/
add_filter('woocommerce_email_order_meta_keys', 'wc4bp_checkout_field_order_meta_keys');

function wc4bp_checkout_field_order_meta_keys( $keys ) {
    $bf_xprofile_options = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return $keys;

    if(!is_array($bf_xprofile_options))
      return $keys;

    foreach( $bf_xprofile_options as $group_id => $fields){

        foreach($fields as $field_id => $field){

            if( isset($field['checkout']) && isset($field['email'] ) ){

                $field_slug = sanitize_title('field_'.$field_id);
                $keys[$field['field_name']] = $field_slug;

            }

        }

    }

    return $keys;
}

/**
 * WooCommerce: Remove fields on checkout page.
 **/
add_filter( 'woocommerce_checkout_fields' , 'wc4bp_custom_override_checkout_fields' );

function wc4bp_custom_override_checkout_fields( $fields ) {

    $bf_xprofile_options = get_option('bf_xprofile_options');

    if(!isset($bf_xprofile_options))
      return $fields;

    if(!is_array($bf_xprofile_options))
      return $fields;

    $shipping = bp_get_option( 'wc4bp_shipping_address_ids' );
    $billing  = bp_get_option( 'wc4bp_billing_address_ids'  );

    foreach( $bf_xprofile_options as $group_id => $bf_fields){

        foreach($bf_fields as $bf_field_id => $bf_field){

            if( isset($bf_field['hide']) ){

                if( array_search( $bf_field_id, $billing ) )
                    $group_name = 'billing';

                if( array_search( $bf_field_id, $shipping) )
                    $group_name = 'shipping';

                $field_name = str_replace(" ", "_", $bf_field['field_name']);
                $field_name = sanitize_title($group_name.'_'.$field_name);

                unset($fields[$group_name][$field_name]);
            }

        }

    }

    return $fields;
}

// update the WooCommerce fields before xprofile_sync_wp_profile is called
add_action( 'xprofile_updated_profile', 'wc4bp_signup_wp_profile_sync'   , 30, 1 );
add_action( 'bp_core_signup_user', 'wc4bp_signup_wp_profile_sync'        , 30, 1 );
add_action( 'bp_core_activated_user', 'wc4bp_signup_wp_profile_sync'     , 30, 1 );

function wc4bp_signup_wp_profile_sync( $user_id ) {

    $wc4bp_sync_mail = get_option('wc4bp_sync_mail');

    if(empty($user_id))
        return;

    // get the profile fields
    $shipping = bp_get_option( 'wc4bp_shipping_address_ids' );
    $billing  = bp_get_option( 'wc4bp_billing_address_ids'  );

    if ( ! empty( $shipping ) ) {
        foreach($shipping as $key => $field_id){
            wc4bp_sync_addresses_from_profile($user_id, $field_id, $_POST['field_' . $field_id ] );
        }
    }

    if ( ! empty( $billing ) ) {
        foreach($billing as $key => $field_id){
                wc4bp_sync_addresses_from_profile($user_id, $field_id, $_POST['field_' . $field_id ] );
        }
    }

    if( ! empty( $wc4bp_sync_mail ) && ! empty( $billing ) ) {
        wc4bp_sync_addresses_from_profile($user_id, $billing['email'], $_POST[ 'signup_email' ] );
    }

}
?>
