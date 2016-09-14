/**
 * Theme Customizer color controls.
 */

( function( api, $ ) {
	'use strict';

	// Number of panels passed by wp_localize_script()
	pnlCountSpacings = parseInt( pnlCountSpacings[0] );

	var cssTemplate = wp.template( 'counter-panel-spacings' ),
		panelSpacingSettings = [];

	for ( var i = 1; i <= pnlCountSpacings; i++ ) {
		panelSpacingSettings.push( 'panel_spacing_' + i );
	}

	// Generate the CSS.
	function updateCSS() {
		var css, spacings = {};

		// Add-in the values.
		_.each( panelSpacingSettings, function( setting ) {
			spacings[ setting ] = api( setting )();
		} );

		// Create the template.
		css = cssTemplate( spacings );

		api.previewer.send( 'update-panel-spacings-css', css );
	}

	// Update the CSS whenever a spacing is changed.
	_.each( panelSpacingSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );

} ) ( wp.customize, jQuery );
