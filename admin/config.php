<?php
/**
* Configuration Settings
*
* Edit this file to customize plugin settings.
*/

	/**
	* Debugging
	*
	* Turn debugging on or off.
	* - use 0 for no error reporting
	* - E_ALL for all errors
	*/
	error_reporting(E_ALL);

	// Set friendly name for the plugin
	$trj_golem_data['plugin_name'] = __('Golem', 'trj_golem');
	// Set the html insertion point string where plugin html will be placed on the page
	$trj_golem_data['html_insertion_point_string'] = '<!-- trj_golem_plugin_insertion_point -->';
	// Set the html insertion point string where plugin html will be placed on the page
	$trj_golem_data['html_insertion_point_comment'] = '<!-- ' . __('Place the insertion point comment where you want the plugin display to appear.', 'trj_golem') . ' -->';

	// Set paths for where primary content is located (relative to plugin base directory)
	$path_admin = 'admin/';
	$path_css = 'css/';
	$path_includes = 'includes/';
	$path_js = 'js/';
	$path_languages = 'languages/';
	$path_media = 'media/';
	$path_scripts = 'scripts/';

?>
