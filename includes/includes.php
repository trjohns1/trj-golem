<?php
/**
* Includes
*
* Load include files for the plugin.
* This file is loaded by the core plugin, so any files listed here will be
* included for every script.
* List all files necessary for the plugin application here.
* 
* To override, leave this file blank and put includes directly in scripts.
*/

	// Form classes
	include_once "form_classes.php";

	// Get query variables from the request (GET or POST)
	include_once "get_query_vars.php";

	// Record In Database
	include_once "record_in_db.php";

	// Save for Redisplay
	include_once "save_for_redisplay.php";

	// Pagination
	include_once "paginate.php";


?>
