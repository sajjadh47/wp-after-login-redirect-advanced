<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @package    Wp_After_Login_Redirect_Advanced
 * @subpackage Wp_After_Login_Redirect_Advanced/admin
 * @author     Sajjad Hossain Sagor <sagorh672@gmail.com>
 */
class Wp_After_Login_Redirect_Advanced_Admin
{
	/**
	 * The ID of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $plugin_name     The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      string    $version    		The current version of this plugin.
	 */
	private $version;

	/**
	 * Ajax Response Messages.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @var      array    $messages    		Responses Message Array.
	 */
	private $messages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @param    string    $plugin_name     The name of this plugin.
	 * @param    string    $version    		The version of this plugin.
	 */
	public function __construct( $plugin_name, $version )
	{
		$this->plugin_name 							= $plugin_name;
		
		$this->version 								= $version;

		$this->messages['default_msg']				= array( 'type' => 'notice-error', 'message' => __( 'Something Went Wrong! Please Try Again.', 'wp-after-login-redirect-advanced' ) );
		
		$this->messages['permission_denied_msg'] 	= array( 'type' => 'notice-error', 'message' => __( 'Permission Denied! You Are Not Allowed To Modify.', 'wp-after-login-redirect-advanced' ) );

		$this->messages['success_msg'] 				= array( 'type' => 'notice-success', 'message' => __( 'Settings Saved Successfully!', 'wp-after-login-redirect-advanced' ) );

		$this->messages['nonce_error_msg']			= array( 'type' => 'notice-error', 'message' => __( 'Sorry, your nonce did not verify.', 'wp-after-login-redirect-advanced' ) );
		
		$this->messages['reset_success_msg']		= array( 'type' => 'notice-success', 'message' => __( 'Filters Successfully Reset.', 'wp-after-login-redirect-advanced' ) );

		$this->messages['filter_enabled_msg']		= array( 'type' => 'notice-success', 'message' => __( 'Filters Enabled!', 'wp-after-login-redirect-advanced' ) );
		
		$this->messages['filter_disabled_msg']		= array( 'type' => 'notice-success', 'message' => __( 'Filters Disabled!', 'wp-after-login-redirect-advanced' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function enqueue_styles()
	{
		$current_scrn = get_current_screen();

		if ( $current_scrn->id !== 'toplevel_page_wp-after-login-redirect-advanced' ) return;
		
		wp_enqueue_style( $this->plugin_name, WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_URL . 'admin/css/admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function enqueue_scripts()
	{
		$current_scrn 			= get_current_screen();

		if ( $current_scrn->id !== 'toplevel_page_wp-after-login-redirect-advanced' ) return;
		
		wp_enqueue_script( $this->plugin_name, WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_URL . 'admin/js/admin.js', array( 'jquery', 'jquery-ui-autocomplete' ), $this->version, false );

		$post_types 			= get_post_types( array( 'public'   => true, '_builtin' => false ), 'names', 'or' );

		$url_sugestions 		= array();

		$all_posts_pages 		= get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => $post_types,
		) );

		foreach( $all_posts_pages as $post )
		{	
			$url_sugestions[]	= esc_url( get_the_permalink( $post->ID ) );
		}

		wp_localize_script( $this->plugin_name, 'Wp_After_Login_Redirect_Advanced', array(
			'ajaxurl'							=> admin_url( 'admin-ajax.php' ),
			'redirect_url_cannot_be_empty_txt'	=> __( 'Redirect URL Can not be Empty!', 'wp-after-login-redirect-advanced' ),
			'saving_txt'						=> __( 'Saving Settings...', 'wp-after-login-redirect-advanced' ),
			'settings_saved_txt'				=> __( 'Settings Saved', 'wp-after-login-redirect-advanced' ),
			'save_changes_txt'					=> __( 'Save Changes', 'wp-after-login-redirect-advanced' ),
			'url_sugestions'					=> $url_sugestions,
		) );
	}

	/**
	 * Adds the plugin settings page to the WordPress dashboard menu.
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function admin_menu()
	{
		add_menu_page( 
			__( 'Login Redirect', 'wp-after-login-redirect-advanced' ),
			__( 'Login Redirect', 'wp-after-login-redirect-advanced' ),
			'manage_options',
			'wp-after-login-redirect-advanced',
			array( $this, 'menu_page' ),
			'dashicons-menu'
		);
	}

	/**
	 * Renders the plugin menu page content.
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function menu_page()
	{
		include WP_AFTER_LOGIN_REDIRECT_ADVANCED_PLUGIN_PATH . 'admin/partials/plugin-admin-display.php';
	}

	/**
	 * Show admin notices.
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function admin_notices()
	{
		if ( isset( $_POST['wplra_login_redirect_filter_reset'] ) )
		{
				if ( ! isset( $_POST['wplra_login_redirect_filters_fields_submit'] ) || ! wp_verify_nonce( $_POST['wplra_login_redirect_filters_fields_submit'], 'wplra_login_redirect_filters_values_submit' )
				)
				{
					echo '<div class="notice notice-error is-dismissible">';
			
						echo '<p>' . $this->messages['nonce_error_msg']['message'] . '</p>';
					
					echo '</div>';
			}
			else
			{
				if( current_user_can( 'manage_options' ) )
				{
					update_option( 'wplra_login_redirect_filters', [] );

					update_option( 'wplra_login_redirect_enable', 'off' );

					echo '<div class="notice notice-success is-dismissible">';
			
						echo '<p>' . $this->messages['reset_success_msg']['message'] . '</p>';
					
					echo '</div>';
				}
				else
				{
					echo '<div class="notice notice-error is-dismissible">';
			
						echo '<p>' . $this->messages['permission_denied_msg']['message'] . '</p>';
					
					echo '</div>';
				}
			}
		}
	}

	/**
	 * Saves the enable/disable toggle setting for login redirects.
	 *
	 * This function handles the AJAX request to save the enable/disable toggle setting
	 * for login redirects. It verifies the nonce, checks user permissions, and updates
	 * the option in the database.
	 *
	 * @since   2.0.0
	 * @access 	public
	 * @return 	void
	 */
	public function save_enable_disable_toggle()
	{
		if ( ! isset( $_POST['wplra_login_redirect_filters_fields_submit'] ) || ! wp_verify_nonce( $_POST['wplra_login_redirect_filters_fields_submit'], 'wplra_login_redirect_filters_values_submit' )
			)
		{
			wp_send_json( $this->messages['nonce_error_msg'] ); die();
		}
		else
		{
			if ( isset( $_POST['wplra_login_redirect_enable'] ) && ! empty( $_POST['wplra_login_redirect_enable'] ) )
			{
				if ( $_POST['wplra_login_redirect_enable'] == 'on' )
				{
					if( current_user_can( 'manage_options' ) )
					{
						update_option( 'wplra_login_redirect_enable', 'on' );

						wp_send_json( $this->messages['filter_enabled_msg'] ); die();
					}
					else
					{
						wp_send_json( $this->messages['permission_denied_msg'] ); die();
					}
				}
				elseif ( $_POST['wplra_login_redirect_enable'] == 'off' )
				{
					if( current_user_can( 'manage_options' ) )
					{
						update_option( 'wplra_login_redirect_enable', 'off' );

						wp_send_json( $this->messages['filter_disabled_msg'] ); die();
					}
					else
					{
						wp_send_json( $this->messages['permission_denied_msg'] ); die();
					}
				}
			}
		}

		wp_send_json( $this->messages['default_msg'] ); die();
	}

	function save_redirect_filters()
	{
		if ( ! isset( $_POST['wplra_login_redirect_filters_fields_submit'] )
				|| ! wp_verify_nonce( $_POST['wplra_login_redirect_filters_fields_submit'], 'wplra_login_redirect_filters_values_submit' )
			)
		{
			wp_send_json( $this->messages['nonce_error_msg'] ); die();
		}
		else
		{
			if ( isset( $_POST['filters'] ) && is_array( $_POST['filters'] ) )
			{
				if( current_user_can( 'administrator' ) )
				{
					$filters = $this->sanitize_array_recursively( $_POST['filters'] );
					
					update_option( 'wplra_login_redirect_filters', $filters );

					wp_send_json( $this->messages['success_msg'] ); die();
				}
				else
				{
					wp_send_json( $this->messages['permission_denied_msg'] ); die();
				}
			}
		}

		wp_send_json( $this->messages['default_msg'] ); die();
	}

	/**
	 * Adds a settings link to the plugin's action links on the plugin list table.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @param    array $links    The existing array of plugin action links.
	 * @return   array $links    The updated array of plugin action links, including the settings link.
	 */
	public function add_plugin_action_links( $links )
	{
		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wp-after-login-redirect-advanced' ), __( 'Settings', 'wp-after-login-redirect-advanced' ) );
		
		return $links;
	}

	/**
	 * Recursively sanitize each array fields
	 *
	 * @since   2.0.0
	 * @access 	public
	 * @param   array $array    The array to sanitize.
	 * @return 	array
	 */
	public function sanitize_array_recursively( array &$array )
	{
		array_walk_recursive( $array, function ( &$value )
		{
			$value = sanitize_text_field( $value );
		} );

		return $array;
	}
}
