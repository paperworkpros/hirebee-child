<?php

define( 'RW_MX_TC_TD', 'agreed' );
$locale = apply_filters( 'plugin_locale', get_locale(), RW_MX_TC_TD );
$base   = basename( dirname( __FILE__ ) );
load_textdomain( RW_MX_TC_TD, WP_LANG_DIR . "/plugins/$base-$locale.mo" );

function oha_is_apptheme_not_exist() {
	$theme     = wp_get_theme(); // gets the current theme
	$appthemes = [ 'ClassiPress', 'Clipper', 'HireBee', 'JobRoller', 'Taskerr', 'appthemes-vantage', 'Vantage' ];

	if ( in_array( $theme->name, $appthemes ) || in_array( $theme->parent_theme, $appthemes ) ) {
		return false;
	} else {
		return true;
	}
}

if ( oha_is_apptheme_not_exist() ) {
	return;
}

function oha_misc_terms_conditions_init() {
	global $oha_tos_options;
	$GLOBALS['oha_tos_options'] = new scbOptions( 'oha_tos_options', false, [
		/*  Register M & C Settings    */
		'oha_register_tos_allow'       => 0,
		'oha_register_tos'             => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Login M & C Settings    */
		'oha_login_tos_allow'          => 0,
		'oha_login_tos'                => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Listing M & C Settings    */
		'oha_listing_tos_allow'        => 0,
		'oha_listing_tos'              => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Event M & C Settings    */
		'oha_event_tos_allow'          => 0,
		'oha_event_tos'                => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Job  M & C Settings    */
		'oha_joblisting_tos_allow'     => 0,
		'oha_joblisting_tos'           => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Resume M & C Settings    */
		'oha_resumelisting_tos_allow'  => 0,
		'oha_resumelisting_tos'        => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Project M & C Settings    */
		'oha_projectlisting_tos_allow' => 0,
		'oha_projectlisting_tos'       => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Coupon M & C Settings    */
		'oha_couponlisting_tos_allow'  => 0,
		'oha_couponlisting_tos'        => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

		/*  Service M & C Settings    */
		'oha_servicelisting_tos_allow' => 0,
		'oha_servicelisting_tos'       => 'I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>',

	] );
	if ( is_admin() ) {
		global $oha_tos_options;

		class Misc_terms_conditions_Plugin_Settings extends APP_Tabs_Page {

			function setup() {
				$this->textdomain = RW_MX_TC_TD;
				$this->args       = [
					'page_title'            => __( 'Agreed Settings', RW_MX_TC_TD ),
					'menu_title'            => __( '[Agreed] - T &amp; C', RW_MX_TC_TD ),
					'page_slug'             => 'rw-tos-settings',
					'parent'                => 'app-dashboard',
					'screen_icon'           => 'options-general',
					'admin_action_priority' => 12,
				];
			} // setup()

			protected function init_tabs() {
				$this->tabs->add( 'oha_misc_terms_conditions_options', __( 'T &amp; C', RW_MX_TC_TD ) );

				/*  Register M & C Settings    */
				$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_regiter_options'] = [
					'title'  => __( 'Registration Page', RW_MX_TC_TD ),
					'fields' => [

						[
							'title' => __( 'Add box', RW_MX_TC_TD ),
							'name'  => 'oha_register_tos_allow',
							'type'  => 'checkbox',
							'desc'  => __( 'Yes', RW_MX_TC_TD ),
							'tip'   => __( 'Turning this on will add terms and conditions box on the user registration page.', RW_MX_TC_TD ),
						],

						[
							'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
							'name'     => 'oha_register_tos',
							'type'     => 'textarea',
							'sanitize' => 'appthemes_clean',
							'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
							'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
							'tip'      => __( 'This is where you can add terms and conditions text for the user registration page.', RW_MX_TC_TD ),
						],

					],
				];

				/*  Login M & C Settings    */
				$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_login_options'] = [
					'title'  => __( 'Login Page', RW_MX_TC_TD ),
					'fields' => [

						[
							'title' => __( 'Add box', RW_MX_TC_TD ),
							'name'  => 'oha_login_tos_allow',
							'type'  => 'checkbox',
							'desc'  => __( 'Yes', RW_MX_TC_TD ),
							'tip'   => __( 'Turning this on will add terms and conditions box on the user login page.', RW_MX_TC_TD ),
						],

						[
							'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
							'name'     => 'oha_login_tos',
							'type'     => 'textarea',
							'sanitize' => 'appthemes_clean',
							'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
							'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
							'tip'      => __( 'This is where you can add terms and conditions text for the user login page.', RW_MX_TC_TD ),
						],
					],
				];


				/*  Listing M & C Settings    */
				if ( defined( 'VA_LISTING_PTYPE' ) && post_type_exists( VA_LISTING_PTYPE ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_listing_options'] = [
						'title'  => __( 'Create Listing Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_listing_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on the create listing page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_listing_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for the create listing page.', RW_MX_TC_TD ),
							],
						],
					];

				}

				/*  Event M & C Settings    */
				if ( defined( 'VA_EVENT_PTYPE' ) && post_type_exists( VA_EVENT_PTYPE ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_event_options'] = [
						'title'  => __( 'Create Event Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_event_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on the create event page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_event_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for the create event page.', RW_MX_TC_TD ),
							],
						],
					];

				}
				/*  Job  M & C Settings    */
				if ( post_type_exists( 'job_listing' ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_joblisting_options'] = [
						'title'  => __( 'Submit Job Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_joblisting_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on the submit job page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_joblisting_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for the submit job page.', RW_MX_TC_TD ),
							],
						],
					];

				}

				/*  Resume M & C Settings    */
				if ( post_type_exists( 'resume' ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_resumelisting_options'] = [
						'title'  => __( 'Add Resume Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_resumelisting_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on add resume page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_resumelisting_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for add resume page.', RW_MX_TC_TD ),
							],
						],
					];

				}


				/*  Coupon M & C Settings    */
				if ( post_type_exists( 'coupon' ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_couponlisting_options'] = [
						'title'  => __( 'Share Coupon Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_couponlisting_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on the share coupon page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_couponlisting_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for the share coupon page.', RW_MX_TC_TD ),
							],
						],
					];

				}


				/*  Project M & C Settings    */
				if ( defined( 'HRB_PROJECTS_PTYPE' ) && post_type_exists( HRB_PROJECTS_PTYPE ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_servicelisting_options'] = [
						'title'  => __( 'Post a Project Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_projectlisting_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on the post a project page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_projectlisting_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for post a project page.', RW_MX_TC_TD ),
							],
						],
					];

				}


				/*  Service M & C Settings    */
				if ( defined( 'TR_SERVICE_PTYPE' ) && post_type_exists( TR_SERVICE_PTYPE ) ) {
					$this->tab_sections['oha_misc_terms_conditions_options']['oha_misc_tc_servicelisting_options'] = [
						'title'  => __( 'Add Service Page', RW_MX_TC_TD ),
						'fields' => [

							[
								'title' => __( 'Add box', RW_MX_TC_TD ),
								'name'  => 'oha_servicelisting_tos_allow',
								'type'  => 'checkbox',
								'desc'  => __( 'Yes', RW_MX_TC_TD ),
								'tip'   => __( 'Turning this on will add terms and conditions box on the add service page.', RW_MX_TC_TD ),
							],

							[
								'title'    => __( 'Terms and conditions text', RW_MX_TC_TD ),
								'name'     => 'oha_servicelisting_tos',
								'type'     => 'textarea',
								'sanitize' => 'appthemes_clean',
								'extra'    => [ 'style' => 'width:100%; min-height: 200px;' ],
								'desc'     => __( 'i.e I agree to the website <a href="#" style="color:blue; text-decoration:underline;" target="_blank">terms and conditions</a>', RW_MX_TC_TD ),
								'tip'      => __( 'This is where you can add terms and conditions text for add service page.', RW_MX_TC_TD ),
							],
						],
					];

				}


			}

		}

		$load_classes = [
			'Misc_terms_conditions_Plugin_Settings' => $oha_tos_options,
		];
		appthemes_add_instance( $load_classes );
	}// admin end if


}

