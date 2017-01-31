/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens
 */

( function( $ ) {
	'use strict'

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

	/**
	 * Adds dropdown toggle icon to menu items that have children.
	 */
	function initSubMenuToggles( container ) {
		// Create the button.
		var button = '<button class="dropdown-toggle" aria-expanded="false">' + screenReaderText.expand + '</button>'

		// Add the button to menu items that have children.
		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( button );

		// Add/remove toggle-related classes and attributes when clicked on the toggle.
		container.find( '.dropdown-toggle' ).click( function( e ) {
			var $this = $( this );
			e.preventDefault();
			$this.toggleClass( 'toggle-on' );
			$this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
			$this.attr( 'aria-expanded', $this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			$this.html( $this.html() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
		} );
	}

	// Initialize the dropdown-toggle.
	initSubMenuToggles( $( '.main-navigation' ) );

	/**
	 * Re-initialize the menu in customizer when it is updated.
	 */
	$( document ).on( 'customize-preview-menu-refreshed', function( e, params ) {
		if ( 'primary' === params.wpNavMenuArgs.theme_location ) {
			initSubMenuToggles( params.newContainer );

			// Re-sync expanded states from oldContainer.
			params.oldContainer.find( '.dropdown-toggle.toggle-on' ).each(function() {
				var containerId = $( this ).parent().prop( 'id' );
				$( params.newContainer ).find( '#' + containerId + ' > .dropdown-toggle' ).triggerHandler( 'click' );
			} );
		}
	} );

} )( jQuery );
