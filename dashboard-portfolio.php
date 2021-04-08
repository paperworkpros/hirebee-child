<h2>Edit Portfolio</h2>

<?php

acf_form_head();

$user = wp_get_current_user();

acf_form( [
	'field_groups'       => [ 'group_606ae4dbe8d8a' ],
	'form_attributes'    => [
		'method' => 'POST',
		'action' => admin_url( "admin-post.php" ),
	],
	'html_before_fields' => sprintf(
		'<input type="hidden" name="action" value="ncd_save_profile_form">
    <input type="hidden" name="user_id" value="user_%s">',
		$user->ID
	),
	'html_submit_button' => '<button type="submit" class="acf-button button button-primary button-large" value="Update Profile">Update Portfolio</button>',
	'post_id'            => "user_{$user->ID}",
	'form'               => true,
] );
?>
