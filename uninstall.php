<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      2.0.0
 * @package    Wp_After_Login_Redirect_Advanced
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) die;

/**
 * Remove plugin options on uninstall/delete
 */
delete_option( 'wplra_login_redirect_enable' );
delete_option( 'wplra_login_redirect_filters' );
