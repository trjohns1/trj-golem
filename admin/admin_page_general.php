<?php
/**
* Create an administrative settings tab
*
* This file creates one tab of the administrative settings user interface.
* It is called by admin_page.php
*/

	/**
	* Register tab elements
	*
	* Register sections, fields, and settings for the tab
	*/
	function trj_golem_admin_settings_general_initialize() {

		/**
		* Check for Custom Buttons
		*
		* If the settings page includes a custom button beyond the normal
		* Save Changes provided by the WordPress Settings API
		* then those custom buttons need to be detected as follows:
		*
		* One switch statement to detect each custom button:
		*	switch(true) {
		*		case (isset($_POST['custom_button'])):
		*			trj_golem_admin_error_log_button_custom_button();
		*			break;
		}	// switch
		*/

		/* ---------- Register sections ---------- */

		add_settings_section(
			'trj_golem_admin_settings_general_section_01',				// ID used to identify this section and with which to register options
			__('Section 01', 'trj_golem'),									// Title to be displayed on the administrative page
			'trj_golem_admin_settings_general_section_01_callback',	// Callback used to render the description of the section
			'trj_golem_admin_menu'												// Page on which to add this section of options
		);

		add_settings_section(
			'trj_golem_admin_settings_general_section_02',				// ID used to identify this section and with which to register options
			__('Section 02', 'trj_golem'),									// Title to be displayed on the administrative page
			'trj_golem_admin_settings_general_section_02_callback',	// Callback used to render the description of the section
			'trj_golem_admin_menu'												// Page on which to add this section of options
		);

		/* ---------- Register fields ---------- */

		add_settings_field(
			'trj_golem_admin_settings_general_field_01',					// ID used to identify the field throughout the theme
			__('Setting 01', 'trj_golem'),									// The label to the left of the option interface element
			'trj_golem_admin_settings_general_field_01_callback',		// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',												// The page on which this option will be displayed
			'trj_golem_admin_settings_general_section_01',				// The name of the section to which this field belongs
			array(																	// Array of arguments to pass to the callback.
				__('optional argument 01', 'trj_golem')					// Optional arguments
			)
		);

		add_settings_field(
			'trj_golem_admin_settings_general_field_02',					// ID used to identify the field throughout the theme
			__('Setting 02', 'trj_golem'),									// The label to the left of the option interface element
			'trj_golem_admin_settings_general_field_02_callback',		// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',												// The page on which this option will be displayed
			'trj_golem_admin_settings_general_section_01',				// The name of the section to which this field belongs
			array(																	// Array of arguments to pass to the callback.
				__('optional argument 02', 'trj_golem')					// Optional arguments
			)
		);

		add_settings_field(
			'trj_golem_admin_settings_general_field_03',					// ID used to identify the field throughout the theme
			__('Setting 03', 'trj_golem'),									// The label to the left of the option interface element
			'trj_golem_admin_settings_general_field_03_callback',		// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',												// The page on which this option will be displayed
			'trj_golem_admin_settings_general_section_02',				// The name of the section to which this field belongs
			array(																	// Array of arguments to pass to the callback.
				__('optional argument 03', 'trj_golem')					// Optional arguments
			)
		);

		add_settings_field(
			'trj_golem_admin_settings_general_field_04',					// ID used to identify the field throughout the theme
			__('Setting 04', 'trj_golem'),									// The label to the left of the option interface element
			'trj_golem_admin_settings_general_field_04_callback',		// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',												// The page on which this option will be displayed
			'trj_golem_admin_settings_general_section_02',				// The name of the section to which this field belongs
			array(																	// Array of arguments to pass to the callback.
				__('option 1', 'trj_golem'),													// Optional arguments
				__('option 2', 'trj_golem'),
				__('option 3', 'trj_golem')
			)
		);


		/* ---------- Register settings ---------- */

		register_setting(
			'trj_golem_admin_settings_general_group_01',					// Option group. Must exist prior to this call
			'trj_golem_admin_settings_general',								// Option name
			'trj_golem_admin_settings_general_validate'					// Validation callback
		);

	} // function trj_golem_admin_settings_general_initialize




	/* ---------- Section Callbacks ---------- */

	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_general_section_01_callback() {
		$html = '<p>' . __('This function displays the user interface elements of section 01.', 'trj_golem') . '<p>';
		echo $html;
	} // function trj_golem_admin_settings_general_section_01_callback

	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_general_section_02_callback() {
		$html = '<p>' . __('This function displays the user interface elements of section 02.', 'trj_golem') . '<p>';
		echo $html;
	} // function trj_golem_admin_settings_general_section_02_callback




	/* ---------- Field Callbacks ---------- */

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_general_field_01_callback($args) {
		$settings = get_option('trj_golem_admin_settings_general');
		$html = '<input type ="text" id="trj_golem_admin_general_option_01" name="trj_golem_admin_settings_general[option_01]" value="' . (isset($settings['option_01']) ? $settings['option_01'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_general_option_01"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_general_field_01_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_general_field_02_callback($args) {
		$settings = get_option('trj_golem_admin_settings_general');
		$html = '<input type ="number" id="trj_golem_admin_general_option_02" name="trj_golem_admin_settings_general[option_02]" value="' . (isset($settings['option_02']) ? $settings['option_02'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_general_option_02"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_general_field_02_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_general_field_03_callback($args) {
		$settings = get_option('trj_golem_admin_settings_general');
		$html = '<input type ="checkbox" id="trj_golem_admin_general_option_03" name="trj_golem_admin_settings_general[option_03]" value="1" ' . checked(1, isset($settings['option_03']), false) . '/>';
		$html .= '<label for="trj_golem_admin_general_option_03"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_general_field_03_callback

	/**
	* Display field user interface elements
	*/
	function trj_golem_admin_settings_general_field_04_callback($args) {
		$settings = get_option('trj_golem_admin_settings_general');
		$html = '<select id="trj_golem_admin_general_option_04" name="trj_golem_admin_settings_general[option_04]" >';
			$html .= '<option value="">Select a time option...</option>';
			$html .= '<option value="never"' .     (isset($settings['option_04']) ? selected($settings['option_04'], 'never', false) : '') . '>Never</option>';
			$html .= '<option value="sometimes"' . (isset($settings['option_04']) ? selected($settings['option_04'], 'sometimes', false) : '') . '>Sometimes</option>';
			$html .= '<option value="always"' . (isset($settings['option_04']) ? selected($settings['option_04'], 'always', false) : '') . '>Always</option>';
		$html .= '</select>';;
		echo $html;
	} // trj_golem_admin_settings_templates_field_select_callback







	/************************************************************************
	*************************************************************************
	* Validation & Sanitizing
	*************************************************************************
	*************************************************************************
	*/

	/**
	* Validate
	*
	* Validate the trj_golem_admin_settings_templates settings.
	* $input is an array of settings to be validated and sanitized.
	*/
	function trj_golem_admin_settings_general_validate( $input ) {

		/* ---------- Set Option Name ---------- */
		// The name of the option as defined in register_setting, argument 2
		$option_name = 'trj_golem_admin_settings_general';

		/* ---------- Initialize Validation ---------- */
		// Create an array to hold the validated and sanitized user input
		$output = array();
		// Assume the input is good and ready for output.
		$output = $input;
		// Get the currently stored settings values from the database
		$saved_settings = get_option($option_name);


		// ------------------------------------------------------
		// Validate array index: text
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'option_01';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('OPTION_01', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_general_option_01';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 255;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// If the input contains forbidden characters escape them
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = $clean_str;
				add_settings_error($id, $id, $friendly_name . __( ' contains forbidden characters. These characters have been modified for safe storage and display. Please make sure the values are still what you want.', 'trj_golem'), 'updated');
			} // if
			// Make sure input is between limits
			if((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */


		// ------------------------------------------------------
		// Validate array index: number
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'option_02';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('OPTION_02', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_general_option_02';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum
		$min = 1;
		// Maximum
		$max = 10;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is numeric
			if(!is_numeric($input[$option_key])) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Must be a numeric value.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif(($input[$option_key] < $min) || ($input[$option_key] > $max) ) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */


		// ------------------------------------------------------
		// Validate array index: checkbox
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'option_03';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('OPTION_03', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_general_option_03';
		// Whether or not the setting is a required field
		$required = false; // checkboxes cannot be required.
		// Minimum length
		$min = 1;
		// Maximum length
		$max = 255;
		/* ---------- Validate ---------- */
		// If the input is bad, replace the output value with the saved value and set an error message.
		if(isset($input[$option_key])) {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = $saved_settings[$option_key];
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif((strlen($input[$option_key]) < $min) || (strlen($input[$option_key]) > $max) ) {
				$output[$option_key] = $saved_settings[$option_key];
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s characters.', 'trj_golem'), $min, $max), 'error');
			} // elseif
		} // else
		/* ---------- End Validation Code ---------- */

		// ------------------------------------------------------
		// Validate array index: select
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be validated, as defined in the html input element as name = "xxx[$option_key]"
		$option_key = 'option_04';
		// The friendly name of the field to be used in error messages, usually as defined in add_settings_field, argument 2
		$friendly_name = __('OPTION_04', 'trj_golem');
		// The html id of the field as defined in the html input element as id="$id"
		$id = 'trj_golem_admin_general_option_04';
		// Whether or not the setting is a required field
		$required = true;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = $saved_settings[$option_key];
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input contains no forbidden characters
			$clean_str = htmlspecialchars($input[$option_key]);
			if($input[$option_key] != $clean_str) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Contains forbidden characters.', 'trj_golem'), 'error');
			} // if
			// Make sure input is a valid selection
			$valid_input = false;
			if (
					$input[$option_key] == 'never' || 
					$input[$option_key] == 'sometimes' ||
					$input[$option_key] == 'always'
				) {
				$valid_input = true;
			} // if
			if(!$valid_input) {
				$output[$option_key] = isset($saved_settings[$option_key]) ? $saved_settings[$option_key] : '';
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Not a valid choice.', 'trj_golem'), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */



		/* ---------- All Validation Complete: Return ---------- */
		// Apply any filters registered to this function and return
		return apply_filters(__FUNCTION__, $output, $input);
	} // function trj_golem_admin_settings_general_validate






	/************************************************************************
	*************************************************************************
	* Custom Buttons
	*************************************************************************
	*************************************************************************
	* Manage buttons other than submit
	*
	* The WordPress Settings API saves fields when the submit button is pressed,
	* but has no method for handling custom buttons. Functions for each custom
	* button should be defined here and called from the switch statement at the
	* top of this file.
	*/

	/**
	* Process custom button
	*/
	/*
	function trj_golem_admin_error_log_button_custom_button() {
		// insert custom button handling code here
	}
	*/

?>
