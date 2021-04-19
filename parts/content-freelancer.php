<article id="freelancer-<?php echo $user->ID; ?>" <?php hrb_user_class( HRB_FREELANCER_UTYPE, $user ); ?>>

	<div class="row">
		<div class="fr-img small-2 columns">
			<?php the_hrb_user_gravatar( $user, 350 ); ?>
			<div class="review-meta">
				<?php the_hrb_user_rating( $user, __( 'No ratings yet', APP_TD ) ); ?>
			</div>
		</div>

		<div class="small-10 columns">
			<div>
				<h2 class="user-name">
					<a href="<?php echo esc_url( $user->profile_url ) ?>" title="<?php echo esc_attr( $user->display_name ); ?>">
						<?php echo ncd_get_user_display_name( $user ); ?>
					</a>
				</h2>
				<small>(<?php echo get_user_meta( $user->ID, 'entity_type', true ); ?>)</small>
			</div>

			<p class="profile-title"><?php echo get_user_meta( $user->ID, 'profile_title', true ); ?></p>

			<div class="user-meta">
				<div>
					<?php ncd_icon( 'calendar' ); ?>
					<?php echo get_user_meta( $user->ID, 'experience', true ); ?> years experience
				</div>

				<div>
					<?php ncd_icon( 'folder-open' ); ?>
					<?php _e( 'Projects Completed:', APP_TD ); ?>
					<?php the_hrb_user_completed_projects_count( $user ); ?>
				</div>

				<div>
					<?php ncd_icon( 'map-marker-alt' ); ?>
					<?php echo get_user_meta( $user->ID, 'city', true ) . ', '; ?>
					<?php the_hrb_user_location( $user ); ?>
				</div>
			</div>

			<div class="user-skills">
				<?php the_hrb_user_skills( $user, ' ', '<span class="label">', '</span>' ); ?>
			</div>

			<div class="freelancer-description"><?php echo wp_trim_words( get_the_hrb_user_bio( $user ), 40 ); ?></div>

		</div>
	</div>

</article>
