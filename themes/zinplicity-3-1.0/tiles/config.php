<?php
	$tileDefinitions = array(
		"default" => array(
			"content" => "tiles/%tile/content.php",
			"css" => array("tiles/%tile/%tile.css"))
	);

	TileSet::configure($tileDefinitions);
?>
