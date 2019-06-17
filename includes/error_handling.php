<?php
/**
* Error Handling Helper Functions
*
*
*/


	/************************************************************************
	*************************************************************************
	* Error Handling Helper Functions
	*************************************************************************
	*************************************************************************
	* Error Handling Functions
	*
	* Routines for handling page errors. Generally an error of this severity
	* would halt normal script operation, log the error, and display a message.
	* Note that these functions support a single page error per script,
	* which is $trj_golem_page_error[].
	*
	* Examples of page errors might include:
	* - corrupt data passed in a query string
	* - non-existent record in database
	* - unauthorized access attempt
	* - non-existent or unregistered script request
	*
	* This set of error handling utilities includes the following functions
	* - trj_golem_set_page_error() - flag the presence of an error and log it in the database
	* - trj_golem_has_page_error() - check if an error exists
	* - trj_golem_get_page_error() - get the details of an error
	* - trj_golem_display_page_error() - display the error via WP filter call
	*
	* The data structure is:
	*	$trj_golem_page_error - Array that holds information associated with the error.
	*		$trj_golem_page_error['error'] - a boolean indicating the presence of an error
	*		$trj_golem_page_error['user'] - The current user when the error occured
	*		$trj_golem_page_error['message'] - The error message
	*		$trj_golem_page_error['script'] - The currently executing script
	*		$trj_golem_page_error['time'] - The time when the error occurred. In php UTC time() format.
	*		$trj_golem_page_error['ip'] - The IP address of the user that encountered the error.
	*		$trj_golem_page_error['plugin_name'] - The name of the current plugin. Inserted for display purposes only.
	*
	* Errors logged to the database are stored in the table wp_trj_golem_error_log
	* which is created during plugin installation. This table can be viewed and
	* managed via the plugin administrative settings interface, which is 
	* managed by admin/admin_page_error_log.php.
	*/


	/*
	* Set Page Error
	*
	* Sets an error in $trj_golem_page_error and writes the error to the
	* database. This database table is wp_trj_golem_error_log, which is 
	* created during plugin installation.
	*/
	function trj_golem_set_page_error($message) {
		// provide access to the global error variable
		global $trj_golem_page_error;
		// provide access to this global variable
		global $trj_golem_data;
		// provide access to the database object
		global $wpdb;
		/* ---------- Populate the page error data structure ---------- */
		// Set error
		$trj_golem_page_error['error'] = true;
		// Get error message
		$trj_golem_page_error['message'] = $message;
		// Get current script
		$trj_golem_page_error['script'] = $trj_golem_data['current_script'];
		// Get the current user
		$trj_golem_page_error['user'] = wp_get_current_user()->user_login;
		// Get the current time
		$trj_golem_page_error['time'] = current_time('mysql', 1);
		// Get the current user's IP address
		$trj_golem_page_error['ip'] = $_SERVER['REMOTE_ADDR'];
		// Get the plugin name
		$trj_golem_page_error['plugin_name'] = $trj_golem_data['plugin_name'];
		/* ---------- Create a trimmed copy of the error to save to the database ---------- */
		$trj_golem_error_nugget = $trj_golem_page_error;
		unset($trj_golem_error_nugget['plugin_name']);
		unset($trj_golem_error_nugget['error']);
		/* ---------- Trim the error log table to the correct size ---------- */
		// Get the number or rows in the table
		$results = $wpdb->get_results('SELECT COUNT(*) FROM wp_trj_golem_error_log', ARRAY_N);
		$num_rows = $results[0][0];
		// Determine how many rows to clip
		$clip_rows = $num_rows - $trj_golem_data['admin_settings_error_log']['num_records'] + 1;
		if($clip_rows < 0) {
			$clip_rows = 0;
		} // if
		if($clip_rows > $num_rows) {
			$clip_rows = $num_rows;
		} // if
		// If rows need to be clipped, clip them
		if($clip_rows > 0) {
			$wpdb->get_results("DELETE FROM wp_trj_golem_error_log ORDER BY id ASC LIMIT $clip_rows");
		} // if
		// If logging is turned on write error to database
		if($trj_golem_data['admin_settings_error_log']['num_records'] > 0) {
			$wpdb->insert('wp_trj_golem_error_log', $trj_golem_error_nugget);
		} // if
		return;
	} // function trj_golem_set_page_error


	/*
	* Has Page Error
	*
	* Determine if a page error has been set
	*
	*
	* @return true if there is a page error
	* @return false if there is no page error
	*/
	function trj_golem_has_page_error() {
		// provide access to the global error variable
		global $trj_golem_page_error;
		// check for page error
		if(isset($trj_golem_page_error['error']) && $trj_golem_page_error['error'] != false) {
			return true;
		} // if
		else {
			return false;
		} // else
	} // function trj_golem_has_page_error



	/*
	* Get Page Error
	*
	* Returns an array containing the page error.
	* The array has the following elements
	* - ['error'] - True indicates that an error has occurred. False indicates no error.
	* - ['message'] - The error message
	* - ['user'] - The current user when the error occured
	* - ['script'] - The currently executing script
	* - ['time'] - The time when the error occurred. In php UTC time() format.
	* - ['ip'] - The IP address of the user that encountered the error.
	* - ['plugin_name'] - The name of the current plugin. Inserted for display purposes only.
	*
	* An empty string is returned for any missing element.
	*
	* @return an array containing page error details
	*/
	function trj_golem_get_page_error() {
		// provide access to the global error variable
		global $trj_golem_page_error;
		// Make a clean copy of error array to return
		$trj_golem_page_error_clean = array();
		// Set error element to true or false based on $trj_golem_page_error['error'] value
		$trj_golem_page_error_clean['error'] = isset($trj_golem_page_error['error']) && ($trj_golem_page_error['error'] != false) ? true : false;
		// Set array elements to empty strings if unset. This is for clean display.
		$trj_golem_page_error_clean['message'] = isset($trj_golem_page_error['message']) ? $trj_golem_page_error['message'] : '';
		$trj_golem_page_error_clean['user'] = isset($trj_golem_page_error['user']) ? $trj_golem_page_error['user'] : '';
		$trj_golem_page_error_clean['script'] = isset($trj_golem_page_error['script']) ? $trj_golem_page_error['script'] : '';
		$trj_golem_page_error_clean['time'] = isset($trj_golem_page_error['time']) ? $trj_golem_page_error['time'] : '';
		$trj_golem_page_error_clean['ip'] = isset($trj_golem_page_error['ip']) ? $trj_golem_page_error['ip'] : '';
		$trj_golem_page_error_clean['plugin_name'] = isset($trj_golem_page_error['plugin_name']) ? $trj_golem_page_error['plugin_name'] : '';
		// Return the sanitized array
		return $trj_golem_page_error_clean;
	} // function trj_golem_get_page_error



	/*
	* Display Page Error
	*
	* Add a filter and create a function to display a page error.
	*
	* This function would typically be used in a view. Call
	* trj_golem_has_page_error() to detect and error. If one is found,
	* call trj_golem_display_page_error() at the beginning of the view
	* and return early. This allows the script to display the page error
	* and not process the view, thus preventing potential references to 
	* bad data.
	*
	* Sample code:
	*	// If there is a page error display it and return early
	*	if ( trj_golem_has_page_error() ) {
	*		trj_golem_display_page_error();
	*		return;
	*	} // if
	*/
	function trj_golem_display_page_error() {
		// Update the content using the_content filter
		add_filter( 'the_content', 'trj_golem_display_page_error_view' );
		// Modifies post content to display an error	 
		function trj_golem_display_page_error_view($content) {
			// Get page error details
			$page_error = trj_golem_get_page_error();
			// Build the HTML to display the error
			$display = '<h2>' . __('Error', 'trj_golem') . '</h2><br />';
			$display .= '<p>' . __('Plugin ', 'trj_golem') . $page_error['plugin_name'] . __(' has experienced an error. If you believe this error is the result of a system malfunction you may report it by copying the error details below and pasting them into an email to your system administrator.', 'trj_golem') . '</p>';
			$display .= '<h3>' . __('Error Details', 'trj_golem') . '</h3>';
			$display .= '<ul>';
			$display .= 	'<li>' . __('Message: ', 'trj_golem') . $page_error['message'] . '</li>';
			$display .= 	'<li>' . __('Script: ', 'trj_golem') . $page_error['script'] . '</li>';
			$display .= 	'<li>' . __('User: ', 'trj_golem') . $page_error['user'] . '</li>';
			$display .= 	'<li>' . __('Time: ', 'trj_golem') . gmdate("Y/m/d G:i:s ", strtotime($page_error['time'])) . ' UTC </li>';
			$display .= '</ul>';
			$content = $content . $display;
			return $content;
		} // function trj_golem_display_error_view
	} // function trj_golem_display_page_error

?>
