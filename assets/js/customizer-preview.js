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

	// Footer text.
	api( 'footer_text', function( value ) {
		value.bind( function( to ) {
			var date = new Date(),
				year = date.getFullYear();
			to = to.replace( '[year]', year );
			to = !to ? defaultFooterMsg[0] : to;
			$( '.site-info' ).text('').append( to );
		} );
	} );

	// Check of we already have inline styles.
	var $styleColor  = $( '#counter-style-color-inline-css' ),
		$stylePanels = $( '#counter-style-panels-inline-css' );

	if ( ! $styleColor.length ) {
		$styleColor = $( 'head' ).append( '<style type="text/css" id="counter-style-color-inline-css" />' ).find( '#counter-style-color-inline-css' );
	}

	if ( ! $stylePanels.length ) {
		$stylePanels = $( 'head' ).append( '<style type="text/css" id="counter-style-panels-inline-css" />' ).find( '#counter-style-panels-inline-css' );
	}

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			$styleColor.html( css );
		} );
	} );

	// Panel spacings CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-panel-spacings-css', function( css ) {
			$stylePanels.html( css );
		} );
	} );

	/**
	 * Updates entry meta items.
	 *
	 * @param  {string} to Comma-separated list of entry meta items.
	 */
	function counterRefreshPostMeta( to ) {
		if ( '' !== to ) {
			list = to.split( ',' );
			$( '.entry-meta' ).each( function() {
				$( this ).show();
				$( this ).find( '.entry-meta-item' ).each( function() {
					$( this ).removeClass( 'last' );
					$( this ).toggle( -1 !== list.indexOf( this.classList[1] ) );
				} );
				$( this ).find( '.entry-meta-item:visible' ).last().addClass( 'last' );
			} );
		} else {
			$( '.entry-meta' ).hide();
		}
	}

	// Update entry meta items on load.
	api.bind( 'ready', _.defer( function() {
		if ( api( 'entry_meta_items' ) ) {
			// Get current value of entry meta items.
			var items = api( 'entry_meta_items' ).get().join();

			// Update entry meta on page load.
			counterRefreshPostMeta( items );

			// Also update when Jetpack loads next set of posts.
			$( document.body ).on( 'post-load', function() {
				counterRefreshPostMeta( items );
			} );
		}
	} ) );

	// Update entry meta items on option change.
	api( 'entry_meta_items', function( value ) {
		value.bind( function( to ) {
			counterRefreshPostMeta( to );
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
