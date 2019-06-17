<?php
/**
* Save for Redisplay
*/

	/**
	* Save for Redisplay
	*
	* Updates a form with user provided-data so that the a form containing
	* errors can be redisplayed to the user without the user having to re-enter
	* all the data in the form.
	* 
	* ARGUMENTS
	* $form is an array of form element objects, i.e. a form
	* $user_query_vars is an associative array of user-provided query values
	* corresponding to the form input elements.
	*
	* @return the updated form
	* 
	*/
	function trj_golem_save_for_redisplay($form, $user_query_vars) {

		// Iterate through each form input element
		foreach ($form as $value) {
			/* ---------- Detect special case submitted elements that need special or no processing ---------- */
			// set initial conditions
			$submit = false;
			$button = false;
			$script = false;
			$email_multiple = false;
			$file_upload = false;
			// Determine if submitted element is a button
			if ( is_a($value, 'trj_golem_form_element_button') ) {
				$button = true;
			} // if
			// Determine if submitted element is an input type=submit button
			if ( is_a($value, 'trj_golem_form_element_input') && ($value->type == 'submit') ) {
				$submit = true;
			} // if
			// Determine if submitted element is the script name element
			if ( is_a($value, 'trj_golem_form_element_input') && ($value->name == 'trj_golem_script') ) {
				$script = true;
			} // if
			// Determine if submitted element is an input type=email element with multiple
			if ( is_a($value, 'trj_golem_form_element_input') && ($value->type == 'email') && (isset($value->multiple)) && ($value->multiple == true) ) {
				$email_multiple = true;
			} // if
			// Determine if submitted element is an input type=file element
			if ( is_a($value, 'trj_golem_form_element_input') && ($value->type == 'file') ) {
				$file_upload = true;
			} // if
			// Iterate through those form elements that have no error messages and are not special cases
			if( !isset($value->error_message) && !$submit && !$button && !$script) {
				/* ---------- Detect type of submitted form element ---------- */
				// set initial conditions
				$checkbox = false;
				$option = false;
				$default = false;
				// Detect if element is a checkbox
				if (is_a($value, 'trj_golem_form_element_input') && ($value->type == 'checkbox')) {
					$checkbox = true;
				} // if
				// Detect if element is a select option
				elseif (is_a($value, 'trj_golem_form_element_select')) {
					$option = true;
				} // if
				// Else element is a normal input or textarea element
				else {
					$default = true;
				} // else
				/* ---------- Replace submitted element depending upon case ---------- */
				switch(true) {
					case($checkbox):
						// Replace the form element with the user submitted value
						if(isset($user_query_vars[$value->name])) {
							$form[$value->name]->checked = true;
						} // if
						else {
							$form[$value->name]->checked = false;
						}
					break;
					case($email_multiple):
						// Replace the form element with the user submitted value
						// Note: single emails will be posted as strings, but multi emails will appear as a comma separated list of email addresses in position [0] of an array per HTML spec and mod_php.
						if(isset($user_query_vars[$value->name])) {
							$form[$value->name]->value = $user_query_vars[$value->name][0];
						} // if
					break;
					case($option):
						// Iterate through each option, clearing all selected attributes
						foreach($value->options as $option) {
							$option->selected = false;
						} // foreach
						// Iterate through each option, setting the selected attribute if the user submitted it
						foreach($value->options as $option) {
							// If the user provided value is a string process it directly
							if(isset($user_query_vars[$value->name]) && is_string($user_query_vars[$value->name])) {
								// If the option's value is equal to one the user submitted, then set that option as selected
								if($option->value == $user_query_vars[$value->name]){
									$option->selected = true;
								} // if
							} // if
							// Else if the user provided value is an array (i.e. multiple) check if the value is present in array before processing
							elseif (isset($user_query_vars[$value->name]) &&  is_array($user_query_vars[$value->name])) {
								if ( in_array($option->value, $user_query_vars[$value->name]) ) {
									$option->selected = true;
								} // if
							} // elseif
						} // foreach
					break;
					case($file_upload):
						// If the user chooses files to upload but the form has errors and needs to be redisplayed, the user will have to reselect the files locally.
					break;
					case($default):
						// Replace the form element with the user submitted value
						if(isset($user_query_vars[$value->name])) {
							$form[$value->name]->value = $user_query_vars[$value->name];
						} // if
					break;
				} // switch
			} // if
		} // foreach

		
		return $form;

	} // function trj_golem_save_for_redisplay

?>
