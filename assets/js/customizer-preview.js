/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( api, $ ) {

	// Passed by wp_localize_script()
	frontPagePanelCount = parseInt( frontPagePanelCount[0] );

	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site description.
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Display site title and description.
	api( 'header_text', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).toggleClass( 'title-tagline-hidden', ! to );
		} );
	} );

	/**
	 * Settings to bind updating to.
	 * @type {array}
	 */
	var settings = [];

	for ( var i = 0; i <= frontPagePanelCount; i++ ) {
		settings.push( {
			index: i,
			settingID: 'panel_bg_repeat_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index + ' .panel-background' ).css( 'background-repeat', to );
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_bg_position_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index + ' .panel-background' ).css( 'background-position', to );
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_bg_attachment_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index + ' .panel-background' ).css( 'background-attachment', to );
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_bg_size_type_' + i,
			callback: function( to ) {
				if ( 'cover' == to || 'auto' == to ) {
					$( '#panel-' + this.index + ' .panel-background' ).css( 'background-size', to );
				}
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_bg_size_' + i,
			callback: function( to ) {
				if ( 'percent' == api( 'panel_bg_size_type_' + this.index )() ) {
					$( '#panel-' + this.index + ' .panel-background' ).css( 'background-size', to + '%' );
				}
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_bg_opacity_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index + ' .panel-background' ).css( 'opacity', to );
			}
		} );
	}

	// Bind update to each setting.
	$.each( settings, function ( k, panel ) {
		api( panel.settingID, function( value ) {
			value.bind( function( to ) {
				panel.callback( to );
			} );
		} );
	} );

} ) ( wp.customize, jQuery );
