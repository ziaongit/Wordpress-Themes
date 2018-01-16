/*
 * Common script for HB. For example: Fixed and Sticky Header animation.
 * Version: 5.9.7
 */
( function( $ ) {
	// Set common variables.
	var windowSel = $( window );
	var fixedSel = $( '.hb-fixed' );
	var stickySel = $( '.hb-sticky' );

	var windowHeight = windowSel.height();

	/**
	 * HELPERS LIST
	 */

	// FH - Get Header offset.
	function hbGetOffset( offset, device ) {
		$offset = 'height';
		if ( typeof offset === 'string' && offset !== 'header' ) {
			offset = Math.round( ( parseInt( offset ) / 100 ) * windowHeight );
		} else if ( typeof offset === 'number' ) {
			offset = parseInt( offset );
		} else {
			offset = $( '.hb-' + device ).height();
		}

		// Check if it's NaN or undefined.
		if ( isNaN( offset ) ) {
			offset = $( '.hb-' + device ).height();
		}

		return offset;
	}

	/**
	 * FUNCTIONS LIST
	 */

	// FH - Set height of HB container.
	function hbSetFixedHeight( selector ) {
		selector.each( function( e ) {
			var thisSel = $( this );
			if ( ! thisSel.hasClass( 'hb-overlap' ) ) {
				var childHeight = thisSel.children( '.hb-device-container' ).height();
				thisSel.height( childHeight );
			}
		});
	}

	// SH - 1. Slide Down.
	function hbSlideDown( current, offset, device, top, curHeight ) {
		var onScroll = function onScroll() {
			if ( windowSel.scrollTop() > offset ) {
			    current.css({ 'top': top });
			    current.addClass( 'hb-sticky--active' );
			} else {
				current.css({ 'top': -curHeight });
			    current.removeClass( 'hb-sticky--active' );
			}
		};

		onScroll();
		windowSel.on( 'scroll', onScroll );
	}

	// SH - 2. Lazy.
	function hbLazy( current, offset, device, top, curHeight ) {
		var lastScrollPos = 0;
		var onScroll = function onScroll() {
			var scrollPos = windowSel.scrollTop();
			if ( scrollPos > offset && scrollPos < lastScrollPos ) {
			    current.css({ 'top': top });
			    current.addClass( 'hb-sticky--active' );
			} else {
				current.css({ 'top': -curHeight });
			    current.removeClass( 'hb-sticky--active' );
			}
			lastScrollPos = scrollPos;
		};

		onScroll();
		windowSel.on( 'scroll', onScroll );
	}

	/**
	 * ACTIONS LIST
	 */

	// Action - FH - Handle all resize action.
	var resizeHeader = function resizeHeader() {
		var fixedRsz = $( '.hb-fixed' );
		if ( fixedRsz.length > 0 ) {
			hbSetFixedHeight( fixedRsz );
		}
	}

	// Action - FH - Set the height of each devices.
	if ( fixedSel.length > 0 ) {
		hbSetFixedHeight( fixedSel );
		windowSel.on( 'resize', resizeHeader );
	}

	// Actiion - SH - Play the effect for Sticky Header.
	if ( stickySel.length > 0 ) {
		stickySel.each( function( e ) {
			var current = $( this );

			// Set the offset when the sticky will be displayed.
			var offset = current.data( 'offset' );
			var device = current.data( 'device' );
			offset = hbGetOffset( offset, device );

			// Set the initial position of the sticky menu.
			var top = current.data( 'top' );
			var curHeight = current.height();
			current.css({ 'top': -curHeight });

			var effect = current.data( 'effect' );
			if ( effect == 'slide-down' ) {
				hbSlideDown( current, offset, device, top, curHeight );
			} else if ( effect == 'lazy' ) {
				hbLazy( current, offset, device, top, curHeight );
			}
		});
	}

})( jQuery );