add_action( 'init', 'oha_misc_terms_conditions_init', 13 );
function oha_register_tos() {
	global $oha_tos_options;

	/*  ClassiPress Registraion Page M & C   */
	if ( post_type_exists( 'ad_listing' ) && $oha_tos_options->oha_register_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
				clear: both;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#checksave .submit .btn_orange' ).attr( 'disabled', true );
				jQuery( '#checksave .submit .btn_orange' ).addClass( 'deactive_term' );
			} );

			function AcceptMe() {

				if ( jQuery( '#checksave .submit .btn_orange' ).is( ':disabled' ) === false ) {

					jQuery( '#checksave .submit .btn_orange' ).attr( 'disabled', true );
					jQuery( '#checksave .submit .btn_orange' ).removeClass( 'active_term' );
					jQuery( '#checksave .submit .btn_orange' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#checksave .submit .btn_orange' ).attr( 'disabled', false );
					jQuery( '#checksave .submit .btn_orange' ).addClass( 'active_term' );

				}
			}
		</script>

		<!-- START TERMS BOX -->
		<p class="terms_checkbox">
			<label></label>
			<input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();">
			<?php
			echo $oha_tos_options->oha_register_tos; ?>
		</p>
		<!-- END TERMS BOX -->
		<?php
	}

	/*  Vantage Registraion Page M & C   */
	if ( defined( 'VA_LISTING_PTYPE' ) && post_type_exists( VA_LISTING_PTYPE ) && $oha_tos_options->oha_register_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '.register-form #register' ).attr( 'disabled', true );
				jQuery( '.register-form #register' ).addClass( 'deactive_term' );
			} );

			function AcceptMe() {

				if ( jQuery( '.register-form #register' ).is( ':disabled' ) === false ) {

					jQuery( '.register-form #register' ).attr( 'disabled', true );
					jQuery( '.register-form #register' ).removeClass( 'active_term' );
					jQuery( '.register-form #register' ).addClass( 'deactive_term' );

				} else {

					jQuery( '.register-form #register' ).attr( 'disabled', false );
					jQuery( '.register-form #register' ).addClass( 'active_term' );

				}
			}
		</script>
		<!-- START TERMS BOX -->
		<div class="terms_checkbox">
			<input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();">
			<?php
			echo $oha_tos_options->oha_register_tos;

			if ( defined( 'VA_VERSION' ) && VA_VERSION >= 4.0 ) {
				?>
				<script type="text/javascript">
					jQuery( document ).ready( function() {
						jQuery( '.terms_checkbox' ).insertBefore( '#register' );
					} );
				</script>
				<style>
					.terms_checkbox {
						line-height: 0.5;
					}
				</style>
				<?php
			}
			?>
		</div>
		<!-- END TERMS BOX -->
		<?php
	}

	/*  JobRoller Registraion Page M & C   */
	if ( post_type_exists( 'job_listing' ) && $oha_tos_options->oha_register_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).attr( 'disabled', true );
				jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).addClass( 'deactive_term' );
			} );

			function AcceptMe() {

				if ( jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).is( ':disabled' ) === false ) {

					jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).attr( 'disabled', true );
					jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).removeClass( 'active_term' );
					jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).addClass( 'deactive_term' );

				} else {

					jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).attr( 'disabled', false );
					jQuery( 'form[name="registerform"] .account_form_fields p :submit' ).addClass( 'active_term' );

				}
			}
		</script>

		<!-- START TERMS BOX -->
		<p class="terms_checkbox">
			<label></label>
			<input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();">
			<?php
			echo $oha_tos_options->oha_register_tos; ?>
		</p>
		<!-- END TERMS BOX -->
		<?php
	}

	/*  Clipper Registraion Page M & C   */
	if ( post_type_exists( 'coupon' ) && $oha_tos_options->oha_register_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			@media screen and (max-width: 640px) {
				p.terms_checkbox label {
					display: none !important;
				}
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#checksave #register' ).attr( 'disabled', true );
				jQuery( '#checksave #register' ).addClass( 'deactive_term' );
			} );

			function AcceptMe() {

				if ( jQuery( '#checksave #register' ).is( ':disabled' ) === false ) {

					jQuery( '#checksave #register' ).attr( 'disabled', true );
					jQuery( '#checksave #register' ).removeClass( 'active_term' );
					jQuery( '#checksave #register' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#checksave #register' ).attr( 'disabled', false );
					jQuery( '#checksave #register' ).addClass( 'active_term' );

				}
			}
		</script>

		<!-- START TERMS BOX -->
		<p class="terms_checkbox">
			<label></label>
			<input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();">
			<?php
			echo $oha_tos_options->oha_register_tos; ?>
		</p>
		<!-- END TERMS BOX -->
		<?php
	}

	/*  Hirebee Registraion Page M & C   */
	if ( defined( 'HRB_PROJECTS_PTYPE' ) && post_type_exists( HRB_PROJECTS_PTYPE ) && $oha_tos_options->oha_register_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			form.custom .custom.checkbox.checked::before {
				content: "√";
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#login-form #register' ).attr( 'disabled', true );
				jQuery( '#login-form #register' ).addClass( 'deactive_term' );
			} );

			function AcceptMe() {
				if ( jQuery( '#login-form #register' ).is( ':disabled' ) === false ) {

					jQuery( '#login-form #register' ).attr( 'disabled', true );
					jQuery( '#login-form #register' ).removeClass( 'active_term' );
					jQuery( '#login-form #register' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#login-form #register' ).attr( 'disabled', false );
					jQuery( '#login-form #register' ).addClass( 'active_term' );

				}
			}
		</script>

		<!-- START TERMS BOX -->
		<div class="row terms_checkbox">
			<div class="large-12 columns form-field">
				<label>
					<input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onchange="javascript:AcceptMe();">
					<?php
					echo $oha_tos_options->oha_register_tos; ?>
				</label>
			</div>
		</div>
		<!-- END TERMS BOX -->
		<?php
	}

	/*  Taskers Registraion Page M & C   */
	if ( defined( 'TR_SERVICE_PTYPE' ) && post_type_exists( TR_SERVICE_PTYPE ) && $oha_tos_options->oha_register_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			form.custom .custom.checkbox.checked::before {
				content: "√";
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#login-form #register' ).attr( 'disabled', true );
				jQuery( '#login-form #register' ).addClass( 'deactive_term' );
			} );

			function AcceptMe() {
				if ( jQuery( '#login-form #register' ).is( ':disabled' ) === false ) {

					jQuery( '#login-form #register' ).attr( 'disabled', true );
					jQuery( '#login-form #register' ).removeClass( 'active_term' );
					jQuery( '#login-form #register' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#login-form #register' ).attr( 'disabled', false );
					jQuery( '#login-form #register' ).addClass( 'active_term' );

				}
			}
		</script>
		<!-- START TERMS BOX -->
		<div class="form-field terms_checkbox">
			<label>
				<input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onchange="javascript:AcceptMe();">
				<?php
				echo $oha_tos_options->oha_register_tos; ?>
			</label>
		</div>
		<!-- END TERMS BOX -->
		<?php
	}
}

