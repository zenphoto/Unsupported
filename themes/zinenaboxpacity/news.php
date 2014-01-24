<?php
	require_once('theme_functions.php');
	$f = $_REQUEST['f'];
	if ( isset($f) && $f == 'xml' ) {
		include('tiles/news/fetch-news.php');	
	}
	else {
		if ( isset($_REQUEST['c']) && $_REQUEST['c'] == 1 ) {
			include("tiles/news/fetch-comments.php");			
		}
		else {
			MenuUtil::setArea(THEME_NEWS);
			NewsUtil::setCurrentNewsPage();
			TileSet::init("News", "news");
			include_once('template.php');
		}
	}
?>
