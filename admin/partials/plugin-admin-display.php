<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      2.0.0
 *
 * @package    Wp_After_Login_Redirect_Advanced
 * @subpackage Wp_After_Login_Redirect_Advanced/admin/partials
 */

// Retrieve plugin settings.
$wplra_login_redirect_enabled 	= get_option( 'wplra_login_redirect_enable', 'off' );
$wplra_login_redirect_filters 	= get_option( 'wplra_login_redirect_filters', [] );

?>

<div class="wrap">
	<h2><?php _e( 'Redirect User After Login Conditionally', 'wp-after-login-redirect-advanced' ); ?></h2>
	<div class="notice wplra_login_redirect_filter_message"><p></p></div><br>
	<form action="" method="post" id="wplra_login_redirect_filter_form">
		<div class="form-group row mb-3">
			<div class="col-sm-2 wplra-enable-redirection">
				<?php _e( 'Enable Redirection', 'wp-after-login-redirect-advanced' ); ?>
			</div>
			<div class="col-sm-10">
				<div class="form-check">
					<div class="wplra-filter-slider">
						<input type="checkbox" name="wplra-filter-slider" class="wplra-filter-slider-checkbox" id="wplra_login_redirect_enable" <?php checked( 'on', $wplra_login_redirect_enabled ); ?>>
						<label class="wplra-filter-slider-label" for="wplra_login_redirect_enable">
							<span class="wplra-filter-slider-inner"></span>
							<span class="wplra-filter-slider-circle"></span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<?php
			if ( ! empty( $wplra_login_redirect_filters ) )
			{
				foreach ( $wplra_login_redirect_filters as $filter )
				{	
					$filter_by 			= sanitize_text_field( $filter['filter_by'] );
					
					$filter_by_value 	= sanitize_text_field( $filter['filter_by_value'] );
					
					$redirect_to_url 	= sanitize_text_field( $filter['redirect_to_url'] );
					
					include WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'admin/partials/plugin-admin-display-fields.php';
				}
			}
			else
			{	
				$filter_by 				= 'email' ;
				
				$filter_by_value 		= '';
				
				$redirect_to_url 		= '';
				
				include WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'admin/partials/plugin-admin-display-fields.php';
			}
		?>
		<button type="submit" class="button button-primary" name="wplra_login_redirect_filter_submit" id="wplra_login_redirect_filter_submit">
			<?php _e( 'Save Changes', 'wp-after-login-redirect-advanced' ); ?>
		</button>
		<?php wp_nonce_field( 'wplra_login_redirect_filters_values_submit', 'wplra_login_redirect_filters_fields_submit' ); ?>
		<button type="submit" class="button button-secondary" name="wplra_login_redirect_filter_reset" id="wplra_login_redirect_filter_reset">
			<?php _e( 'Reset', 'wp-after-login-redirect-advanced' ); ?>
		</button>
	</form>
</div>