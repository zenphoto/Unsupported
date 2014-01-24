<?php
	require_once('theme_functions.php');
	$code = 500;
	TileSet::init(getOption('simplicity_2_error_500_title'), "error");
	include_once('template.php');
?>
