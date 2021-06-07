<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/mashrurFahim
 * @since             1.0.0
 * @package           Wp_To_Do_List
 *
 * @wordpress-plugin
 * Plugin Name:       WP To Do List
 * Plugin URI:        https://github.com/mashrurFahim/wp-to-do-list.git
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mashrur Fahim
 * Author URI:        https://github.com/mashrurFahim
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-to-do-list
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
define( 'WP_TO_DO_LIST_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-to-do-list-activator.php
 */
function activate_wp_to_do_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-to-do-list-activator.php';
	Wp_To_Do_List_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-to-do-list-deactivator.php
 */
function deactivate_wp_to_do_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-to-do-list-deactivator.php';
	Wp_To_Do_List_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_to_do_list' );
register_deactivation_hook( __FILE__, 'deactivate_wp_to_do_list' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-to-do-list.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_to_do_list() {

	$plugin = new Wp_To_Do_List();
	$plugin->run();

}
run_wp_to_do_list();
