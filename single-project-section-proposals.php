<?php
global $post, $current_user;
?>

<table class="proposals-list">

	<tr class="bid-headings">
		<th>Developer Bidding</th>
		<th class="bid-details">Bid Details</th>
		<th>Bid Amount</th>
	</tr>

	<?php hrb_before_post_section( HRB_PROJECTS_PTYPE, 'proposals' ); ?>

	<?php if ( ! empty( $proposals ) && is_user_logged_in() ) : ?>

		<?php foreach ( $proposals as $proposal ) : ?>

			<?php if ( $post->post_author === $current_user->ID || (int) $proposal->user_id === $current_user->ID ) : ?>

				<?php appthemes_load_template( 'parts/content-proposal.php', [ 'proposal' => $proposal ] ); ?>

			<?php endif; ?>


		<?php endforeach; ?>

	<?php elseif ( is_user_logged_in() ) : ?>

		<h5 class="no-results"><?php echo __( 'No Proposals Yet.', APP_TD ) . ( ( current_user_can( 'add_bid', get_the_ID() ) ? ' ' . sprintf( __( '<a href="%s">Apply to Project.</a>', APP_TD ), esc_url( get_the_hrb_apply_to_url() ) ) : '' ) ); ?></h5>

	<?php else : ?>

		<h5 class="no-results"><?php printf( __( "<a href='%s'>Login</a> to view this project's proposals.", APP_TD ), wp_login_url( get_permalink() . '#proposals' ) ); ?></h5>

	<?php endif; ?>

	<?php hrb_after_post_section( HRB_PROJECTS_PTYPE, 'proposals' ); ?>

</table>
