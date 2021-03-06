<?php
/**
 * Post a project form template
 *
 * @package HireBee\Templates
 * @since   1.0.0
 */
?>

<div class="section-head">
	<h1><?php _e( 'Details', APP_TD ); ?></h1>
</div>

<form id="create-project-form" class="custom main" enctype="multipart/form-data" method="post" action="<?php echo esc_url( $form_action ); ?>">

	<fieldset>
		<legend><?php _e( 'Essential info', APP_TD ); ?></legend>
		<div class="row">
			<div class="large-12 columns">
				<label for="post_title"><?php _e( 'What do you need?', APP_TD ); ?></label>
				<input name="post_title" tabindex="1" type="text" placeholder="<?php echo esc_attr_x( 'e.g. I need a Web Developer to develop a plugin', 'placeholder', APP_TD ); ?>" value="<?php echo esc_attr( $project->post_title ); ?>" class="required"/>
			</div>
		</div>
		<div class="row">
			<div class="large-12 columns">
				<label for="post_content"><?php _e( 'Project Details', APP_TD ); ?></label>
				<textarea name="post_content" tabindex="2" placeholder="<?php echo esc_attr_x( 'Provide a detailed description of what you need to get done.', 'placeholder', APP_TD ); ?>" class="required"><?php echo esc_textarea( $project->post_content ); ?></textarea>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<legend><?php _e( 'Categories & Skills', APP_TD ); ?></legend>
		<div class="row">
			<div class="large-12 columns category-dropdown">

				<label for="category"><?php _e( 'Category', APP_TD ); ?></label>
				<?php
				$projects_cat_name = '_' . HRB_PROJECTS_CATEGORY . '[]';

				$args = [
					'id'              => 'category',
					'name'            => $projects_cat_name,
					'taxonomy'        => HRB_PROJECTS_CATEGORY,
					'hide_empty'      => false,
					'hierarchical'    => true,
					'depth'           => 1,
					'selected'        => $project->categories,
					'class'           => 'category-dropdown required' . ( $categories_locked ? ' locked' : '' ),
					'show_option_all' => __( '&ndash; Select Category &ndash;', APP_TD ),
					'orderby'         => 'name',
					'tab_index'       => 3,
				];
				wp_dropdown_categories( $args );
				?>

				<?php if ( $categories_locked ) { ?>
					<input name="<?php echo esc_attr( $projects_cat_name ); ?>" type="hidden" value="<?php echo esc_attr( $project->categories ); ?>">
				<?php } ?>

			</div>
		</div>

		<div class="row">
			<div class="large-12 columns">
				<?php if ( hrb_charge_listings() ) { ?>
					<p class="important-note"><?php _e( '<strong>Note:</strong> Categories are locked after purchase', APP_TD ); ?></p>
				<?php } ?>
			</div>
		</div>

		<?php if ( hrb_get_allowed_skills_count() ) : ?>

			<div class="row">
				<div class="large-12 columns">
					<div class="row">
						<div class="large-12 columns">
							<label for="skills"><?php _e( 'Skills', APP_TD ); ?></label>
							<?php
							$args     = [
								'id'           => 'skills',
								'name'         => '_' . HRB_PROJECTS_SKILLS . '[]',
								'taxonomy'     => HRB_PROJECTS_SKILLS,
								'hide_empty'   => false,
								'hierarchical' => true,
								'selected'     => $project->skills,
								'walker'       => new HRB_OptGroup_Category_Walker,
								'depth'        => 5,
								'meta_key'     => 'tax_position',
								'orderby'      => 'tax_position',
								'echo'         => false,
								'tab_index'    => 5,
							];
							$dropdown = wp_dropdown_categories( $args );

							// Make this a multiple dropdown.
							echo str_replace( '<select ', '<select multiple="multiple"', $dropdown );
							?>
						</div>
					</div>
				</div>
			</div>

		<?php endif; ?>

		<div class="row">
			<div class="large-12 columns">
				<div class="row">
					<div class="large-12 columns">
						<label for="tags"><?php _e( 'Tags', APP_TD ); ?></label>
						<span class="tags-tags"></span>
						<input id="tags" name="<?php echo esc_attr( HRB_PROJECTS_TAG ); ?>" tabindex="6" type="text" class="tm-input tm-tag" placeholder="<?php echo esc_attr_x( 'e.g. mobile, web (comma separated)', 'placeholder', APP_TD ); ?>" value="<?php echo esc_attr( $project->tags ); ?>">
					</div>
				</div>
			</div>
		</div>
	</fieldset>

	<?php do_action( 'hrb_project_custom_fields', $project ); ?>

	<fieldset>
		<legend><?php _e( 'Budget', APP_TD ); ?></legend>
		<div class="row">
			<div class="large-4 columns">
				<select id="budget_type" name="budget_type" tabindex="10">
					<?php if ( ! $hrb_options->budget_types || 'fixed' == $hrb_options->budget_types ) { ?>
						<option value="fixed" <?php selected( $project->_hrb_budget_type, 'fixed' ); ?>><?php _e( 'Fixed Price', APP_TD ); ?></option>
					<?php } ?>
					<?php if ( ! $hrb_options->budget_types || 'hourly' == $hrb_options->budget_types ) { ?>
						<option value="hourly" <?php selected( $project->_hrb_budget_type, 'hourly' ); ?>><?php _e( 'Per Hour', APP_TD ); ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="large-8 columns">
				<div class="row collapse">
					<div class="large-6 small-6 columns budget-price">
						<span class="prefix"><?php _e( 'Price', APP_TD ); ?></span>
					</div>
					<div class="large-1 small-1 columns">
						<span class="prefix selected-currency center">$</span>
					</div>
					<div class="large-5 small-5 columns">
						<input id="budget_price" name="budget_price" tabindex="12" type="number" class="required" value="<?php echo esc_attr( $project->_hrb_budget_price ); ?>"/>
					</div>
				</div>
			</div>
			<div class="large-8 columns screen-reader-text">
				<div class="row collapse">
					<div class="large-5 columns">
						<span class="prefix"><?php _e( 'Currency', APP_TD ); ?></span>
					</div>
					<div class="large-7 columns budget-currency">
						<select id="budget_currency" name="budget_currency" tabindex="11">
							<?php foreach ( hrb_get_currencies() as $key => $currency ) : ?>
								<option currency-symbol="<?php echo $currency['symbol'] ?>" value="<?php echo esc_attr( $key ); ?>" <?php selected( $project->_hrb_budget_currency ? $project->_hrb_budget_currency : APP_Currencies::get_current_currency( 'code' ), $key ); ?>><?php echo $currency['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="large-12 columns">
				<div class="row collapse budget-min-hours">
					<div class="large-6 small-6 columns">
						<span class="prefix"><?php _e( 'Minimum Hours', APP_TD ); ?></span>
					</div>
					<div class="large-6 small-6 columns">
						<input id="hourly_min_hours" name="hourly_min_hours" tabindex="13" type="text" class="required" value="<?php echo esc_attr( $project->_hrb_hourly_min_hours ); ?>"/>
					</div>
				</div>
			</div>
		</div>

	</fieldset>

	<fieldset id="optional-fields">
		<?php if ( $hrb_options->attachments ) { ?>
			<div class="row">
				<div class="large-12 columns">
					<?php hrb_media_manager( $project->ID, [
						'id'    => '_app_media',
						'title' => __( 'Files', APP_TD ),
					] ); ?>
				</div>
			</div>
		<?php } ?>

	</fieldset>

	<?php do_action( 'hrb_project_form', $project ); ?>

	<fieldset>
		<?php do_action( 'hrb_project_form_fields', $project ); ?>

		<?php wp_nonce_field( 'hrb_post_project' ); ?>

		<?php
		hrb_hidden_input_fields(
			[
				'ID'     => esc_attr( $project->ID ),
				'action' => esc_attr( $action ),
			]
		);
		?>

		<input tabindex="20" type="submit" class="button" value="<?php echo esc_attr( $bt_step_text ); ?>"/>
	</fieldset>
</form>
