<?php


// Setup theme.
add_action( 'init', function () {

	// Head optimizations.
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link' );
	remove_action( 'wp_head', 'start_post_rel_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_head', 'wp_resource_hints', 2 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	add_action( 'wp_footer', function () {
		wp_dequeue_script( 'wp-embed' );
	} );

	add_action( 'widgets_init', function () {
		global $wp_widget_factory;
		remove_action( 'wp_head', [
			$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
			'recent_comments_style',
		] );
	} );

	// Remove hirebee attachments, use our own.
	remove_theme_support( 'app-media-manager' );

	// Custom logo size.
	add_theme_support( 'custom-logo', [
		'height'      => 100,
		'width'       => 356,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// Enable featured images for projects.
	// add_post_type_support( 'project', 'thumbnail' );

	// Home page customization.
	add_filter( 'hrb_background_cover', function () {
		return 'class="hero-section"';
	} );

	// Replace strings.
	$replacements = [
		'FREELANCER'                => 'DEVELOPER',
		'Freelancer'                => 'Developer',
		'freelancer'                => 'developer',
		'Top Freelancers'           => 'Top No-Code Developers',
		'Find Work'                 => 'Available Projects',
		'Proposal'                  => 'Bid',
		'proposal'                  => 'bid',
		' :: '                      => ': ',
		'Email shared in projects:' => ncd_get_icon('envelope'),
	];

	foreach ( $replacements as $original => $replacement ) {
		\add_filter( 'gettext', function ( $string, $text, $domain ) use ( $original, $replacement ) {
			if ( APP_TD === $domain && \strpos( $text, $original ) !== false ) {
				$string = \str_replace( $original, $replacement, $text );
			}

			return $string;
		}, 10, 3 );
	}
}, 0 );
