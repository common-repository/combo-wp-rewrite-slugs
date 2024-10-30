<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://codezel.com/
 * @since      1.0.0
 *
 * @package    RewriteSlugs
 * @subpackage RewriteSlugs/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    RewriteSlugs
 * @subpackage RewriteSlugs/includes
 * @author     CodeZel <thecodezel@gmail.com>
 */
class Rewrite_Slugs_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'combo-wp-rewrite-slugs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
