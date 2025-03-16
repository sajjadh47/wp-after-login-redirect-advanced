<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             2.0.0
 * @package           Wp_After_Login_Redirect_Advanced
 *
 * Plugin Name:       After Login Redirect
 * Plugin URI:        https://wordpress.org/plugins/wp-after-login-redirect-advanced/
 * Description:       Redirect User After Successfully Logged in To Any Page You Want Easily. Filter By User ID, Username, User Email, User Role.
 * Version:           2.0.0
 * Author:            Sajjad Hossain Sagor
 * Author URI:        https://sajjadhsagor.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-after-login-redirect-advanced
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

/**
 * Currently plugin version.
 */
define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_VERSION', '2.0.0' );

/**
 * Define Plugin Folders Path
 */
define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-activator.php
 * 
 * @since    2.0.0
 */
function activate_wp_after_login_redirect_advanced()
{
	require_once WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'includes/class-plugin-activator.php';
	
	Wp_After_Login_Redirect_Advanced_Activator::activate();
}

register_activation_hook( __FILE__, 'activate_wp_after_login_redirect_advanced' );

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-deactivator.php
 * 
 * @since    2.0.0
 */
function deactivate_wp_after_login_redirect_advanced()
{
	require_once WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'includes/class-plugin-deactivator.php';
	
	Wp_After_Login_Redirect_Advanced_Deactivator::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_wp_after_login_redirect_advanced' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 * 
 * @since    2.0.0
 */
require WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'includes/class-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    2.0.0
 */
function run_wp_after_login_redirect_advanced()
{
	$plugin = new Wp_After_Login_Redirect_Advanced();
	
	$plugin->run();
}

run_wp_after_login_redirect_advanced();
