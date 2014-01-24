<?php
	require_once('theme_functions.php');
	define("AREA", 'THEME');
	TileSet::init(getGalleryTitle() . ' : Theme', "theme");
	include_once('template.php');
?>
