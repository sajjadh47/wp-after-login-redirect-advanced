<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      2.0.0
 * @package    Wp_After_Login_Redirect_Advanced
 * @subpackage Wp_After_Login_Redirect_Advanced/includes
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */
class Wp_After_Login_Redirect_Advanced_i18n
{
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain(
			'wp-after-login-redirect-advanced',
			false,
			dirname( WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_BASENAME ) . '/languages/'
		);
	}
}
