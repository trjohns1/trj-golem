<?php
/**
* Get Query Variables
*/

	/**
	* Get Query Variables
	*
	* Get query variables from a request, whether GET or POST.
	* Takes as an argument an array of form element objects (i.e. a form definition)
	* 
	* Only return values for query variables named in the form. All other
	* query variables are ignored.
	*
	* Log error and halt if the user provided variables do not match the type
	* expected by the form. E.G. Form elements defined as multiple must
	* be provided as an array of strings. Singular elements must be strings.
	* 
	* @return an array containing user provided variables indexed by name.
	* Ensures that all returned query variables are of the correct type.
	*/
	function trj_golem_get_query_vars($form) {

		// Get a list of valid query variables from the form
		foreach ($form as $form_element) {
			$valid_query_vars[]=$form_element->name;
		} // foreach

		// Holds the list of found query variables
		$query_vars = array();

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			foreach($valid_query_vars as $key=>$value) {
				if(isset($_GET[$value])) {
					$query_vars[$value] = $_GET[$value];
				}
			} // foreach
		} // if

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			foreach($valid_query_vars as $key=>$value) {
				if(isset($_POST[$value])) {
					$query_vars[$value] = $_POST[$value];
				}
			} // foreach
		} // if

		// Validate that user provided variables match expected type.
		foreach ($form as $var=>$name) {
			// Set a flag to indicate if the form element is a multiple
			$multiple = (isset($form[$var]->multiple) && ($form[$var]->multiple) ) ? true : false;
			// If the form element is defined as multiple but the user provided variable is not an array set an error
			if ( $multiple && isset($query_vars[$var]) && !is_array($query_vars[$var] )) {
				$message = "Critical Error: Form expecting array for variable $var but user sent a different type.";
				trj_golem_set_page_error($message);
				wp_die($message);
			} // if
			// Else if the form element is a string make sure user provided data is a string. If not set an error.			
			elseif ( !$multiple && isset($query_vars[$var]) && !is_string($query_vars[$var]) ) {
				$message = "Critical Error: Form expecting string for variable $var but user sent a different type.";
				trj_golem_set_page_error($message);
				wp_die($message);
			} // elseif
			// If the form element is an array and the user provided variable is an array, make sure that each
			// element in the user provided array is a string.
			if ($multiple && isset($query_vars[$var]) && is_array($query_vars[$var] )) {
				foreach ($query_vars[$var] as $sub_element) {
					if (!is_string($sub_element)) {
					$message = "Critical Error: Form expecting array of strings for variable $var but user sent a different type.";
					trj_golem_set_page_error($message);
					wp_die($message);
					} // if
				} // foreach
			}
		} // foreach

		return $query_vars;

	} // function trj_golem_get_query_vars

?>
