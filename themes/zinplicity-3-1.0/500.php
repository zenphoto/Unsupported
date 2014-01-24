<?php
	require_once('theme_functions.php');
	define('ERROR_MESSAGE', "Weirdly enough, an internal error just occured. It is most probably only temporary, but should it perdure, " . 
						    "feel free to <a href='" . getCustomPageURL('contact') . "' rel='contact'>report the problem</a>.");
	TileSet::init(getGalleryTitle() . ' : ' . "Internal error", "error");
	include_once('template.php');
?>
