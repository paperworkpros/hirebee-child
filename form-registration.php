<div id="primary" class="content-area row">
	<div class="large-6 push-3 columns center">
		<div class="row form-wrapper register">
			<?php if ( get_option( 'users_can_register' ) ) : ?>
				<?php appthemes_load_template( 'form-registration-main.php' ); ?>
			<?php else: ?>
				<h3><?php _e( 'User registration has been disabled.', APP_TD ); ?></h3>
			<?php endif; ?>
		</div>
	</div>
</div>
