/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( api, $, window ) {
	'use strict';

	// Passed by wp_localize_script()
	counterPanelCount = parseInt( counterPanelCount[0] );

	// Adjust the preview screen when editing panels and footer message.
	api.bind( 'preview-ready', function() {

		// Hide all empty panels.
		$( '.panel-empty' ).hide();

		// Show panels if on the front page and the 'Theme Options' section is open
		api.preview.bind( 'theme-options-highlight', function( data ) {

			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'front-page' ) ) {
				return;
			}

			if ( true === data.expanded ) {
				$( '.panel-empty' ).slideDown( 200 );
			} else {
				$( '.panel-empty' ).slideUp( 200 );
			}

		} );

		// Scroll to a panel that is being edited.
		api.preview.bind( 'panel-highlight', function( data ) {

			// Only on the front page.
			if ( ! $( 'body' ).hasClass( 'front-page' ) ) {
				return;
			}

			if ( true === data.expanded ) {
				// Define variables and cache the DOM.
				var $panel = $( '#' + data.id.replace( '_', '-' ) ),
					navBarHeight = $( '#site-navigation' ).outerHeight(),
					adminBarHeight = $( '#wpadminbar' ).outerHeight(),
					offset;

				// Calculate Menu Bar and Admin Bar height.
				if ( 600 < $( window ).width() && 768 > $( window ).width() ) {
					offset = adminBarHeight - 1;
				} else {
					offset = adminBarHeight + navBarHeight - 1;
				}

				// Scroll to the current panel.
				$.scrollTo( $panel, {
					duration: 600,
					offset: { 'top': -offset }
				} );
			}
		} );

		// Scroll down when the footer message is being edited.
		api.preview.bind( 'footer-highlight', function( data ) {
			if ( true === data.expanded ) {
				// Define variables and cache the DOM.
				var $footer = $( '#colophon' );

				// Scroll to footer.
				$.scrollTo( $footer, {
					duration: 600
				} );
			}
		} );

	} );

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
	 *
	 * @type {array}
	 */
	var settings = [];

	for ( var i = 0; i <= counterPanelCount; i++ ) {
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
				$( '#panel-' + this.index ).toggleClass( 'panel-bg-fixed', ( 'fixed' === to ) );
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

} ) ( wp.customize, jQuery, window );
