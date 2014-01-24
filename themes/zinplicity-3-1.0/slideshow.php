<?php
	require_once('theme_functions.php');
	define("AREA", GALLERY);
	TileSet::init(getGalleryTitle() . ' : ' . getAlbumTitle() . " slideshow", "slideshow");
	include_once('template.php');
?>
