<?php

add_filter( 'gform_pre_render_5', 'ncd_populate_category_field' );
add_filter( 'gform_pre_validation_5', 'ncd_populate_category_field' );
add_filter( 'gform_pre_submission_filter_5', 'ncd_populate_category_field' );
add_filter( 'gform_admin_pre_render_5', 'ncd_populate_category_field' );
/**
 * Add category choices to dropdown.
 *
 * @since 1.0.0
 *
 * @param array $form The form meta array.
 *
 * @return mixed
 */
function ncd_populate_category_field( $form ) {
	foreach ( $form['fields'] as $field ) {
		if ( $field->id !== 6 ) {
			continue;
		}

		$categories = get_terms(
			[
				'taxonomy'    => 'project_category',
				'post_status' => 'publish',
				'hide_empty'  => false,
			]
		);

		$choices = [];

		/**
		 * @var $category WP_Term
		 */
		foreach ( $categories as $category ) {
			$choices[] = [
				'text'  => $category->name,
				'value' => $category->name,
			];
		}

		$field->choices = $choices;
	}

	return $form;
}

add_filter( 'gform_advancedpostcreation_post_after_creation_5', function ( $post_id, $feed, $entry, $form ) {
	foreach ( $form['fields'] as $field ) {
		if ( $field->type !== 'fileupload' || ! isset( $entry[ $field->id ] ) ) {
			continue;
		}

		$files = json_decode( $entry[ $field->id ] );

		if ( ! is_array( $files ) ) {
			continue;
		}

		$file_ids      = [];
		$wp_upload_dir = wp_upload_dir();

		foreach ( $files as $file_url ) {
			$file_type = wp_check_filetype( basename( $file_url ), null );
			$parts     = explode( 'uploads/', $file_url );

			if ( ! is_array( $parts ) || ! isset( $parts[1] ) ) {
				continue;
			}

			$file_path  = $wp_upload_dir['basedir'] . '/' . $parts[1];
			$file_url   = $wp_upload_dir['baseurl'] . '/' . $parts[1];
			$attachment = [
				'guid'           => $file_url,
				'post_mime_type' => $file_type['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_url ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			];

			$attach_id  = wp_insert_attachment( $attachment, $file_path, 0 );
			$file_ids[] = $attach_id;

			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

			if ( $attach_data ) {
				wp_update_attachment_metadata( $attach_id, $attach_data );
			} else {
				echo '<div id="message" class="error"><h1>Failed to create Meta-Data</h1></div>';
			}

			wp_update_attachment_metadata( $attach_id, $attach_data );
		}

		update_post_meta( $post_id, 'files', $file_ids );
	}
}, 10, 4 );

// Add all fields merge tag.
add_filter( 'gform_custom_merge_tags', function ( $merge_tags ) {
	$merge_tags[] = [
		'label' => 'All Values',
		'tag'   => '{all_values}',
	];

	return $merge_tags;
}, 10, 1 );
