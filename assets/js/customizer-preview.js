/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( api, $ ) {

	console.log( defaultFooterMsg );

	// Site title.
	api( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Site description
	api( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Check if we already have inline styles.
	var	$stylePanels = $( '#counter-style-panels-inline-css' );

	if ( ! $stylePanels.length ) {
		$stylePanels = $( 'head' ).append( '<style type="text/css" id="counter-style-panels-inline-css" />' ).find( '#counter-style-panels-inline-css' );
	}

	// Panel spacings CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-panel-spacings-css', function( css ) {
			$stylePanels.html( css );
		} );
	} );

	// Passed by wp_localize_script()
	frontPagePanelCount = parseInt( frontPagePanelCount[0] );

	/**
	 * Settings to bind updating to.
	 * @type {array}
	 */
	var settings = [];

	for ( var i = 1; i <= frontPagePanelCount; i++ ) {
		settings.push( {
			index: i,
			settingID: 'panel_title_display_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index + ' .panel-title' ).toggle( to );
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_text_alignment_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index ).
					removeClass( 'panel-align-center panel-align-right' ).
					addClass( 'panel-align-' + to );
			}
		} );
		settings.push( {
			index: i,
			settingID: 'panel_title_alignment_' + i,
			callback: function( to ) {
				$( '#panel-' + this.index ).
					removeClass( 'panel-title-align-center panel-title-align-right' ).
					addClass( 'panel-title-align-' + to );
			}
		} );
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
