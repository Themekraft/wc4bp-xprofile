=== WC4BP -> Checkout Manager ===
Contributors: svenl77, tristanpenman, garrett-eclipse, themekraft
Tags: BuddyPress, WooCommerce, user, members, profiles, checkout, xProfile, e-commerce
Requires at least: WordPress 3.9
Tested up to: 4.6.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WooCommerce BuddyPress Integration xProfile Checkout Manager

== Description ==

This is the WooCommerce BuddyPress Integration xProfile Checkout extension. Integrate your BuddyPress xProfiles fields into your WooCommerce Checkout. You need the WC4BP plugin installed for the extension to work. <a href="http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/" target="_blank">Get WC4BP now!</a>

What the plugin does:
Add your BuddyPress Member Profile Fields into the WooCommerce Checkout.
Manage your WooCommerce Checkout field and remove unwanted fields like "phone number" from the checkout form.

BuddyPress xProfile Fields Checkout Integration Options:

 - Add to Checkout
 - Add to order emails
 - Display field value on the order edit page

With this plugin you need no other WooCommerce Checkout manager. Use the BuddyPress User Field with many different field types to create individual checkout forms.

BuddyPress Default Field Types:

<h3><b>Multi Fields</h3>
<ul>
    <li>Checkboxes</li>
    <li>Drop Down Select Box</li>
    <li>Multi Select Box</li>
    <li>Radio Buttons</li>
</ul>

<h3>Single Fields</h3>
<ul>
    <li>Date Selector</li>
    <li>Multi-line Text Area</li>
    <li>Number</li>
    <li>Text Box</li>
    <li>URL</li>
</ul>

There are already great plugins to add more field types to BuddyPress

See BuddyPress xProfile Custom Fields Type: https://wordpress.org/plugins/buddypress-xprofile-custom-fields-type/

<h3>Conditional Visibility</h3>
Make profile groups visible on the checkout page, depend on certain products (or categories) being present in a user's cart.
<ul>
<li>Display this group if the cart contains any of the following products</li>
<li>Display this group if the cart contains a product from any of the following categories:</li>
</ul>

== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

See the documentation http://docs.themekraft.com/collection/208-wc4bp-integration

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your WC4BP Settings Panel in your WP Dashboard!

<h4>Got ideas or just missing something?</h4>
If you still miss something, let us know!


== Installation ==

You can download and install WC4BP xProfile using the build in WordPress plugin installer. If you download WC4BP xProfile manually,
make sure it is uploaded to "/wp-content/plugins/wc4bp-xprofile/".

Activate WC4BP xProfile in the "Plugins" admin panel using the "Activate" link.

== Frequently Asked Questions ==

You need the <a href="http://themekraft.com/store/woocommerce-buddypress-integration-wordpress-plugin/" target="_blank">WooCommerce BuddyPress Integration</a> plugin installed for the plugin to work.


When is it the right choice for you?

If you run BuddyPress and WooCommerce together and want to adjust the WooCommerce Checkout

== Screenshots ==

1. **Manage BuddyPress xProfile Fields** - Add BuddyPress xProfile user fields to the WooCommerce checkout

2. **Manage WooCommerce Customer Fields** - Remove WooCommerce fields from the checkout

3. **Conditional Visibility** - Allow the Visibility of Xprofile Field Groups on the Checkout Page to Depend on Certain Products (or Categories) Being Present in a User's Cart.

4. **Checkout Example** - This is how it looks when you add BuddyPress User Fields to the checkout.

== Changelog ==

= 1.2.1 =
Move has_action in the menue hook. for some reason it was not fired in the latest version.


= 1.2 =
* Fix CSS bugs in conditional visibility UI and fix warning shown when WP_DEBUG is enabled
* Fix warning that is shown when wc4bp billing or shipping data is not set
* Remove extra closing brace from stylesheet and ensure dependent stylesheets are loaded
* Implement XProfile group conditional visibility feature in admin interface
* Allow visibility of Xprofile field groups to depend on products or categories in cart
* Ensure that group visibility hook handles all three positive cases correctly
* Fix usage of non-existent ID fields in wc4bp_get_categories_for_products function
* Add default hook to determine group visibility based on products (or categories) present in cart
* Allow Xprofile field groups to be skipped based on the output of a filter

= 1.1.2 =
Huge thanks to tristanpenman for the his contributions:
* Allow customisation of field group headings shown on WooCommerce checkout pages
* Filter heading text produced for each field group on the checkout page
* Allow for translation of default 'INFORMATION' text appended to field…

= 1.1.1 =
Add some checks to avoid notice with undefined index.
clean up the code
Change name to WC4BP -> BuddyPress xProfile Checkout Manager

= 1.1 =
fixed the empty array issues props to Kishore
Improved Integration with WooCommerce props to Garrett
fixed all bugs reported by users.

= 1.0.3 =
add an option to sync the signup mail with WooCommerce billing
move function from the base plugin to the extension
Add a check to recognise deleted options

= 1.0.2 =
Add a new feature to add WooCommerce Checkout Fields to the BuddyPress Register Page
changed the xProfile option logic in the admin
changed the sync logic
Add the correct error message for the required fields
spelling correction

= 1.0.1 =
hook into wrong hook name wc4bp_custom_checkout_field_order_meta_keys. changed now to the correct wc4bp_checkout_field_order_meta_keys

= 1.0 =
final 1.0 version
