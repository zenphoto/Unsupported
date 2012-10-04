<?php 
/**
 * Trackback receiver for Zenphoto
 */
require_once(dirname(__FILE__).'/zp-core/folder-definitions.php');
require_once(ZENFOLDER ."/functions.php");
if (!getOption('zp_plugin_comment_trackback')) {
	header("HTTP/1.0 404 Not Found");
	header("Status: 404 Not Found");
	include(ZENFOLDER. '/404.php');
	exit();
}
require_once(ZENFOLDER .'/'.PLUGIN_FOLDER . "/comment_trackback.php");
$_zp_trackback->printTrackbackReceiver();
?>