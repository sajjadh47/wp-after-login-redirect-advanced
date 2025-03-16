jQuery( document ).ready( function( $ )
{
	$( document ).on( 'change', '.wplra_select_filter_by_elem', function( event )
	{
		var parent 	= $( this ).closest( '.wplra_filtering_group_container' );
		
		var val 	= $( this ).val();
		
		$( parent ).find( 'select' ).not( $( this ) ).hide();
		
		$( parent ).find( '.wplra_filter_by_' + val ).show();
	} );

	$( document ).on( 'keydown.autocomplete', '.wplra_redirect_url', function()
	{
		var options =
		{
			source: Wp_After_Login_Redirect_Advanced.url_sugestions,
		};

		$( this ).autocomplete( options );
	} );

	$( '#wplra_login_redirect_filter_form .wplra_filtering_group_container' ).first().find( 'span.wplra_delete_filter' ).css( 'visibility', 'hidden' );

	$( document ).on( 'click', 'span.wplra_add_more_filter', function( event )
	{
		$( this ).closest( '.wplra_filtering_group_container' ).after( $( this ).closest( '.wplra_filtering_group_container' ).clone() );
		
		$( '.wplra_filtering_group_container' ).not( $( '#wplra_login_redirect_filter_form .wplra_filtering_group_container' ).first() ).find( 'span.wplra_delete_filter' ).css( 'visibility','visible' );
		
		$( '.wplra_filtering_group_container' ).last().find( 'select' ).not( '.wplra_select_filter_by_elem' ).hide();
		
		$( '.wplra_filtering_group_container' ).last().find( 'select.wplra_filter_by_id' ).show();
		
		$( '.wplra_filtering_group_container' ).last().find( '.wplra_redirect_url' ).val( '' );
	} );

	$( document ).on( 'click', 'span.wplra_delete_filter', function( event )
	{
		$( this ).closest( '.wplra_filtering_group_container' ).remove();
	} );

	$( '#wplra_login_redirect_enable' ).click( function( event )
	{
		$( '.wplra_login_redirect_filter_message' ).hide( 'slow' );
		
		var _this								= $( this );
		
		var data 								=
		{
			wplra_login_redirect_enable 				: 'off',
			action  									: 'wplra_save_enable_disable_toggle',
			wplra_login_redirect_filters_fields_submit  : $( '#wplra_login_redirect_filters_fields_submit' ).val()
		};
		
		if ( $( _this ).is( ':checked' ) )
		{
			data.wplra_login_redirect_enable 	= 'on';
		}

		$.post( ajaxurl, data, function( response )
		{
			$( '.wplra_login_redirect_filter_message p' ).text( response.message );

			$( '.wplra_login_redirect_filter_message' ).removeClass( 'notice-error notice-success' ).addClass( response.type ).show( 'slow' );

			if ( response.type == 'notice-error' )
			{
				if ( $( _this ).is( ':checked' ) )
				{
					$( _this ).prop( 'checked', false );
				}
				else
				{
					$( _this ).prop( 'checked', true );
				}
			}
		} );
	} );

	$( '#wplra_login_redirect_filter_submit' ).click( function( event )
	{
		event.preventDefault();

		var empty 			= false;

		$( '.wplra_login_redirect_filter_message' ).hide( 'slow' );

		$( '.wplra_filtering_group_container' ).each( function( index, el )
		{
			if ( $( this ).find( '.wplra_redirect_url' ).val() == '' )
			{
				$( '.wplra_login_redirect_filter_message p' ).text( Wp_After_Login_Redirect_Advanced.redirect_url_cannot_be_empty_txt );

				$( '.wplra_login_redirect_filter_message' ).addClass( 'notice-error' ).show( 'slow' );

				empty 		= true; return;
			};
		} );

		if ( ! empty )
		{
			$( this ).text( Wp_After_Login_Redirect_Advanced.saving_txt ).prop( 'disabled', true );

			var filters 	= [];

			$( '.wplra_filtering_group_container' ).each( function( index, el )
			{
				filter_by_ 	= $( this ).find( '.wplra_select_filter_by_elem' ).val();

				filters.push(
				{
					filter_by       :  filter_by_,
					filter_by_value :  $( this ).find( '.wplra_filter_by_'+  filter_by_ ).val(),
					redirect_to_url :  $( this ).find( '.wplra_redirect_url' ).val()
				} );
			} );

			var data =
			{
				filters : filters,
				action  : 'wplra_save_redirect_filters',
				wplra_login_redirect_filters_fields_submit   : $( '#wplra_login_redirect_filters_fields_submit' ).val()
			};

			$.post( ajaxurl, data, function( response )
			{
				$( '#wplra_login_redirect_filter_submit' ).text( Wp_After_Login_Redirect_Advanced.settings_saved_txt );

				setTimeout( function()
				{
					$( '#wplra_login_redirect_filter_submit' ).text( Wp_After_Login_Redirect_Advanced.save_changes_txt ).prop( 'disabled', false );

				}, 2000 );

				$( '.wplra_login_redirect_filter_message p' ).text( response.message );

				$( '.wplra_login_redirect_filter_message' ).removeClass( 'notice-error notice-success' ).addClass( response.type ).show( 'slow' );
			} );
		}
	} );
} );