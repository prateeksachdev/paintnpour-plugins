=== Inline Image Base64 - inline specific images into the HTML ===
Contributors: giuse
Donate link: buymeacoffee.com/josem
Tags: speed optimisation,layout shift
Requires at least: 4.6
Tested up to: 6.3
Stable tag: 0.0.4
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Improve the rendering performance inlining the little images directly into the HTML as base64 (e.g. the logo).




== Description ==


With Inline Image Base64 you can **inline specific images directly into the HTML** as base64.

You can also use it to **disable the native lazy loading for specific images**.

After successful activation, you will see two checkboxes when you open an attachment in the media library. One for inlining the image and another one to disable the native lazy loading.

Inlining the first image that appears in the viewport can drastically improve the rendering performance.

The benefits will be higher for light images. A typical example is a light logo.

If you do it for too big images the size of the HTML may become too big.

Inlining images is very useful for images that are not more than 20-30 kB. But it depends on the size of the HTML that you already have.

We suggest perform some speed tests with <a href="https://pagespeed.web.dev/">Google PageSpeed Insights</a> to check the benefits.


Upload an image that already has the right dimensions.

To have a minimum Content Layout Shift, better you assign the width and hight to the image with custom CSS.

In any case, we suggest disabling the native lazy loading for all the images that appear on the viewport during the first rendering.

Disabling the lazy loading for those images can only give benefits.


You will find the settings on every single attachment in the media library, no dedicated settings page for this plugin.


== How to inline an image into the HTML ==
1. Install and activate Inline Image base64
2. Go to the media library and open the image that you want to inline into the HTML
3. Check the checkbox "Inline Image"


== How to disable the native lazy loading of a specific image ==
1. Install and activate Inline Image base64
2. Go to the media library and open the image that you want to load without lazy loading
3. Unheck the checkbox "Native Lazy Loading"

== Suggestions ==

* Always disable the lazy loading for the images that appear in the viewport during the page loading
* Inline only the images that appears in the viewport during the page loading, only if they aren't too big. Until 20-30 kB should be ok, but it depends on the size of the HTML.
* Perform some tests with <a href="https://pagespeed.web.dev/">Google PageSpeed Insights</a> before and after inlining an image. So you can evaluate the benefits and drawbacks that could be caused by a too large HTML


== Installation ==

1. Upload the entire `inline-image-b64` folder to the `/wp-content/plugins/` directory or install it using the usual installation button in the Plugins administration page.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. After successful activation you will see a checkbox when you open an attachment in the media library.
4. All done. Good job!


== Help ==

For any kind of issue, don't hesitate to open a thread on the <a href="https://wordpress.org/support/plugin/inline-image-base64/">Support Forum</a>

== Screenshots ==

1. Settings in the media library


== Changelog ==

= 0.0.4 =
* Fix: attachment post meta not removed on plugin deletion

= 0.0.3 =
* Added: CSS class to inlined images
* Added: checkbox to disable the native lazy loading

= 0.0.2 =
* Added: disabled native lazy loading for inlined images

= 0.0.1 =
* First release
