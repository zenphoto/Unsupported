<?php
	global $_zp_current_image;
	require_once('theme_functions.php');
	AlbumUtil::setCurrentAlbumPage();
	$_highlight_image = $_zp_current_image->filename;
	include('album.php');
?>
