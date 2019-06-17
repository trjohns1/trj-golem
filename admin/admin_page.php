<?php
/**
* Create the plugin administrative settings pages.
*
* This file contains the overall settings page code which supports multiple
* tabs. This code creates the overal structure, determines which tab to call,
* and calls that tab.
*
* The code for each tab is included in its own seperate file.
* Each tab creates a distinct row/option in the wp_options database table.
* Each tab option is an array that can store multiple associated options.

* To create a new tab:
* - Create a new file for the tab.
* - Include the tab file here.
* - Add a case to the switch statement in trj_golem_admin_menu_create for the
*   tab.
* - In trj_golem_admin_menu_callback, render the tab.
* - In trj_golem_admin_menu_callback, create a case in the switch statement to
*   print the form elements for the tab.
* - Make sure the option created by the tab is destroyed by uninstall.php
* - Make sure the option used by the tab is created/upgraded as needed in
*   includes/version_functions.php.
*/


	/* ---------- Include Code for Each Tab ---------- */
	include_once "admin_page_general.php";
	include_once "admin_page_error_log.php";
	include_once "admin_page_documentation.php";
	include_once "admin_page_templates.php";


	/**
	* Create administrative menu
	*
	* Create the basic structure for the plugin administrative settings page.
	* Also calls the appropriate logic for the selected tab.
	*/
	function trj_golem_admin_menu_create() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// A global variable to hold the active tab. Necessary to pass into callback function
		global $trj_golem_admin_active_tab;

		// Create a submenu on the plugins page in the administrative interface.
		add_plugins_page(
			__($trj_golem_data['plugin_name'] . ' Settings', 'trj_golem'),	// Title to be displayed in browswer window for this page
			__($trj_golem_data['plugin_name'], 'trj_golem'),				// The text to be displayed for this menu item
			'administrator',							// Which type of users can see this menu item
			'trj_golem_admin_menu',					// The unique ID --the slug or page name-- for this menu item
			'trj_golem_admin_menu_callback'		// The name of the function to call when rendering this menu's page
		);

		// Determine the appropriate settings tab and action based on the URL query string
		// The query string will be different in GET vs POST, so check both ways
		if($_SERVER['REQUEST_METHOD']==='POST') {
			parse_str(wp_get_referer(), $query_args);
		} // if
		elseif($_SERVER['REQUEST_METHOD']==='GET'){
			$query_args = $_GET;
		}
		// Get the selected tab if there is one
		if(isset($query_args['trj_golem_tab'])) {
			$tab = $query_args['trj_golem_tab'];
		}
		// If no tab parameter was passed set $tab to null string so switch default case will work
		if(!isset($tab)) {
			$tab = '';
		} //if
		// Set the active tab and call the appropriate logic for it
		switch(true) {
			case ($tab == 'general'):
				add_action('admin_init', 'trj_golem_admin_settings_general_initialize');
				$trj_golem_admin_active_tab = 'general';
				break;
			case ($tab == 'error_log'):
				add_action('admin_init', 'trj_golem_admin_settings_error_log_initialize');
				$trj_golem_admin_active_tab = 'error_log';
				break;
			case ($tab == 'documentation'):
				add_action('admin_init', 'trj_golem_admin_settings_documentation');
				$trj_golem_admin_active_tab = 'documentation';
				break;
			case ($tab == 'templates'):
				add_action('admin_init', 'trj_golem_admin_settings_templates_initialize');
				$trj_golem_admin_active_tab = 'templates';
				break;
			default:
				add_action('admin_init', 'trj_golem_admin_settings_general_initialize');
				$trj_golem_admin_active_tab = 'general';
		} // switch
	} // trj_golem_admin_menu_create


	/* ---------- Create Plugin Settings Pages ---------- */
	add_action('admin_menu', 'trj_golem_admin_menu_create');


	/**
	* Display callback
	*
	* Display the administrative menu page for the plugin.
	* This is the view.
	*
	*/
	function trj_golem_admin_menu_callback() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// Make the active tab variable available to this view
		global $trj_golem_admin_active_tab; ?>

		<!-- Create a header using the WordPress 'wrap' container-->
		<div class="wrap">

			<h1><?php echo $trj_golem_data['plugin_name']; _e(' Plugin Settings', 'trj_golem'); ?></h1>

			<!-- Call the WordPress settings errors function -->
			<?php settings_errors(); ?>
			<?php // settings_errors('trj_golem_admin_error_log_num_records'); ?>

			<!-- Render tabs -->
			<h2 class="nav-tab-wrapper">
				<a href="?page=trj_golem_admin_menu&trj_golem_tab=general" class="nav-tab <?php echo $trj_golem_admin_active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e('General', 'trj_golem'); ?></a>
				<a href="?page=trj_golem_admin_menu&trj_golem_tab=error_log" class="nav-tab <?php echo $trj_golem_admin_active_tab == 'error_log' ? 'nav-tab-active' : ''; ?>"><?php _e('Error Logs', 'trj_golem'); ?></a>
				<a href="?page=trj_golem_admin_menu&trj_golem_tab=documentation" class="nav-tab <?php echo $trj_golem_admin_active_tab == 'documentation' ? 'nav-tab-active' : ''; ?>"><?php _e('Documentation', 'trj_golem'); ?></a>
				<a href="?page=trj_golem_admin_menu&trj_golem_tab=templates" class="nav-tab <?php echo $trj_golem_admin_active_tab == 'templates' ? 'nav-tab-active' : ''; ?>"><?php _e('Templates', 'trj_golem'); ?></a>
			</h2>

			<?php


				/**
				* Create Form Elements
				*
				* HTML elements for each form are are created here.
				* The Settings API is the normal form for saving savings. It only
				* requires an opening tag.
				*
				* The WordPress Settings API saves fields when the submit button is pressed,
				* but has no method for handling custom buttons. Functions for each custom
				* button should be defined here and called from the switch statement.
				*
				* All tabs with custom buttons require a specific form.
				*/

				// Create form html (opening tag only) for normal options.php
				$html_form_options = '<form method="post" action="options.php">';

				// Create form html for tab: error_log
				$html_form_error_log_path = $_SERVER["REQUEST_URI"];
				$html_form_error_log =
					'<form action="' . $html_form_error_log_path .'" method="POST" name="form_error_log">' .
						'<p><button type="submit" name="clear_log" value="clear_log" class="button-secondary">' . __('Clear the Log', 'trj_golem') . '</button></p>' .
					'</form>';


				// Render the form elements based on the active tab
				switch(true) {
					case ($trj_golem_admin_active_tab == 'general'):
						echo $html_form_options;
						settings_fields('trj_golem_admin_settings_general_group_01');
						do_settings_sections('trj_golem_admin_menu');
						submit_button();
						break;
					case ($trj_golem_admin_active_tab == 'error_log'):
						echo $html_form_error_log;
						echo $html_form_options;
						settings_fields('trj_golem_admin_settings_error_log_group_01');
						submit_button();
						do_settings_sections('trj_golem_admin_menu');
						break;
					case ($trj_golem_admin_active_tab == 'documentation'):
						echo $html_form_options;
						do_settings_sections('trj_golem_admin_menu');
						break;
					case ($trj_golem_admin_active_tab == 'templates'):
						echo $html_form_options;
						settings_fields('trj_golem_admin_settings_templates_group_01');
						submit_button();
						do_settings_sections('trj_golem_admin_menu');
						submit_button();
						break;
				} // switch
			?>
			</form>
		</div>	<!-- .wrap -->

	<?php
	} // function trj_golem_admin_menu_callback




	/**
	* Include Admin CSS
	*
	* Include stylesheet for styling the administrative settings pages.
	*
	*/
	function trj_golem_admin_register_head() {
	global $trj_golem_data;
		$siteurl = get_option('siteurl');
		$url = $trj_golem_data['paths']['css_url'] . 'adminstyle.css';
		echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
	}

	/* ---------- Hook Admin Styles ---------- */
	add_action('admin_head', 'trj_golem_admin_register_head');

?>
