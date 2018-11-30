=== Give PDF Receipts ===
Plugin URI: https://givewp.com
Contributors: wordimpress
Requires at least: 4.2
Tested up to: 4.7
Stable Tag: 2.0.4

Dynamically generate PDF Receipts for each donation made. Also features receipt templates and email templates to match the design of the receipts.

== Description ==

Take your digital store to the next level of professionalism by providing your customers with PDF Receipts.  The add-on comes with 12 beautifully crafted receipt and email templates and they are easily customisable.  To allow consistency between your receipts and donation receipts, several email templates have also been provided.

Features of the plugin include:

* Dynamically generate PDF Receipts from each donation
* Integrates with the Payment History [donation_history] shortcode to give users a link to download the receipt
* A template tag can easily show a link to a downloadable receipt in the donation receipt
* Includes 12 receipt templates and 12 email templates

More information at [givewp.com](http://givewp.com/).

== Installation ==

1. Activate the plugin
2. Go to Downloads > Settings > PDF Receipts and configure the options
3. Customers can now download receipts for any donation on the Donation History page

== Changelog ==

= 2.0.4 =
* New: {today} tag which will output the date the receipt was generated - https://github.com/WordImpress/Give-PDF-Receipts/issues/62
* Tweak: Updated DOMPDF library to the latest version and updated functions for compatiblity - https://github.com/WordImpress/Give-PDF-Receipts/issues/70
* Tweak: Removed usage of deprecated hooks as of Give core version 1.7
* Tweak: Minimum version of Give updated to 1.7
* Fix: Allow cancelled transactions to still have a receipt generated - https://github.com/WordImpress/Give-PDF-Receipts/pull/58
* Fix: The ability to preview PDFs within the admin builder breaks when WooCommerce is active - https://github.com/WordImpress/Give-PDF-Receipts/issues/55

= 2.0.3 =
* New: Plugin activation check PHP version minimum PHP version requirement - https://github.com/WordImpress/Give-PDF-Receipts/issues/45
* New: Support for Mandarin, Japanese, and many other languages now supported via the Droid Sans Full fallback font for "Set PDF Templates" - https://github.com/WordImpress/Give-PDF-Receipts/issues/47

= 2.0.2 =
* Fix: Updated license version number to prevent endless update issue
* Fix: Cache folder returned to TCPDF to fix issues with some servers not allowing system to create it

= 2.0.1 =
* Fix: Compatibility issue with Autoptimize plugin - https://github.com/WordImpress/Give-PDF-Receipts/issues/35
* Fix: Compatibility issue with Hyper Cache plugin - https://github.com/WordImpress/Give-PDF-Receipts/issues/36
* Fix: PDF Receipt Previews Viewable to Non-Admins - https://github.com/WordImpress/Give-PDF-Receipts/issues/37

= 2.0 =
* New PDF Template builder functionality

= 1.0 =
* Plugin Release
