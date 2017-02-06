/**
 * navigation.js
 *
 * Primary navigation enhancements.
 */

( function( $ ) {
	'use strict'

	// Define variables.
	var container, containerHeight, header, headerHeight, links, menu, menuToggle, subMenus, scrollPos;

	// Get the header and the menu container.
	header = document.getElementById( 'masthead' ),
	container = document.getElementById( 'site-navigation' );

	// If no header or container, return early.
	if ( ! header || ! container ) {
		return;
	}

	// Get the menu list and the toggle button
	menu = container.getElementsByTagName( 'ul' )[0];
	menuToggle = document.getElementById( 'site-navigation-toggle' );

	// Hide menu toggle if the menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		menuToggle.style.display = 'none';
		return;
	}

	menu.setAttribute( 'aria-expanded', 'false' );
	if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
		menu.className += ' nav-menu';
	}

	menuToggle.onclick = function() {
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			menuToggle.className    = menuToggle.className.replace( ' toggled', '' );
			menu.setAttribute( 'aria-expanded', 'false' );
		} else {
			container.className += ' toggled';
			menuToggle.className += ' toggled';
			menu.setAttribute( 'aria-expanded', 'true' );
		}
	};

	// Get all the link elements within the menu.
	links = menu.getElementsByTagName( 'a' );
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
		// Cache 'this'.
		var self = this;

		// Walk up through ancestors until we hit 'nav-menu' class.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// Toggle the 'focus' class on 'li' elements.
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
		// Create the dropdown toggle string.
		var dropdownToggle = '<button class="dropdown-toggle" aria-expanded="false">' + counterScreenReaderText.expand + '</button>'

		// Add the dropdown toggle to menu items that have children.
		container.find( '.menu-item-has-children > a, .page_item_has_children > a' ).after( dropdownToggle );

		// Add/remove toggle-related classes and attributes when clicked on the toggle.
		container.find( '.dropdown-toggle' ).click( function( e ) {
			var $this = $( this );
			e.preventDefault();
			$this.toggleClass( 'toggle-on' );
			$this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
			$this.attr( 'aria-expanded', $this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
			$this.html( $this.html() === counterScreenReaderText.expand ? counterScreenReaderText.collapse : counterScreenReaderText.expand );
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

	/**
	 * Make the menu sticky.
	 */
	window.addEventListener( 'scroll', function() {
		containerHeight = container.offsetHeight;
		headerHeight = header.offsetHeight - container.offsetHeight;
		scrollPos = window.pageYOffset;

		if ( scrollPos > headerHeight ) {
			if ( -1 === container.className.indexOf( 'fixed' ) ) {
				container.className += ' fixed';
				header.style.paddingBottom = containerHeight + 'px';
			}
		} else if ( scrollPos <= headerHeight ) {
			if ( -1 !== container.className.indexOf( 'fixed' ) ) {
				container.className = container.className.replace( ' fixed', '' );
				header.style.paddingBottom = '0';
			}
		}
	} );

} )( jQuery );
