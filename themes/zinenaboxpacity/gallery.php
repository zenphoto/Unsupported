<?php
	require_once('theme_functions.php');

	$f = $_REQUEST['f'];
	if ( isset($f) && $f == 'xml' ) {
		include('tiles/gallery/fetch-thumbs.php');	
	}
	else {
		MenuUtil::setArea(THEME_GALLERY);
		TileSet::init("Gallery", "gallery", THEME_GALLERY);
		include_once('template.php');
	}
?>

<?php
?>
