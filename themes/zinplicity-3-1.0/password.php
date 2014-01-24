<?php
	require_once('theme_functions.php');
	TileSet::init(getGalleryTitle() . ' : ' . "Protected page", "password");
	include_once('template.php');
?>
