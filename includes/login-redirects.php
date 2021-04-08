<?php


// Disable limit login attempts by Flywheel.
add_filter( 'login_errors', function ( $errors ) {
	if ( is_page_template( 'form-login.php' ) && ! is_a( $errors, 'WP_Error' ) ) {
		$errors = new WP_Error();
	}

	return $errors;
} );

// Remove button class around link on login page.
add_filter( 'register', function ( $link ) {
	return str_replace(
		'button ',
		'',
		$link
	);
}, 10, 1 );

// Modify register link URL.
add_filter( 'register_url', function ( $url ) {
	if ( ! is_admin() ) {
		$url = home_url( '/sign-up' );
	}

	return $url;
}, 10, 1 );

// Modify register link URL.
add_filter( 'register', function ( $link ) {
	if ( ! is_admin() ) {
		$link = str_replace( site_url( 'wp-login.php?action=register', 'login' ), site_url( 'sign-up', 'login' ), $link );
	}

	return $link;
} );

// Change login redirect URL.
add_filter( 'login_redirect', function ( $redirect_to, $requested_redirect_to, $user ) {
	if ( isset( $user->roles ) && in_array( $user->roles[0], [ 'freelancer', 'employer' ] ) ) {
		$redirect_to = home_url( '/dashboard' );
	}

	return $redirect_to;
}, 10, 3 );
