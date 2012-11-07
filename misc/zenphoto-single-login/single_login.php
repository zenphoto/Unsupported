<?php
/**
 * This script provides a single login to your zenphoto
 * gallery from somewhere else in your website. Place
 * the script in the zenphoto root folder.  create an
 * index.php file at the URL where your users will visit
 * to login. This index.php script should be simply
 *
 * <?php
 * header("Location: <zenphoto install root>/single_login.php" );
 * exit();
 * ?>
 *
 * Where <zenphoto install root> is the URL of your zenphoto root folder, e.g. http://myhost.com/zenphoto
 *
 * Of course, modify the style of this script to fit your needs.
 */
require_once(dirname(__FILE__).'/zp-core/global-definitions.php');
define('OFFSET_PATH', 0);
require_once(ZENFOLDER . "/template-functions.php");
checkInstall();

if (!is_null($_zp_current_admin_obj)) {
	if ($_zp_loggedin & ADMIN_RIGHTS) {
		header("Location: " . WEBPATH . "/");
	} else {
		$albums = getManagedAlbumList();
		$album = array_shift($albums);
		header("Location: " . WEBPATH . "/".$album.'/');
	}
}
header ('Content-Type: text/html; charset=' . getOption('charset'));
?>
<html>
<head>
<title>Zenphoto Single_login</title>
</head>
<body>
<?php
printPasswordForm('', true, false, "#");
?>
</body>
</html>
