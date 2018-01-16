( function( $ ) {
	// Open the overlay box after click the icon.
	$( '.hb-trigger__fullscreen--open' ).on( 'click', function( e ) {
		$( '.hb-search-el__overlay' ).addClass( 'hb-search-el__overlay--show' );
		setTimeout( function() {
			$( '#hb-search-el__overlay__search-input' ).focus();
		}, 300 );
		e.preventDefault();
	});

	// Close the overlay box after click close icon.
	$( '.hb-search-el__overlay__close' ).on( 'click', function( e ) {
		$( '.hb-search-el__overlay' ).removeClass( 'hb-search-el__overlay--show' );
		e.preventDefault();
	});
})( jQuery );