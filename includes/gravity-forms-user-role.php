<?php
/**
 * Declare and initiliaze the Custom User Role field
 */
if ( ! class_exists( 'GF_Field' ) ) {
	return;
}

/**
 * GF_Field_User_Role
 *
 * A custom field to add to forms so you can perform custom conditional logic on roles.
 */
class GF_Field_User_Role extends GF_Field_Checkbox {

	/**
	 * @var string
	 */
	public $type = 'user_role';

	/**
	 * @var string
	 */
	public $inputName = 'user_role';

	/**
	 * GF_Field_User_Role constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = [] ) {
		do_action( 'qm/start', __METHOD__ );

		parent::__construct( $data );

		$this->label             = 'User Role';
		$this->enableChoiceValue = true;
		$this->visibility        = $this->is_entry_detail() || $this->is_form_editor() ? 'visible' : 'hidden';
		$this->choices           = [
			[
				'text'       => 'Freelancer',
				'value'      => 'freelancer',
				'isSelected' => true,
			],
			[
				'text'  => 'Employer',
				'value' => 'employer',
			],
		];

		do_action( 'qm/stop', __METHOD__ );
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'User Role', 'gravityforms' );
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_form_editor_button() {
		return [
			'group' => 'advanced_fields',
			'text'  => $this->get_form_editor_field_title(),
		];
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_form_editor_field_settings() {
		return [
			'choices_setting',
		];
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param array|string $value
	 * @param array        $form
	 *
	 * @return void
	 */
	public function validate( $value, $form ) {
		$user = wp_get_current_user();

		if ( ! $value || ! $user ) {
			return;
		}

		foreach ( $value as $input_id => $role ) {
			if ( ! in_array( $role, $user->roles ) ) {
				$this->failed_validation = true;

				if ( ! empty( $this->errorMessage ) ) {
					$this->validation_message = 'Sorry, you are not a member of that role.';
				}
			}
		}
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field_values
	 * @param bool  $get_from_post_global_var
	 *
	 * @return array|string
	 */
	public function get_value_submission( $field_values, $get_from_post_global_var = true ) {
		$user  = wp_get_current_user();
		$value = [];

		if ( $user && $user->roles ) {
			foreach ( $user->roles as $role ) {
				$value[ $this->id ] = $role;
			}
		}

		return $value;
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_conditional_logic_supported() {
		return true;
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param $role
	 *
	 * @return int|string
	 */
	private function get_role_id( $role ) {
		foreach ( $this->choices as $index => $choice ) {
			if ( $choice['value'] === $role ) {
				return $index + 1;
			}
		}
	}

	/**
	 * Override and return null if a multi-input field value is to be stored under the field ID instead of the
	 * individual input IDs.
	 *
	 * @return array|null
	 */
	public function get_entry_inputs() {
		if ( ! $this->inputs ) {
			$this->inputs = [];

			foreach ( $this->choices as $choice ) {
				$this->inputs[] = [
					'id'    => $this->id,
					'label' => $choice['text'],
					'name'  => '',
				];
			}
		}

		return $this->inputs;
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value
	 * @param int    $form_id
	 *
	 * @return string
	 */
	public function sanitize_entry_value( $value, $form_id ) {
		if ( is_numeric( rgar( $_GET, 'lid', false ) ) ) {
			return $value;
		}

		$user = wp_get_current_user();

		if ( ! $user || ! is_string( $value ) || ! in_array( $value, $user->roles ) ) {
			return '';
		}

		return $value;
	}
}

//GF_Fields::register( new GF_Field_User_Role() );
