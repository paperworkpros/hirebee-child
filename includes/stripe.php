<?php


// Override stripe templates.
add_filter( 'appthemes_stripe_escrow_user_form', function () {
	return __DIR__ . '/templates/stripe-escrow-user-form.php';
} );
