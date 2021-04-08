<?php

// Modify edit profile.
add_filter( 'edit_profile_url', function ( $url ) {
	if ( ! is_admin() ) {
		$url = home_url( 'dashboard/profile' );
	}

	return $url;
}, 10, 3 );

// Limit Gravity Forms countries to US & Canada only.
add_filter( 'gform_countries', function () {
	return [ 'United States', 'Canada' ];
} );

// Remove all social fields, including public email.
add_filter( 'hrb_profile_social_fields', '__return_empty_array' );

// Modify edit profile form data on save.
add_action( 'gform_after_submission_4', function ( $entry, $form ) {
	$user_id = get_current_user_id();

	foreach ( $form['fields'] as $field ) {

		// Save user skills separately.
		if ( $field->type === 'multiselect' && $field->label === 'Skills' && isset( $entry[ $field->id ] ) ) {
			$skills = json_decode( $entry[ $field->id ] );

			if ( is_array( $skills ) ) {
				delete_user_meta( $user_id, 'hrb_user_skills' );

				foreach ( $skills as $skill ) {
					$term = get_term_by( 'slug', $skill, 'project_skill' );

					add_user_meta( $user_id, 'hrb_user_skills', $term->term_id );
				}
			}
		}

		// Upload avatar on edit profile form submission.
		if ( $field->type === 'fileupload' && isset( $entry[ $field->id ] ) ) {
			$fileurl        = $entry[ $field->id ];
			$parent_post_id = 0;
			$filetype       = wp_check_filetype( basename( $fileurl ), null );
			$wp_upload_dir  = wp_upload_dir();
			$parts          = explode( 'uploads/', $entry[ $field->id ] );

			if ( ! is_array( $parts ) || ! isset( $parts[1] ) ) {
				continue;
			}

			$filepath   = $wp_upload_dir['basedir'] . '/' . $parts[1];
			$fileurl    = $wp_upload_dir['baseurl'] . '/' . $parts[1];
			$attachment = [
				'guid'           => $fileurl,
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $fileurl ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			];

			$attach_id = wp_insert_attachment( $attachment, $filepath, $parent_post_id );

			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			if ( $attach_data = wp_generate_attachment_metadata( $attach_id, $filepath ) ) {
				wp_update_attachment_metadata( $attach_id, $attach_data );
			} else {
				echo '<div id="message" class="error"><h1>Failed to create Meta-Data</h1></div>';
			}

			wp_update_attachment_metadata( $attach_id, $attach_data );
			update_user_meta( $user_id, '_app_gravatar', [ $attach_id ] );
		}
	}
}, 10, 2 );

// Show avatar on edit profile form.
add_filter( 'gform_field_content', function ( $field_content, $field ) {
	if ( ! is_admin() && $field->type === 'fileupload' && $field->id === 17 ) {
		$field_content = str_replace(
			'</label>',
			// Uses get_avatar instead or hrb function to avoid link.
			'<br>' . get_avatar( get_current_user_id() ) . '</label>',
			$field_content
		);
	}

	return $field_content;
}, 10, 2 );

add_filter( 'gform_pre_render_4', 'ncd_populate_skills_field' );
add_filter( 'gform_pre_validation_4', 'ncd_populate_skills_field' );
add_filter( 'gform_pre_submission_filter_4', 'ncd_populate_skills_field' );
add_filter( 'gform_admin_pre_render_4', 'ncd_populate_skills_field' );
/**
 * Add skills choices to dropdown.
 *
 * @since 1.0.0
 *
 * @param array $form The form meta array.
 *
 * @return mixed
 */
function ncd_populate_skills_field( $form ) {
	foreach ( $form['fields'] as $field ) {
		if ( $field->id === 18 && $field->type === 'multiselect' ) {
			$field->choices = [];
			$skills         = get_terms(
				[
					'taxonomy'   => 'project_skill',
					'hide_empty' => false,
				]
			);

			/**
			 * @var $skill WP_Term
			 */
			foreach ( $skills as $skill ) {
				$field->choices[] = [
					'text'  => $skill->name,
					'value' => $skill->slug,
				];
			}
		}
	}

	return $form;
}

// Add custom pages to user dashboard.
add_filter( 'hrb_dashboard_pages', function ( $permalinks ) {
	$permalinks['profile'] = [
		'name'      => 'Profile',
		'permalink' => 'profile',
	];

	return $permalinks;
}, 10, 1 );


// Set minimum hourly rate.
add_filter( 'hrb_profile_base_fields', function ( $fields ) {
	foreach ( $fields as $field => $args ) {
		if ( isset( $args['name'] ) && 'hrb_rate' === $args['name'] ) {
			$fields[ $field ]['extra'] = [
				'size'  => 3,
				'class' => 'short-field',
				'type'  => 'number',
				'min'   => 30,
			];
		}

		if ( isset( $args['name'] ) && 'hrb_currency' === $args['name'] ) {
			unset( $fields[ $field ] );
		}
	}

	return $fields;
}, 10, 1 );

// Add user role merge tag.
add_filter( 'gform_custom_merge_tags', function ( $merge_tags ) {
	$merge_tags[] = [
		'label' => 'User Role',
		'tag'   => '{user_role}',
	];

	return $merge_tags;
}, 10, 1 );

add_filter( 'gform_replace_merge_tags', 'ncd_replace_user_role_merge_tag', 10, 1 );
add_filter( 'gform_field_content', 'ncd_replace_user_role_merge_tag', 10, 1 );
/**
 * Replace user role merge tag in Gravity Forms.
 *
 * @since 1.0.0
 *
 * @param string $text
 *
 * @return mixed
 */
function ncd_replace_user_role_merge_tag( $text ) {
	if ( ! is_admin() && strpos( $text, '{user_role}' ) !== false ) {
		$text = str_replace( '{user_role}', wp_get_current_user()->roles[0], $text );
	}

	return $text;
}

// Redirect to same page on edit profile submission.
add_filter( 'gform_confirmation_4', function () {
	$confirmation = [ 'redirect' => add_query_arg( 'form', 'submitted', $_SERVER['PHP_SELF'] ) ];

	return $confirmation;
} );
