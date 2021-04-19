<?php

$project_id   = get_the_ID();
$budget_range = get_post_meta( $project_id, '_hrb_budget_price', true );

?>

<article id="project-<?php echo $project_id; ?>" <?php post_class( 'project' ); ?>>

	<div class="col col-1">
		<small><?php echo ncd_get_icon( 'folder-open' ); ?><?php the_hrb_tax_terms( HRB_PROJECTS_CATEGORY ); ?></small>
		<?php appthemes_before_post_title( HRB_PROJECTS_PTYPE ); ?>
		<h2 class="archive-project-title"><?php the_hrb_project_title(); ?>
		</h2>
		<?php appthemes_after_post_title( HRB_PROJECTS_PTYPE ); ?>
		<?php appthemes_before_post_content( HRB_PROJECTS_PTYPE ); ?>
		<?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
		<?php appthemes_after_post_content( HRB_PROJECTS_PTYPE ); ?>
	</div>

	<ul class="col col-2">
		<li><?php echo ncd_get_icon( 'dollar-sign' ) . ' ' . $budget_range; ?></li>
		<li><?php echo ncd_get_icon( 'comments-dollar' ) . ' ' . appthemes_get_post_total_bids( $project_id ) . ' bids'; ?></li>
		<li><?php echo ncd_get_icon( 'calendar' ) . ' ' . (int) get_the_hrb_project_remain_days( $project_id ) . ' days remaining'; ?></li>
		<li><?php echo ncd_get_icon( 'clock' ) . ' ' . get_the_hrb_project_posted_time_ago( $project_id ) . ' ago'; ?></li>
		<li><?php echo ncd_get_icon( 'map-marker-alt' ) . ' ' . get_the_hrb_project_location( $project_id ); ?></li>
	</ul>

</article>
