<?php
/**
* Create an administrative settings tab
*
* This file creates one tab of the administrative settings user interface.
* It is called by admin_page.php
*/

	/**
	* Register tab elements
	*
	* Register sections, fields, and settings for the tab
	*/
	function trj_golem_admin_settings_documentation() {

		/* ---------- Register sections ---------- */

		add_settings_section(
			'trj_golem_admin_settings_documentation_section_01',				// ID used to identify this section and with which to register options
			__('Plugin Documentation', 'trj_golem'),								// Title to be displayed on the administrative page
			'trj_golem_admin_settings_documentation_section_01_callback',	// Callback used to render the description of the section
			'trj_golem_admin_menu'														// Page on which to add this section of options
		);

	} // function trj_golem_admin_settings_documentation


	/* ---------- Section Callbacks ---------- */

	/**
	* Display section user interface elements
	*/
	function trj_golem_admin_settings_documentation_section_01_callback() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		$html  = '';
		$html .= '<p>';
		$html .= 	$trj_golem_data['plugin_name'] . __(' is a plugin template that can be used to create other WordPress plugins. It is a fully functional plugin that can be modified to create a database-driven web application. It has the following features:', 'trj_golem');
		$html .= '</p>';
		$html .= '<ol>';
		$html .= 	'<li>';
		$html .= 		__('Enables the creation of database-driven web applications.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Full installation and clean uninstallation.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Supports database upgrades as the plugin versions increase.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('User management and authorization via standard WordPress capabilities.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Robust tabbed administrative settings interface.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('HTML form classes for easy form creation and management.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Error logging.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Creation of custom database tables for complex data management.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('The core plugin is fully internationalized to support translations.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Support for CSS styling of plugin elements.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Queues .js files for plugin development requiring javascript.', 'trj_golem');
		$html .= 	'</li>';
		$html .= '</ol>';
		$html .= '<h2>';
		$html .= 	__('Make a Working Copy of the Plugin', 'trj_golem');;
		$html .= '</h2>';
		$html .= '<p>';
		$html .= 	__('In order to use the plugin as a template, first create a copy of the plugin giving it a new name and replacing the plugin prefix with a new prefix to ensure that all functions and variables have a unique namespace.', 'trj_golem');
		$html .= '</p>';
		$html .= '<ol>';
		$html .= 	'<li>';
		$html .= 		__('Make a copy of the entire trj_golem directory and put it in the WordPress plugins directory, giving it a new name as you do so.', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Change the name of the new plugin core file "trj_golem.php" to something descriptive and unique, such as "trj_foo".', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<li>';
		$html .= 		__('Search the entire new plugin directory, including all files and subdirectories for occurences of "trj_golem" and replace them with a new prefix string, such as "trj_foo".', 'trj_golem');
		$html .= 	'</li>';
		$html .= 	'<pre>';
		$html .= 		"find -name '*.php' -type f -print0 | xargs -0 sed -i 's/trj_golem/trj_zombie/g'";
		$html .= 	'</pre>';
		$html .= '</ol>';
		$html .= '<h2>';
		$html .= 	__('User Management', 'trj_golem');;
		$html .= '</h2>';
		$html .= '<p>';
		$html .= 	__('The plugin uses standard WordPress user accounts and can be used straightaway without modification. To enable single sign-on, install the plugin miniOrangeSAML SSO and configure according to specifications provided by your identity management service provider.', 'trj_golem');
		$html .= '</p>';
		$html .= '<h2>';
		$html .= 	__('Authorization', 'trj_golem');;
		$html .= '</h2>';
		$html .= '<p>';
		$html .= 	__('The plugin uses the WordPress capabilities model to control access to individual scripts and handle authorization. When the plugin is installed it creates the capabilities it needs and assigns them to the administrator role. The plugin does not have a built-in user capabilities editor. Instead use the "User Role Editor" plugin or similar capabilities editor to assign plugin capabilities to the roles of your choice. These capabilities should be prefixed by the plugin prefix created when the working copy of the plugin was created.', 'trj_golem');
		$html .= '</p>';
		$html .= '<p>';
		$html .= 	__('The programmer should do two things to enable authorization:', 'trj_golem');
		$html .= '</p>';
		$html .= '<ol>';
		$html .= '<li>';
		$html .= 	__('The file admin/version_functions.php contains an array $capabilities which holds a list of capabilities that are created when the plugin is installed. Edit this list to create the capabilities required for the application.', 'trj_golem');
		$html .= '</li>';
		$html .= '<li>';
		$html .= 	__('Each script features a $script_permission variable which the programmer should set to a capability that should have access to the script. Generally, this capability corresponds to one of the capabilities created in admin/version_functions, although it could refer to any WordPress capability.', 'trj_golem');
		$html .= '</li>';
		$html .= '</ol>';
		$html .= '<h2>';
		$html .= 	__('Creating Scripts', 'trj_golem');;
		$html .= '</h2>';
		$html .= '<p>';
		$html .= 	__('When installed, the plugin creates a single WordPress page. All of the scripts run on this page, creating different forms and views for the user. The individual scripts to run are based on the script name being provided in the query string. For example', 'trj_golem');
		$html .= '</p>';
		$html .= 	'<pre>';
		$html .= 		'https://www.example.com/wordpress/?page_id=3012&trj_golem_script=trj_golem_template_form&trj_golem_color=red';
		$html .= 	'</pre>';
		$html .= 	__('describes a WordPress instance running encrypted on www.example.com. The page_id of 3012 indicates the plugin home page from which all plugin scripts will run. The particular script to be invoked is "trj_golem_template_form" and "red" is an argument used by that script.', 'trj_golem');
		$html .= '</p>';
		$html .= '<h2>';
		$html .= 	__('Files and How to Use Them', 'trj_golem');;
		$html .= '</h2>';
		$html .= '<table class="widefat">';
		$html .= 	'<th>';
		$html .= 		'<em><b>' . __('file', 'trj_golem') . '</b></em>';
		$html .= 	'</th>';
		$html .= 	'<th>';
		$html .= 		'<em><b>' . __('comment', 'trj_golem') . '</b></em>';
		$html .= 	'</th>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			'<em>' . __('- Top level files. -', 'trj_golem') . '</em>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'trj_golem.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('The core plugin logic. Initializes the plugin and calls the appropriate script. ', 'trj_golem') . '<strong>' . __('There is generally not a need to modify this file.', 'trj_golem') . '</strong>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'uninstall.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Actions needed when the plugin is uninstalled from the administrative interface. Put code here to delete custom options, database tables, and capabilities.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			'<em>' . __('- Files used by the administrative user interface and to configure the plugin. -', 'trj_golem') . '</em>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/admin_page.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Main code to create the administrative user interface. Use this to create individual tabs.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/admin_page_documentation.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Creates the documentation tab of the administrative user interface.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/admin_page_error_log.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Creates the error_log tab of the administrative user interface.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/admin_page_general.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Creates the general tab of the administrative user interface.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/admin_page_templates.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Creates the templates tab of the administrative user interface.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/comment_style.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Sample comments to show documentation style. For reference only.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/config.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Sets basic options for the plugin. Modify PHP behavior here.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/load_admin_settings.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Get plugin options for use by the plugin. These are the options set in the administrative user interface.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/script_registry.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A list of all scripts that are allowed to run for the plugin. Unregistered scripts will not be called. List new scripts here.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'admin/version_functions.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Code to install the initial database and options, and to upgrade them as the plugin version increases. Put upgrade code here.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			'<em>' . __('- Files included to be used by scripts -', 'trj_golem') . '</em>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/includes.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Included automaticall by the core plugin. List here any files you wish to be included by ALL scripts.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/error_handling.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A set of functions that register a page error, log a page error to the database, and display a page error.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/form_classes.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A set of classes for creating and managing forms. Used only on application pages, not in the administrative user interface.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/get_query_vars.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Gets query variables requested by the user regardless of http message type.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/paginate.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A utility that generates an HTML pagination widget.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/record_in_db.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Tests if a particular record exists in the database. Used to prevent processing a record that does not exist.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/register_css_and_javascript.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('Registers and enqueues css stylesheets and javascript programs. Edit this to include css and js files.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'includes/save_for_redisplay.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A utility that copies user data into a form so that a user does not have to retype all form data just because there are validation errors in some form fields.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			'<em>' . __('- CSS -', 'trj_golem') . '</em>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'css/adminstyles.css';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('CSS file for styling administrative settings pages', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'css/styles.css';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('CSS file for styling plugin elements', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			'<em>' . __('- Javascript -', 'trj_golem') . '</em>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'js/script.js';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A sample javascript file that is properly enqueued.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			'<em>' . __('- Sample scripts to be used as templates for building applications -', 'trj_golem') . '</em>';
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'scripts/cars_create.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A script that allows a user to create a new record', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'scripts/cars_edit.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A script that allows a user to update or delete an existing record.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'scripts/cars_list.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A script that allows a user to search for records based on filter criteria and display the results in a paginated list.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 			'scripts/default.php';
		$html .= 		'</td>';
		$html .= 		'<td>';
		$html .= 			__('A script that runs when no specific script is included in the query request. This is often used as the application home or splash page.', 'trj_golem');
		$html .= 		'</td>';
		$html .= 	'</tr>';
		$html .= '</table>';










		echo $html;
	} // function trj_golem_admin_settings_documentation_view
?>
