<?php
	require_once('theme_functions.php');
	define("AREA", NEWS);
	TileSet::init(getGalleryTitle() . ' : ' . "Notes", "news");
	include_once('template.php');
?>
