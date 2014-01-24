<?php
	require_once('theme_functions.php');
	MenuUtil::setArea(THEME_HOME);
	TileSet::init("Home", "index");
	include_once('template.php');
?>
