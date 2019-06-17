<?php
/**
* cars_list
*
* Sample script for the cars application. Allows the user to search the
* database and list results.
*/


	/**
	* cars_list
	*
	* This script takes all search terms as query arguments in the URL and
	* performs a search and display based on a GET request. If no search
	* terms are provided then the form is displayed with no results listing.
	* If search terms are provided in the URL then the results of the search
	* are displayed. If the search terms are invalid, an error message is
	* displayed.
	*
	* If the user submits the search request via POST, then the submitted
	* data is validated before being processed and an error message displayed
	* if necessary. If the submitted data is valid, the script takes the 
	* search terms and uses them to construct a URL containing the desired
	* search terms and issues that search via GET request back to this
	* script. Thus, all searches are processed via GET.
	*
	* This script is configured to use the same validation function for both
	* GET and POST requests, so validation rules can be streamlined.
	*
	* Note that the script is configured to treat the submission of an empty
	* string as a wildcard search, the same as if no search term is submitted.
	*
	* This script supports pagination of results listings.
	*/


	/************************************************************************
	*************************************************************************
	* Controller
	*************************************************************************
	*************************************************************************
	*/


	/**
	* trj_golem_cars_list
	*
	* Primary control logic for the script. Determines which action to take
	* based on what button was submitted by the user.
	*/
	function trj_golem_cars_list () {
	
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
					case (isset($_POST['trj_golem_search'])):
						// Validate the request and get any errors
						$trj_golem_data = trj_golem_validate_search($trj_golem_data);
						// If no errors were found process the form
						if ( !$trj_golem_data['script']['form_error'] ) {
							trj_golem_process_search($trj_golem_data);
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
			// if the user provided arguments, then validate and process them.
			if (trj_golem_has_args($trj_golem_data['script']['user_query_vars'])) {
				// Validate the request and get any errors
				$trj_golem_data = trj_golem_validate_get($trj_golem_data);		
				// If no errors were found process the form
				if ( !$trj_golem_data['script']['form_error'] ) {
					$trj_golem_data = trj_golem_process_get($trj_golem_data);
				} // if
			} // if
		} // if

		// Call the view
		trj_golem_view();


	} // function trj_golem_cars_list








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

		// Get or create a list of valid select options
		$trj_golem_data['script']['valid_numresults'] = array(
			'0',
			'1',
			'2',
			'5',
			'10',
			'50',
			'100'
		);

		// Create form control numresults
		$trj_golem_data['script']['form']['trj_golem_numresults'] = new trj_golem_form_element_select();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_numresults']->name='trj_golem_numresults';
		$trj_golem_data['script']['form']['trj_golem_numresults']->type='text';

			// Create option 1
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option1'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option1']->value=$trj_golem_data['script']['valid_numresults'][0];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option1']->inner_text=$trj_golem_data['script']['valid_numresults'][0];

			// Create option 2
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option2'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option2']->value=$trj_golem_data['script']['valid_numresults'][1];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option2']->inner_text=$trj_golem_data['script']['valid_numresults'][1];

			// Create option 3
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option3'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option3']->value=$trj_golem_data['script']['valid_numresults'][2];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option3']->inner_text=$trj_golem_data['script']['valid_numresults'][2];

			// Create option 4
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option4'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option4']->value=$trj_golem_data['script']['valid_numresults'][3];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option4']->inner_text=$trj_golem_data['script']['valid_numresults'][3];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option4']->selected=true;

			// Create option 5
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option5'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option5']->value=$trj_golem_data['script']['valid_numresults'][4];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option5']->inner_text=$trj_golem_data['script']['valid_numresults'][4];

			// Create option 6
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option6'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option6']->value=$trj_golem_data['script']['valid_numresults'][5];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option6']->inner_text=$trj_golem_data['script']['valid_numresults'][5];

			// Create option 7
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option7'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option7']->value=$trj_golem_data['script']['valid_numresults'][6];
			$trj_golem_data['script']['form']['trj_golem_numresults']->options['option7']->inner_text=$trj_golem_data['script']['valid_numresults'][6];

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

			// Create option 1 *** The wildcard option ***
			$trj_golem_data['script']['form']['trj_golem_make']->options['option1'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option1']->value='';
			$trj_golem_data['script']['form']['trj_golem_make']->options['option1']->inner_text='any';

			// Create option 2
			$trj_golem_data['script']['form']['trj_golem_make']->options['option2'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option2']->value=$trj_golem_data['script']['valid_makes'][0];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option2']->inner_text=$trj_golem_data['script']['valid_makes'][0];

			// Create option 3
			$trj_golem_data['script']['form']['trj_golem_make']->options['option3'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option3']->value=$trj_golem_data['script']['valid_makes'][1];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option3']->inner_text=$trj_golem_data['script']['valid_makes'][1];

			// Create option 4
			$trj_golem_data['script']['form']['trj_golem_make']->options['option4'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option4']->value=$trj_golem_data['script']['valid_makes'][2];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option4']->inner_text=$trj_golem_data['script']['valid_makes'][2];

			// Create option 5
			$trj_golem_data['script']['form']['trj_golem_make']->options['option5'] = new trj_golem_form_element_option();
			// Set attributes
			$trj_golem_data['script']['form']['trj_golem_make']->options['option5']->value=$trj_golem_data['script']['valid_makes'][3];
			$trj_golem_data['script']['form']['trj_golem_make']->options['option5']->inner_text=$trj_golem_data['script']['valid_makes'][3];

		// Create search control
		$trj_golem_data['script']['form']['trj_golem_search'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_search']->name='trj_golem_search';
		$trj_golem_data['script']['form']['trj_golem_search']->type='submit';

		// Create cancel control
		$trj_golem_data['script']['form']['trj_golem_cancel'] = new trj_golem_form_element_button();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_cancel']->name='trj_golem_cancel';
		$trj_golem_data['script']['form']['trj_golem_cancel']->type='submit';

		/* ---------- Hidden Offset Element ---------- */
		// Create form hidden input control for offset
		$trj_golem_data['script']['form']['trj_golem_offset'] = new trj_golem_form_element_input();
		// Set attributes
		$trj_golem_data['script']['form']['trj_golem_offset']->name='trj_golem_offset';
		$trj_golem_data['script']['form']['trj_golem_offset']->type='text';
		$trj_golem_data['script']['form']['trj_golem_offset']->value='0';
		// Set display attributes for form hidden input control for offset
		$trj_golem_data['script']['form']['trj_golem_offset']->hidden=true;

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

		// Validate using the same criteria as POST
		$trj_golem_data = trj_golem_validate_search($trj_golem_data);

		return $trj_golem_data;
	} // trj_golem_validate_cancel




	/**
	* trj_golem_process_get
	*
	* Processes a user GET request.
	*
	* Query the database and a return a list of records based on search criteria
	* provided in the URL query string. The search may be limited by number of
	* records to return and by an offset to control pagination.
	*
	* In addition to making a query for the results, this function also makes
	* a count query to determine the total number of records that would be
	* returned if there were no limit. This total number of records value
	* is used in pagination.
	*
	* To accomplish both limited and count queries the query strings are built
	* using substring components. These substrings are then combined to create
	* the individual queries. This allows the developer to focus on ensuring
	* that the substrings are correctly constructed with confidence that both
	* query strings will be constructed properly. Note that this is only true
	* for basic queries. Complex queries may required further query string
	* manipulation.
	*
	* Assumes validation of the query terms has already been accomplished.
	*
	*/
	function trj_golem_process_get($trj_golem_data) {


		// Access the wordpress database object
		global $wpdb;

		// Set default number of results to return if none provided in URL
		$default_num_results = 15;

		// Set the column names to include in the select statement.
		$column_string = '*';

		// Set the table name to include in the select statement
		$table = 'wp_trj_golem_car';

		// Add a WHERE filter parameter
		// If the parameter is not set make a wildcard search term
		if(!isset($trj_golem_data['script']['user_query_vars']['trj_golem_make'])) {
			$where_string = " make LIKE '%'";
		} // if
		// If the parameter is an empty string make a wildcard search term
		elseif($trj_golem_data['script']['user_query_vars']['trj_golem_make'] == '') {
			$where_string = " make LIKE '%'";
		} // elseif
		// Else make the submitted parameter the search term
		else {
			$where_string = " make='" . "{$trj_golem_data['script']['user_query_vars']['trj_golem_make']}" . "'";
		} // else

		// Set Offset value for query
		$offset = 	isset($trj_golem_data['script']['user_query_vars']['trj_golem_offset']) && 
						$trj_golem_data['script']['user_query_vars']['trj_golem_offset'] != ''
						? 
						$trj_golem_data['script']['user_query_vars']['trj_golem_offset'] 
						:
						0;

		// Set Limit value for query
		$limit = 	isset($trj_golem_data['script']['user_query_vars']['trj_golem_numresults']) &&
						$trj_golem_data['script']['user_query_vars']['trj_golem_numresults'] != ''
						?
						$trj_golem_data['script']['user_query_vars']['trj_golem_numresults']
						:
						$default_num_results;

		// Assemble the query string
		$query_string = "SELECT $column_string FROM $table WHERE $where_string LIMIT $limit OFFSET $offset";
		// Make the query
		$trj_golem_data['script']['records'] = $wpdb->get_results($query_string);

		/* ****************************** PAGINATION ****************************** */
		/**
		* Count the total number of rows the query would return without limits.
		* This value is used in pagination.
		*/
		// Assemble the count string
		$count_string = "SELECT COUNT(*) FROM $table WHERE $where_string";
		// Make the count query
		$count_result = $wpdb->get_results($count_string);

		/*
		* Save values into data structure for pagination use by the view
		*/
		// Save the number of rows
		$trj_golem_data['script']['pagination']['count'] = $count_result[0]->{"COUNT(*)"};
		// Save the number of records to display per page
		$trj_golem_data['script']['pagination']['limit'] = $limit;
		// Save the first record to display on the page
		$trj_golem_data['script']['pagination']['offset'] = $offset;
		// Save the name of the URL query term which specifies the offset
		$trj_golem_data['script']['pagination']['offset_name'] = 'trj_golem_offset';

		return $trj_golem_data;
		}





	/**
	* Validate Search
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
	* There is no need to validate the trj_golem_script element because that is
	* checked by the core plugin and an error thrown if it is malformed.
	*
	* @ return entire updated data structure.
	*/
	function trj_golem_validate_search($trj_golem_data) {

		// Inititalize the form error flag assuming no errors yet found.
		$trj_golem_data['form_error']= false;

		/* ****************************************************************************************** */
		/* VALIDATE FORM ELEMENT ******************************************************************** */
		/* ****************************************************************************************** */
		$testField = 'trj_golem_make';
		/*
		/* ****************************** TEST REQUIRED STATUS ****************************** */
		/* ********** SETUP ********** */
		$required = true;
		$required_message = "Required";
		/* ********** TEST ********** */
		// If the field is required and not present set a required error message
		if (!isset($trj_golem_data['script']['user_query_vars'][$testField])) {
			if ($required) {
				$trj_golem_data['script']['form'][$testField]->error_message=$required_message;
			} // if
		} // if
		/* ********** END OF TEST ********** */

		/* ****************************** TEST DATA VALIDITY ****************************** */
		if (isset($trj_golem_data['script']['user_query_vars'][$testField])) {

			/* ********** TEST THAT SELECTION IS A VALID CHOICE ********** */
			/* ********** SETUP ********** */
			$error_message = "Invalid selection.";
			/* ********** TEST ********** */
			if($trj_golem_data['script']['user_query_vars'][$testField] !='') {
				if(!in_array($trj_golem_data['script']['user_query_vars'][$testField], $trj_golem_data['script']['valid_makes'])) {
					$trj_golem_data['script']['form'][$testField]->error_message=$error_message;
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
		$testField = 'trj_golem_numresults';
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

			/* ********** TEST FOR DATA IN RANGE ********** */
			/* ********** SETUP ********** */
			$min = 0;
			$max = 10000;
			$range_error = "Out of range. Must be between $min and {$max}.";
			/* ********** TEST ********** */
			if(isset($trj_golem_data['script']['user_query_vars'][$testField])) {
				if( ($trj_golem_data['script']['user_query_vars'][$testField] < $min) || ($trj_golem_data['script']['user_query_vars'][$testField] > $max)  ) {
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
		$testField = 'trj_golem_offset';
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
			$min = 0;
			$max = 1000000;
			$range_error = "Out of range. Must be between $min and {$max}.";
			/* ********** TEST ********** */
			if(isset($trj_golem_data['script']['user_query_vars'][$testField])) {
				if( ($trj_golem_data['script']['user_query_vars'][$testField] < $min) || ($trj_golem_data['script']['user_query_vars'][$testField] > $max)  ) {
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
	} // trj_golem_validate_search



	/**
	* Process Search
	*
	* Takes validated user input and constructs a new search URL.
	* Redirects to the new URL upon completion.
	*
	*/
	function trj_golem_process_search($trj_golem_data) {

		// Access the wordpress database object
		global $wpdb;

		/* ---------- PREP USER SUBMITTED DATA ---------- */
		$trj_golem_make = isset ($trj_golem_data['script']['user_query_vars']['trj_golem_make']) ? "&trj_golem_make={$trj_golem_data['script']['user_query_vars']['trj_golem_make']}" : NULL;
		$trj_golem_numresults = isset ($trj_golem_data['script']['user_query_vars']['trj_golem_numresults']) ? "&trj_golem_numresults={$trj_golem_data['script']['user_query_vars']['trj_golem_numresults']}" : NULL;
		$trj_golem_offset = isset ($trj_golem_data['script']['user_query_vars']['trj_golem_offset']) ? "&trj_golem_offset={$trj_golem_data['script']['user_query_vars']['trj_golem_offset']}" : NULL;

		// Build URL and query string
		$url = 'https://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"],'?') . '?page_id=' . $trj_golem_data['init']['plugin_home_page'] . '&trj_golem_script=' . $trj_golem_data['current_script'];
		$url .= !is_null($trj_golem_make) ? $trj_golem_make: '';
		$url .= !is_null($trj_golem_numresults) ? $trj_golem_numresults: '';
		$url .= !is_null($trj_golem_offset) ? $trj_golem_offset: '';

		// Redirect
		wp_redirect($url, $status=303);

		return;
		} // trj_golem_process_search



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
		$url = 'https://' . $_SERVER['HTTP_HOST'] . strtok($_SERVER["REQUEST_URI"],'?') . '?page_id=' . $trj_golem_data['init']['plugin_home_page'];
		wp_redirect($url, $status=303);

		return true;
		}




	/**
	* trj_golem_has_args
	*
	* A utility to determine if the user provided arguments to the script.
	* Ignores the argument trj_golem_script since that is required.
	* Generally used to determine whether or not to display search results on a GET request.
	*
	* @ return true if the user query includes arguments, otherwise false
	*/
	function trj_golem_has_args($trj_golem_user_query_vars) {
		// If the script element is set remove it from the array, leaving only members of interest.
		if(isset($trj_golem_user_query_vars['trj_golem_script'])) {
			unset($trj_golem_user_query_vars['trj_golem_script']);
		} // if
		// If the array still has arguments then set args to true
		if (count($trj_golem_user_query_vars) > 0) {
			$args = true;
		} // if
		else {
			$args = false;
		}
		return $args;
	} // trj_golem_has_args








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

		// Set display attributes for form control numresults
		$trj_golem_data['script']['form']['trj_golem_numresults']->label_text='Results to display';
		$trj_golem_data['script']['form']['trj_golem_numresults']->helper_text = 'The number of results per page to display.';
		$trj_golem_data['script']['form']['trj_golem_numresults']->class = 'trj_golem_form_element_input';

		// Set display attributes for form control make
		$trj_golem_data['script']['form']['trj_golem_make']->label_text='Make';
		$trj_golem_data['script']['form']['trj_golem_make']->helper_text = 'Car manufacturer';
		$trj_golem_data['script']['form']['trj_golem_make']->class = 'trj_golem_form_element_input';
		$trj_golem_data['script']['form']['trj_golem_make']->options['option4']->class='trj_golem_form_element_select_option';

		// Set display attributes for control search
		$trj_golem_data['script']['form']['trj_golem_search']->value='Search';
		$trj_golem_data['script']['form']['trj_golem_search']->class='trj_golem_button_primary';

		// Set display attributes for control cancel
		$trj_golem_data['script']['form']['trj_golem_cancel']->value='Cancel';
		$trj_golem_data['script']['form']['trj_golem_cancel']->inner_text='Cancel';
		$trj_golem_data['script']['form']['trj_golem_cancel']->class='trj_golem_button_secondary';

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
		global $post;

		// Build the View
		$view = PHP_EOL;

		// Open page container
		$view .= '<div class="trj_golem_frame">';
		// Page title
		$view .= '<h2>Cars - List</h2>';
		// If there is a form error display it
		$view .= ($trj_golem_data['script']['form_error']) 
						? '<p class="trj_golem_error">' . $trj_golem_data['script']['form_error'] . '</p>'
						: '';
		// Create the form
		$view .= '<form action="' . $trj_golem_data['script']['site_url'] . '/?page_id=' . $trj_golem_data['init']['plugin_home_page'] . '" method="POST" enctype="multipart/form-data">';
		// Render hidden form elements
		$view .= 	$trj_golem_data['script']['form']['trj_golem_script']->get_form_element();
		$view .= 	$trj_golem_data['script']['form']['trj_golem_offset']->get_form_element();

		/*
		*	Create the form layout in a table
		*/

		$view .= '<table class="trj_golem_form_table">';

		$view .=		'<tr>';
		$view .=			'<td>';
		$view .=				'<p class="trj_golem_form_element_label_text">' .$trj_golem_data['script']['form']['trj_golem_numresults']->label_text . '</p>';
		$view .= 				(isset($trj_golem_data['script']['form']['trj_golem_numresults']->helper_text))
										? '<p class="trj_golem_form_element_helper_text">' . $trj_golem_data['script']['form']['trj_golem_numresults']->helper_text . '</p>'
										: '';
		$view .=					(isset($trj_golem_data['script']['form']['trj_golem_numresults']->error_message)) 
										? '<p class="trj_golem_form_element_error_message">' . $trj_golem_data['script']['form']['trj_golem_numresults']->error_message . '</p>' 
										: '';
		$view .=			'</td>';
		$view .=			'<td>';
		$view .=					$trj_golem_data['script']['form']['trj_golem_numresults']->get_form_element();
		$view .=			'</td>';
		$view .=		'</tr>';

		$view .=		'<tr>';
		$view .=			'<td>';
		$view .=				'<p class="trj_golem_form_element_label_text">' .$trj_golem_data['script']['form']['trj_golem_make']->label_text . '</p>';
		$view .= 			(isset($trj_golem_data['script']['form']['trj_golem_make']->helper_text)) 
									? '<p class="trj_golem_form_element_helper_text">' . $trj_golem_data['script']['form']['trj_golem_make']->helper_text . '</p>' 
									: '';
		$view .=				(isset($trj_golem_data['script']['form']['trj_golem_make']->error_message)) 
									? '<p class="trj_golem_form_element_error_message">' . $trj_golem_data['script']['form']['trj_golem_make']->error_message . '</p>' 
									: '';
		$view .=			'</td>';
		$view .=			'<td>';
		$view .=				$trj_golem_data['script']['form']['trj_golem_make']->get_form_element();
		$view .=			'</td>';
		$view .=		'</tr>';

		// close the table
		$view .= '</table>';

		$view .= PHP_EOL;
		$view .= "{$trj_golem_data['script']['form']['trj_golem_search']->get_form_element()}";
		$view .= PHP_EOL;
		$view .= " {$trj_golem_data['script']['form']['trj_golem_cancel']->get_form_element()}";


		/*
		*	Display a list of found records
		*/
		if(isset($trj_golem_data['script']['records'])) {
			// Make a table and header
			$view .= '<table class="trj_golem_list_results_table">';
				$view .= "<tr>";
					$view .= "<th>ID</th>";
					$view .= "<th>Make</th>";
					$view .= "<th>Model</th>";
					$view .= "<th>Automatic</th>";
				$view .= "</tr>";
			// Loop through records and display them
			foreach ($trj_golem_data['script']['records'] as $record) {
				// Determine the EDIT URL
				$cars_create_url = '?page_id=' . $post->ID . '&trj_golem_script=trj_golem_cars_edit' . "&trj_golem_record_id=$record->id";
				// Print the table row
				$view .= "<tr>";
					$view .= '<td>' . '<a href="' . $cars_create_url . '">' . $record->id . '</a>' . '</td>';
					$view .= "<td>$record->make</td>";
					$view .= "<td>$record->model</td>";
					$view .= "<td>$record->automatic</td>";
				$view .= "</tr>";
			} // foreach
			$view .= "</table>";
			/*
			*	Display pagination controls
			*/
			$view .= trj_golem_pagination_controls(
							$trj_golem_data['script']['pagination']['count'],
							$trj_golem_data['script']['pagination']['limit'],
							$trj_golem_data['script']['pagination']['offset'],
							$trj_golem_data['script']['pagination']['offset_name']
						);
		} // if


		/*
		*	Clean up
		*/

		// close the form
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
