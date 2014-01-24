<?php
	require_once('theme_functions.php');
	MenuUtil::setArea(THEME_SEARCH);
	TileSet::init("Archives", "archive");
	include_once('template.php');
?>
