<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @since      2.0.0
 * @package    Wp_After_Login_Redirect_Advanced
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Remove plugin option.
delete_option( 'wplra_login_redirect_enable' );
delete_option( 'wplra_wc_login_redirect_enable' );
delete_option( 'wplra_login_redirect_filters' );
