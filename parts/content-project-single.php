<?php
global $post, $current_user;
?>
<article id="project-<?php echo $post->ID; ?>" <?php post_class( [ 'single-project' ] ); ?> role="article">
	<div class="project-section">
		<div class="single-project-details">
			<h1><?php the_title(); ?></h1>

			<?php
			$categories = get_the_terms(
				$post->ID,
				'project_category'
			);
			$details    = [
				ncd_get_icon( 'comments-dollar' ) . ' Bids'    => appthemes_get_post_total_bids( $post->ID ),
				ncd_get_icon( 'dollar-sign' ) . ' Budget'      => $post->_hrb_budget_price,
				ncd_get_icon( 'calendar' ) . ' Days Remaining' => (int) get_the_hrb_project_remain_days(),
				ncd_get_icon( 'folder-open' ) . ' Category'    => $categories[0]->name,
			];
			?>
			<ul class="project-list">
				<?php foreach ( $details as $detail => $value ) : ?>
					<li><span><?php echo $detail; ?></span><b><?php echo $value; ?></b></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<div class="single-project-bid">
			<p>Posted on <?php echo get_the_date(); ?></p>
			<strong><?php echo mb_convert_case( get_post_status(), MB_CASE_TITLE ); ?></strong>
			<?php
			echo html( 'a', [
				'class' => 'button secondary expand',
				'href'  => esc_url( get_the_hrb_apply_to_url( $post->ID ) ),
			], 'Bid Project' );
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
			<li><?php ncd_icon('user-alt'); ?><?php the_author(); ?></li>
			<li><?php ncd_icon('map-marker-alt'); ?><?php the_hrb_project_location(); ?></li>
		</ul>
	</div>

	<div class="project-section bids">
		<?php appthemes_load_template( 'single-project-section-proposals.php', [ 'proposals' => $proposals ] ); ?>
	</div>

	<div class="project-section">
		<h2>Clarification Board</h2>
		<?php appthemes_load_template( 'single-project-section-clarification.php' ); ?>
	</div>

</article>

