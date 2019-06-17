<?php
/*
Plugin Name: trj_golem
Plugin URI: 
Description: trj_golem is a template that can be used as a starting point for building WordPress plugins. It includes admin menus and basic functionality that the developer can extend.
Version: 1.0
Author: Tyler Johnson
Author URI: 
Text Domain: trj_golem
License: GPLv2
*/

/**
* trj_golem
*
* This plugin is designed to support single page applications that run as
* WordPress plugins.
*
* The plugin creates a page that acts as the application's host page.
*
* A script is passed to the host page (via URL for GET or form submission
* for POST). These scripts provided different functionalities and appear as 
* individual pages to the user, though the base URL remains unchanged.
*
* The function trj_golem_activate_script() is the main control structure for
* the plugin. It runs on each page load and determines which script should be
* run, validates, loads, and runs it. If no valid script is provided the 
* function returns early and the plugin does nothing more.
*/



	/**
	* Primary Data Structure
	*
	* $trj_golem_data is the primary data structure. It is declared as a global
	* array to allow passing data between functions when registered as hooks.
	* This variable is destroyed if not needed.
	* The basic structure is:
	*
	*	$trj_golem_data - the global data structure
	*		$trj_golem_data['admin_settings_error_log'][] - Plugin options from admin panel error_log tab. Populated from the wp_options table.
	*	$trj_golem_data['admin_settings_general'][] - Plugin options from admin panel general tab. Populated from the wp_options table.
	*	$trj_golem_data['admin_settings_xxx'][] - Plugin options from admin panel xxx tab if present. Populated from the wp_options table.
	*	$trj_golem_data['current_script'] - The name of the current script the page is running (not a filename)
	*	$trj_golem_data['init'][] - plugin initialization settings
	*		$trj_golem_data['init']['db_version'] - the version of the currently installed database
	*		$trj_golem_data['init']['plugin_home_page'] - the post id of the page on which the plugin runs
	*	$trj_golem_data['paths'][] - pathnames for access to files and directories
	*		$trj_golem_data['paths'][admin] - Administrative settings pages and functions related to the core plugin
	*		$trj_golem_data['paths'][css] - Style sheets and markup
	*		$trj_golem_data['paths'][css_url] - URL form of stylesheet path
	*		$trj_golem_data['paths'][includes] - include and utility files for scripts
	*		$trj_golem_data['paths'][js] - javascript
	*		$trj_golem_data['paths'][js_url] - URL form of javascript path
	*		$trj_golem_data['paths'][languages] - translation files
	*		$trj_golem_data['paths'][media] - images and media
	*		$trj_golem_data['paths'][scripts] - scripts ("pages") that provide extended plugin functionality
	*	$trj_golem_data['plugin_db_version'] - the version of the database required by the currently unstalled plugin
	*	$trj_golem_data['plugin_initialization_error'] - If set contains a string that indicates why the plugin could not initialize
	*	$trj_golem_data['plugin_name'] - friendly name for the plugin
	*  $trj_golem_data['script'][] - All global variables created by individual scripts go here
	*	$trj_golem_data['scripts'][] - filenames for all scripts extending plugin functionality
	*
	*/
	global $trj_golem_data;


	/**
	* A variable to hold information about whether or not an error has
	* occurred in processing the page. This is used by the following
	* included functions:
	* - trj_golem_set_page_error()
	* - trj_golem_has_page_error()
	* - trj_golem_get_page_error()
	* - trj_golem_display_page_error()
	*/
	global $trj_golem_page_error;






	/************************************************************************
	*************************************************************************
	* Function Hooks
	*************************************************************************
	*************************************************************************
	*/

	/* ---------- Plugin Initialization ---------- */
	// Initial setup for plugin. Run on all page loads.
	add_action( 'wp_loaded', 'trj_golem_plugin_init' );

	/* ---------- Main Plugin Control ---------- */
	// Determine which script to run and run it.
	add_action( 'template_redirect', 'trj_golem_activate_script' );

	/* ---------- Plugin Activation ---------- */
	// When the plugin is activated execute the activation code.
	register_activation_hook( __FILE__, 'trj_golem_activate' );

	/* ---------- Plugin Deactivation ---------- */
	// When the plugin is deactivated execute the deactivation code.
	register_deactivation_hook( __FILE__, 'trj_golem_deactivate' );

	/* ---------- Prevent Deletion ---------- */
	// Prevent the plugin homepage from being deleted.
	add_action( 'wp_trash_post', 'trj_golem_prevent_deletion' );











	/************************************************************************
	*************************************************************************
	* Initialization
	*************************************************************************
	*************************************************************************
	*/


	/**
	* Initialize the plugin.
	*
	* Run on every page load so this should only be used for necessary functions.
	*/
	function trj_golem_plugin_init() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// Include settings file
		include_once "admin/config.php";

		// Set paths using config file
		$trj_golem_data['paths']['admin'] = 		plugin_dir_path( __FILE__ ) . $path_admin;
		$trj_golem_data['paths']['base'] = 			plugin_dir_path( __FILE__ );
		$trj_golem_data['paths']['css'] = 			plugin_dir_path( __FILE__ ) . $path_css;
		$trj_golem_data['paths']['css_url'] = 		plugins_url($path_css,__FILE__ ); // URL form of css path. Needed for enqueuing stylesheets.
		$trj_golem_data['paths']['includes'] = 	plugin_dir_path( __FILE__ ) . $path_includes;
		$trj_golem_data['paths']['js'] = 			plugin_dir_path( __FILE__ ) . $path_js;
		$trj_golem_data['paths']['js_url'] = 		plugins_url($path_js,__FILE__ ); // URL form of js path. Needed for enqueuing scripts.
		$trj_golem_data['paths']['languages'] = 	plugin_dir_path( __FILE__ ) . $path_languages;
		$trj_golem_data['paths']['media'] = 		substr(plugin_dir_path( __FILE__ ), -(strlen(plugin_dir_path( __FILE__ )) - strlen(getcwd()) -1 )) . $path_media;
		$trj_golem_data['paths']['scripts'] = 		plugin_dir_path( __FILE__ ) . $path_scripts;

		// Include error handling functions
		include_once "{$trj_golem_data['paths']['includes']}error_handling.php";

		// Internationalization
		load_plugin_textdomain('trj_golem', false, $trj_golem_data['paths']['languages']);

		// Load admin plugin settings
		include_once "{$trj_golem_data['paths']['admin']}load_admin_settings.php";

		// Include code to manage upgrades
		include_once "{$trj_golem_data['paths']['admin']}version_functions.php";

		// Include code to create administrative settings pages
		if(is_admin()) {
			include_once "{$trj_golem_data['paths']['admin']}admin_page.php";
		} // if

		// Get existing initialization settings from database
		$trj_golem_data['init'] = get_option( 'trj_golem_init');

		// Verify that options are well-formed. Otherwise set an error to disable the plugin.
		if($trj_golem_data['init']) {
			if(!isset($trj_golem_data['init']['plugin_home_page'])) {
				$trj_golem_data['plugin_initialization_error'] = __('Plugin initialization plugin_home_page option missing.', 'trj_golem');
			} // if
			if(!isset($trj_golem_data['init']['db_version'])) {
				$trj_golem_data['plugin_initialization_error'] = __('Plugin initialization db_version option missing.', 'trj_golem');
			} // if
		} // if
		else {
			// Set db_version to zero to indicate database not installed.
			$trj_golem_data['init']['db_version'] = 0;
		} // else

		// Upgrade to the latest version of the plugin if necessary
		trj_golem_version_upgrade();

		return;

	} // trj_golem_plugin_init




	/************************************************************************
	*************************************************************************
	* Function Definitions
	*************************************************************************
	*************************************************************************
	*/


	/**
	* Take actions when the plugin is activated.
	*
	* Because people WordPress' activate/deactivate functions to enable/disable
	* plugins, often for testing purposes, activation and deactivation hooks
	* are not used for installation, upgrade or deinstallation purposes.
	* Instead, version_functions.php contains utilities to install and upgrade
	* the plugin and uninstall.php handles removal of plugin data.
	*
	* This hook function is provided as a stub only.
	*/
	function trj_golem_activate() {
		// Sample activation error
		/*
		$activation_error = false;
		$activation_error_message = __('Custom Activation Error Message. - ', 'trj_golem');
		if($activation_error) {
			trigger_error($activation_error_message);
			exit;
		}
		*/
	} // function trj_golem_activate


	/**
	* Take actions when the plugin is deactivated.
	*
	* Because people WordPress' activate/deactivate functions to enable/disable
	* plugins, often for testing purposes, activation and deactivation hooks
	* are not used for installation, upgrade or deinstallation purposes.
	* Instead, version_functions.php contains utilities to install and upgrade
	* the plugin and uninstall.php handles removal of plugin data.
	*
	* This hook function is provided as a stub only.
	*/
	function trj_golem_deactivate() {
	} // function trj_golem_deactivate


	/**
	* Prevent Deletion
	*
	* Prevent the plugin homepage from being deleted by the user.
	*/
	function trj_golem_prevent_deletion($post_id) {
		// provide access to the primary plugin data structure
		global $trj_golem_data;
		// Get id of plugin home page
		$page_id = $trj_golem_data['init']['plugin_home_page'];
		// if the deleted post is the home page set an error
		if($page_id == $post_id) {
			// Build error message components
			$message = '<h1>' . __('Delete Page Request Denied', 'trj_golem') . '</h1><br/>' . __('Page #', 'trj_golem') . $page_id . __(' is protected and should not be deleted except by using the plugin deletion link on the dashboard plugins page. This page is necessary for the plugin to operate properly.', 'trj_golem');
			$title = __('Delete Page Request Denied', 'trj_golem');
			$args = array(
				'back_link'=>true
				);
			wp_die( $message, $title, $args );
		}
		return;
	} // function trj_golem_prevent_deletion



	/**
	* Activate Script
	*
	* The primary core logic control structure.
	* 1. Make sure there was no initialization error.
	* 2. Check if the current page is the plugin page.
	* 3. Make sure the requested script is a valid one or choose a default.
	* 4. Load and execute the appropriate script for the plugin.
	* 5. Load administrative settings.
	* 6. Load includes.php so scripts can access common functions.
	* 7. Run the script.
	*
	* @return true if a script was loaded and executed.
	* @return false if no script was executed (i.e. the plugin is not active for the current page.)
	*/
	function trj_golem_activate_script() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// If there was a plugin initialization error return early doing nothing.
		if(isset($trj_golem_data['plugin_initialization_error'])) {
			return false;
		} // if

		// Get the id of the current post (only works if used on or after action hook parse_query)
		global $wp_query;
		global $post;
		// If the request is for a non-existent page just return early
		if ( !isset($post) ) {
			return;
		} // if
		$currentPostID = $post->ID;

		// name of the default script to run if none is provided
		$default_script = 'trj_golem_default';

		// Set user provided script to null as a starting condition
		$user_script = null;

		// If the current page is not the plugin home page just return because the plugin is not valid for this page.
		if ($currentPostID !== $trj_golem_data['init']['plugin_home_page']) {
			// unset global data structure to free memory and deny other pages access to it
			unset($trj_golem_data);
			return false;
		} // if

		/* ---------- Determine which script was requested ---------- */
		// If the request is a GET get the query variable from the GET message
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if (isset($_GET['trj_golem_script'])) {
				$user_script = $_GET['trj_golem_script'];
			} // if
		} // if
		// If the request is a POST get the query variable from the POST message
		elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['trj_golem_script'])) {
				$user_script = $_POST['trj_golem_script'];
			} // if
		}  // elseif
		// The request is invalid (neither GET nor POST) so set page error
		else {
			trj_golem_set_page_error(__('HTTP Access Error. Unsupported method (neither GET nor POST).', 'trj_golem'));
		} // else


		/* ---------- Make sure script is valid ---------- */
		// Load script registry from database. This is the list of valid scripts.
		$trj_golem_data['scripts'] = get_option( 'trj_golem_scripts');

		// Set the default script to execute in case of error
		$trj_golem_data['current_script'] = $default_script;

		// If a script was included in the URL check that it is registered
		if (!is_null($user_script)) {
			// If the script is registered make it the active script, otherwise set an error
			if (isset($trj_golem_data['scripts'][$user_script])) {
				$trj_golem_data['current_script'] = $user_script;
			} // if
			else {
				trj_golem_set_page_error(__('Attempt to access the plugin via an unregistered script.', 'trj_golem'));
			} // else
		} // if

		// Load the correct script
		include_once $trj_golem_data['paths']['scripts'] . $trj_golem_data['scripts'][$trj_golem_data['current_script']];

		/* ---------- Includes: Load files needed for all scripts ---------- */
		// Form classes
		include_once "{$trj_golem_data['paths']['includes']}includes.php";

		/* ---------- Include and Register CSS & Javascript ---------- */
		// Include css and javascript
		include_once $trj_golem_data['paths']['includes'] . 'register_css_and_javascript.php';
		// Register custom CSS and Javascript for this plugin
		add_action( 'wp_enqueue_scripts','register_css_and_js');

		// run the script
		$trj_golem_data['current_script']();

		return true;

	} // function


?>
