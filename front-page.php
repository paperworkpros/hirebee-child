<?php while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'parts/hero', 'cover' ); ?>

	<?php get_template_part( 'parts/how-it-works' ); ?>

	<div id="primary" class="content-area">

		<div class="row">

			<div class="columns">

				<?php do_action( 'hrb_front_loops' ); ?>

			</div>

		</div>

	</div><!-- #primary -->

	<?php get_template_part( 'parts/footer-before' ); ?>

<?php endwhile; ?>
