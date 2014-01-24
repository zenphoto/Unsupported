<?php
	require_once('theme_functions.php'); 
	define("AREA", GALLERY);
	TileSet::init(getGalleryTitle() . ' : ' . getAlbumTitle() . ' : ' . getImageTitle(), "album");
	include_once('template.php');
?>
