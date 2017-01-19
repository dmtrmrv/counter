/**
 * post-navigation.js
 *
 * Shows and hides post navigation depending on the scroll position
 */

( function ( document, window, index ) {
	'use strict';

	// Return if the width is smaller than 768px.
	if ( 768 > window.innerWidth ) {
		return;
	}

	// Define variables.
	var header  = document.getElementById( 'masthead' ),
		menuBar = document.getElementById( 'site-navigation' );

	function adjustPostNav() {
		if ( window.pageYOffset >= header.offsetHeight + menuBar.offsetHeight ) {
			if ( -1 === document.body.className.indexOf( 'scrolled-passed-header' ) ) {
				document.body.className += ' scrolled-passed-header';
			}
		} else {
			if ( -1 !== document.body.className.indexOf( 'scrolled-passed-header' ) ) {
				document.body.className = document.body.className.replace( ' scrolled-passed-header', '');
			}
		}
	} 
	
	// Fire the magic on scroll event.
	window.addEventListener( 'scroll', adjustPostNav );

	// Fire the adjustment on window resize.
	window.addEventListener( 'resize', adjustPostNav );

} ( document, window, 0 ) );
