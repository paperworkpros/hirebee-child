<?php
global $post;
?>
<article id="project-<?php the_ID(); ?>" <?php post_class( [ 'single-project' ] ); ?> role="article">
	<div class="project-section">
		<div class="single-project-details">
			<h1><?php the_title(); ?></h1>

			<?php
			$categories = get_the_terms(
				$post->ID,
				'project_category'
			);
			$details    = [
				'Bids'           => get_comments_number(),
				'Budget'         => '$' . $post->_hrb_budget_price,
				'Days Remaining' => get_the_hrb_project_remain_days(),
				'Category'       => $categories[0]->name,
			];
			?>
			<ul class="project-list">
				<?php foreach ( $details as $detail => $value ) : ?>
					<li><?php echo $detail; ?> <b><?php echo $value; ?></b></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="single-project-bid">
			<p>Posted on <?php echo get_the_date(); ?></p>
			<strong><?php echo mb_convert_case( get_post_status(), MB_CASE_TITLE ); ?></strong>
			<?php
			echo html( 'a', array(
				'class' => 'button secondary expand',
				'href' => esc_url( get_the_hrb_apply_to_url( $post->ID ) ),
			), 'Bid Project' );
			?>
		</div>
	</div>
	<div class="project-section">
		<h2>Project Description</h2>
		<?php the_content(); ?>
		<?php
		$files = get_field( 'files' );

		if ( is_array( $files ) ) :
			foreach ( $files as $file ) : ?>
				<a href="<?php echo wp_get_attachment_image_url( $file, 'full' ); ?>" target="_blank">
					🔗 <?php echo basename( wp_get_attachment_image_url( $file, 'full' ) ); ?>
				</a>
			<?php endforeach;
		endif; ?>
		<hr>
		<h2>Employer Information</h2>
		<ul class="project-list">
			<li><?php the_author(); ?></li>
			<li><i class="icon i-project-location"></i> <?php the_hrb_project_location(); ?></li>
		</ul>
	</div>

	<div class="project-section">
		<h2>Bids</h2>
		<?php appthemes_load_template( 'single-project-section-proposals.php', [ 'proposals' => $proposals ] ); ?>
	</div>

	<div class="project-section">
		<h2>Clarification Board</h2>
		<?php appthemes_load_template( 'single-project-section-clarification.php' ); ?>
	</div>

</article>