function oha_login_tos() {
	global $oha_tos_options;

	/*  ClassiPress Login Page M & C   */
	if ( post_type_exists( 'ad_listing' ) && $oha_tos_options->oha_login_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#checksave .submit .btn_orange' ).attr( 'disabled', true );
				jQuery( '#checksave .submit .btn_orange' ).addClass( 'deactive_term' );
				jQuery( '#checksave' ).before( '<p class="terms_checkbox"><label></label><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_login_tos;?></p>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#checksave .submit .btn_orange' ).is( ':disabled' ) === false ) {

					jQuery( '#checksave .submit .btn_orange' ).attr( 'disabled', true );
					jQuery( '#checksave .submit .btn_orange' ).removeClass( 'active_term' );
					jQuery( '#checksave .submit .btn_orange' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#checksave .submit .btn_orange' ).attr( 'disabled', false );
					jQuery( '#checksave .submit .btn_orange' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Vantage Login Page M & C   */
	if ( defined( 'VA_LISTING_PTYPE' ) && post_type_exists( VA_LISTING_PTYPE ) && $oha_tos_options->oha_login_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#login-form  #login' ).attr( 'disabled', true );
				jQuery( '#login-form  #login' ).addClass( 'deactive_term' );
				jQuery( '#login' ).before( '<p class="terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_login_tos;?></p>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#login-form  #login' ).is( ':disabled' ) === false ) {

					jQuery( '#login-form  #login' ).attr( 'disabled', true );
					jQuery( '#login-form  #login' ).removeClass( 'active_term' );
					jQuery( '#login-form  #login' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#login-form  #login' ).attr( 'disabled', false );
					jQuery( '#login-form  #login' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}
	/*  Jobroller Login Page M & C   */
	if ( post_type_exists( 'job_listing' ) && $oha_tos_options->oha_login_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( 'input[type=\'submit\'][name=\'login\']' ).attr( 'disabled', true );
				jQuery( 'input[type=\'submit\'][name=\'login\']' ).addClass( 'deactive_term' );
				jQuery( 'input[type=\'submit\'][name=\'login\']' ).before( '<p class="terms_checkbox"><label></label><input type="checkbox" id="agreeTC1" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe1();"><?php echo $oha_tos_options->oha_login_tos;?></p>' );
			} );

			function AcceptMe1() {

				if ( jQuery( 'input[type=\'submit\'][name=\'login\']' ).is( ':disabled' ) === false ) {

					jQuery( 'input[type=\'submit\'][name=\'login\']' ).attr( 'disabled', true );
					jQuery( 'input[type=\'submit\'][name=\'login\']' ).removeClass( 'active_term' );
					jQuery( 'input[type=\'submit\'][name=\'login\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( 'input[type=\'submit\'][name=\'login\']' ).attr( 'disabled', false );
					jQuery( 'input[type=\'submit\'][name=\'login\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Clipper Login Page M & C   */
	if ( post_type_exists( 'coupon' ) && $oha_tos_options->oha_login_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			@media screen and (max-width: 640px) {
				p.terms_checkbox label {
					display: none !important;
				}
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#loginForm  #login' ).attr( 'disabled', true );
				jQuery( '#loginForm  #login' ).addClass( 'deactive_term' );
				jQuery( '#loginForm  #login' ).before( '<p class="terms_checkbox"><label></label><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_login_tos;?></p>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#loginForm  #login' ).is( ':disabled' ) === false ) {

					jQuery( '#loginForm  #login' ).attr( 'disabled', true );
					jQuery( '#loginForm  #login' ).removeClass( 'active_term' );
					jQuery( '#loginForm  #login' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#loginForm  #login' ).attr( 'disabled', false );
					jQuery( '#loginForm  #login' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Hirebee Login Page M & C   */
	if ( defined( 'HRB_PROJECTS_PTYPE' ) && post_type_exists( HRB_PROJECTS_PTYPE ) && $oha_tos_options->oha_login_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( 'input[type=\'submit\'][id=\'login\']' ).attr( 'disabled', true );
				jQuery( 'input[type=\'submit\'][id=\'login\']' ).addClass( 'deactive_term' );
				jQuery( 'div .form-field #rememberme' ).before( '<div class="form-field terms_checkbox"><label><input type="checkbox" id="agreeTC" name="interests" class="checkbox hidden-field term_field" tabindex="8" onclick="javascript:AcceptMe();"> <?php echo $oha_tos_options->oha_login_tos;?></label></div>' );
			} );

			function AcceptMe() {

				if ( jQuery( 'input[type=\'submit\'][id=\'login\']' ).is( ':disabled' ) === false ) {

					jQuery( 'input[type=\'submit\'][id=\'login\']' ).attr( 'disabled', true );
					jQuery( 'input[type=\'submit\'][id=\'login\']' ).removeClass( 'active_term' );
					jQuery( 'input[type=\'submit\'][id=\'login\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( 'input[type=\'submit\'][id=\'login\']' ).attr( 'disabled', false );
					jQuery( 'input[type=\'submit\'][id=\'login\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Taskers Login Page M & C   */
	if ( defined( 'TR_SERVICE_PTYPE' ) && post_type_exists( TR_SERVICE_PTYPE ) && $oha_tos_options->oha_login_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( 'input[type=\'submit\'][id=\'login\']' ).attr( 'disabled', true );
				jQuery( 'input[type=\'submit\'][id=\'login\']' ).addClass( 'deactive_term' );
				jQuery( 'div .form-field #login' ).before( '<div class="form-field terms_checkbox"><label><input type="checkbox" id="agreeTC" name="interests" class="checkbox hidden-field term_field" tabindex="8" onclick="javascript:AcceptMe();"> <?php echo $oha_tos_options->oha_login_tos;?></label></div>' );
			} );

			function AcceptMe() {

				if ( jQuery( 'input[type=\'submit\'][id=\'login\']' ).is( ':disabled' ) === false ) {

					jQuery( 'input[type=\'submit\'][id=\'login\']' ).attr( 'disabled', true );
					jQuery( 'input[type=\'submit\'][id=\'login\']' ).removeClass( 'active_term' );
					jQuery( 'input[type=\'submit\'][id=\'login\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( 'input[type=\'submit\'][id=\'login\']' ).attr( 'disabled', false );
					jQuery( 'input[type=\'submit\'][id=\'login\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}
}

function oha_add_misc_terms_scripts() {
	global $oha_tos_options;

	/*
	echo '<pre>';
print_r(is_page_template('create-listing.php'));
echo '</pre>';
die;
*/

	/*  Vantage Create Listing  Page M & C   */
	if ( defined( 'VA_LISTING_PTYPE' ) && post_type_exists( VA_LISTING_PTYPE ) && is_page_template( 'create-listing.php' ) && $_REQUEST['step'] && $oha_tos_options->oha_listing_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#create-listing  div :submit' ).attr( 'disabled', true );
				jQuery( '#create-listing  div :submit' ).addClass( 'deactive_term' );
				jQuery( '#create-listing  #misc-fields' ).after( '<div class="form-field terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_listing_tos;?></div>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#create-listing  div :submit' ).is( ':disabled' ) === false ) {

					jQuery( '#create-listing  div :submit' ).attr( 'disabled', true );
					jQuery( '#create-listing  div :submit' ).removeClass( 'active_term' );
					jQuery( '#create-listing  div :submit' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#create-listing  div :submit' ).attr( 'disabled', false );
					jQuery( '#create-listing  div :submit' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	} elseif ( defined( 'VA_LISTING_PTYPE' ) && post_type_exists( VA_LISTING_PTYPE ) && isset( $_REQUEST['step'] ) && $oha_tos_options->oha_listing_tos_allow ) {

		?>
		<style type="text/css">
			.terms_checkbox {
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#listing-new-edit-info :submit' ).attr( 'disabled', true );
				jQuery( '#listing-new-edit-info :submit' ).addClass( 'deactive_term' );
				jQuery( '#listing-new-edit-info .fieldset' ).append( '<div class="form-field terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_listing_tos;?></div>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#listing-new-edit-info :submit' ).is( ':disabled' ) === false ) {

					jQuery( '#listing-new-edit-info :submit' ).attr( 'disabled', true );
					jQuery( '#listing-new-edit-info :submit' ).removeClass( 'active_term' );
					jQuery( '#listing-new-edit-info :submit' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#listing-new-edit-info :submit' ).attr( 'disabled', false );
					jQuery( '#listing-new-edit-info :submit' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Vantage Create Event  Page M & C   */
	if ( defined( 'VA_EVENT_PTYPE' ) && post_type_exists( VA_EVENT_PTYPE ) && is_page_template( 'create-event.php' ) && isset( $_REQUEST['step'] ) && $oha_tos_options->oha_event_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#create-event  div :submit' ).attr( 'disabled', true );
				jQuery( '#create-event  div :submit' ).addClass( 'deactive_term' );
				jQuery( '#create-event  #misc-fields' ).after( '<div class="form-field terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_event_tos;?></div>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#create-event  div :submit' ).is( ':disabled' ) === false ) {

					jQuery( '#create-event  div :submit' ).attr( 'disabled', true );
					jQuery( '#create-event  div :submit' ).removeClass( 'active_term' );
					jQuery( '#create-event  div :submit' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#create-event  div :submit' ).attr( 'disabled', false );
					jQuery( '#create-event  div :submit' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  JobRoller Submit Job  Page M & C   */
	if ( post_type_exists( 'job_listing' ) && is_page_template( 'tpl-submit.php' ) && $_REQUEST['step'] == '3' && $oha_tos_options->oha_joblisting_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).attr( 'disabled', true );
				jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).addClass( 'deactive_term' );

				jQuery( 'form[id!=\'submit_form\'] input[type=\'submit\'][name=\'goback\']' ).before( '<p class="terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_joblisting_tos;?></p>' );
			} );

			function AcceptMe() {

				if ( jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).is( ':disabled' ) === false ) {

					jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).attr( 'disabled', true );
					jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).removeClass( 'active_term' );
					jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).attr( 'disabled', false );
					jQuery( 'input[type=\'submit\'][name=\'job_confirm\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Clipper Share Coupon  Page M & C   */
	if ( post_type_exists( 'coupon' ) && ( is_page_template( 'tpl-submit-coupon.php' ) || is_page_template( 'create-listing.php' ) ) && $oha_tos_options->oha_couponlisting_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			@media screen and (max-width: 640px) {
				.terms_checkbox label {
					display: none !important;
				}
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#couponForm  li :submit' ).attr( 'disabled', true );
				jQuery( '#couponForm  li :submit' ).addClass( 'deactive_term' );
				jQuery( '#couponForm  li :submit' ).before( '<li class="terms_checkbox"><label></label><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_couponlisting_tos;?></li>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#couponForm  li :submit' ).is( ':disabled' ) === false ) {

					jQuery( '#couponForm  li :submit' ).attr( 'disabled', true );
					jQuery( '#couponForm  li :submit' ).removeClass( 'active_term' );
					jQuery( '#couponForm  li :submit' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#couponForm  li :submit' ).attr( 'disabled', false );
					jQuery( '#couponForm  li :submit' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  JobRoller Add Resume Page M & C   */
	if ( post_type_exists( 'resume' ) && is_page_template( 'tpl-edit-resume.php' ) && $_REQUEST['edit'] == '' && $oha_tos_options->oha_resumelisting_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).attr( 'disabled', true );
				jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).addClass( 'deactive_term' );
				jQuery( 'p input[type=\'submit\'][name=\'save_resume\']' ).before( '<p class="optional terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_resumelisting_tos;?></p>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).is( ':disabled' ) === false ) {

					jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).attr( 'disabled', true );
					jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).removeClass( 'active_term' );
					jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).attr( 'disabled', false );
					jQuery( '#submit_form input[type=\'submit\'][name=\'save_resume\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Hirebee Add Project Page M & C   */
	if ( defined( 'HRB_PROJECTS_PTYPE' ) && post_type_exists( HRB_PROJECTS_PTYPE ) && is_page_template( 'create-project.php' ) && isset( $_REQUEST['step'] ) && $_REQUEST['step'] === 'preview' && $oha_tos_options->oha_projectlisting_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.checkbox {
				margin-right: 10px;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			form.custom .custom.checkbox.checked::before {
				content: "√";
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).attr( 'disabled', true );
				jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).addClass( 'deactive_term' );
				jQuery( '#preview-project-form  > fieldset:nth-child(2)' ).before( '<fieldset><div class="terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onchange="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_projectlisting_tos;?></div></fieldset>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).is( ':disabled' ) === false ) {

					jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).attr( 'disabled', true );
					jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).removeClass( 'active_term' );
					jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).attr( 'disabled', false );
					jQuery( '#preview-project-form input[type=\'submit\'][value=\'Confirm & Submit\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}

	/*  Taskers Add Service Page M & C   */
	if ( defined( 'TR_SERVICE_PTYPE' ) && post_type_exists( TR_SERVICE_PTYPE ) && is_page_template( 'add-service.php' ) && $_REQUEST['step'] == 'edit-info' && $oha_tos_options->oha_servicelisting_tos_allow ) {
		?>
		<style type="text/css">
			.terms_checkbox {
				padding: 10px 0 20px 0;
				display: table;
			}

			.checkbox {
				margin-right: 10px;
			}

			.term_field {
				margin-right: 5px;
				display: inline;
			}

			.deactive_term {
				opacity: 0.4;
				filter: alpha(opacity=40);
			}

			.active_term {
				opacity: 1;
				filter: alpha(opacity=100);
			}

			form.custom .custom.checkbox.checked::before {
				content: "√";
			}
		</style>
		<script type="text/javascript"> jQuery( document ).ready( function() {

				jQuery( '#edit-service  button[type=\'submit\']' ).attr( 'disabled', true );
				jQuery( '#edit-service  button[type=\'submit\']' ).addClass( 'deactive_term' );
				jQuery( '#edit-service  #misc-fields' ).after( '<div class="form-field terms_checkbox"><input type="checkbox" id="agreeTC" name="interests" class="term_field" tabindex="8" onclick="javascript:AcceptMe();"><?php echo $oha_tos_options->oha_listing_tos;?></div>' );
			} );

			function AcceptMe() {

				if ( jQuery( '#edit-service  button[type=\'submit\']' ).is( ':disabled' ) === false ) {

					jQuery( '#edit-service  button[type=\'submit\']' ).attr( 'disabled', true );
					jQuery( '#edit-service  button[type=\'submit\']' ).removeClass( 'active_term' );
					jQuery( '#edit-service  button[type=\'submit\']' ).addClass( 'deactive_term' );

				} else {

					jQuery( '#edit-service  button[type=\'submit\']' ).attr( 'disabled', false );
					jQuery( '#edit-service  button[type=\'submit\']' ).addClass( 'active_term' );

				}
			}
		</script>
		<?php
	}
}

add_action( 'wp_head', 'oha_add_misc_terms_scripts', 20 );
add_action( 'register_form', 'oha_register_tos', 99 );
add_action( 'login_form', 'oha_login_tos' );
