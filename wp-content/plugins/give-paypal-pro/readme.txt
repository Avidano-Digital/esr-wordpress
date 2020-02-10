=== Give - PayPal Pro ===
Contributors: givewp
Tags: donations, donation, ecommerce, e-commerce, fundraising, fundraiser, paypal, paypal pro, gateway
Requires at least: 4.8
Tested up to: 5.2
Stable tag: 1.2.2
Requires Give: 2.4.0
License: GPLv3
License URI: https://opensource.org/licenses/GPL-3.0

PayPal Pro Gateway Add-on for Give.

== Description ==

This plugin requires the Give plugin activated to function properly. When activated, it adds a payment gateway for PayPal Website Payments Pro.

== Installation ==

= Minimum Requirements =

* WordPress 4.8 or greater
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

= 1.2.2: June 3rd, 2019 =
* Tweak: Adjusted the plugin's settings screens code logic to work with GiveWP Core 2.5.0+ which deprecates the old methods used to register settings in this add-on.

= 1.2.1: November 19th, 2018 =
* New: Added "give_paypal_rest_payer_info_args" for developers to customize gateway info as needed.
* Tweak: Updated the PayPal SDK to the latest version and tested.

= 1.2.0: September 6th, 2018 =
* New: There is now an option to prefix PayPal invoice numbers to differentiate which payments were created by Give compared to other sources.
* New: Implemented the ability to process refunds within the donation payment details screen for all of PayPal Pro's APIs.
* New: Payments processed through Give + PayPal Pro can now have a customizable invoice prefix so that you can more easily identify which payments were received through the plugin.
* Fix: Updated the PayPal API library to resolve issue with the REST API not working.

= 1.1.6: July 5th, 2018 =
* Fix: Ensure compatibility with PayPal Pro (Payflow) Fraud Protection controls. Donations flagged by PayPal's fraud filter will be marked pending and a note will be added to the payment with a link to the payment under review.

= 1.1.5: May 3rd, 2018 =
* New: Compatibility with Currency Switcher 1.1 and Give Core 2.1+ - Please update to the latest of all add-ons for maximum compatibility.
* Tweak: Minimum WP version has been bumped to 4.5+
* Fix: Added checks to ensure that Give is active prior to using gateway.

= 1.1.4: September 22nd, 2017 =
* New: PayPal Payments Pro now has additional comments that appear within the transaction details screen on the PayPal Manager dashboard to provide you better reporting and understanding that the transaction came from GiveWP, which donation form, and the URL the form was on. As well, it supports the Fee Recovery add-on and Tributes.
* New: PayPal Payments Pro transaction IDs are now linked to the payments within the Give payment details screen. This gives you an easier way to review transaction details within PayPal by clicking on them from Give's dashboard.
* Fix: Resolved issue with post transaction inquiry on payment through PayPal Payments Pro.

= 1.1.3 =
* New: The plugin now checks to see if Give is active and up to the minimum version required to run the plugin.

= 1.1.2 =
* Fix: PHP warning because private `load_textdomain()` method should have been public.

= 1.1.1 =
* Fix: Issue outputting CC fields when multiple donations forms are on a page and the default gateways is PayPal Pro the donation form.

= 1.1 =
* New: Support for PayPal Payments Pro
* New: Support for PayPal's Website Payment Pro REST API integration. Now you can accept payments using PayPals' modern API for faster transaction times.
* New: Now you have the ability to disable the "Billing Details" fieldset which contains the address fields. This information is not required to process transactions and disabling the fields could help increase conversion rates.
* New: Additional inline documentation for easier understanding of each gateway offering and links to in-depth docs.
* Update: 'BUTTONSOURCE' PayPal arg

= 1.0.1 =
* Update: Updated 'buttonsource' param for PP API
* Fix: PHP notice about missing variable upon successful transaction

= 1.0 =
* Initial plugin release. Yippee!
