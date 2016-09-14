/**
 * Theme Customizer color controls.
 */

( function( api, $ ) {
	'use strict';

	// Passed by wp_localize_script()
	pnlCountColor = parseInt( pnlCountColor[0] );

	var cssTemplate = wp.template( 'counter-color-scheme' ),
		colorSchemeKeys = [
			'color_bg',
			'color_accent',
			'color_headings',
			'color_text',
		],
		colorSettings = [
			'color_bg',
			'color_accent',
			'color_headings',
			'color_text',
		];

	for ( var i = 1; i <= pnlCountColor; i++ ) {
		colorSchemeKeys.push(
			'panel_color_bg_' + i,
			'panel_color_accent_' + i,
			'panel_color_headings_' + i,
			'panel_color_text_' + i
		);
		colorSettings.push(
			'panel_color_bg_' + i,
			'panel_color_accent_' + i,
			'panel_color_headings_' + i,
			'panel_color_text_' + i
		);
	}

	api.bind( 'ready', function() {

		var currentColors = {
			'background': api( 'color_bg' )(),
			'accent':     api( 'color_accent' )(),
			'headings':   api( 'color_headings' )(),
			'text':       api( 'color_text' )(),
		};

		// Update panel background color globally.
		api( 'color_bg', function( value ) {
			value.bind( function( to ) {
				for ( var i = 1; i <= pnlCountColor; i++ ) {
					if ( api( 'panel_color_bg_' + i )() === currentColors.background ) {
						api( 'panel_color_bg_' + i ).set( to );
					}
					api.control( 'panel_color_bg_' + i ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', to )
						.wpColorPicker( 'defaultColor', to );
				}
				currentColors.background = to;
			} );
		} );

		// Update panel accent color globally.
		api( 'color_accent', function( value ) {
			value.bind( function( to ) {
				for ( var i = 1; i <= pnlCountColor; i++ ) {
					if ( api( 'panel_color_accent_' + i )() === currentColors.accent ) {
						api( 'panel_color_accent_' + i ).set( to );
					}
					api.control( 'panel_color_accent_' + i ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', to )
						.wpColorPicker( 'defaultColor', to );
				}
				currentColors.accent = to;
			} );
		} );

		// Update panel text color globally.
		api( 'color_text', function( value ) {
			value.bind( function( to ) {
				for ( var i = 1; i <= pnlCountColor; i++ ) {
					if ( api( 'panel_color_text_' + i )() === currentColors.text ) {
						api( 'panel_color_text_' + i ).set( to );
					}
					api.control( 'panel_color_text_' + i ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', to )
						.wpColorPicker( 'defaultColor', to );
				}
				currentColors.text = to;
			} );
		} );

		// Update panel headings color globally.
		api( 'color_headings', function( value ) {
			value.bind( function( to ) {
				for ( var i = 1; i <= pnlCountColor; i++ ) {
					if ( api( 'panel_color_headings_' + i )() === currentColors.headings ) {
						api( 'panel_color_headings_' + i ).set( to );
					}
					api.control( 'panel_color_headings_' + i ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', to )
						.wpColorPicker( 'defaultColor', to );
				}
				currentColors.headings = to;
			} );
		} );
	} );

	api.controlConstructor.select = api.Control.extend( {
		ready: function() {
			if ( 'color_scheme' === this.id ) {
				this.setting.bind( 'change', function( value ) {

					// Update Body Background Color.
					api( 'color_bg' ).set( colorScheme[value].colors[0] );
					api.control( 'color_bg' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[0] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[0] );

					// Update Accent Color.
					api( 'color_accent' ).set( colorScheme[value].colors[1] );
					api.control( 'color_accent' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[1] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[1] );

					// Update Headings Color.
					api( 'color_headings' ).set( colorScheme[value].colors[2] );
					api.control( 'color_headings' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[2] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[2] );

					// Update Text Color.
					api( 'color_text' ).set( colorScheme[value].colors[3] );
					api.control( 'color_text' ).container.find( '.color-picker-hex' )
						.data( 'data-default-color', colorScheme[value].colors[3] )
						.wpColorPicker( 'defaultColor', colorScheme[value].colors[3] );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		var scheme = api( 'color_scheme' )(), css,
			colors = _.object( colorSchemeKeys, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			colors[ setting ] = api( setting )();
		});

		// Add additional colors.
		colors.color_text_light = Color( colors.color_text ).toCSS( 'rgba', 0.15 );

		for ( var i = 1; i <= pnlCountColor; i++ ) {
			colors[ 'panel_color_text_light_' + i ] = Color( colors[ 'panel_color_text' + i ] ).toCSS( 'rgba', 0.15 );
		}

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );

} ) ( wp.customize, jQuery );
