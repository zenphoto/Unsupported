<?php
	require_once('theme_functions.php');
	MenuUtil::setArea(THEME_INFO);
	TileSet::init("Archives", "theme-info");
	include_once('template.php');
?>
