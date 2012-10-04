<?php
/**
 * Copyright 2006/2007  Alessandro Morandi  (email : webmaster@simbul.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once('classes.php');

// Create Error Handling Object
$zp_eh = new ZenPressErrorHandler(ZP_E_FATAL);	// To debug use ZP_E_ALL

// Start output buffering
ob_start(array($zp_eh,'callback'));

$zp_eh->addInfo('PHP Version:',phpversion());
$zp_eh->addInfo('Current working directory:',getcwd());
$zp_eh->addInfo('POST:',$_POST);
$zp_eh->addInfo('GET:',$_GET);

$zp_path = '../../../../';
if (!file_exists($zp_path.'wp-config.php') || !file_exists($zp_path.'wp-admin/admin.php')) {
	$zp_path = ZenPressHelpers::getWPBasePath();
	if ($zp_path == null) {
		$zp_eh->addFatal('Could not find wp-config.php or wp-admin dir');
	}
}
require_once($zp_path.'wp-config.php');
require_once($zp_path.'wp-admin/admin.php');

load_plugin_textdomain('zenpress','wp-content/plugins/zenpress/locale');
		
$zp_web_path = get_option('zp_web_path');
$zp_admin_path = get_option('zp_admin_path');

$zp_eh->addInfo('Web path:',$zp_web_path);
$zp_eh->addInfo('Admin path:',$zp_admin_path);
$zp_eh->addInfo('WordPress ABSPATH:',ABSPATH);
$zp_eh->addInfo('WordPress siteurl:',get_option('siteurl'));

if ($zp_web_path=="" || $zp_admin_path=="") {	
	$zp_eh->addFatal(__('Zenphoto paths are not set. Check the configuration page.','zenpress'));
}
if (!file_exists($zp_admin_path.'/zp-config.php')) {
	$zp_eh->addWarning(__('File zp-config.php not found. Looking for config.php','zenpress'));
	// Support for past Zenphoto versions
	if (!file_exists($zp_admin_path.'/config.php')) {
		$zp_eh->addFatal(__('Cannot find Zenphoto configuration file.','zenpress'));
	} else {
		require_once($zp_admin_path.'/config.php');
	}
} else {
	require_once($zp_admin_path.'/zp-config.php');
}

$zp_eh->addInfo('mod_rewrite:',$conf['mod_rewrite']);

// Create Database Object
$zp_db = new ZenPressDB($conf['mysql_host'], $conf['mysql_user'], $conf['mysql_pass'], $conf['mysql_database'], $conf['mysql_prefix']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php _e('ZenPress Dialog','zenpress') ?></title>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<?php if ($_GET[tinyMCE]) {?>
	<script language='javascript' type='text/javascript' src='<?php echo get_bloginfo('wpurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js'></script>
	<?php } else { ?>
	<link rel='stylesheet' href='css/zenpress.css' type='text/css' />
	<?php } ?>
	<link rel='stylesheet' href='css/zenpress_additional.css' type='text/css' />
	<script language='javascript' type='text/javascript' src='js/functions.js'></script>
</head>

<body>
<?php
	ZenPressGUI::print_albums($_POST[album]);
	
	if ($_POST[album]) {
		ZenPressGUI::print_image_select($_POST[album]);
	}

	// Stop buffering output
	ob_end_flush();
?>
</body>
</html>
