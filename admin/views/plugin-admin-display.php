<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      2.0.0
 * @package    Wp_After_Login_Redirect_Advanced
 * @subpackage Wp_After_Login_Redirect_Advanced/admin/views
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Retrieve plugin settings.
$wplra_login_redirect_enabled    = get_option( 'wplra_login_redirect_enable', 'off' );
$wplra_wc_login_redirect_enabled = get_option( 'wplra_wc_login_redirect_enable', 'off' );
$wplra_login_redirect_filters    = get_option( 'wplra_login_redirect_filters', array() );

?>

<div class="wrap">
	<h2><?php esc_html_e( 'Redirect User After Login', 'wp-after-login-redirect-advanced' ); ?></h2>
	<div class="notice wplra_login_redirect_filter_message"><p></p></div><br>
	<form action="" method="post" id="wplra_login_redirect_filter_form">
		<div class="form-group row mb-3">
			<div class="col-sm-3 wplra-enable-redirection">
				<?php esc_html_e( 'Enable Redirection', 'wp-after-login-redirect-advanced' ); ?>
			</div>
			<div class="col-sm-9">
				<div class="form-check">
					<div class="wplra-filter-slider">
						<input type="checkbox" name="wplra_login_redirect_enable" class="wplra-filter-slider-checkbox" id="wplra_login_redirect_enable" <?php checked( 'on', $wplra_login_redirect_enabled ); ?>>
						<label class="wplra-filter-slider-label" for="wplra_login_redirect_enable">
							<span class="wplra-filter-slider-inner"></span>
							<span class="wplra-filter-slider-circle"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row mb-3">
			<div class="col-sm-3 wplra-enable-redirection">
				<?php esc_html_e( 'Enable compatibility with WooCommerce', 'wp-after-login-redirect-advanced' ); ?>
			</div>
			<div class="col-sm-9">
				<div class="form-check">
					<div class="wplra-filter-slider">
						<input type="checkbox" name="wplra_wc_login_redirect_enable" class="wplra-filter-slider-checkbox" id="wplra_wc_login_redirect_enable" <?php checked( 'on', $wplra_wc_login_redirect_enabled ); ?>>
						<label class="wplra-filter-slider-label" for="wplra_wc_login_redirect_enable">
							<span class="wplra-filter-slider-inner"></span>
							<span class="wplra-filter-slider-circle"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<?php
		if ( ! empty( $wplra_login_redirect_filters ) ) {
			foreach ( $wplra_login_redirect_filters as $filter ) {
				$filter_by       = sanitize_text_field( $filter['filter_by'] );
				$filter_by_value = sanitize_text_field( $filter['filter_by_value'] );
				$redirect_to_url = sanitize_text_field( $filter['redirect_to_url'] );
				require WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'admin/views/plugin-admin-display-fields.php';
			}
		} else {
			$filter_by       = 'email';
			$filter_by_value = '';
			$redirect_to_url = '';
			require WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'admin/views/plugin-admin-display-fields.php';
		}
		?>
		<button type="submit" class="button button-primary" name="wplra_login_redirect_filter_submit" id="wplra_login_redirect_filter_submit">
			<?php esc_html_e( 'Save Changes', 'wp-after-login-redirect-advanced' ); ?>
		</button>
		<?php wp_nonce_field( 'wplra_nonce', 'wplra_nonce' ); ?>
		<button type="submit" class="button button-secondary" name="wplra_login_redirect_filter_reset" id="wplra_login_redirect_filter_reset">
			<?php esc_html_e( 'Reset', 'wp-after-login-redirect-advanced' ); ?>
		</button>
	</form>
</div>
