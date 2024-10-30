<?php

/**
 *
 * @link              https://fruitfulwp.com/
 * @since             1.0.0
 * @package           Fruitful_Inline_Social_Sharing
 *
 * @wordpress-plugin
 * Plugin Name:       Inline Social Sharing
 * Plugin URI:        https://fruitfulwp.com/inline-social-sharing/
 * Description:       Boost Social Traffic Shares up to 300% with a stupid simple technology.
 * Version:           1.0.3
 * Author:            Fruitfull
 * Author URI:        https://fruitfulwp.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fruitful-inline-social-sharing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fruitful-inline-social-sharing-activator.php
 */
function activate_fruitful_inline_social_sharing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fruitful-inline-social-sharing-activator.php';
	Fruitful_Inline_Social_Sharing_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fruitful-inline-social-sharing-deactivator.php
 */
function deactivate_fruitful_inline_social_sharing() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fruitful-inline-social-sharing-deactivator.php';
	Fruitful_Inline_Social_Sharing_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fruitful_inline_social_sharing' );
register_deactivation_hook( __FILE__, 'deactivate_fruitful_inline_social_sharing' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fruitful-inline-social-sharing.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fruitful_inline_social_sharing() {

	$plugin = new Fruitful_Inline_Social_Sharing();
	$plugin->run();

}
run_fruitful_inline_social_sharing();
