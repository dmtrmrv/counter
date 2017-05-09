/**
 * navigation.js
 *
 * Primary navigation enhancements.
 */

/**
 * Set of primary navigation enhancements:
 * - Adds dropdown toggle buttons and aria and role attributes.
 * - Introduces toggle functionality.
 * - Handles :focus nicely.
 */
( function( $ ) {
	'use strict'

	// Cache the DOM.
	var $header = $( '#masthead' ),
		$nav = $header.find( '#site-navigation' ),
		$navUl = $nav.find( '#primary-menu' ),
		$navItemHasSubMenu = $navUl.find( '.menu-item-has-children' ),
		$navItemHasSubMenuLink = $navUl.find( '.menu-item-has-children > a' ),
		$navLink = $nav.find( 'a' ),
		$navLinkEmpty = $nav.find( 'a[href="#"]' ),
		$navLinkFirst = $navLink.first(),
		$navLinkLast = $navLink.last(),
		$navToggle = $header.find( '#site-navigation-toggle' );

	// Initial markup updates.
	markupUpdate();

	// Bind events.
	$navLink.on( 'focusin focusout', toggleNavItemFocus );
	$navToggle.on( 'click', toggleNav );
	$( window ).on( 'scroll', stickNav );
	$( document ).on( 'customize-preview-menu-refreshed', reinitNav );
	$( document ).keyup( escClose );
	$navToggle.on( 'keydown', resetNavFocusFirst );
	$navLink.on( 'keydown', resetFocusLast );
	$navLinkEmpty.on( 'click', toggleSubNavEmptyLink );
	$nav.on( 'keydown', 'button', resetFocusLast );

	/**
	 * Add 'role' and 'aria' attributes.
	 */
	function markupUpdate() {
		// Set 'role' attribute to 'navigation' on the <nav> element.
		$nav.attr( 'role', 'navigation' );

		// Set 'aria-expanded' attribute to 'false' on the <ul> element.
		$navUl.attr( 'aria-expanded', false );

		// Set 'aria-haspopup' attribute to 'true' on <li> elements with submenus.
		$navItemHasSubMenu.attr( 'aria-haspopup', true );

		// Add the dropdown toggle element to menu items that have children.
		$navItemHasSubMenuLink.after( $( '<button></button>' )
			.attr( 'aria-expanded', false )
			.addClass( 'dropdown-toggle' )
			.html( counterScreenReaderText.expand )
			.on( 'click', toggleSubNav )
		);
	}

	/**
	 * Menu toggle functionality.
	 */
	function toggleNav() {
		if ( $nav.hasClass( 'toggled' ) ) {
			closeNav();
		} else {
			openNav();
		}
	}

	/**
	 * Add/Remove toggle-related classes and attributes when clicked on the toggle.
	 */
	function toggleSubNav( e ) {
		var $this = $( e.target );
		$this.toggleClass( 'toggle-on' );
		$this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
		$this.attr( 'aria-expanded', $this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		$this.html( $this.html() === counterScreenReaderText.expand ? counterScreenReaderText.collapse : counterScreenReaderText.expand );
	}

	function toggleSubNavEmptyLink( e ) {
		e.preventDefault();
		var $this = $( e.target ),
			$dropdownToggle = $this.next( '.dropdown-toggle' );

		if ( $dropdownToggle ) {
			$dropdownToggle.trigger( 'click' );
		}
	}

	/**
	 * Sets or removes 'focus' class on an <li> element.
	 */
	function toggleNavItemFocus( e ) {
		$( e.target ).parentsUntil( '.nav-menu', 'li' ).toggleClass( 'focus' );
	}

	/**
	 * Re-initialize the menu in the Customizer.
	 */
	function reinitNav( e, params ) {
		if ( 'primary' === params.wpNavMenuArgs.theme_location ) {

			// Variables needed to recreate dropdown toggles.
			var $newNav = $( params.newContainer ),
				$newNavItemHasSubMenuLink = $newNav.find( '.menu-item-has-children > a' );

			// Re-create dropdown toggles.
			$newNavItemHasSubMenuLink.after( $( '<button></button>' )
				.attr( 'aria-expanded', false )
				.addClass( 'dropdown-toggle' )
				.html( counterScreenReaderText.expand )
				.on( 'click', toggleSubNav )
			);

			// Re-sync expanded states.
			params.oldContainer.find( '.dropdown-toggle.toggle-on' ).each( function() {
				var containerId = $( this ).parent().prop( 'id' );
				$( params.newContainer ).find( '#' + containerId + ' > .dropdown-toggle' ).triggerHandler( 'click' );
			} );
		}
	}

	/**
	 * Opens the menu.
	 */
	function openNav() {
		$nav.addClass( 'toggled' );
		$navToggle.addClass( 'toggled' );
		$navUl.attr( 'aria-expanded', true );
		$navToggle.text( counterScreenReaderText.close );
	}

	/**
	 * Closes the menu.
	 */
	function closeNav() {
		$nav.removeClass( 'toggled' );
		$navToggle.removeClass( 'toggled' );
		$navUl.attr( 'aria-expanded', false );
		$navToggle.text( counterScreenReaderText.menu );
	}

	/**
	 * Closes the menu on 'esc' key press.
	 */
	function escClose( e ) {
		if ( e.keyCode === 27 ) {
			closeNav();
		}
	}

	/**
	 * Returns the list of all focusable elements in the menu. Aware of state of
	 * the submenus. We can't cache it at the beginning because dropdown toggles
	 * are added later and because the state of submenus may vary.
	 */
	function getFocusables() {
		return $nav.find( '#primary-menu > li > a, #primary-menu > li > .dropdown-toggle, .sub-menu.toggled-on > li > a, .sub-menu.toggled-on > li > .dropdown-toggle' );
	}

	/**
	 * Moves the focus to the hamburger icon.
	 */
	function resetFocusLast( e ) {
		if ( 9 == e.keyCode && ! e.shiftKey && 768 > $( window ).width() ) {
			var $current = $( e.target ),
				$focusables = getFocusables(),
				$lastFocusable = $focusables.last();

			if ( $current.is( $lastFocusable ) ) {
				e.preventDefault();
				$navToggle.focus();
			}
		}
	}

	/**
	 * Moves the focus to the last focusable element in the menu if tab and
	 * shift keys were pressed together.
	 */
	function resetNavFocusFirst( e ) {
		if ( 9 == e.keyCode && e.shiftKey && 768 > $( window ).width() ) {
			e.preventDefault();
			var $focusables = getFocusables();
			$focusables.last().focus();
		}
	}

	/**
	 * Makes the menu sticky.
	 */
	function stickNav() {
		// Quick return if on a small screen.
		if ( 768 > $( window ).width() ) {
			return;
		}

		// Variables.
		var navHeight = $nav.outerHeight(),
			headerHeight = $header.outerHeight(),
			stickStart = headerHeight - navHeight;

		// Magic.
		if ( $( window ).scrollTop() > stickStart ) {
			$nav.addClass( 'fixed' );
			$header.css( 'padding-bottom', navHeight );
		} else if ( $( window ).scrollTop() <= headerHeight ) {
			$nav.removeClass( 'fixed' );
			$header.removeAttr( 'style' );
		}
	}

} )( jQuery );
