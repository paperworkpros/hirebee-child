

<div id="primary" class="content-area row">
	<div id="main" class="large-8 columns">
		<div class="edit-profile">
			<div class="form-wrapper">
				<div class="row">
					<div class="large-12 columns">
						<form name="profile" id="profile-form" action="#" class="custom" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="large-12 columns">
									<div class="upload-gravatar left">
										<?php hrb_gravatar_media_manager( $current_user->ID, [ 'id' => '_app_gravatar' ] ); ?>
									</div>
								</div>
							</div>
							<fieldset>
								<div class="row">
									<div class="large-6 columns form-field screen-reader-text">
										<label><?php _e( 'Nickname', APP_TD ); ?></label>
										<input type="hidden" name="nickname" class="text regular-text required" id="nickname" value="<?php echo $current_user->nickname; ?>" maxlength="100"/>
									</div>
									<div class="large-6 columns form-field">
										<label><?php _e( 'First Name', APP_TD ); ?></label>
										<input type="text" name="first_name" class="text regular-text" id="first_name" value="<?php echo esc_attr( $current_user->first_name ); ?>" maxlength="100"/>
									</div>
									<div class="large-6 columns form-field">
										<label><?php _e( 'Last Name', APP_TD ); ?></label>
										<input type="text" name="last_name" class="text regular-text" id="last_name" value="<?php echo esc_attr( $current_user->last_name ); ?>" maxlength="100"/>
									</div>
								</div>
								<div class="row">
									<div class="large-6 columns form-field">
										<label><?php _e( 'Email Address', APP_TD ); ?></label>
										<input type="email" name="email" class="text regular-text required" id="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" maxlength="100"/>
									</div>
									<div class="large-6 columns form-field">
										<label><?php _e( 'Website', APP_TD ); ?></label>
										<input type="url" name="url" class="text regular-text" id="url" value="<?php echo esc_url( $current_user->user_url ); ?>" maxlength="100"/>
									</div>
								</div>
								<div class="row">
									<div class="large-12 columns form-field">
										<label><?php _e( 'About Me', APP_TD ); ?></label>
										<textarea name="description" class="text regular-text" id="description" rows="10"><?php echo esc_attr( $current_user->description ); ?></textarea>
									</div>
								</div>
								<?php if ( $show_password_fields ) : ?>
									<div class="user-pass1-wrap manage-password">
										<div class="row">
											<div class="large-12 columns form-field">
												<label for="pass1"><?php _e( 'New Password', APP_TD ); ?></label>
												<div class="wp-pwd hide-if-js">
													<?php $initial_password = wp_generate_password( 24 ); ?>
													<input type="password" id="pass1" name="pass1" class="regular-text" autocomplete="off" data-pw="<?php echo esc_attr( $initial_password ); ?>" aria-describedby="pass-strength-result"/>
													<input type="text" style="display:none" name="pass2" id="pass2" autocomplete="off"/>
												</div>
											</div>
										</div>
										<div class="row pass-strenght-indicator wp-pwd hide-if-no-js">
											<div class="large-6 columns form-field">
												<span><?php _e( 'Should be at least seven characters long.', APP_TD ); ?></span>
												<div id="pass-strength-result"><?php _e( 'Strength indicator', APP_TD ); ?></div>
											</div>
										</div>
									</div>
								<?php
								endif;
								do_action( 'profile_personal_options', $current_user );
								do_action( 'show_user_profile', $current_user );
								?>
								<div class="form-field">
									<input type="submit" class="button" name="update_profile" value="<?php esc_attr_e( __( 'Update Profile', APP_TD ) ); ?>">
								</div>
							</fieldset>
							<?php
							wp_nonce_field( 'app-edit-profile' );

							// Need to pass in these values otherwise they get blown away in wp-admin/profile.php.
							if ( ! empty( $current_user->rich_editing ) ) { ?>
								<input type="hidden" name="rich_editing" value="<?php esc_attr_e( $current_user->rich_editing ); ?>"/>
							<?php } ?>
							<?php if ( ! empty( $current_user->admin_color ) ) { ?>
								<input type="hidden" name="admin_color" value="<?php esc_attr_e( $current_user->admin_color ); ?>"/>
							<?php } ?>
							<?php if ( ! empty( $current_user->comment_shortcuts ) ) { ?>
								<input type="hidden" name="comment_shortcuts" value="<?php esc_attr_e( $current_user->comment_shortcuts ); ?>"/>
							<?php } ?>
							<input type="hidden" name="admin_bar_front" value="<?php esc_attr_e( get_user_option( 'show_admin_bar_front', $current_user->ID ) ); ?>"/>

							<?php
							hrb_hidden_input_fields(
								[
									'from'         => 'profile',
									'action'       => 'app-edit-profile',
									'checkuser_id' => $user_ID,
									'user_id'      => $user_ID,
								]
							);
							?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
