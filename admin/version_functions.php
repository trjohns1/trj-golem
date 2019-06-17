<?php
/**
* Version Functions
*
* Functions related to maintaining the plugin to the latest version.
* Includes the initial database installation.
*
* To create a new version:
* 1. Create a new function trj_golem_version_upgrade_vx_to_vy() with all the 
*    upgrade logic.
* 2. Add another case statement to trj_golem_version_upgrade for the new
*    function.
* 3. Adjust (increment) $trj_golem_data['plugin_db_version'] to reflect the
*    required db version.
*
*
*/


	/**
	* trj_golem_version_upgrade
	*
	* Manages the upgrade of the database and options from the initial
	* installation through various versions until it is up to date with the 
	* current version.
	*/
	function trj_golem_version_upgrade() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// Set database version required by the plugin
		$trj_golem_data['plugin_db_version'] = 2;

		// If there was a plugin initialization error return early doing nothing.
		if(isset($trj_golem_data['plugin_initialization_error'])) {
			return false;
		}

		/* ---------- Register Scripts ---------- */
		include_once "{$trj_golem_data['paths']['admin']}script_registry.php";
		// Add script registry to options table
		update_option( 'trj_golem_scripts', $scripts, true );

		// Determine which upgrade to apply and apply it
		$safety_loop = 0; // Set a safety loop to prevent runaway upgrades
		while($trj_golem_data['plugin_db_version'] != $trj_golem_data['init']['db_version']) {
			$safety_loop++;
			switch(true) {
				// If the current db version is zero, assume fresh installation.
				// Setup new v1 environment
				case ($trj_golem_data['init']['db_version'] == 0):
					trj_golem_version_install_v1();
					break;
				// If the current database version is 1, update to version 2
				case($trj_golem_data['init']['db_version'] == 1):
					trj_golem_version_upgrade_v1_to_v2();
					break;
				default:
			} // switch
			if($safety_loop > 25) {
				_e('Fatal Error in plugin ', 'trj_golem') . $trj_golem_data['plugin_name'] . _e(': Maximum number of upgrade cycles exceeded. Manually remove plugin.', 'trj_golem');
				exit;
			} // if
		} // while

		return;

	} // function trj_golem_db_upgrade


	/**
	* trj_golem_version_install_v1
	*
	* Installs the initial v1 version of the database and options.
	*/
	function trj_golem_version_install_v1() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;

		// Get the global database object
		global $wpdb;

		/* ---------- Parameters ---------- */
		// New database version #
		$plugin_db_version = 1;

		// Create a new page to host the user-facing side of the plugin.
		$new_page = array(
		  'post_title' => $trj_golem_data['plugin_name'],
		  'post_content' => $trj_golem_data['html_insertion_point_comment'] . $trj_golem_data['html_insertion_point_string'] ,
		  'post_status' => 'publish',
		  'post_type' => 'page'
		);
		// Insert the post into the database
		$page_id = wp_insert_post( $new_page );

		/* ---------- Create init options ---------- */
		$init = array();
		$init['db_version'] = $plugin_db_version;
		$init['plugin_home_page'] = $page_id;
		update_option( 'trj_golem_init', $init, true );
		// update $trj_golem_data['init'] in memory
		$trj_golem_data['init']['db_version'] = $plugin_db_version;
		$trj_golem_data['init']['plugin_home_page'] = $page_id;


		/* ---------- Create Tables ---------- */
		// Create the table name
		$table_name = $wpdb->prefix . "trj_golem_error_log";
		// If the table does not already exist, create it.
		if(!$wpdb->query("SHOW TABLES LIKE '$table_name'")) {
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				message varchar(4096),
				script varchar(256),
				user varchar(256),
				ip varchar(256),
				time datetime,
				UNIQUE KEY id (id)
			) $charset_collate;";
			$wpdb->query($sql);
		} // if
		// Else if the table already exists set an error and return early
		else {
			$trj_golem_data['plugin_initialization_error'] = "Error creating table $table_name. Table already exists.";
		}

		/* ---------- Create Admin Settings---------- */

		// Add admin option if it does not already exist
		if (false == get_option('trj_golem_admin_settings_general')) {
			add_option('trj_golem_admin_settings_general');
		} // if

		// Add error_log option if it does not already exist
		if (false == get_option('trj_golem_admin_settings_error_log')) {
			add_option('trj_golem_admin_settings_error_log');
		} // if

		// Add templates option if it does not already exist
		if (false == get_option('trj_golem_admin_settings_templates')) {
			add_option('trj_golem_admin_settings_templates');
		} // if


		/* ---------- Create Default Values for Settings---------- */

		$trj_golem_admin_settings_general_default = array (
			'option_01' => 'option 01 default',
			'option_02' => '10',
			'option_03' => '1',
			'option_04' => 'never'
		);
		update_option('trj_golem_admin_settings_general', $trj_golem_admin_settings_general_default, true);

		$trj_golem_admin_settings_error_log_default = array (
			'num_records' => '25'
		);
		update_option('trj_golem_admin_settings_error_log', $trj_golem_admin_settings_error_log_default, true);

		$trj_golem_admin_settings_templates_default = array (
			'text' => 'text default',
			'password' => 'password default',
			'number' => '5',
			'color' => '#0000ff',
			'range' => '75',
			'email' => 'user@example.com',
			'search' => 'default search string',
			'tel' => '800-123-4567',
			'url' => 'http://www.example.com',
			'date' => '1776-07-04',
			'month' => '1776-07',
			'week' => '1776-W26',
			'time' => '10:00:00',
			'datetime' => '1776-07-04T10:00:00',
			// 'checkbox' => '1', // leave this array element out for unchecked default
			'radio' => '2',
			'select' => 'sometimes',
			'textarea' => 'textarea default'
		);
		update_option('trj_golem_admin_settings_templates', $trj_golem_admin_settings_templates_default, true);


		/* ---------- Register Authorization Capabilities ---------- */
		// Define the capabilities
		$capabilities =
			array(
				'trj_golem_permission_1',
				'trj_golem_permission_2',
				'trj_golem_permission_3'
			);
		// Get the administrator role
		$role = get_role('administrator');
		// Add capabilities to the role
		foreach($capabilities as $cap) {
			$role->add_cap($cap);
		}

		return;
	} // function


	/**
	* trj_golem_version_upgrade_v1_to_v2
	*
	* Upgrades the database from version 1 to version 2.
	*/
	function trj_golem_version_upgrade_v1_to_v2() {

		// provide access to the primary plugin data structure
		global $trj_golem_data;
		// Get the global database object
		global $wpdb;
		// New plugin_db_version
		$plugin_db_version = 2;
		

		/* ---------- Create Tables ---------- */
		// Create the table name
		$table_name = $wpdb->prefix . "trj_golem_car";
		// If the table does not already exist, create it.
		if(!$wpdb->query("SHOW TABLES LIKE '$table_name'")) {
			$charset_collate = $wpdb->get_charset_collate();
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				make varchar(256),
				model varchar(256),
				automatic tinyint,
				UNIQUE KEY id (id)
			) $charset_collate;";
			$wpdb->query($sql);
		} // if
		// Else if the table already exists set an error and return early
		else {
			$trj_golem_data['plugin_initialization_error'] = "Error creating table $table_name. Table already exists.";
		}

		/* ---------- Update init options - IMPORTANT ---------- */
		$trj_golem_data['init']['db_version'] = $plugin_db_version;
		update_option( 'trj_golem_init', $trj_golem_data['init'], true );

		return;
	}

?>
