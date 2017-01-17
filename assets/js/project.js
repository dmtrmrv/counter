/**
 * skip-link-focus-fix.js
 *
 * Helps with accessibility for keyboard only users
 *
 * Learn more: https://git.io/vWdr2
 */

( function() {
	var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
	    is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
	    is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

	if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();

/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens
 */

( function() {
	var container, button, menu, links, subMenus;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	menu = container.getElementsByTagName( 'ul' )[0];

	button = document.getElementById( 'site-navigation-toggle' );
	if ( 'undefined' === typeof button ) {
		return;
	}

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	button.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.className    = button.className.replace( ' toggled', '' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			button.className += ' toggled';
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links    = menu.getElementsByTagName( 'a' );
	subMenus = menu.getElementsByTagName( 'ul' );

	// Set menu items with submenus to aria-haspopup="true".
	for ( var i = 0, len = subMenus.length; i < len; i++ ) {
		subMenus[i].parentNode.setAttribute( 'aria-haspopup', 'true' );
	}

	// Each time a menu link is focused or blurred, toggle focus.
	for ( i = 0, len = links.length; i < len; i++ ) {
		links[i].addEventListener( 'focus', toggleFocus, true );
		links[i].addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
	}
} )();

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
