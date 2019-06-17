<?php
/**
* Register CSS and Javascript
*/


	/**
	* Register CSS and Javascript
	* 
	* Register custom CSS and Javascript for this plugin.
	* 
	* Multiple code blocks can be implemented to enable multiple stylesheets
	* or javascript files.
	*/
	function register_css_and_js() {
		// Access the global data structure
		global $trj_golem_data;

		/*
		* Register a css stylesheet
		*/
		// Stylesheet name
		$stylesheet = 'styles.css';
		// Register the stylesheet
		wp_register_style('trj_golem', $trj_golem_data['paths']['css_url'] . $stylesheet);
		// Enqueue the stylesheet
		wp_enqueue_style('trj_golem');


		/*
		* Register a javascript file
		*/
		// Javascript filename
		$js_file = "script.js";
		// Register the file
		wp_register_script( 'trj_golem', $trj_golem_data['paths']['js_url'] . $js_file);
		// Enqueue the script
		wp_enqueue_script('trj_golem');

	} // function register_css_and_js

?>
