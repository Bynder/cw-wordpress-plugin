# GatherContent Plugin -- Version 3.0.0.4 #

This plugin allows you to transfer content from your GatherContent projects into your WordPress site and vice-versa.

## Description ##

Installing our WordPress plugin on your site allows you to quickly perform updates of your content from your GatherContent account to WordPress as well as push your WordPress content updates back to GatherContent. Content can be imported as new pages/posts or custom post types, and you can also import your WordPress content back to new GatherContent items.

The plugin allows you to map each field in your GatherContent Templates with WordPress fields. This is accomplished by creating a Template Mapping, which allows you to map each field in GatherContent to various fields in WordPress; title, body content, custom fields, tags, categories, Yoast fields, advanced custom fields, featured images … and many more.

The module currently supports the following features:

* Import content from GatherContent
* Export content to GatherContent
* Update content in Wordpress from GatherContent
* Update content from Wordpress to GatherContent

For additional developer documentation, please [review the wiki](https://github.com/gathercontent/wordpress-plugin/wiki).

### What is GatherContent?

GatherContent is an online platform for pulling together, editing, and reviewing website content with your clients and colleagues. It's a reliable alternative to emailing around Word documents and pasting content into your CMS. This plugin replaces that process of copying and pasting content and allows you to bulk import structured content, and then continue to update it in WordPress with a few clicks.

Connecting a powerful content production platform, to a powerful content publishing platform.

## Installation ##

This section describes how to install the plugin and get it working.

1. Upload `gathercontent-import` to the `/wp-content/plugins/` directory
1. Activate the GatherContent plugin through the 'Plugins' menu in WordPress
1. Click on the menu item "GatherContent"
2. Link your accounts. You will need to enter your GatherContent account URL (e.g. http://mywebsite.gathercontent.com) and your personal GatherContent API key. You can find your API key in your [Settings area within GatherContent](https://gathercontent.com/developers/authentication/).

For more detailed installation instructions please visit our [HelpCentre](https://gathercontent.com/support/wordpress-integration-installation/).

## Support ##

If you need help

* Please [visit our support documentation](https://gathercontent.com/support/wordpress-integration).

## Changelog ##

### 3.0.0.4 ###
* Allow file fields to be mapped to custom fields. Will store an array of WordPress attachment ids, or a single attachment id if the file field from GatherContent only contains a single file.

### 3.0.0.3 ###
* Fix issue on PHP 5.4 with using shortand array syntax.

### 3.0.0.2 ###
* Fix bug when creating a new mapping and trying to map GatherContent statuses before saving the mapping.

### 3.0.0.1 ###
* Fix bug where WordPress pointer script/css was not properly enqueued in some instances.

### 3.0.0 ###
* Complete rewrite. Plugin no longer uses the legacy API, and allows mapping templates, and then importing/exporting items via the mapped templates.

### 2.6.40 ###
* Update plugin to use Items instead of Pages

### 2.6.3 ###
* Better integration with yoast and ACF pro. Map to author. Added post format option

### 2.6.2 ###
* Remove inline comments from text content

### 2.6.1 ###
* Fix bug for multi site installs

### 2.6.0 ###
* Add support for custom tabs feature within GatherContent

### 2.5.0 ###
* Import hierarchy from GatherContent. Added publish state dropdown to

### 2.4.1 ###
* Integrated a few updates from github and fixed coding standard to match WordPress coding standards

### 2.4.0 ###
* Changed how the plugin stores page data to allow a larger amount of pages with larger content

### 2.3.0 ###
* Updated GatherContent API requests to match current API version and minor UI updates for WP 3.8

### 2.2.1 ###
* Added check to makesure cURL is enabled

### 2.2.0 ###
* Reworked pages importing to work via ajax. Should fix problems importing too many fields (`max_input_vars`)

### 2.1.0 ###
* Added repeatable field mapping

### 2.0.4 ###
* Fixed a bug where tag strings weren't being separated by commas

### 2.0.3 ###
* Added an alert when pages have no fields to import

### 2.0.2 ###
* Fixed line break issues

### 2.0.1 ###
* Fixed errors that were only displaying in WP_DEBUG mode

### 2.0 ###
* Complete rewrite of old plugin
