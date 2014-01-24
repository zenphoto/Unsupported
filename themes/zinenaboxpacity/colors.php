<?php 

	header("Content-type: text/css");
	
	$colorset = getOption('simplicity2_colorset');

	if ( $colorset != 'defaults' ) {
		include("personality/defaults.css"); 
	}
	
	$theme = SERVERPATH . "/themes/" . basename(dirname(__FILE__)) . "/personality/$colorset.css";
	if ( file_exists($theme) ) {
		include($theme); 
	}
?>

