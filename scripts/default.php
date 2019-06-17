<?php

/**
* Default script
*
*
*/

	/**
	* trj_golem_default
	*
	* This default script is run if the user accesses the plugin home page
	* without specifying a script in the query string.
	*
	* Typically this script creates a 'Home' page for the application which
	* may include branding and navigational menues.
	*
	* The script shown is in minimal form which is only set up for display.
	* However, one of the full-fledged example script templates could be
	* used to create a more functional default script if required.
	*/


	/************************************************************************
	*************************************************************************
	* Controller
	*************************************************************************
	*************************************************************************
	*/
	function trj_golem_default () {
		// provide access to this global variable
		global $trj_golem_data;
		// If there is a page error display it and return early
		if ( trj_golem_has_page_error() ) {
			trj_golem_display_page_error();
			return;
		} // if
		add_filter( 'the_content', 'trj_golem_show_script_view' );
		// Build a view
		function trj_golem_show_script_view($content) {
			// provide access to this global variable
			global $trj_golem_data;
			// Build the url for the template
			// Get the id of the current post (only works if used on or after action hook parse_query)
			global $wp_query;
			global $post;
			$currentPostID = $post->ID;
			$template_url = '?page_id=' . $currentPostID . '&trj_golem_script=trj_golem_template_form';
			$cars_create_url = '?page_id=' . $currentPostID . '&trj_golem_script=trj_golem_cars_create';
			$cars_list_url = '?page_id=' . $currentPostID . '&trj_golem_script=trj_golem_cars_list';
			$message = "<h2>Welcome</h2>";
			$message .= "<p>This script can be used to create a splash page for the plugin. It's also a good place to put navigation controls and status information.</p>";
			$message .= "<p>This is the default screen that you get if you don't specify a script in your request. Because of that, the URL is visually friendly and easy to remember.</p>";
			$message .= '<img src="' . $trj_golem_data['paths']['media'] . 'mini.png' . '" width="50%">';
			$message .= '<h2>Car Manager</h2>';
			$message .= "<p>Car manager is a sample application that demonstrates the three primary sample scripts:</p>";
			$message .= "<ul>";
			$message .= 	"<li>";
			$message .= 		'<a href="' . $cars_create_url . '">Create</a> - Create a new database record';
			$message .= 	"</li>";
			$message .= 	"<li>";
			$message .= 		'<a href="' . $cars_list_url . '">List</a> - Search for a display results from the database';
			$message .= 	"</li>";
			$message .= 	"<li>";
			$message .= 		'Update - edit or delete a database record (accessed from the <em>List</em> script)';
			$message .= 	"</li>";
			$message .= "</ul>";
			$content = $message . $content;
			return $content;
		} // function trj_golem_show_script_view
	} // functiontrj_golem_default
?>
