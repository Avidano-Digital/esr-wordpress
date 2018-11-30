=== Give - Form Field Manager ===
Contributors: wordimpress, dlocc, webdevmattcrom, ramiy
Tags: donations, donation, ecommerce, e-commerce, fundraising, fundraiser, paymill, gateway
Requires at least: 4.2
Tested up to: 4.7
Stable tag: 1.1.3
License: GPLv3
License URI: https://opensource.org/licenses/GPL-3.0

== Description ==

Easily add and control Give's form fields using an easy-to-use interface.

== Installation ==

= Minimum Requirements =

* WordPress 4.2 or greater
* PHP version 5.3 or greater
* MySQL version 5.0 or greater
* Some payment gateways require fsockopen support (for IPN access)

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don't need to leave your web browser. To do an automatic install of Give, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type "Give" and click Search Plugins. Once you have found the plugin you can view details about it such as the the point release, rating and description. Most importantly of course, you can install it by simply clicking "Install Now".

= Manual installation =

The manual installation method involves downloading our donation plugin and uploading it to your server via your favorite FTP application. The WordPress codex contains [instructions on how to do this here](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Changelog ==

= 1.1.3 =
* Tweak: Updated deprecated Give core hooks in use for version 1.7
* Tweak: New banner will display if Give is not active or minimum version is not met - https://github.com/WordImpress/Give-Form-Field-Manager/issues/123
* Fix: The new email field had a bug preventing the field data to be viewed and updated in the admin - https://github.com/WordImpress/Give-Form-Field-Manager/issues/121

= 1.1.2 =
* New: Phone number field added. - https://github.com/WordImpress/Give-Form-Field-Manager/issues/57
* New: The time within the date picker field now has formatting options for additional flexibility - https://github.com/WordImpress/Give-Form-Field-Manager/issues/50
* New: Option to toggle the datepicker CSS output to better prevent conflicts with themes that style the datepicker - https://github.com/WordImpress/Give-Form-Field-Manager/issues/109
* New: Plugin activation banner with links to documentation and support.
* Fix: Multiple donation forms on a page containing custom form fields cause duplicate fields to appear incorrectly - https://github.com/WordImpress/Give-Form-Field-Manager/issues/108
* Fix: An admin entering the same value for multiple Meta Key fields prevents some data from being saved during a transaction. https://github.com/WordImpress/Give-Form-Field-Manager/issues/88
* Fix: The repeater field doesn't allow entries to be added in the wp-admin "Transaction Details" screen. Now it does. :) https://github.com/WordImpress/Give-Form-Field-Manager/issues/77
* Fix: The email field type is using the same ID as the Give core email field which can lead to issues. https://github.com/WordImpress/Give-Form-Field-Manager/issues/70
* Fix: Grunt now runs uglify properly to prevent infinite loop when developing. https://github.com/WordImpress/Give-Form-Field-Manager/issues/95
* Fix: The email address field is being pre-filled with the logged in users email address incorrectly. https://github.com/WordImpress/Give-Form-Field-Manager/issues/51
* Fix: The timepicker should default to the current time. https://github.com/WordImpress/Give-Form-Field-Manager/issues/49
* Fix: Custom form field metakeys are not sanitizing special characters and length properly. https://github.com/WordImpress/Give-Form-Field-Manager/issues/65
* Fix: Custom field data is not properly being passes to the Give API. https://github.com/WordImpress/Give-Form-Field-Manager/issues/35
* Fix: Issue with the support link not going to the proper URL. https://github.com/WordImpress/Give-Form-Field-Manager/issues/101
* Tweak: Updated the plugin's text domain to 'give-form-field-manager' to match plugin slug - https://github.com/WordImpress/Give-Form-Field-Manager/issues/116

= 1.1.1 =
* Tweak: Moved the transaction's "Custom Form Fields" metabox above "Payment Notes" so it's more easily accessible to admins - https://github.com/WordImpress/Give-Form-Field-Manager/issues/40
* Fix: Compatibility issues with custom form fields and floating labels functionality https://github.com/WordImpress/Give-Form-Field-Manager/issues/66
* Fix: No form fields, set as empty meta so no blank fields leftover
* Fix: PHP7 produces fatal error with WP_DEBUG and SCRIPT_DEBUG set to true - https://github.com/WordImpress/Give-Form-Field-Manager/issues/67

= 1.1 =
* New: Added a new {all_custom_fields} email to to output all custom field data from a donation form submission
* Fix: When a user sets up a donation form with the "Reveal Upon Click" option and wants the Custom Form Fields to display in those hidden fields they were displaying rather than being hidden. https://github.com/WordImpress/Give-Form-Field-Manager/issues/59

= 1.0 =
* Initial plugin release. Yippee!