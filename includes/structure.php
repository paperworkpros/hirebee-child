<?php

// Remove unnecessary php template from body class.
add_filter( 'body_class', function ( $classes ) {
	foreach ( $classes as $index => $class ) {
		if ( ncd_string_contains( '-php', $class ) ) {
			unset( $classes[ $index ] );
		}
	}

	return $classes;
} );

// Add see all developers button to home page.
add_action( 'appthemes_after_project_loop', function () {
	if ( is_front_page() ) : ?>
		<div class="all-projects cf">
			<a href="/projects" class="button button-outline">See all Projects</a>
		</div>
	<?php endif;
} );

// Add see all developers button to home page.
add_action( 'appthemes_after_freelancer_loop', function () {
	?>
	</div>
	<div class="all-devs">
		<a href="/developers" class="button button-outline">See all Developers</a>
	<?php
} );
