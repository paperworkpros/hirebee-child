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

add_filter( 'gform_replace_merge_tags', function ( $text ) {
	global $wp;

	if ( ! $wp ) {
		return $text;
	}

	$project_id  = (int) basename( $wp->request );
	$budget      = get_post_meta( $project_id, '_hrb_budget_price', true );
	$budget_type = get_post_meta( $project_id, '_hrb_budget_type', true );
	$text        = str_replace( '{budget}', $budget, $text );

	if ( 'fixed' === $budget_type ) {
		$text = str_replace( '{budget_type}', 'Firm Fixed Price', $text );
	}

	if ( 'hourly' === $budget_type ) {
		$text = str_replace( '{budget_type}', 'Estimate (pay per hour)', $text );
	}

	return $text;
}, 10, 7 );

add_filter( 'gform_pre_render_7', 'ncd_set_default_proposal_type' );
add_filter( 'gform_pre_validation_7', 'ncd_set_default_proposal_type' );
add_filter( 'gform_pre_submission_filter_7', 'ncd_set_default_proposal_type' );
add_filter( 'gform_admin_pre_render_7', 'ncd_set_default_proposal_type' );
/**
 * Set default proposal type for application form.
 *
 * @since 1.0.0
 *
 * @param $form
 *
 * @return mixed
 */
function ncd_set_default_proposal_type( $form ) {
	foreach ( $form['fields'] as &$field ) {
		if ( 'radio' === $field->type && isset( $field['choices'] ) ) {
			global $wp;
			$project_id  = (int) basename( $wp->request );
			$budget_type = get_post_meta( $project_id, '_hrb_budget_type', true );
			$choices     = [];

			foreach ( $field->choices as $choice ) {
				if ( $budget_type === $choice['value'] ) {
					$choice['isSelected'] = true;
				}

				$choices[] = $choice;
			}

			$field->choices = $choices;
		}
	}

	return $form;
}
