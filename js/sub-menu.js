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
