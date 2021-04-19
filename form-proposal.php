<?php

if ( get_user_option( 'stripe-test-connected-account-id' ) ) {
	global $wp;

	$project_id = (int) basename( $wp->request );

	gravity_form( 7, false, false );

} else {
	?>
	<div data-alert="" class="notice error alert-box radius">
		<div>Notice: You need to <a href="<?php echo home_url( 'dashboard/payments' ); ?>">connect your Stripe
				account</a> before you can apply to projects.
		</div>
		<a href="#" class="close">×</a>
	</div>
	<?php

}
