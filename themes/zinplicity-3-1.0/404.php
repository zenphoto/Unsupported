<?php
	require_once('theme_functions.php');
	define('ERROR_MESSAGE', 'The requested page cannot be found. This may be our fault - or not. The page might have have been deleted or moved. Either case, ' . 
							'if you ended up here through an internal link, please <a href="' . getCustomPageURL('contact') . '">report the problem</a>.');
	TileSet::init(getGalleryTitle() . ' : ' . "Resource not found", "error");
	include_once('template.php');
?>
