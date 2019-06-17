<?php
/**
* cars_edit
*
* Sample script for the cars application. Allows the user to edit an existing
* database record or delete one.
*/

	/**
	* cars_edit
	*
	* Receives a GET request containing a record id in the query string.
	* Creates a form and populates it with data from the database corresponding
	* to that record id.
	* Generates an error if the requested record does not exist.
	* Receives a POST request containing updated information for an existing
	* record id. Updates the database with the new information.
	*/



	/************************************************************************
	*************************************************************************
	* Controller
	*************************************************************************
	*************************************************************************
	*/


	/**
	* trj_golem_cars_edit
	*
	* Primary control logic for the script. Determines which action to take
	* based on what button was submitted by the user.
	*/
	function trj_golem_cars_edit () {
	
		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// If user is not authorized set error and return early
		$script_permission = 'trj_golem_permission_1';
		if(!current_user_can($script_permission)) {
			$message = "UNAUTHORIZED PAGE ACCESS ATTEMPT";
			trj_golem_set_page_error($message);
			trj_golem_display_page_error();
			return;
		} // if

		// Initialize form validation error message. False means no form validation errors have occurred.
		$trj_golem_data['script']['form_error'] = false;

		// Get data statically and from the database that will be needed to display, validate, and process the page
		$trj_golem_data = trj_golem_get_page_data($trj_golem_data);
		// If a page error was generated getting page data, display the error and return early
		if(trj_golem_has_page_error()) {
			trj_golem_display_page_error();
			return;
		} // if

		// Get the query variables provided by the user. Do this for each form.
			$trj_golem_data['script']['user_query_vars'] = trj_golem_get_query_vars($trj_golem_data['script']['form']);

		// If the request is an http POST process the user-submitted data
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

			// If POST exceeds post_max_size in PHP configuration display error and return early
			if (empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {
				trj_golem_set_page_error('You have attempted to upload data that exceeds the maximum allowed by the server.');
				trj_golem_display_page_error();
				return;
			}
			else {
				// Determine which form action was submitted and take appropriate action
				switch(true) {
					case (isset($_POST['trj_golem_save'])):
						// Validate the request and get any errors
						$trj_golem_data = trj_golem_validate_save($trj_golem_data);
						// If no errors were found process the form
						if ( !$trj_golem_data['script']['form_error'] ) {
							trj_golem_process_save($trj_golem_data);
						}
						break;
					case (isset($_POST['trj_golem_cancel'])):
						// Validate the request and get any errors
						$trj_golem_data = trj_golem_validate_cancel($trj_golem_data);
						// If no errors were found process the form
						if ( !$trj_golem_data['script']['form_error'] ) {
							trj_golem_process_cancel($trj_golem_data);
						}
						break;
					default:
						// Do this if the user's submit request is unrecognized
						trj_golem_set_page_error('Unrecognized HTML form button in ' . __FILE__ . '.');
				} // switch
			} // else
		} // if


		// If the request is an http GET process the user-submitted data
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			// Validate the request and get any errors
			$trj_golem_data = trj_golem_validate_get($trj_golem_data);
			// If no errors were found process the form
			if ( !$trj_golem_data['script']['form_error'] ) {
				trj_golem_process_get($trj_golem_data);
			}
		}

		// Call the view
		trj_golem_view();

	} // function trj_golem_cars_edit





	/**
	* Get Page Data
	*
	* Get data for the display and processing of the page.
	* Get both static defaults and data pulled from the database.
	* This includes data needed to setup both GET and POST requests.
	*
	* Form controls are created in this function so that their values can be
	* populated statically or from the database.
	*
	* If the page has more than one form use:
	* - $trj_golem_data['script']['form1']
	* - $trj_golem_data['script']['form2']
	* - etc.
	*
	* @return a modified $trj_golem_data data structure containing page data.
	*/
	function trj_golem_get_page_data($trj_golem_data) {

		// Make sure the requested record is valid
		$user_record_id = 'trj_golem_record_id';		// name of record id in query string or POST
		$id_column = 'id';									// the name of the record id in the database table
		$table = 'wp_trj_golem_car';						// the database table name
		$record_id = trj_golem_record_in_db($user_record_id, $id_column, $table);
	
		// If user-provided record is invalid display error and return early
		if( !$record_id ) {
			$message = "Attempt to access an invalid record.";
			trj_golem_set_page_error($message);
			return;
		} // if

		// Get the Wordpress database object
		global $wpdb;
		// Get the record from the database
		$record = $wpdb->get_row("SELECT * FROM wp_trj_golem_car WHERE id=$record_id");

		// Get or create a list of valid select options
		$trj_golem_data['script']['valid_makes'] = array(
			'Audi',
			'BMW',
			'Mini',
			'Tesla'
		);

		// Create form control make
		$trj_golem_data['script']['form']['trj_golem_make'] = new trj_golem_form_element_select();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_make']->name='trj_golem_make';
		$trj_golem_data['script']['form']['trj_golem_make']->multiple=false;

			// Create option 1
			$trj_golem_data['script']['form']['trj_golem_make']->options['option1'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option1']->value=$trj_golem_data['script']['valid_makes'][0];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option1']->inner_text=$trj_golem_data['script']['valid_makes'][0];
			// Set option as selected if it matches the database record
			if($trj_golem_data['script']['form']['trj_golem_make']->options['option1']->value == $record->make) {
				$trj_golem_data['script']['form']['trj_golem_make']->options['option1']->selected=true;
			} // if

			// Create option 2
			$trj_golem_data['script']['form']['trj_golem_make']->options['option2'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option2']->value=$trj_golem_data['script']['valid_makes'][1];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option2']->inner_text=$trj_golem_data['script']['valid_makes'][1];
			// Set option as selected if it matches the database record
			if($trj_golem_data['script']['form']['trj_golem_make']->options['option2']->value == $record->make) {
				$trj_golem_data['script']['form']['trj_golem_make']->options['option2']->selected=true;
			} // if

			// Create option 3
			$trj_golem_data['script']['form']['trj_golem_make']->options['option3'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option3']->value=$trj_golem_data['script']['valid_makes'][2];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option3']->inner_text=$trj_golem_data['script']['valid_makes'][2];
			// Set option as selected if it matches the database record
			if($trj_golem_data['script']['form']['trj_golem_make']->options['option3']->value == $record->make) {
				$trj_golem_data['script']['form']['trj_golem_make']->options['option3']->selected=true;
			} // if

			// Create option 4
			$trj_golem_data['script']['form']['trj_golem_make']->options['option4'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option4']->value=$trj_golem_data['script']['valid_makes'][3];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option4']->inner_text=$trj_golem_data['script']['valid_makes'][3];
			// Set option as selected if it matches the database record
			if($trj_golem_data['script']['form']['trj_golem_make']->options['option4']->value == $record->make) {
				$trj_golem_data['script']['form']['trj_golem_make']->options['option4']->selected=true;
			} // if

		// Create form control model
		$trj_golem_data['script']['form']['trj_golem_model'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_model']->name='trj_golem_model';
		$trj_golem_data['script']['form']['trj_golem_model']->type='text';
		$trj_golem_data['script']['form']['trj_golem_model']->value=$record->model;

		// Create form control auto
		$trj_golem_data['script']['form']['trj_golem_auto'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_auto']->name='trj_golem_auto';
		$trj_golem_data['script']['form']['trj_golem_auto']->type='checkbox';
		$trj_golem_data['script']['form']['trj_golem_auto']->checked=$record->automatic;

		// Create save control
		$trj_golem_data['script']['form']['trj_golem_save'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_save']->name='trj_golem_save';
		$trj_golem_data['script']['form']['trj_golem_save']->type='submit';

		// Create cancel control
		$trj_golem_data['script']['form']['trj_golem_cancel'] = new trj_golem_form_element_button();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_cancel']->name='trj_golem_cancel';
		$trj_golem_data['script']['form']['trj_golem_cancel']->type='submit';

		/* ---------- Hidden Record ID Element ---------- */
		// Create form hidden input control for script
		$trj_golem_data['script']['form']['trj_golem_record_id'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_record_id']->name='trj_golem_record_id';
		$trj_golem_data['script']['form']['trj_golem_record_id']->type='text';
		$trj_golem_data['script']['form']['trj_golem_record_id']->value=$record_id;
		// Set display attributes
		$trj_golem_data['script']['form']['trj_golem_record_id']->hidden=true;

		/* ---------- Hidden Current Script Element ---------- */
		// Create form hidden input control for script
		$trj_golem_data['script']['form']['trj_golem_script'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_script']->name='trj_golem_script';
		$trj_golem_data['script']['form']['trj_golem_script']->type='text';
		$trj_golem_data['script']['form']['trj_golem_script']->value=$trj_golem_data['current_script'];
		// Set display attributes for form hidden input control for script
		$trj_golem_data['script']['form']['trj_golem_script']->hidden=true;

		return $trj_golem_data;
	} // trj_golem_get_page_data




	/**
	* trj_golem_validate_get
	*
	* Validates input provided to the script via URL query arguments.
	*
	* A GET request that contains no query string will not need to be validated.
	* However, a GET request with a query string will require validation.
	* Often this validation is the same as the script's validate_save() function.
	* In this case, validate_get() can simply call validate_save().
	* Alternatively, validate_get() can implement its own validation code.
	*
	* Sets an overall form error message in $trj_golem_data['form_error'] if there
	* are errors. Otherwise $trj_golem_data['form_error'] is set to false.
	*
	* Sets an error message in the error_message property of each form element
	* for which the user provided invalid input. If a form element has no errors
	* then the error_message property is left unchanged.
	*
	* If there is a form error, then valid user input is saved to the form
	* element objects for redisplay so the user does not have to retype the
	* entire form.
	*
	* There should be a VALIDATE FORM ELEMENT block for each form element.
	* The VALIDATE FORM ELEMENT block consists of two parts:
	* - TEST REQUIRED STATUS: looks for missing or empty submissions
	* - TEST DATA VALIDITY: checks that user-supplied data is within specification.
	*
	* Note that if form attributes are set to multiple validation rules should be
	* sure to check for arrays instead of strings.
	*
	* There is no need to validate the trj_golem_script element because that is
	* checked by the core plugin and an error thrown if it is malformed.
	*
	* @ return entire updated data structure.
	*/
	function trj_golem_validate_get($trj_golem_data) {
		// Nothing to validate
		return $trj_golem_data;
	} // trj_golem_validate_cancel




	/**
	* trj_golem_process_get
	*
	* Processes a user get request.
	*
	*/
	function trj_golem_process_get($trj_golem_data) {
		// Nothing to process
		return true;
		}





	/**
	* Validate Save
	*
	* Validates user input.
	*
	* Sets an overall form error message in $trj_golem_data['form_error'] if there
	* are errors. Otherwise $trj_golem_data['form_error'] is set to false.
	*
	* Sets an error message in the error_message property of each form element
	* for which the user provided invalid input. If a form element has no errors
	* then the error_message property is left unchanged.
	*
	* If there is a form error, then valid user input is saved to the form
	* element objects for redisplay so the user does not have to retype the
	* entire form.
	*
	* There should be a VALIDATE FORM ELEMENT block for each form element.
	* The VALIDATE FORM ELEMENT block consists of two parts:
	* - TEST REQUIRED STATUS: looks for missing or empty submissions
	* - TEST DATA VALIDITY: checks that user-supplied data is within specification.
	*
	* Note that if form attributes are set to multiple validation rules should be
	* sure to check for arrays instead of strings.
	*
	* File upload validation (<input type="file">) should be validated manually
	* as its content does not show up in $_POST or $trj_golem_data['script']['user_query_vars'].
	*
	* There is no need to validate the trj_golem_script element because that is
	* checked by the core plugin and an error thrown if it is malformed.
	*
	* @ return entire updated data structure.
	*/
	function trj_golem_validate_save($trj_golem_data) {

		// Inititalize the form error flag assuming no errors yet found.
		$trj_golem_data['form_error']= false;

		/* ****************************************************************************************** */
		/* VALIDATE FORM ELEMENT ******************************************************************** */
		/* ****************************************************************************************** */
		$testField = 'trj_golem_make';
		/*
		/* ****************************** TEST REQUIRED STATUS ****************************** */
		/* ********** SETUP ********** */
		$required = false;
		$required_message = "Required";
		/* ********** TEST ********** */
		// If the field is required and not present set a required error message
		$empty = false;
		if (!isset($trj_golem_data['script']['user_query_vars'][$testField])) {
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // if
		// Else if the field is required and empty set a required error message
		elseif (trim($trj_golem_data['script']['user_query_vars'][$testField]) == '') { // Adjust allowed whitespace here
			$empty = true;
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // elseif
		/* ********** END OF TEST ********** */

		/* ****************************** TEST DATA VALIDITY ****************************** */
		if (isset($trj_golem_data['script']['user_query_vars'][$testField]) && !$empty) {

			/* ********** TEST THAT SELECTION IS A VALID CHOICE ********** */
			/* ********** SETUP ********** */
			$error_message = "Invalid selection.";
			/* ********** TEST ********** */
			if(!in_array($trj_golem_data['script']['user_query_vars'][$testField], $trj_golem_data['script']['valid_makes'])) {
				$trj_golem_data['script']['form'][$testField]->error_message=$error_message;
			} // if
			/* ********** END OF TEST ********** */

		} // if
		/* ****************************************************************************************** */
		/* END OF FORM ELEMENT VALIDATION *********************************************************** */
		/* ****************************************************************************************** */



		/* ****************************************************************************************** */
		/* VALIDATE FORM ELEMENT ******************************************************************** */
		/* ****************************************************************************************** */
		$testField = 'trj_golem_model';
		/*
		/* ****************************** TEST REQUIRED STATUS ****************************** */
		/* ********** SETUP ********** */
		$required = true;
		$required_message = "Required";
		/* ********** TEST ********** */
		// If the field is required and not present set a required error message
		$empty = false;
		if (!isset($trj_golem_data['script']['user_query_vars'][$testField])) {
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // if
		// Else if the field is required and empty set a required error message
		elseif (trim($trj_golem_data['script']['user_query_vars'][$testField]) == '') { // Adjust allowed whitespace here
			$empty = true;
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // elseif
		/* ********** END OF TEST ********** */

		/* ****************************** TEST DATA VALIDITY ****************************** */
		if (isset($trj_golem_data['script']['user_query_vars'][$testField]) && !$empty) {

			/* ********** TEST FOR DATA IN RANGE ********** */
			/* ********** SETUP ********** */
			$min = 1;
			$max = 10;
			$range_error = "Out of range. Must be between $min and $max characters.";
			/* ********** TEST ********** */
			if(isset($trj_golem_data['script']['user_query_vars'][$testField])) {
				if( (strlen($trj_golem_data['script']['user_query_vars'][$testField]) < $min) || (strlen($trj_golem_data['script']['user_query_vars'][$testField]) > $max ) ) {
					if(!isset($trj_golem_data['script']['form'][$testField]->error_message)) {
						$trj_golem_data['script']['form'][$testField]->error_message=$range_error;
					} // if
				} // if
			} // if
			/* ********** END OF TEST ********** */

		} // if
		/* ****************************************************************************************** */
		/* END OF FORM ELEMENT VALIDATION *********************************************************** */
		/* ****************************************************************************************** */



		/* ****************************************************************************************** */
		/* VALIDATE FORM ELEMENT ******************************************************************** */
		/* ****************************************************************************************** */
		$testField = 'trj_golem_auto';
		/*
		/* ****************************** TEST REQUIRED STATUS ****************************** */
		/* ********** SETUP ********** */
		$required = false;
		$required_message = "Required";
		/* ********** TEST ********** */
		// If the field is required and not present set a required error message
		$empty = false;
		if (!isset($trj_golem_data['script']['user_query_vars'][$testField])) {
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // if
		// Else if the field is required and empty set a required error message
		elseif (trim($trj_golem_data['script']['user_query_vars'][$testField]) == '') { // Adjust allowed whitespace here
			$empty = true;
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // elseif
		/* ********** END OF TEST ********** */

		/* ****************************** TEST DATA VALIDITY ****************************** */
		if (isset($trj_golem_data['script']['user_query_vars'][$testField]) && !$empty) {

			// No need to validate checkboxes

		} // if
		/* ****************************************************************************************** */
		/* END OF FORM ELEMENT VALIDATION *********************************************************** */
		/* ****************************************************************************************** */



		/* ---------- CHECK FOR OVERALL FORM ERRORS ---------- */
		// Check if any errors were found in the form and set an overall form error message.
		$form_error_message = "Input Error. Please check your entries and resubmit.";
		$errors = 0;
		foreach($trj_golem_data['script']['form'] as $form_element) {
			if (isset($form_element->error_message)) {
				$errors++;
			} // if
		} // foreach
		if($errors) {
			$trj_golem_data['script']['form_error'] = $form_error_message;
		} // if



		/* ----------------------------------------------------------------------------------------------- */
		/* ------------------------------ SAVE USER FORM DATA FOR REDISPLAY ------------------------------ */
		/* ----------------------------------------------------------------------------------------------- */
		// If there is an error, save any user-provided data for redisplay
		// so the user does not have to retype it.
		if($trj_golem_data['script']['form_error']) {
			$trj_golem_data['script']['form'] = trj_golem_save_for_redisplay($trj_golem_data['script']['form'], $trj_golem_data['script']['user_query_vars']);
		} // if

		// Return the updated form
		return $trj_golem_data;
	} // trj_golem_validate_save



	/**
	* Process Save
	*
	* Takes validated user input saves it to the database.
	* Redirects upon completion.
	*
	*/
	function trj_golem_process_save($trj_golem_data) {

		// Access the wordpress database object
		global $wpdb;

		/* ---------- PREP USER SUBMITTED DATA ---------- */
		$trj_golem_make = isset ($trj_golem_data['script']['user_query_vars']['trj_golem_make']) ? $trj_golem_data['script']['user_query_vars']['trj_golem_make'] : NULL;
		$trj_golem_model = isset ($trj_golem_data['script']['user_query_vars']['trj_golem_model']) ? $trj_golem_data['script']['user_query_vars']['trj_golem_model'] : NULL;
		$trj_golem_auto = isset ($trj_golem_data['script']['user_query_vars']['trj_golem_auto']) ? true: false;


		/* ---------- INSERT THE DATA INTO THE DATABASE ---------- */
		$wpdb->update(
			'wp_trj_golem_car',
			array(
				'make' => $trj_golem_make,
				'model' => $trj_golem_model,
				'automatic' => $trj_golem_auto
			),
			array('id' => $trj_golem_data['script']['user_query_vars']['trj_golem_record_id']),
			array(
				'%s',
				'%s',
				'%d'
			)
		); // insert


		// Redirect
		$url = 'https://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"],'?') . '?page_id=' . $trj_golem_data['init']['plugin_home_page'];
		wp_redirect($url, $status=303);

		return;
		} // trj_golem_process_save



	/**
	* trj_golem_validate_cancel
	*
	* Validates user input.
	*
	* @ return entire updated data structure.
	*/
	function trj_golem_validate_cancel($trj_golem_data) {
		// Nothing to validate
		return $trj_golem_data;
	} // trj_golem_validate_cancel




	/**
	* trj_golem_process_cancel
	*
	* Processes a user cancel request.
	* Redirects upon completion.
	*
	*/
	function trj_golem_process_cancel($trj_golem_data) {

		// Redirect
		$url = 'https://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"],'?') . '?page_id=' . $trj_golem_data['init']['plugin_home_page'] . '&trj_golem_script=trj_golem_cars_list';
		wp_redirect($url, $status=303);

		return true;
		}










	/************************************************************************
	*************************************************************************
	* View
	*************************************************************************
	*************************************************************************
	* Displays the user interface
	*
	* The view is broken down into two functions:
	* - trj_golem_prep_view
	* - trj_golem_display_view
	*
	* trj_golem_prep_view does any processing of view data necessary to present
	* the view. No html is managed here.
	*
	* trj_golem_display_view simply presents the view. This function handles
	* all of the html. The only PHP that should be present is very basic
	* templating logic in support of creating the HTML.
	*/


	/**
	* trj_golem_view
	*
	* Manages the view by checking for errors, then preparing the view and
	* displaying it.
	*/
	function trj_golem_view() {

		// Primary data structure for the plugin
		global $trj_golem_data;

		// If there is a page error display it and return early
		if ( trj_golem_has_page_error() ) {
			trj_golem_display_page_error();
			return;
		} // if

		// Prep the view
		$trj_golem_data = trj_golem_prep_view($trj_golem_data);

		// Display the view by updating the content using the_content filter
		add_filter( 'the_content', 'trj_golem_display_view' );

		return;

	} // function trj_golem_view


	/**
	* trj_golem_prep_view
	*
	* Prepares data for the view.
	* Insert code here to do any calculations, database lookups, etc.
	* needed to get the view ready for display.
	*
	* This function is to prevent trj_golem_display_view from having to have
	* much logic in it.
	*
	* @return an updated copy of the data structure
	*/
	function trj_golem_prep_view($trj_golem_data) {

		// Set display attributes for form control make
		$trj_golem_data['script']['form']['trj_golem_make']->label_text='Make';
		$trj_golem_data['script']['form']['trj_golem_make']->class = 'trj_golem_form_element_input';

		// Set display attributes for form control model
		$trj_golem_data['script']['form']['trj_golem_model']->placeholder='Enter auto model...';
		$trj_golem_data['script']['form']['trj_golem_model']->label_text='Model';
		$trj_golem_data['script']['form']['trj_golem_model']->helper_text='Include trim variant';
		$trj_golem_data['script']['form']['trj_golem_model']->class = 'trj_golem_form_element_input';

		// Set display attributes for form control auto
		$trj_golem_data['script']['form']['trj_golem_auto']->placeholder='Enter auto model...';
		$trj_golem_data['script']['form']['trj_golem_auto']->label_text='Automatic?';
		$trj_golem_data['script']['form']['trj_golem_auto']->helper_text='Leave unchecked for manual transmission.';
		$trj_golem_data['script']['form']['trj_golem_auto']->class = 'trj_golem_form_element_input';

		// Set display attributes for control save
		$trj_golem_data['script']['form']['trj_golem_save']->value='Update';
		$trj_golem_data['script']['form']['trj_golem_save']->class='trj_golem_button_primary';

		// Set display attributes for control cancel
		$trj_golem_data['script']['form']['trj_golem_cancel']->value='Cancel';
		$trj_golem_data['script']['form']['trj_golem_cancel']->inner_text='Cancel';
		$trj_golem_data['script']['form']['trj_golem_cancel']->class='trj_golem_button_secondary';
		$trj_golem_data['script']['form']['trj_golem_cancel']->hidden=false;

		// Get the URL of the current WordPress instance
		$trj_golem_data['script']['site_url'] = get_site_url();

		return $trj_golem_data;

	} // function trj_golem_prep_view




	/**
	* trj_golem_display_view
	*
	* Render the HTML for the view
	*
	* @return $content
	*/
	function trj_golem_display_view($content) {

		// Primary data structure for the plugin
		global $trj_golem_data;

		// Build the View
		$view = PHP_EOL;

		// Open page container
		$view .= '<div class="trj_golem_frame">';

		// Build the View
		$view .= "<h2>Cars - Edit</h2>";

		// Render error message if necessary
		$view .= ($trj_golem_data['script']['form_error']) 
						? '<p class="trj_golem_error">' . $trj_golem_data['script']['form_error'] . '</p>' 
						: '';
		// Create the form
		$view .= '<form action="' . $trj_golem_data['script']['site_url'] . '/?page_id=' . $trj_golem_data['init']['plugin_home_page'] . '" method="POST" enctype="multipart/form-data">';

		// Render hidden form elements
		$view .= 	$trj_golem_data['script']['form']['trj_golem_script']->get_form_element();
		$view .= 	$trj_golem_data['script']['form']['trj_golem_script']->get_form_element();
		$view .= 	$trj_golem_data['script']['form']['trj_golem_record_id']->get_form_element();



		/*
		*	Create the form layout in a table
		*/

		$view .= '<table class="trj_golem_form_table">';

		$view .=		'<tr>';
		$view .=			'<td>';
		$view .=				'<p class="trj_golem_form_element_label_text">' .$trj_golem_data['script']['form']['trj_golem_make']->label_text . '</p>';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_make']->helper_text)) 
									? '<p class="trj_golem_form_element_helper_text">' . $trj_golem_data['script']['form']['trj_golem_make']->helper_text . '</p>' 
									: '';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_make']->error_message)) 
									? '<p class="trj_golem_form_element_error_message">' . $trj_golem_data['script']['form']['trj_golem_make']->error_message . '</p>' 
									: '';
		$view .=			'</td>';
		$view .=			'<td>';
		$view .=				$trj_golem_data['script']['form']['trj_golem_make']->get_form_element();
		$view .=			'</td>';
		$view .=		'</tr>';
		$view .=		'<tr>';
		$view .=			'<td>';
		$view .=				'<p class="trj_golem_form_element_label_text">' .$trj_golem_data['script']['form']['trj_golem_model']->label_text . '</p>';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_model']->helper_text)) 
									? '<p class="trj_golem_form_element_helper_text">' . $trj_golem_data['script']['form']['trj_golem_model']->helper_text . '</p>' 
									: '';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_model']->error_message)) 
									? '<p class="trj_golem_form_element_error_message">' . $trj_golem_data['script']['form']['trj_golem_model']->error_message . '</p>' 
									: '';
		$view .=			'</td>';
		$view .=			'<td>';
		$view .=				$trj_golem_data['script']['form']['trj_golem_model']->get_form_element();
		$view .=			'</td>';
		$view .=		'</tr>';
		$view .=		'<tr>';
		$view .=			'<td>';
		$view .=				'<p class="trj_golem_form_element_label_text">' .$trj_golem_data['script']['form']['trj_golem_auto']->label_text . '</p>';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_auto']->helper_text)) 
									? '<p class="trj_golem_form_element_helper_text">' . $trj_golem_data['script']['form']['trj_golem_auto']->helper_text . '</p>' 
									: '';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_auto']->error_message)) 
									? '<p class="trj_golem_form_element_error_message">' . $trj_golem_data['script']['form']['trj_golem_auto']->error_message . '</p>' 
									: '';
		$view .=			'</td>';
		$view .=			'<td>';
		$view .=				$trj_golem_data['script']['form']['trj_golem_auto']->get_form_element();
		$view .=			'</td>';
		$view .=		'</tr>';

		// close the table
		$view .= '</table>';

		// render action buttons
		$view .= PHP_EOL;
		$view .= $trj_golem_data['script']['form']['trj_golem_save']->get_form_element();
		$view .= PHP_EOL;
		$view .=	$trj_golem_data['script']['form']['trj_golem_cancel']->get_form_element();

		$view .= '</form>';

		// close page container
		$view .= '</div> <!-- id="trj_golem" -->';

		// Break the content into pre and post insertion point components
		$content_parts = explode($trj_golem_data['html_insertion_point_string'], $content, 2);
		// If there is no insertion point, set second half of content to empty string
		if(!isset($content_parts[1])){
			$content_parts[1]='';
		}
		// Assemble the content with plugin html at the insertion point
		$content = $content_parts[0] . $view . $content_parts[1];

		return $content;

	} // function trj_golem_display_view

?>
