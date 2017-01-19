/*
 * Custom theme scripts.
 */

( function( $, window ) {
	// Smooth scroll to anchor adjustment.
	$( 'a[href*="#"]:not([href="#"])' ).click( function() {
		if ( location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname ) {

			var target, adminBarHeight, navbarHeight, offset, windowWidth;

			target         = $( this.hash );
			target         = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			navBarHeight   = $( '#site-navigation' ).outerHeight();
			adminBarHeight = $( '#wpadminbar' ).outerHeight();
			offset         = 0;

			if ( 600 > $( window ).width() ) {
				$( '.menu-toggle' ).trigger( 'click' );
			} else if ( 600 < $( window).width() && 768 > $( window ).width() ) {
				offset = adminBarHeight - 1;
				$( '.menu-toggle' ).trigger( 'click' );
			} else {
				offset = adminBarHeight + navBarHeight - 1;
			}

			if ( target.length ) {
				$( 'html, body' ).animate( { scrollTop: target.offset().top - offset }, 300 );
				return false;
			}
		}
	} );
} ) ( jQuery, window );
