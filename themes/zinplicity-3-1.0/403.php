<?php
	require_once('theme_functions.php');
	define('ERROR_MESSAGE', 'You\'re not allowed to access the requested page. This is not a temporary error. ' . 
							'If you ended up here through an internal link, please <a href="' . getCustomPageURL('contact') . '">report the problem</a>.');
	TileSet::init(getGalleryTitle() . ' : ' . "Access forbidden", "error");
	include_once('template.php');
?>
