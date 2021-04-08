<?php


// Platform showcase customizations.
add_action( 'wp', function () {
	if ( is_page( 'platform-showcase' ) ) {
		remove_action( 'hrb_content_container_top', '_hrb_content_container_top' );

		add_action( 'hrb_content_container_top', function () {
			?>
			<div class="content-header">
				<div class="row">
					<div class="columns">
						<h3>Platform Showcase</h3>
						<p>Learn more about industry-leading no-code development platforms</p>
					</div>
					<div class="columns">
						<a href="/platform-showcase-application" class="button">Platform Showcase Application</a>
					</div>
				</div>
			</div>
			<?php
		} );
	}

	if ( is_singular( 'platform' ) ) {
		remove_action( 'hrb_content_container_top', '_hrb_content_container_top' );

		add_action( 'hrb_content_container_top', function () {
			?>
			<div class="row single-platform-header">
				<div class="columns">
					<a href="/platform-showcase">← Back to all platforms</a>
				</div>
			</div>
			<?php
		} );
	}

	add_filter( 'body_class', function ( $classes ) {
		if ( is_hrb_users_archive() ) {
			$classes[] = 'user-archive';
		}

		if ( is_page( 15 ) ) {
			$classes[] = 'hrb-dashboard';
		}

		return $classes;
	} );
}, 99 );

// Register "Platform Showcase" custom post type.
add_action( 'init', function () {
	register_post_type( 'platform', [
		'labels'              => [
			'name'                  => 'Platforms',
			'singular_name'         => 'Platform',
			'menu_name'             => _x( 'Platforms', 'Admin Menu text' ),
			'add_new'               => _x( 'Add New', 'Platform' ),
			'add_new_item'          => 'Add New Platform',
			'new_item'              => 'New Platform',
			'edit_item'             => 'Edit Platform',
			'view_item'             => 'View Platform',
			'all_items'             => 'Platforms',
			'search_items'          => 'Search Platforms',
			'parent_item_colon'     => 'Parent Platform:',
			'not_found'             => 'No platforms found.',
			'not_found_in_trash'    => 'No platforms found in Trash.',
			'archives'              => 'Platform archives',
			'insert_into_item'      => 'Insert in to platform',
			'uploaded_to_this_item' => 'Uploaded to this platform',
			'filter_items_list'     => 'Filter platforms list',
			'items_list_navigation' => 'Platforms list navigation',
			'items_list'            => 'Platforms list',
		],
		'label'               => 'Platform',
		'description'         => 'Platform Description',
		'supports'            => [ 'title', 'excerpt', 'editor', 'thumbnail' ],
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-slides',
		'show_in_admin_bar'   => false,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
	] );
} );
