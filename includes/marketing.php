<?php

// Add zendesk script to production site only.
add_action( 'wp_footer', function () {
	if ( ! ncd_string_contains( 'hirebee', home_url() ) ) {
		echo '<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=9e80a84c-d172-4c70-994f-98170c4fe19a"></script>';
	}
} );
