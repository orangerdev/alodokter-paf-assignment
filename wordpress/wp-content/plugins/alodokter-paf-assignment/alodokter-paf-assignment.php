<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ridwan-arifandi.com
 * @since             1.0.0
 * @package           Alodokter
 *
 * @wordpress-plugin
 * Plugin Name:       Alodokter - Principal Architect Framework assignment
 * Plugin URI:        https://ridwan-arifandi.com
 * Description:       Plugin for Principal Architect Framework assignment.
 * Version:           1.0.0
 * Author:            Ridwan Arifandi
 * Author URI:        https://ridwan-arifandi.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       alodokter
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
define( 'ALODOKTER_VERSION', 		'1.0.0' );
define( 'ALODOKTER_PRODUCT_CPT',	'product' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-alodokter-activator.php
 */
function activate_alodokter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alodokter-activator.php';
	Alodokter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-alodokter-deactivator.php
 */
function deactivate_alodokter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-alodokter-deactivator.php';
	Alodokter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_alodokter' );
register_deactivation_hook( __FILE__, 'deactivate_alodokter' );

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-alodokter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_alodokter() {

	$plugin = new Alodokter();
	$plugin->run();

}
run_alodokter();
