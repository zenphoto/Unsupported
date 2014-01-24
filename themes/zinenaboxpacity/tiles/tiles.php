<?php
	$tileDefinitions = array(

			"album" => array(
					"left" => "tiles/album/left.php", 
					"content" => "tiles/album/content.php", 
					"script" => "tiles/album/script.js", 
					"init-script" => "tiles/album/init.php"),

			"archive" => array(
					"left" => "tiles/search/left.php", 
					"content" => "tiles/archive/content.php",
					"script" => array(
						"tiles/album/script.js", 
						"tiles/archive/script.js"), 
					"init-script" => "tiles/album/init.php"),

			"contact" => array(
					"left" => "tiles/contact/left.php", 
					"content" => "tiles/contact/content.php",
					"script" => "tiles/contact/script.js", 
					"init-script" => "tiles/shared/init.php"),

			"gallery" => array(
					"left" => "tiles/gallery/left.php", 
					"content" => "tiles/gallery/content.php",
					"script" => "tiles/album/script.js", 
					"init-script" => "tiles/album/init.php"),

			"error" => array(
					"left" => "tiles/index/left.php", 
					"content" => "tiles/error/content.php",
					"init-script" => "tiles/shared/init.php"),

			"index" => array(
					"left" => "tiles/index/left.php", 
					"content" => "tiles/index/content.php",
					"init-script" => "tiles/shared/init.php"),

			"news" => array(
					"left" => "tiles/news/left.php", 
					"content" => "tiles/news/content.php",
					"init-script" => "tiles/news/init.php", 
					"script" => "tiles/news/script.js"),

			"pages" => array(
					"left" => "tiles/page/left.php", 
					"content" => "tiles/page/content.php",
					"init-script" => "tiles/shared/init.php"),

			"password" => array(
					"left" => "tiles/index/left.php", 
					"content" => "tiles/password/content.php",
					"init-script" => "tiles/shared/init.php"),

			"search" => array(
					"left" => "tiles/search/left.php", 
					"content" => "tiles/search/content.php",
					"script" => "tiles/album/script.js", 
					"init-script" => "tiles/album/init.php"),

			"theme-info" => array(
					"left" => "tiles/theme/left.php", 
					"content" => "tiles/theme/content.php",
					"init-script" => "tiles/shared/init.php")
	);

	TileSet::configure($tileDefinitions);
?>
