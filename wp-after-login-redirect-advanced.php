<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @package           Wp_After_Login_Redirect_Advanced
 * @author            Sajjad Hossain Sagor <sagorh672@gmail.com>
 *
 * Plugin Name:       After Login Redirect
 * Plugin URI:        https://wordpress.org/plugins/wp-after-login-redirect-advanced/
 * Description:       Redirect User After Successfully Logged in To Any Page You Want Easily. Filter By User ID, Username, User Email, User Role.
 * Version:           2.0.4
 * Requires at least: 5.6
 * Requires PHP:      8.1
 * Author:            Sajjad Hossain Sagor
 * Author URI:        https://sajjadhsagor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-after-login-redirect-advanced
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_VERSION', '2.0.4' );

/**
 * Define Plugin Folders Path
 */
define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-after-login-redirect-advanced-activator.php
 *
 * @since    2.0.0
 */
function on_activate_wp_after_login_redirect_advanced() {
	require_once WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'includes/class-wp-after-login-redirect-advanced-activator.php';

	Wp_After_Login_Redirect_Advanced_Activator::on_activate();
}

register_activation_hook( __FILE__, 'on_activate_wp_after_login_redirect_advanced' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-after-login-redirect-advanced-deactivator.php
 *
 * @since    2.0.0
 */
function on_deactivate_wp_after_login_redirect_advanced() {
	require_once WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'includes/class-wp-after-login-redirect-advanced-deactivator.php';

	Wp_After_Login_Redirect_Advanced_Deactivator::on_deactivate();
}

register_deactivation_hook( __FILE__, 'on_deactivate_wp_after_login_redirect_advanced' );

/**
 * The core plugin class that is used to define admin-specific and public-facing hooks.
 *
 * @since    2.0.0
 */
require WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'includes/class-wp-after-login-redirect-advanced.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_wp_after_login_redirect_advanced() {
	$plugin = new Wp_After_Login_Redirect_Advanced();

	$plugin->run();
}

run_wp_after_login_redirect_advanced();
