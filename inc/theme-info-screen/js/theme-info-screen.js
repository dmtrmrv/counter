/**
 * Theme info screen tabs.
 */

( function( $ ) {
	'use strict'

	$( 'div.tp-tab-content' ).hide();
	$( 'div#getting-started' ).show();

	$( '.tp-nav-tab-wrapper a' ).click( function() {

		var tab  = $( this );
		var	wrap = tab.closest( '.tp-theme-info' );

		$( '.tp-nav-tab-wrapper a', wrap ).removeClass( 'nav-tab-active' );
		$( 'div.tp-tab-content', wrap ).hide();
		$( 'div' + tab.attr( 'href' ), wrap ).show();
		tab.addClass( 'nav-tab-active' );

		return false;
	} );

} ) ( jQuery );
