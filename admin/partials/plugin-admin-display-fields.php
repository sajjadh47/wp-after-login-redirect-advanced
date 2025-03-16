<?php

/**
 * Render settings form fields
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      2.0.0
 *
 * @package    Wp_After_Login_Redirect_Advanced
 * @subpackage Wp_After_Login_Redirect_Advanced/admin/partials
 */

// get all users
$users 							= get_users();

// get all registered user roles
$roles 							= get_editable_roles();

?>

<div class="input-group mb-3 wplra_filtering_group_container">
	<div class="input-group-prepend">
		<span class="input-group-text">
			<?php _e( 'Redirect If', 'wp-after-login-redirect-advanced' ); ?>
		</span>
	</div>
	<select name="wplra_select_filter_by_elem" class="form-control wplra_filter_select wplra_select_filter_by_elem">
		<option value="id" <?php selected( $filter_by, 'id' ); ?>><?php _e( 'User ID', 'wp-after-login-redirect-advanced' ); ?></option>
		<option value="email" <?php selected( $filter_by, 'email' ); ?>><?php _e( 'User Email', 'wp-after-login-redirect-advanced' ); ?></option>
		<option value="role" <?php selected( $filter_by, 'role' ); ?>><?php _e( 'User Role', 'wp-after-login-redirect-advanced' ); ?></option>
		<option value="username" <?php selected( $filter_by, 'username' ); ?>><?php _e( 'User Username', 'wp-after-login-redirect-advanced' ); ?></option>
	</select>
	<div class="input-group-append">
		<span class="input-group-text">==</span>
	</div>
	<select name="wplra_filter_by_email" class="form-control wplra_filter_select wplra_filter_by_email" <?php echo $filter_by == 'email' ? " style='display:block;'" : ""; ?>>
		<?php
			foreach ( $users as $user )
			{
				if ( ! empty( $user->user_email ) )
				{
					echo '<option '. selected( $filter_by_value, $user->user_email ) .' value="'. esc_attr( $user->user_email ) .'">'. esc_html( $user->user_email ) .'</option>';
				}
			}
		?>
	</select>
	<select name="wplra_filter_by_id" class="form-control wplra_filter_select wplra_filter_by_id" <?php echo $filter_by == 'id' ? " style='display:block;'" : ""; ?>>
		<?php
			foreach ( $users as $user )
			{

				if ( ! empty( $user->ID ) )
				{
					echo '<option '. selected( $filter_by_value, $user->ID ) .' value="'. esc_attr( $user->ID ) .'">'. esc_html( $user->ID ) .'</option>';
				}
			}
		?>
	</select>
	<select name="wplra_filter_by_role" class="form-control wplra_filter_select wplra_filter_by_role" <?php echo $filter_by == 'role' ? " style='display:block;'" : ""; ?>>
		<?php
			foreach ( $roles as $role_name => $role_info )
			{
				if ( ! empty( $role_name ) )
				{
					echo '<option '. selected( $filter_by_value, $role_name ) .' value="'. esc_attr( $role_name ) .'">'. esc_html( $role_name ) .'</option>';
				}
			}
		?>
	</select>
	<select name="wplra_filter_by_username" class="form-control wplra_filter_select wplra_filter_by_username" <?php echo $filter_by == 'username' ? " style='display:block;'" : ""; ?>>
		<?php
			foreach ( $users as $user )
			{
				if ( ! empty( $user->user_login ) )
				{
					echo '<option '. selected( $filter_by_value, $user->user_login ) .' value="'. esc_attr( $user->user_login ) .'">'. esc_html( $user->user_login ) .'</option>';
				}
			}
		?>
	</select>
	<div class="input-group-append">
		<span class="input-group-text"><?php _e( 'To', 'wp-after-login-redirect-advanced' ); ?></span>
	</div>
	<input type="text" class="form-control wplra_filter_select wplra_redirect_url" name="wplra_redirect_url" value='<?php echo esc_url( $redirect_to_url ); ?>' placeholder="<?php _e( 'Enter Redirect URL...', 'wp-after-login-redirect-advanced' ); ?>">
	<span class="dashicons dashicons-plus-alt wplra_add_more_filter"></span>
	<span class="dashicons dashicons-minus wplra_delete_filter"></span>
</div>