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
	function trj_golem_admin_settings_error_log_initialize() {


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

		switch(true) {
			case (isset($_POST['clear_log'])):
				trj_golem_admin_error_log_button_clear_log();
				break;
		} // switch


		/* ---------- Register sections ---------- */

		// section_01
		add_settings_section(
			'trj_golem_admin_settings_error_log_section_01',				// ID used to identify this section and with which to register options
			__('Error Log Settings', 'trj_golem'),								// Title to be displayed on the administrative page
			'trj_golem_admin_settings_error_log_section_01_callback',	// Callback used to render the description of the section
			'trj_golem_admin_menu'													// Page on which to add this section of options
		);

		// section_02
		add_settings_section(
			'trj_golem_admin_settings_error_log_section_02',				// ID used to identify this section and with which to register options
			__('Error Log', 'trj_golem'),											// Title to be displayed on the administrative page
			'trj_golem_admin_settings_error_log_section_02_callback',	// Callback used to render the description of the section
			'trj_golem_admin_menu'													// Page on which to add this section of options
		);

		/* ---------- Register fields ---------- */

		// error_log_entries
		add_settings_field(
			'trj_golem_admin_settings_error_log_entries',					// ID used to identify the field throughout the theme
			__('Error Log Size', 'trj_golem'),									// The label to the left of the option interface element
			'trj_golem_admin_settings_error_log_entries_callback',		// The name of the function responsible for rendering the option interface
			'trj_golem_admin_menu',													// The page on which this option will be displayed
			'trj_golem_admin_settings_error_log_section_01',				// The name of the section to which this field belongs
			array(																		// Array of arguments to pass to the callback.
				__('The number of error log entries to be stored', 'trj_golem')
			)
		);

		/* ---------- Register settings ---------- */

		// error_log
		register_setting(
			'trj_golem_admin_settings_error_log_group_01',					// Option group. Must exist prior to this call
			'trj_golem_admin_settings_error_log',								// Option name
			'trj_golem_admin_settings_error_log_validate'					// Validation callback.
		);

	} // function trj_golem_admin_settings_general_initialize



	/* ---------- Section Callbacks ---------- */

	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_error_log_section_01_callback() {
		$html = '<p>' . __('Errors and abnormal events are logged to the database for administrative review. You can adjust the size of the error log table to control how many events are logged for troubleshooting purposes. The error log table size will be updated the next time an error is recorded.', 'trj_golem') . '<p>';
		echo $html;
	} // trj_golem_admin_settings_error_log_section_01_callback


	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_error_log_section_02_callback() {

		// Get access to the database object
		global $wpdb;
		// Query the database to get the error log entries
		$error_log_data = $wpdb->get_results(
			"
			SELECT id, message, script, user, ip, time
			FROM wp_trj_golem_error_log
			",
			ARRAY_A
		);

		// Display the table
		$html = '';
		$html .= '<p>' . __('Error log entries shown below.', 'trj_golem') . '<p>';
		$html .='<table class="widefat">';
		$html .=	'<tr>
						<th>id</th>
						<th>message</th>
						<th>script</th>
						<th>user</th>
						<th>IP address</th>
						<th>time</th>
					</tr>';
		foreach($error_log_data as $row) {
			$html .= '<tr>';
				$html .= '<td>' . $row['id'] . '</td>';
				$html .= '<td>' . $row['message'] . '</td>';
				$html .= '<td>' . $row['script'] . '</td>';
				$html .= '<td>' . $row['user'] . '</td>';
				$html .= '<td>' . $row['ip'] . '</td>';
				$html .= '<td>' . $row['time'] . '</td>';
			$html .= '</tr>';
		}
		$html .= '</table>';
		echo $html;
	} // trj_golem_admin_settings_error_log_section_02_callback


	/* ---------- Field Callbacks ---------- */

	/**
	* Display Field user interface elements
	*/
	function trj_golem_admin_settings_error_log_entries_callback($args) {
		$settings = get_option('trj_golem_admin_settings_error_log');
		$html = '<input type ="number" id="trj_golem_admin_error_log_num_records" name="trj_golem_admin_settings_error_log[num_records]" value="' . (isset($settings['num_records']) ? $settings['num_records'] : '')  . '" />';
		$html .= '<label for="trj_golem_admin_error_log_entries"> ' . $args[0] . '</label>';
		echo $html;
	} // trj_golem_admin_settings_error_log_entries_callback











	/************************************************************************
	*************************************************************************
	* Validation & Sanitizing
	*************************************************************************
	*************************************************************************
	*/

	/**
	* Validate
	*
	* Validate the settings.
	* $input is an array of settings to be validated and sanitized.
	*/
	function trj_golem_admin_settings_error_log_validate( $input ) {

		/* ---------- Initialize Variables ---------- */

		/* ---------- Set Option Name ---------- */
		// The name of the option as defined in register_setting, argument 2
		$option_name = 'trj_golem_admin_settings_error_log';

		/* ---------- Initialize Validation ---------- */
		// Create an array to hold the validated and sanitized user input
		$output = array();
		// Assume the input is good and ready for output.
		$output = $input;
		// Get the currently stored settings values from the database
		$saved_settings = get_option($option_name);


		// ------------------------------------------------------
		// Validate array index: num_records
		// ------------------------------------------------------
		/* ---------- Setup ---------- */
		// The specific array index of the option array for the element to be 
		// validated, as defined in the html input element as
		// name = "xxx[$option_key]"
		$option_key = 'num_records';
		// The friendly name of the field to be used in error messages, usually
		// as defined in add_settings_field, argument 2
		$friendly_name = __('Error Log Size', 'trj_golem');
		// The html id of the field as defined in the html input element
		// as id="$id"
		$id = 'trj_golem_admin_error_log_num_records';
		// Whether or not the setting is a required field
		$required = true;
		// Minimum
		$min = 0;
		// Maximum
		$max = 1000;
		/* ---------- Validate ---------- */
		// Make sure the input is not required
		if($required && trim($input[$option_key])=='') {
			$output[$option_key] = $saved_settings[$option_key];
			add_settings_error($id, $id, $friendly_name . __(' is a required field.', 'trj_golem'), 'error');
		} // if required
		else {
			// Make sure input is numeric
			if(!is_numeric($input[$option_key])) {
				$output[$option_key] = $saved_settings[$option_key];
				add_settings_error($id, $id, $friendly_name . __( ' not saved. Must be a numeric value.', 'trj_golem'), 'error');
			} // if
			// Make sure input is between limits
			elseif(($input[$option_key] < $min) || ($input[$option_key] > $max) ) {
				$output[$option_key] = $saved_settings[$option_key];
				add_settings_error($id, $id, $friendly_name . sprintf(__( ' not saved. Must be between %1$s and %2$s.', 'trj_golem'), $min, $max), 'error');
			} // if
		} // else
		/* ---------- End Validation Code ---------- */

		// Apply any filters registered to this function and return
		return apply_filters(__FUNCTION__, $output, $input);
	} // function trj_golem_admin_settings_error_log_validate





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
	/ Clear the error log table.
	*/
	function trj_golem_admin_error_log_button_clear_log() {
		// Access the wordpress database object
		global $wpdb;
		// Get the number or rows in the table
		$results = $wpdb->get_results('SELECT COUNT(*) FROM wp_trj_golem_error_log', ARRAY_N);
		$clip_rows = $results[0][0];
		// If rows need to be clipped, clip them
		if($clip_rows > 0) {
			$wpdb->get_results("DELETE FROM wp_trj_golem_error_log ORDER BY id ASC LIMIT $clip_rows");
		} // if
	}


?>
