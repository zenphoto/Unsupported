<?php
	require_once('theme_functions.php');

	$f = $_REQUEST['f'];
	if ( isset($f) && $f == 'xml' ) {
		include('tiles/search/fetch-thumbs.php');	
	}
	else {
		MenuUtil::setArea(THEME_SEARCH);
		TileSet::init("Search", "search");
		include_once('template.php');
	}
?>
