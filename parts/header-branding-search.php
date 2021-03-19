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
					<a href="<?php echo get_the_hrb_site_registration_url(); ?>">Sign Up</a>
				</li>

			<?php else: ?>

				<?php $current_user = wp_get_current_user(); ?>

				<li class="hrb-gravatar">
					<?php the_hrb_user_gravatar( $current_user->ID ); ?>
				</li>

				<li class="hrb-user menu-item-has-children">
					<a title="Dashboard" href="/dashboard"><?php echo $current_user->user_firstname . ' ' . $current_user->user_lastname[0]; ?></a>

					<ul class="sub-menu">
						<li class="hrb-dashboard">
							<a href="/dashboard">Dashboard</a>
						</li>

						<li class="hrb-profile">
							<a href="<?php echo appthemes_get_edit_profile_url(); ?>">Edit Profile</a>
						</li>

						<li class="hrb-billing">
							<a href="<?php echo hrb_get_dashboard_url_for() . '/payment/'; ?>">Billing</a>
						</li>

						<li class="hrb-logout">
							<a href="<?php echo wp_logout_url(); ?>">Logout</a>
						</li>

					</ul>

				</li>

			<?php endif; ?>


		</ul>

	</div>

</div><!-- .row -->
