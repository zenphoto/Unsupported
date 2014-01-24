<?php
	require_once('theme_functions.php');
	$code = 404;
	TileSet::init(getOption('simplicity2_error_404_title'), "error");
	include_once('template.php');
?>
