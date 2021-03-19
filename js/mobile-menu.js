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
