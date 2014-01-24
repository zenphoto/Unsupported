<?php
	require_once('theme_functions.php');
	define("AREA", HOME);
	TileSet::init(getGalleryTitle() . ' : ' . "Home", "index");
	include_once('template.php');
?>
