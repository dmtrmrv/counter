/**
 * stycky-navBar.js
 *
 * Shows and hides Primary Menu depending on the scroll position
 */

( function ( document, window, index ) {
	'use strict';

	// Define nav selector and a. Try to get the nav object.
	var header = document.getElementById( 'masthead' ),
		navBar = document.getElementById( 'site-navigation' );

	// Return if no menu or header found or if on mobile.
	if ( ! header || ! navBar || 768 > window.innerWidth ) {
		return;
	}

	// Define variables.
	var navBarHeight, headerHeight, scrollPos;

	// Fire the magic on scroll event.
	window.addEventListener( 'scroll', function() {
		navBarHeight = navBar.offsetHeight;
		headerHeight = header.offsetHeight - navBar.offsetHeight;
		scrollPos    = window.pageYOffset;

		if ( scrollPos > headerHeight ) {
			if ( -1 === navBar.className.indexOf( 'fixed' ) ) {
				navBar.className += ' fixed';
				header.style.paddingBottom = navBarHeight + 'px';
			}
		} else if ( scrollPos <= headerHeight ) {
			if ( -1 !== navBar.className.indexOf( 'fixed' ) ) {
				navBar.className = navBar.className.replace( ' fixed', '' );
				header.style.paddingBottom = '0';
			}
		}

	} );

} ( document, window, 0 ) );
