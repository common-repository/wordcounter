<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nearchx.com
 * @since             1.0.0
 * @package           Wordcounter
 *
 * @wordpress-plugin
 * Plugin Name:       WordCounter
 * Plugin URI:        https://wordcounter.world/tools/wordpress-plugin
 * Description:       Counts the words in your post and display it at the beginning/end of the post.
 * Version:           1.0.0
 * Requires at least: 3.0.1
 * Requires PHP:      7.0
 * Author:            NearchX
 * Author URI:        https://nearchx.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordcounter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WORDCOUNTER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wordcounter-activator.php
 */
function wordcounter_active_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordcounter-activator.php';
	Wordcounter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wordcounter-deactivator.php
 */
function wordcounter_deactivate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordcounter-deactivator.php';
	Wordcounter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'wordcounter_active_plugin' );
register_deactivation_hook( __FILE__, 'wordcounter_deactivate_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wordcounter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wordcounter_run_plugin() {

	$plugin = new Wordcounter();
	$plugin->run();

}
wordcounter_run_plugin();
