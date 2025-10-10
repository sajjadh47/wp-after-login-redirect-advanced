<?php
/**
 * This file contains the definition of the Wp_After_Login_Redirect_Advanced_Public class, which
 * is used to load the plugin's public-facing functionality.
 *
 * @package       Wp_After_Login_Redirect_Advanced
 * @subpackage    Wp_After_Login_Redirect_Advanced/public
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    2.0.0
 */
class Wp_After_Login_Redirect_Advanced_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $plugin_name The name of the plugin.
	 * @param     string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Filters the login redirect URL based on user criteria.
	 *
	 * This function modifies the login redirect URL based on user ID, email, role, or username,
	 * according to the settings configured in the plugin's options.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string  $redirect_to The redirect destination URL.
	 * @param     string  $request     The requested URL.
	 * @param     WP_User $user        The WP_User object.
	 * @return    string               The filtered redirect URL.
	 */
	public function login_redirect( $redirect_to, $request, $user ) {
		// Retrieve plugin settings.
		$wplra_login_redirect_enabled = get_option( 'wplra_login_redirect_enable', 'off' );
		$wplra_login_redirect_filters = get_option( 'wplra_login_redirect_filters', array() );

		// Check if login redirect is enabled.
		if ( 'on' === $wplra_login_redirect_enabled ) {
			// Check if redirect filters are defined.
			if ( ! empty( $wplra_login_redirect_filters ) ) {
				// Iterate through each filter.
				foreach ( $wplra_login_redirect_filters as $filter ) {
					// Check the filter type.
					switch ( $filter['filter_by'] ) {
						case 'id':
							if ( isset( $user->ID ) && $user->ID === $filter['filter_by_value'] ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;

						case 'email':
							if ( isset( $user->user_email ) && $user->user_email === $filter['filter_by_value'] ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;

						case 'role':
							if ( isset( $user->roles ) && is_array( $user->roles ) && in_array( $filter['filter_by_value'], $user->roles, true ) ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;

						case 'username':
							if ( isset( $user->user_login ) && $user->user_login === $filter['filter_by_value'] ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;
						case 'country':
							$visitor_ip = Wp_After_Login_Redirect_Advanced::get_visitor_ip();
							// if result is found then redirect.
							try {
								// This creates the Reader object.
								$reader          = new \GeoIp2\Database\Reader( WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'public/geoip-db/GeoLite2-Country.mmdb' );
								$visitor_geo     = $reader->country( $visitor_ip );
								$visitor_country = $visitor_geo->country->isoCode;

								if ( strtolower( $visitor_country ) === strtolower( $filter['filter_by_value'] ) ) {
									return esc_url( $filter['redirect_to_url'] );
								}
							} catch ( Exception $e ) {
								// do nothing now.
								break;
							}
							break;
					}
				}
			}
		}

		// Return the original redirect URL if no filter matches.
		return $redirect_to;
	}

	/**
	 * Filters the woocommerce my account login redirect URL based on user criteria.
	 *
	 * This function modifies the login redirect URL based on user ID, email, role, or username,
	 * according to the settings configured in the plugin's options.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string  $redirect_to The redirect destination URL.
	 * @param     WP_User $user        The WP_User object.
	 * @return    string               The filtered redirect URL.
	 */
	public function wc_login_redirect( $redirect_to, $user ) {
		// Retrieve plugin settings.
		$wplra_login_redirect_enabled    = get_option( 'wplra_login_redirect_enable', 'off' );
		$wplra_wc_login_redirect_enabled = get_option( 'wplra_wc_login_redirect_enable', 'off' );
		$wplra_login_redirect_filters    = get_option( 'wplra_login_redirect_filters', array() );

		// Check if login redirect is enabled.
		if ( 'on' === $wplra_login_redirect_enabled && 'on' === $wplra_wc_login_redirect_enabled ) {
			// Check if redirect filters are defined.
			if ( ! empty( $wplra_login_redirect_filters ) ) {
				// Iterate through each filter.
				foreach ( $wplra_login_redirect_filters as $filter ) {
					// Check the filter type.
					switch ( $filter['filter_by'] ) {
						case 'id':
							if ( isset( $user->ID ) && $user->ID === $filter['filter_by_value'] ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;

						case 'email':
							if ( isset( $user->user_email ) && $user->user_email === $filter['filter_by_value'] ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;

						case 'role':
							if ( isset( $user->roles ) && is_array( $user->roles ) && in_array( $filter['filter_by_value'], $user->roles, true ) ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;

						case 'username':
							if ( isset( $user->user_login ) && $user->user_login === $filter['filter_by_value'] ) {
								return esc_url( $filter['redirect_to_url'] );
							}
							break;
						case 'country':
							$visitor_ip = Wp_After_Login_Redirect_Advanced::get_visitor_ip();
							// if result is found then redirect.
							try {
								// This creates the Reader object.
								$reader          = new \GeoIp2\Database\Reader( WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'public/geoip-db/GeoLite2-Country.mmdb' );
								$visitor_geo     = $reader->country( $visitor_ip );
								$visitor_country = $visitor_geo->country->isoCode;

								if ( strtolower( $visitor_country ) === strtolower( $filter['filter_by_value'] ) ) {
									return esc_url( $filter['redirect_to_url'] );
								}
							} catch ( Exception $e ) {
								// do nothing now.
								break;
							}
							break;
					}
				}
			}
		}

		// Return the original redirect URL if no filter matches.
		return $redirect_to;
	}
}
