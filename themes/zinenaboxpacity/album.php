<?php
	$f = $_REQUEST['f'];
	if ( isset($f) && $f == 'xml' ) {
		require_once('theme_functions.php');
		include('tiles/album/fetch-thumbs.php');	
	}
	else {
		require_once('theme_functions.php');
		MenuUtil::setArea(THEME_GALLERY);
		TileSet::init(getAlbumTitle(), "album");
		include_once('template.php');
	}
?>
