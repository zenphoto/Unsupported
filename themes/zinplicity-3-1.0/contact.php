<?php
	require_once('theme_functions.php');
	define("AREA", 'CONTACT');
	TileSet::init(getGalleryTitle() . ' : Contact', "contact");
	include_once('template.php');
?>
