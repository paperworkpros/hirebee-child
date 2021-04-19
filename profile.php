<div id="primary" class="content-area row">
	<div id="main" class="large-8 columns user-profile">
		<div class="row profile">

			<div class="fr-img small-2 columns">
				<?php the_hrb_user_gravatar( $profile_author->ID, 175, '', '' ); ?>
				<div class="review-meta">
					<?php the_hrb_user_rating( $profile_author->ID, __( 'No ratings yet', APP_TD ) ); ?>
				</div>
				<a href="/bid" class="button button-outline button-small invite-to-bid">Invite to Bid</a>
			</div>

			<div class="small-10 columns user-info">

				<div>
					<h2 class="user-name"><?php echo ncd_get_user_display_name( $profile_author ); ?></h2>
					<span class="location"><?php echo file_get_contents( __DIR__ . '/svg/map-marker.svg' ); ?><?php echo get_user_meta( $profile_author->ID, 'city', true ) . ', '; ?><?php the_hrb_user_location( $profile_author->ID ); ?></span>
				</div>

				<p class="profile-title"><?php echo get_user_meta( $profile_author->ID, 'profile_title', true ); ?></p>

				<div class="user-meta">
					<div>
						<?php echo get_user_meta( $profile_author->ID, 'experience', true ); ?> years experience
					</div>

					<div>
						<?php _e( 'Projects Completed:', APP_TD ); ?>
						<?php the_hrb_user_completed_projects_count( $profile_author ); ?>
					</div>
				</div>

				<div class="user-skills">
					<?php the_hrb_user_skills( $profile_author, ' ', '<span class="label">', '</span>' ); ?>
				</div>

				<div class="user-description"><?php the_hrb_user_bio( $profile_author ); ?></div>

				<?php
				$portfolio_items = get_user_meta( $profile_author->ID, 'portfolio_items', true );

				if ( is_array( $portfolio_items ) ) : ?>
				<h3>Portfolio</h3>
				<div class="user-portfolio gallery">
					<?php foreach ( $portfolio_items as $portfolio_item ) : ?>
						<a class="portfolio-item" href="<?php echo wp_get_attachment_image_url( $portfolio_item, 'full', false ); ?>">
							<?php
							echo wp_get_attachment_image(
								$portfolio_item,
								'full',
								false,
								[
									'class' => 'portfolio-image',
								]
							);
							?>
						</a>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="user-content-tabs row">
			<div class="section-container auto section-tabs" data-section data-options="deep_linking: true">

				<?php if ( $projects_owned && $projects_owned->have_posts() ) : ?>

					<section class="services-current <?php echo empty( $active ) ? $active = 'active' : ''; ?>">

						<p class="title" data-section-title>
							<a href="#projects-employer"><?php _e( 'Projects', APP_TD ) ?></a></p>

						<div class="content" data-section-content>
							<?php appthemes_load_template( 'profile-section-projects.php', [
								'projects' => $projects_owned,
								'relation' => 'employer',
							] ); ?>
						</div>

					</section>

				<?php endif; ?>

				<?php if ( $projects_participant && $projects_participant->have_posts() ) : ?>

					<section class="services-current <?php echo empty( $active ) ? $active = 'active' : ''; ?>">

						<p class="title" data-section-title>
							<a href="#projects-worker"><?php _e( 'Awarded Projects', APP_TD ) ?></a></p>

						<div class="content" data-section-content>
							<?php appthemes_load_template( 'profile-section-projects.php', [
								'projects' => $projects_participant,
								'relation' => 'worker',
							] ); ?>
						</div>

					</section>

				<?php endif; ?>

				<section class="services-current <?php echo empty( $active ) ? $active = 'active' : ''; ?>">

					<p class="title" data-section-title><a href="#reviews"><?php _e( 'Reviews', APP_TD ); ?></a></p>

					<div class="content" data-section-content>
						<?php appthemes_load_template( 'profile-section-reviews.php', [ 'reviews' => $reviews ] ); ?>
					</div>

				</section>

				<?php if ( $user_posts->have_posts() ) : ?>

					<section class="services-current <?php echo empty( $active ) ? $active = 'active' : ''; ?>">

						<p class="title" data-section-title><a href="#posts"><?php _e( 'Posts', APP_TD ); ?></a></p>

						<div class="content" data-section-content>
							<?php appthemes_load_template( 'profile-section-posts.php', [ 'user_posts' => $user_posts ] ); ?>
						</div>

					</section>

				<?php endif; ?>

				<?php do_action( 'hrb_profile_tabs', $profile_author, $active ); ?>

			</div>
		</div>
	</div>
</div>
