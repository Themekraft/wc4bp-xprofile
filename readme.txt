=== BuddyPress xProfile Checkout Manager for WooCommerce ===
Contributors: svenl77, tristanpenman, garrett-eclipse, themekraft, gfirem
Tags: BuddyPress, WooCommerce, user, members, profiles, checkout, xProfile, e-commerce
Requires at least: WordPress 3.9
Tested up to: 6.1.1
Stable tag: 1.3.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

BuddyPress xProfile Checkout Manager for WooCommerce extension where you can integrate BuddyPress xProfile into WooCommerce Checkout.

== Description ==

This is theBuddyPress xProfile Checkout Manager for WooCoommerce extension where you can integrate BuddyPress xProfile into WooCommerce Checkout. Integrate your BuddyPress xProfiles fields into your WooCommerce Checkout. You need the WooBuddy -> WooCommerce BuddyPress Integration plugin installed for the extension to work. <a href="https://wordpress.org/plugins/wc4bp/" target="_blank">Get WooBuddy -> WooCommerce BuddyPress Integration now!</a>

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

See BuddyPress xProfile Custom Fields Type:[BuddyPress xProfile Custom Fields Type](https://wordpress.org/plugins/buddypress-xprofile-custom-fields-type/)

<h3>Conditional Visibility</h3>
Make profile groups visible on the checkout page, depend on certain products (or categories) being present in a user's cart.
<ul>
<li>Display this group if the cart contains any of the following products</li>
<li>Display this group if the cart contains a product from any of the following categories:</li>
</ul>

### Addons

> * [Shop solution for your BuddyPress community. Integrates a WooCommerce installation with a BuddyPress social network.](https://wordpress.org/plugins/wc4bp)
> * [WooBuddy -> Subscriptions, integrate BuddyPress with WooCommerce Subscription. Ideal for subscription and membership sites such as premium support.](https://themekraft.com/products/buddypress-woocommerce-subscriptions-integration/)
> * [WooBuddy -> Groups, integrate BuddyPress Groups with WooCommerce and WooCommerce Subscription. Ideal for subscription and membership sites such as premium support.](https://wordpress.org/plugins/wc4bp-groups/)

== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

See the documentation [Documentation](http://docs.themekraft.com/collection/208-wc4bp-integration)

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your WooBuddy Settings Panel in your WP Dashboard!

<h4>Got ideas or just missing something?</h4>
If you still miss something, let us know!


== Installation ==

You can download and install WooBuddy -> BuddyPress xProfile Checkout Manager using the build in WordPress plugin installer. If you download WooBuddy -> BuddyPress xProfile Checkout Manager manually,
make sure it is uploaded to "/wp-content/plugins/wc4bp-xprofile/".

Activate WooBuddy -> BuddyPress xProfile Checkout Manager in the "Plugins" admin panel using the "Activate" link.

== Frequently Asked Questions ==

You need the <a href="https://themekraft.com/products/woocommerce-buddypress-integration/" target="_blank">WooCommerce BuddyPress Integration</a> plugin installed for the plugin to work.


When is it the right choice for you?

If you run BuddyPress and WooCommerce together and want to adjust the WooCommerce Checkout

== Screenshots ==

1. **Manage BuddyPress xProfile Fields** - Add BuddyPress xProfile user fields to the WooCommerce checkout

2. **Manage WooCommerce Customer Fields** - Remove WooCommerce fields from the checkout

3. **Conditional Visibility** - Allow the Visibility of Xprofile Field Groups on the Checkout Page to Depend on Certain Products (or Categories) Being Present in a User's Cart.

4. **Checkout Example** - This is how it looks when you add BuddyPress User Fields to the checkout.

== Changelog ==
= 1.3.8 - 09 Dec 2022 =
* Updated plugin name.

= 1.3.7 - 09 Dec 2022 =
* Fixed issue with field group names.
* Tested up to WordPress 6.1.1

= 1.3.6 - 15 Aug 2022 =
* Fixed vulnerability issue.
* Tested up to WordPress 6.0.1

= 1.3.5 - 17 May 2022 =
* Updated readme.txt

= 1.3.4 - 07 Mar 2022 =
* Fixed issue with fields not displaying on order edit page.
* Tested up to WordPress 5.9

= 1.3.3 - 14 Nov 2021 =
* Fixed issue related with missing CSS.
* Fixed JS conflict when loading custom fields on checkout.
* Tested up with WordPress 5.8

= 1.3.2 - 10 May 2021 =
* Fixed issue xProfiles on Checkout that was requiring validation on hidden fields.
* Adding proper integration with freemius.

= 1.3.1 - 10 Mar 2021 =
* Change name to WooBuddy -> BuddyPress xProfile Checkout Manager.
* Tested up with WordPress 5.7
* Tested up with WC 5.1.0

= 1.3.0 May 21.2018 =
* Changing the TMPGA library to avoid crash with other implementations of the same library.

= 1.2.7 Dec 18.2017 =
* Changing the requirement text for generic one.

= 1.2.6 Dec 11.2017 =
* Fixing the assets generated by the sh script.

= 1.2.5 Nov 23.2017 =
* Refactoring the code.
* Remove duplicate tabs when upgrade to paid version of the core plugin.
* Remove the hiding duplicate tabs verification.
* Fix the required dependency messages.
* Fixing the drop-downs using select2

= 1.2.4 Jun 15.2017 =
* Improving the requirement for wc4bp

= 1.2.3 =
* Refactoring the code. Including the premium version of wc4bp in the requirement check
* Multiple Fixes for WooCommerce 3.0

= 1.2.2 =
* Include TGM to check requirements.
* Updating the call to a function from wc4bp to latest version
* Fixing issue with tgma

= 1.2.1 =
* Move has_action in the menue hook. for some reason it was not fired in the latest version.

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
