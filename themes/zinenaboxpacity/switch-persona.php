<?php
	require_once('theme_functions.php');

	$persona = $_GET['persona'];

	$serverPrefix = SERVERPATH . '/themes/' . basename(dirname(__FILE__)) . "/personality/" . $persona;
	$webPrefix = WEBPATH . '/themes/' . basename(dirname(__FILE__)) . "/personality/" . $persona;

	if (!isset($persona) || trim($persona) == '') {
		//TODO remove cookie and reset ui. 
		return;
	}

	$never_expire = 60*60*24*365*10;
	setcookie("persona", $persona, mktime() + $never_expire, "/"); 

	function handleStyles() {
		global $serverPrefix, $webPrefix, $persona;
		$validBanner = file_exists("$serverPrefix/banner.png");
		$validFooter = file_exists("$serverPrefix/footer.png");

		$validCss = file_exists("$serverPrefix/styles.css");

		if ( $validCss ) {
			$css = "$webPrefix/styles.css";
		}
		else {
			$css = WEBPATH . "/themes/" . basename(dirname(__FILE__)) . "/resources/css/styles.css";
		}

		echo "<style src='$css'>\n";
		if ( $validBanner ) {
			$banner = "$webPrefix/banner.png";
			echo "#banner {	\n" .
				 "	background: transparent url($banner) no-repeat 0 -10px; \n" .
				 "} \n";
		}
		else {
			echo "#banner {	\n" .
				 "  background-image: none; \n" +
				 "	background: transparent no-repeat 0 -10px; \n" .
				 "} \n";
		}

		if ( $validFooter ) {
			$footer = "$webPrefix/footer.png";
		 	echo "#footer {	\n" .
				 "	background: transparent url($footer) no-repeat 0 -10px; \n" .
				 "} \n" ;
		}
		else {		
		 	echo "#footer {	\n" .
				 "  background-image: none; \n" +
				 "	background: #ccd no-repeat 0 -10px; \n" .
				 "} \n" ;
		}
	    echo "</style> \n";

		$icons = PersonalityUtil::getPersonaIconList($persona);
		
		echo "<div id='icons'";
		
		foreach ( $icons as $icon ) {
			$i = substr($icon, 0, strlen($icon) - 4);
			echo " $i='1'";
		}

		echo "/>";
		
	}

	handleStyles();

?>
