<?php
/**
* Uninstall
*
* Actions that are called when the plugin is deactivated
*
* 1. Delete plugin home page.
* 2. Delete admin settings.
* 3. Delete custom database tables.
* 4. Delete custom capabilities.
*/

	// If uninstall not called from WordPress exit early
	if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		 exit ();
	} // if

	// provide access to the primary plugin data structure
	global $trj_golem_data;

	// provide access to the database object
	global $wpdb;

	// Get options
	$init = get_option( 'trj_golem_init' );

	// Delete plugin home page
	wp_delete_post($init['plugin_home_page'], true);

	// Delete plugin init
	delete_option( 'trj_golem_init');

	// Delete plugin scripts
	delete_option( 'trj_golem_scripts');


	/************************************************************************
	*************************************************************************
	* Delete Custom Options
	*************************************************************************
	*************************************************************************
	* Delete Custom Options
	*
	* Delete options set on administrative tabs.
	* There should be one option for each tab.
	*/

	// Delete options admin_settings_general
	delete_option('trj_golem_admin_settings_general');

	// Delete options admin_settings_error_log
	delete_option('trj_golem_admin_settings_error_log');

	// Delete options admin_settings_templates
	delete_option('trj_golem_admin_settings_templates');


	/************************************************************************
	*************************************************************************
	* Delete Tables
	*************************************************************************
	*************************************************************************
	* Delete Custom Tables
	*
	* Delete any tables created by the plugin.
	*/

	// Drop the table trj_golem_error_log
	$tablename = $wpdb->prefix.'trj_golem_error_log';
	$sql = "DROP TABLE IF EXISTS ". $tablename;
	$wpdb->query($sql);

	// Drop the table trj_golem_test
	$tablename = $wpdb->prefix.'trj_golem_car';
	$sql = "DROP TABLE IF EXISTS ". $tablename;
	$wpdb->query($sql);



	/************************************************************************
	*************************************************************************
	* Delete Capabilities
	*************************************************************************
	*************************************************************************
	* Delete Authorization Capabilities
	*
	* Delete any capabilities created by the plugin.
	*/
	$capabilities =
		array(
			'trj_golem_permission_1',
			'trj_golem_permission_2',
			'trj_golem_permission_3'
		);
	// get the administrator role
	$role = get_role('administrator');
	// remove capabilities from the role
	foreach($capabilities as $cap) {
		$role->remove_cap($cap);
	} // foreach

?>
