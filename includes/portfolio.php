<?php

add_action( 'appthemes_before_sidebar_widgets', function ( $location ) {
	$user_role = wp_get_current_user()->roles[0];
	if ( 'dashboard' === $location && ( 'administrator' === $user_role || 'freelancer' === $user_role ) ) {
		?>
		<aside class="user-portfolio">
			<a href="/dashboard/portfolio">Edit Portfolio</a>
		</aside>
		<?php
	}
} );

add_action( 'admin_post_ncd_save_profile_form', function () {
	if ( ! isset( $_REQUEST['user_id'] ) ) {
		return;
	}

	do_action( 'acf/save_post', $_REQUEST['user_id'] );

	wp_redirect( add_query_arg( 'updated', 'success', wp_get_referer() ) );
	exit;
} );


// Add custom pages to user dashboard.
add_filter( 'hrb_dashboard_pages', function ( $permalinks ) {
	$curent_user = wp_get_current_user();
	$user_role   = isset( $curent_user->roles[0] ) ? $curent_user->roles[0] : 'guest';

	if ( 'freelancer' === $user_role || 'administrator' === $user_role ) {
		$permalinks['portfolio'] = [
			'name'      => 'Portfolio',
			'permalink' => 'portfolio',
		];
	}

	return $permalinks;
}, 10, 1 );
