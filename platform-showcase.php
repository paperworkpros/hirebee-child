<?php
/**
 * Template Name: Platform Showcase
 */
wp_enqueue_style(
	'platform-showcase',
	get_stylesheet_directory_uri() . '/css/platform-showcase.css',
	[],
	filemtime( __DIR__ . '/css/platform-showcase.css' )
);

get_header();
?>

	<div class="row">
		<div class="columns">

			<?php
			$query = new WP_Query( [
				'post_type' => 'platform',
			] );

			if ( $query->have_posts() ) : ?>

				<section class="platform-grid clear">

					<?php while ( $query->have_posts() ) : $query->the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( 'platform-card' ); ?>>

							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="card-image-link">
								<?php the_post_thumbnail( 'large' ); ?>
							</a>

							<div class="card-inner">

								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="card-title">
									<h2><?php the_title(); ?></h2>
								</a>

								<?php
								$content         = get_post_meta( get_the_ID(), 'description', true );
								$trimmed_content = wp_trim_words( $content, 20, null );
								echo $trimmed_content;
								?>
							</div>
						</article>

					<?php endwhile; ?>

				</section>

			<?php endif;
			wp_reset_postdata();
			?>
		</div>
	</div>

<?php
get_footer();

