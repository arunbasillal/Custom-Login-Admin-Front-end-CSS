=== Custom Login Admin Front-end CSS ===
Contributors: arunbasillal
Donate link: http://millionclues.com/donate/
Tags: css, admin css, login css, frontend css, custom login css, custom admin css, admin, admin interface, multisite
Requires at least: 3.0
Tested up to: 5.7
Requires PHP: 5.5
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Loads custom CSS on WordPress Login Pages, Admin and Front-end via admin interface. Works on Multisites as well.

== Description ==

Loads custom CSS on WordPress Login Pages, Admin and Front-end via the admin interface. Can be used with WordPress single install and WordPress multisites.

Custom LAF CSS is very useful on multisite networks. Admins can customize the look and feel of the network and add CSS for the entire network. Adding CSS to the front-end via this plugin is handy when common features need styling and you are not sure which theme the user will be activating. 

**Main features:**

*   Loads custom CSS on Login, Admin and Front-end pages regardless of the active theme.
*   CSS for Login, Admin and Front-end is separately saved and used. 
*   CSS is beautified and neatly presented in the admin. 
*	CSS minification. 
*   Multisite compatible. 
*   Translation ready.
*	Compatible with [Admin CSS MU](https://wordpress.org/plugins/admin-css-mu/) plugin with inbuilt feature to import CSS.

You can add your custom CSS in **WordPress Admin > Appearance > Custom LAF CSS** of your WordPress install or the base site on a WordPress multisite network. 

**Upgrading From Admin CSS MU**

Follow these steps if you are upgrading from the [Admin CSS MU](https://wordpress.org/plugins/admin-css-mu/) plugin. 

1. Install Custom LAF CSS plugin. Do not delete the Admin CSS MU plugin yet. 
2. Go to the plugin page and in the 'Admin CSS' section, check the box that says 'Import and append CSS from Admin CSS MU'.
3. Click 'Save CSS'. Your CSS should be imported now. 
4. Deactivate and delete the Admin CSS MU plugin. 

== Installation ==

For WordPress single install: 

1. Install the plugin through the WordPress admin interface, or upload the folder /custom-login-admin-frontend-css/ to /wp-content/plugins/ using ftp.
2. Activate the plugin via WordPress admin interface.
3. Go to WordPress Admin > Appearance > Custom LAF CSS and add the custom CSS you want. 

For Multisite: 

1. Install the plugin through the WordPress admin interface, or upload the folder /custom-login-admin-frontend-css/ to /wp-content/plugins/ using ftp.
2. Network activate the plugin via WordPress admin interface.
3. In the base website go to WordPress Admin > Appearance > Custom LAF CSS and add the custom CSS you want. 

== Frequently Asked Questions ==

= Some CSS Samples =

To change the size of the h1 tags in WordPress Admin add this to Admin CSS:

`h1 {
	font-size: 40px !important;
}`

To change the background color of the Login Page, add this to Login CSS: 

`.login {
  background: #ECCFFF !important;
}`

= I need more features. Can I hire you? =

Yes. Please [get in touch via my contact form](http://millionclues.com/contact/) with a brief description of your requirement and budget for the project. I will be in touch shortly.

= I found this plugin very useful, how can I show my appreciation? =

I am glad to hear that! You can either [make a donation](http://millionclues.com/donate/) or leave a [rating](https://wordpress.org/support/plugin/custom-login-admin-front-end-css-with-multisite-support/reviews/?rate=5#new-post) to support the development of the plugin. 

== Screenshots ==

1. Admin Interface in Appearance > Custom LAF CSS

== Changelog ==

= 1.3.1 =
* Date: 21.September.2017
* Tested on WordPress 4.8.2. Result = Pass
* Minor corrections in the settings page text. 

= 1.3 =
* Date: 29.August.2017
* Tested upto WordPress 4.8.1. Result = Pass
* Updated CSSTidy classes to meet PHP 7.x standards. [Thanks](https://stackoverflow.com/a/37100413/8255629)
* New: Added options to enable or disable Login, Admin and Front-end CSS individually.
* New: Added option to minify CSS. CSS is only minified during use and the CSS editor will show the un-minified and more readable version for easy editing. 
* New: Added option to import Admin CSS from [Admin CSS MU](https://wordpress.org/plugins/admin-css-mu/). This will help with easy migration from Admin CSS MU to this plugin. 
* Fixed: Conflict with [Admin CSS MU](https://wordpress.org/plugins/admin-css-mu/) plugin.
* Code improvements. 

= 1.2 =
* Minor bug fixes.
* Tested upto WordPress 4.7.

= 1.01 =
* Added complete multisite compatibility. 

= 1.0 =
* First release of the plugin.

== Upgrade Notice ==

= 1.3.1 =
* Date: 21.September.2017
* Tested on WordPress 4.8.2. Result = Pass
* Minor corrections in the settings page text. 

= 1.3 =
* Date: 29.August.2017
* Tested upto WordPress 4.8.1. Result = Pass
* Updated CSSTidy classes to meet PHP 7.x standards. [Thanks](https://stackoverflow.com/a/37100413/8255629)
* New: Added options to enable or disable Login, Admin and Front-end CSS individually.
* New: Added option to minify CSS. CSS is only minified during use and the CSS editor will show the un-minified and more readable version for easy editing. 
* New: Added option to import Admin CSS from [Admin CSS MU](https://wordpress.org/plugins/admin-css-mu/). This will help with easy migration from Admin CSS MU to this plugin. 
* Fixed: Conflict with [Admin CSS MU](https://wordpress.org/plugins/admin-css-mu/) plugin.
* Code improvements. 

= 1.2 =
Fixed a minor bug and tested with WordPress 4.7.

= 1.01 =
Added complete multisite compatibility.

= 1.0 =
First release of the plugin.