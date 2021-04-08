<?php
/**
 * The template for displaying the header branding & search area
 *
 * @package HireBee
 * @since   1.4.0
 */
?>

<div class="row header-wrap">

	<?php the_custom_logo(); ?>

	<div class="responsive-menu">

		<form method="get" action="<?php echo esc_url( trailingslashit( home_url() ) ); ?>" class="header-search">

			<!-- <?php the_hrb_search_dropdown( [ 'name' => 'drop-search' ] ); ?>-->

			<!-- <input type="search" id="search" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', APP_TD ); ?>" name="ls" class="text search" value="<?php esc_attr( hrb_output_search_query_var( 'ls' ) ); ?>"/>

			<button type="submit" id="search-submit" class="search-button hide">Search</button>-->

			<input type="hidden" id="st" name="st" value="<?php echo esc_attr( hrb_get_search_query_var( 'st' ) ? hrb_get_search_query_var( 'st' ) : HRB_PROJECTS_PTYPE ); ?>">

		</form>

		<?php
		wp_nav_menu( [
			'menu_id'        => 'navigation',
			'theme_location' => 'header',
			'items_wrap'     => '<ul id="%1$s" class="header-%2$s">%3$s</ul>',
			'container'      => false,
			'fallback_cb'    => false,
		] );
		?>

		<ul id="profile-links" class="header-menu">

			<?php if ( ! is_user_logged_in() ) : ?>

				<li class="hrb-login">
					<a href="<?php echo get_the_hrb_site_login_url(); ?>">Login</a>
				</li>

				<li class="hrb-register">
					<a href="/sign-up" class="button button-small">Sign Up</a>
				</li>

			<?php else: ?>

				<?php $current_user = wp_get_current_user(); ?>

				<li class="hrb-gravatar">
					<?php the_hrb_user_gravatar( $current_user->ID ); ?>
				</li>

				<li class="hrb-user menu-item-has-children">
					<a title="Dashboard" href="/dashboard"><?php echo ncd_get_user_display_name( $current_user ); ?></a>

					<ul class="sub-menu">

						<?php

						$menu_items = [
							[
								'href' => '/dashboard',
								'text' => 'Dashboard',
								'role' => 'all',
							],
							[
								'href' => '/dashboard/profile',
								'text' => 'Edit Profile',
								'role' => 'all',
							],
							[
								'href' => '/post-a-project',
								'text' => 'Post a Project',
								'role' => 'employer',
							],
							[
								'href' => '/dashboard/projects',
								'text' => 'My Projects',
								'role' => 'employer',
							],
							[
								'href' => '/dashboard/payments',
								'text' => 'Billing',
								'role' => 'freelancer',
							],
							[
								'href' => wp_logout_url(),
								'text' => 'Log out',
								'role' => 'all',
							],
						];


						foreach ( $menu_items as $menu_item ) :
							if ( 'all' === $menu_item['role'] || in_array( 'administrator', $current_user->roles ) || in_array( $menu_item['role'], $current_user->roles ) ) : ?>
								<li class="hrb-logout">
									<a href="<?php echo $menu_item['href']; ?>">
										<?php echo $menu_item['text']; ?>
									</a>
								</li>
							<?php endif;
						endforeach; ?>


					</ul>

				</li>

			<?php endif; ?>


		</ul>

	</div>

</div><!-- .row -->
