<?php
	require_once('theme_functions.php');
	define("AREA", ARCHIVES);
	TileSet::init(getGalleryTitle() . ' : ' . "Search", "search");
	include_once('template.php');
?>
