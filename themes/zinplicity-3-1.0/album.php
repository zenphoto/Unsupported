<?php
	require_once('theme_functions.php');
	define("AREA", GALLERY);
	TileSet::init(getGalleryTitle() . ' : ' . getAlbumTitle(), "album");
	include_once('template.php');
?>
