<?php
	require_once('theme_functions.php');
	$code = 403;
	TileSet::init(getOption('simplicity_2_error_403_title'), "error");
	include_once('template.php');
?>

