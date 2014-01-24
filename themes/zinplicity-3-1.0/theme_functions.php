<?php 
	//ensure deprecated errors don't go through
	error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
	
	//set DEPLOY to generate appropriate headers
	//define('DEPLOY', 1);

	//show stacktraces in debug mode
	//require_once('lib/debugging.php');

	require_once('options-override.php');
	require_once('areas.php');
	require_once('classes/Utils.php');
	require_once('classes/Menu.php');
	require_once('classes/TileSet.php');	
	require_once('tiles/config.php');
?>
