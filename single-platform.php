<?php

wp_enqueue_script(
	'lightbox',
	get_stylesheet_directory_uri() . '/js/lightbox.js',
	[],
	filemtime( __DIR__ . '/js/lightbox.js' )
);

get_header();

// Custom fields.
$post_id         = get_the_ID();
$featured_image  = get_the_post_thumbnail( $post_id, 'medium' );
$description     = get_post_meta( $post_id, 'description', true );
$features        = explode( PHP_EOL, get_post_meta( $post_id, 'features', true ) );
$benefits        = explode( PHP_EOL, get_post_meta( $post_id, 'benefits', true ) );
$differentiators = explode( PHP_EOL, get_post_meta( $post_id, 'differentiators', true ) );
$screenshots     = get_post_meta( $post_id, 'screenshots', true );
$testimonial     = get_post_meta( $post_id, 'testimonial', true );
$author          = get_post_meta( $post_id, 'testimonial_author', true );
$address         = get_post_meta( $post_id, 'address', true );
$phone           = get_post_meta( $post_id, 'phone', true );
$email           = get_post_meta( $post_id, 'email', true );
$public_email    = get_post_meta( $post_id, 'public_email', true );
$website         = get_post_meta( $post_id, 'website', true );
$affiliate       = get_post_meta( $post_id, 'affiliate_link', true );
$url             = $affiliate ? $affiliate : $website;

?>

	<div class="row">
		<div class="columns d-flex">
			<div class="platform-sidebar large-4 columns">
				<div class="contact-info">
					<?php the_post_thumbnail( 'medium' ); ?>
					<p>
						<?php echo file_get_contents( __DIR__ . '/svg/map-marker.svg' ); ?>
						<?php echo $address; ?>
					</p>
					<p>
						<?php echo file_get_contents( __DIR__ . '/svg/phone.svg' ); ?>
						<?php echo $phone; ?>
					</p>
					<p>
						<?php echo file_get_contents( __DIR__ . '/svg/envelope.svg' ); ?>
						<?php echo $public_email; ?>
					</p>
					<p>
						<?php echo file_get_contents( __DIR__ . '/svg/laptop.svg' ); ?>
						<a href="<?php echo $url; ?>" target="_blank">
							<?php echo $website; ?>
						</a>
					</p>
					<a href="#contact" id="contact-button" class="button">Contact <?php the_title(); ?></a>
				</div>

				<div class="screenshots gallery">
					<h6>Images</h6>
					<br>
					<?php foreach ( $screenshots as $screenshot ) : ?>
						<a href="<?php echo wp_get_attachment_image_url( $screenshot, 'large' ); ?>" title="<?php echo wp_get_attachment_caption( $screenshot ); ?>">
							<?php echo wp_get_attachment_image( $screenshot, 'medium' ); ?>
						</a>
					<?php endforeach; ?>
				</div>

			</div>
			<div class="platform-content large-8 columns">
				<h1><?php the_title(); ?></h1>
				<div><?php echo $description; ?></div>
				<h2>Features</h2>
				<ul class="features">
					<?php foreach ( $features as $feature ) : ?>
						<?php if ( $feature ) : ?>
							<li><?php echo $feature; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<h2>Benefits</h2>
				<ul>
					<?php foreach ( $benefits as $benefit ) : ?>
						<?php if ( trim( $benefit ) ): ?>
							<li><?php echo $benefit; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<h2>Differentiators</h2>
				<ul>
					<?php foreach ( $differentiators as $differentiator ) : ?>
						<?php if ( $differentiator ) : ?>
							<li><?php echo $differentiator; ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<h2>Testimonial</h2>
				<blockquote>
					<?php echo $testimonial; ?>
					<cite> - <?php echo $author; ?></cite>
				</blockquote>
				<input id="platform-email" type="hidden" value="<?php echo $email; ?>">
			</div>
		</div>
		<div class="form-popup">
			<div class="form-popup-wrapper">
				<p>Send a message to <?php the_title(); ?></p>
				<br>
				<?php gravity_form( 2, 0 ); ?>
			</div>
		</div>
	</div>
<?php


get_footer();
