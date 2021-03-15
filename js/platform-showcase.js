document.addEventListener( 'DOMContentLoaded', function() {
	const platformEmail = document.getElementById( 'platform-email' ).getAttribute( 'value' );
	const hiddenField   = document.getElementById( 'input_2_5' );
	const contactButton = document.getElementById( 'contact-button' );
	const formPopup     = document.getElementsByClassName( 'form-popup' )[ 0 ];
	const formPopupWrap = document.getElementsByClassName( 'form-popup-wrapper' )[ 0 ];

	hiddenField.setAttribute( 'value', platformEmail );
	formPopup.classList.add( 'hidden' );

	contactButton.addEventListener( 'click', function() {
		formPopup.classList.remove( 'hidden' );
		formPopup.classList.add( 'visible' );
	} );

	document.addEventListener( 'click', function( event ) {
		if ( contactButton !== event.target && formPopupWrap !== event.target && ! formPopupWrap.contains( event.target ) ) {
			formPopup.classList.add( 'hidden' );
			formPopup.classList.remove( 'visible' );
		}
	} );

	new SimpleLightbox( { elements: '.screenshots a' } );

} );
