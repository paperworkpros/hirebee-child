// Responsive menu.
document.addEventListener( 'DOMContentLoaded', function() {
	const navMenu  = document.getElementsByClassName( 'responsive-menu' )[ 0 ];
	const delay    = 1000;
	let throttled  = false;
	let menuToggle = document.createElement( 'button' );
	let menuVars   = {
		'breakpoint': 1140,
		'text': '☰',
		'display': 'flex',
	};

	menuToggle.classList.add( 'menu-toggle' );
	menuToggle.setAttribute( 'aria-expanded', 'false' );
	menuToggle.innerText = menuVars.text;
	navMenu.parentNode.insertBefore( menuToggle, navMenu );

	const hideShowElements = function() {
		if ( window.innerWidth < menuVars.breakpoint ) {
			menuToggle.nextElementSibling.style.display = 'none';
			menuToggle.style.display                    = menuVars.display;
		} else {
			menuToggle.nextElementSibling.style.display = menuVars.display;
			menuToggle.style.display                    = 'none';
		}
	};

	hideShowElements();

	window.addEventListener( 'resize', function() {
		if ( ! throttled ) {
			hideShowElements();
			throttled = true;

			setTimeout( function() {
				throttled = false;
			}, delay );
		}
	} );

	const toggleMenu = function() {
		if ( 'false' === this.getAttribute( 'aria-expanded' ) ) {
			this.setAttribute( 'aria-expanded', 'true' );
		} else {
			this.setAttribute( 'aria-expanded', 'false' );
		}

		if ( 'none' === this.nextElementSibling.style.display ) {
			this.nextElementSibling.style.display = menuVars.display;
		} else {
			this.nextElementSibling.style.display = 'none';
		}
	};

	menuToggle.addEventListener( 'click', toggleMenu );
} );

// Sub menu.
document.addEventListener( 'DOMContentLoaded', function() {
	const parentMenuItems = document.getElementsByClassName( 'menu-item-has-children' );

	[ ...parentMenuItems ].forEach( function( item, index ) {
		const parentMenuItem = parentMenuItems[ index ];
		const subMenu        = parentMenuItem.getElementsByClassName( 'sub-menu' )[ 0 ];

		parentMenuItem.addEventListener( 'mouseover', function() {
			subMenu.classList.add( 'visible' );
		} );

		parentMenuItem.addEventListener( 'mouseout', function() {
			subMenu.classList.remove( 'visible' );
		} );
	} );
} );

// Init lightbox.
document.addEventListener( 'DOMContentLoaded', function() {
	new SimpleLightbox( { elements: '.gallery a' } );
} );

// Platform showcase modal.
document.addEventListener( 'DOMContentLoaded', function() {
	const platformEmail = document.getElementById( 'platform-email' );

	if ( null === platformEmail ) {
		return;
	}

	const platformEmailVal = platformEmail.getAttribute( 'value' );
	const hiddenField      = document.getElementById( 'input_2_5' );
	const contactButton    = document.getElementById( 'contact-button' );
	const formPopup        = document.getElementsByClassName( 'form-popup' )[ 0 ];
	const formPopupWrap    = document.getElementsByClassName( 'form-popup-wrapper' )[ 0 ];

	hiddenField.setAttribute( 'value', platformEmailVal );
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
} );

// Add dropdown UI.
document.addEventListener( 'DOMContentLoaded', function() {
	const dropdowns = document.getElementsByClassName( 'f-dropdown' );

	if ( ! dropdowns ) {
		return;
	}

	[ ...dropdowns ].forEach( /** @param {HTMLElement} dropdown */  function( dropdown ) {
		const toggleLink = dropdown.previousSibling;
		const listItems  = dropdown.querySelectorAll( 'li' );

		if ( ! toggleLink || ! listItems ) {
			return;
		}

		dropdown.style.display  = 'none';
		dropdown.style.position = 'absolute';

		toggleLink.addEventListener( 'click', function() {
			toggleLink.classList.toggle( 'clicked' );

			if ( dropdown.style.display === 'block' ) {
				dropdown.style.display = 'none';
			} else {
				dropdown.style.display = 'block';
			}
		} );
	} );
} );

// Form preview.
document.addEventListener( 'DOMContentLoaded', function() {
	const fields  = document.querySelectorAll( '#gform_page_5_1 .gfield' );
	const preview = document.getElementsByClassName( 'form-preview' )[ 0 ];

	if ( ! fields || ! preview ) {
		return;
	}

	preview.innerHTML = '<h2>Preview</h2>';

	[ ...fields ].forEach( /** @param {HTMLElement} field */ function( field ) {
		const input = field.querySelectorAll( 'input, select, textarea' )[ 0 ];
		const label = field.querySelectorAll( 'label' )[ 0 ];

		if ( input && label ) {
			preview.innerHTML += '<strong>' + label.innerText + '</strong>';

			if ( ! input.value ) {
				preview.innerHTML += '<p>-</p>';
			} else {
				preview.innerHTML += '<p>' + input.value + '</p>';
			}
		}
	} );
} );
