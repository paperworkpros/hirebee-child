<?php

add_action( 'gform_after_submission_7', function ( $entry, $form ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	$bid = new stdClass();

	foreach ( $form['fields'] as $field ) {
		if ( ! isset( $entry[ $field['id'] ] ) ) {
			continue;
		}

		$value = $entry[ $field['id'] ];

		if ( 1 === $field['id'] ) {
			$bid->amount = (int) $value;
		}

		if ( 2 === $field['id'] ) {
			$bid->content = wp_kses_post( $value );
		}

		if ( 3 === $field['id'] ) {
			$bid->attachment = $value;
		}

		if ( 4 === $field['id'] ) {
			$bid->project_name = basename( $value );
		}

		if ( 5 === $field['id'] ) {
			$bid->project_id = (int) basename( $value );
		}
	}

	if ( ! is_int( $bid->project_id ) ) {
		return;
	}

	$current_user = wp_get_current_user();
	$comments     = get_comments( [
		'post_id'    => $bid->project_id,
		'author__in' => [ $current_user->ID ],
	] );

	/**
	 * @var $comment WP_Comment
	 */
	foreach ( $comments as $comment ) {
		if ( isset( $comment->comment_content ) && $bid->content === $comment->comment_content ) {
			return;
		}
	}

	$data = [
		'user_id'              => (int) $current_user->ID,
		'comment_author'       => $current_user->nickname,
		'comment_author_email' => $current_user->user_email,
		'comment_author_url'   => $current_user->user_url,
		'comment_post_ID'      => $bid->project_id,
		'comment_content'      => $bid->content,
		'comment_date'         => current_time( 'mysql' ),
		'comment_approved'     => 1,
		'comment_type'         => 'proposal',
		'comment_meta'         => [
			'_bid_amount'   => $bid->amount,
			'_bid_currency' => 'USD',
		],
	];

	wp_insert_comment( $data );
}, 10, 2 );
