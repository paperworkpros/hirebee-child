<?php
$proposal_hidden = __( 'N/A', APP_TD );
?>

<tr class="single-bid">
	<td class="bidder-info">
		<span class="hrb-gravatar"><?php the_hrb_user_gravatar( $proposal->user_id, 90 ); ?></span>
		<span class="bidder-display-name"><?php the_hrb_user_display_name( $proposal->user_id ); ?></span>
		<span class="bidder-location"><i class="icon i-user-location"></i> <?php the_hrb_user_location( $proposal->user_id ); ?></span>
		<?php the_hrb_user_rating( $proposal->user_id ); ?>
		<?php $user_reviews = appthemes_get_user_total_reviews( $proposal->user_id ); ?>
	</td>
	<td class="bid-content">
		<?php echo $proposal->comment_content; ?>
	</td>
	<td class="bid-amount">
		<?php echo get_the_hrb_proposal_amount( $proposal ); ?>
		<p><?php the_hrb_proposal_posted_time_ago( $proposal ); ?></p>
		<a href="<?php echo esc_url( get_the_hrb_proposal_url( $proposal ) ); ?>" class="button secondary expand"><?php _e( 'View', APP_TD ); ?></a>
	</td>
</tr>
