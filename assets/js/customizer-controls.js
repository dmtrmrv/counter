/**
 * Theme Customizer enhancements for a better user experience.
 */

( function( api, $ ) {
	'use strict';

	// Number of panels passed by wp_localize_script()
	counterPanelCount = parseInt( counterPanelCount[0] );

	api.bind( 'ready', function() {
		/**
		 * Logic for toggling controls.
		 *
		 * @type {Array}
		 */
		var toggleables = [];

		/**
		 * Toggles section class.
		 *
		 * Sometimes you need to hide/show multiple controls depending on the
		 * value of another single control. For example if the Background Image
		 * for a panel is not set, there is no point in displaying background
		 * attachment, repeat, size and other backgground-related controls.
		 *
		 * This function adds or removes the class to the section in the
		 * Customizer if the value is of a passed control is set. Later you
		 * can dependant controls with CSS. The 'getting real' approach.
		 * Robust, fast and clean. That's right.
		 *
		 * @param  {object} control Control object that the class i
		 * @param  {number} value   ID of the page for the frontpage panel.
		 */
		function toggleSectionClass( control, value, className ) {
			// Parent ul that holds all list items.
			var section = $( control.container.closest( '.accordion-section-content' ) );

			section.toggleClass( className, 0 == value );
		}

		/*
		 * Loop through the panels, building the 'toggleables' array. Also
		 * hide the controls in the sectoin if the content for the panel is not
		 * set or was removed in 'panel_content_x' control.
		 */
		for ( var i = 0; i <= counterPanelCount; i++ ) {

			// Background Size in %.
			toggleables.push( {
				settingID: 'panel_bg_size_type_' + i,
				controlIDs: [ 'panel_bg_size_' + i ],
				callback: function( value ) {
					return 'percent' === value;
				}
			} );

			/**
			 * Hide all controls when content for the panel is not set.
			 */

			// Don't hide panel controls for Hero panel.
			if ( 0 !== i ) {
				// On load.
				toggleSectionClass(
					api.control( 'panel_content_' + i ),
					api.instance( 'panel_content_' + i ).get(),
					'counter-empty-panel'
				);

				// On panel content change.
				api.control( 'panel_content_' + i, function( control ) {
					control.setting.bind( function( value ) {
						toggleSectionClass( control, value, 'counter-empty-panel' );
					} );
				} );
			}

			/**
			 * Hide all background controls if no background image is set.
			 */

			// On load.
			toggleSectionClass(
				api.control( 'panel_bg_image_' + i ),
				api.instance( 'panel_bg_image_' + i ).get(),
				'counter-no-bg-panel'
			);

			// On background image change.
			api.control( 'panel_bg_image_' + i, function( control ) {
				control.setting.bind( function( value ) {
					toggleSectionClass( control, value, 'counter-no-bg-panel' );
				} );
			} );
		}

		/**
		 * Handles the toggling of controls.
		 */
		$.each( toggleables, function ( k, toggleable ) {
			api( toggleable.settingID, function( setting ) {
				$.each( toggleable.controlIDs, function( n, controlID ) {
					api.control( controlID, function( control ) {
						/**
						 * Toggles the control visibility.
						 *
						 * Shows or hides the control depending on the value
						 * of the control it depends on.
						 *
						 * @param  {mixed} value Value of the parent control.
						 */
						var visibility = function( value ) {
							control.container.toggle( toggleable.callback( value ) );
						};

						// Launch the function on the 'ready' event.
						visibility( setting.get() );

						// Launch on setting change.
						setting.bind( visibility );
					} );
				} );
			} );
		} );
	} );

	// Detect when the 'Theme Options' panel is opened or closed and send the
	// event to the preview screen.
	api.panel( 'theme_options', function( panel ) {
		panel.expanded.bind( function( isExpanding ) {
			api.previewer.send( 'theme-options-highlight', {
				expanded: isExpanding
			} );
		} );
	} );

	// Detect when the front page panel sections are opened or closed so we can
	// scroll to the panel that is being configured.
	for ( var i = 0; i <= counterPanelCount; i++ ) {
		api.section( 'panel_' + i , function( section ) {
			section.expanded.bind( function( isExpanding ) {
				api.previewer.send( 'panel-highlight', {
					expanded: isExpanding,
					id: section.id
				} );
			} );
		} );
	}

	// Detect when the 'Footer' section is opened or closed and send the
	// event to the preview screen.
	api.section( 'footer', function( section ) {
		section.expanded.bind( function( isExpanding ) {
			api.previewer.send( 'footer-highlight', {
				expanded: isExpanding
			} );
		} );
	} );

} ) ( wp.customize, jQuery );
