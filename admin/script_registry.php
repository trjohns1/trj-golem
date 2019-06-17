<?php
/**
* Script Registry
*
* An array of scripts that the plugin may run.
* All scripts must be registered here in order to function.
* This data structure is checked by the main code to determine if a script
* requested by a user is actually a registered script.
*
* Format: $scripts['script_name'] = 'filename';
* - script_name is the name used in the http query to identify a script.
* - filename is the name of the file containing the script.
*/

	$scripts['trj_golem_default'] = 'default.php';
	$scripts['trj_golem_template'] = 'template.php';
	$scripts['trj_golem_template_form'] = 'template_form.php';
	$scripts['trj_golem_cars_create'] = 'cars_create.php';
	$scripts['trj_golem_cars_edit'] = 'cars_edit.php';
	$scripts['trj_golem_cars_list'] = 'cars_list.php';

?>
