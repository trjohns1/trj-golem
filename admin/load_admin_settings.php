<?php
/**
* Load plugin settings.
*
* Get plugin options from the wp_options table.
* In general there should be one setting loaded for each admin settings tab.
* Each option is generally stored as an array of individual options.
*/

	$trj_golem_data['admin_settings_general'] = get_option('trj_golem_admin_settings_general', false);
	$trj_golem_data['admin_settings_error_log'] = get_option('trj_golem_admin_settings_error_log', false);
?>
