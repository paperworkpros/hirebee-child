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
			<?php do_action( 'hrb_before_user_nav_links' ); ?>
			<?php the_hrb_user_nav_links(); ?>
			<?php do_action( 'hrb_after_user_nav_links' ); ?>
		</ul>

	</div>

</div><!-- .row -->
