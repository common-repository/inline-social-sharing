<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://fruitfulwp.com/
 * @since      1.0.0
 *
 * @package    Fruitful_Inline_Social_Sharing
 * @subpackage Fruitful_Inline_Social_Sharing/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Fruitful_Inline_Social_Sharing
 * @subpackage Fruitful_Inline_Social_Sharing/includes
 * @author     Fruitfull <info@fruitfulwp.com>
 */
class Fruitful_Inline_Social_Sharing_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'fruitful-inline-social-sharing',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
