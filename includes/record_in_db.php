<?php
/**
* Record In Database
*/

	/**
	* Record In Database
	*
	* A custom utility function to determine if a record requested by a user
	* is actually in a database table.
	* 
	* Takes a query variable provided by the user in either a GET or POST
	* and counts the number of times a key matching that query variable is
	* found in the named table.
	* 
	* This function is intended to work only on auto-incrementing integer
	* keys and will return false and throw an error if the user-supplied
	* query variable is not an integer.
	*
	* @return the record id if the requested record is in the database exactly once.
	* return false otherwise, including if query term is not presented
	* 
	*/
	function trj_golem_record_in_db($query_var, $column, $table) {

		// Assume that the request is valid
		$valid = true;

		// Get the id provided in the GET or POST request
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$record_id = isset($_GET[$query_var]) ? $_GET[$query_var] : NULL;
		} // if
		elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$record_id = isset($_POST[$query_var]) ? $_POST[$query_var] : NULL;
		} // if
		// Request not a GET or POST so assume the request is invalid
		else {
			$valid = false;
		} // else
		// If no id was provided then the request is not valid
		if(!isset($record_id)) {
			$valid = false;
		} // if
		// If the id is not a number then the request is not valid
		elseif(!is_numeric($record_id)) {
			$valid = false;
		} // elseif
		// If the id is not an integer then the request is not valid
		elseif(!is_int($record_id+0)) {
			$valid = false;
		} // elseif
		// If the id is less than zero then the request is not valid
		elseif($record_id < 0) {
			$valid = false;
		} // elseif

		// Access the database object
		if($valid) {
			global $wpdb;
			// See if the id exists in the database
			$result = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE $column=$record_id");
			if ($result != 1) {
				$valid = false;
			} // if
		} // if

		// Return
		if($valid) {
			return $record_id;
		}
		else {
			return false;
		}
	} // function trj_golem_record_in_db

?>
