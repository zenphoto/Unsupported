<?php
if(function_exists("checkForPage")) { // check if Zenpage is enabled or not
	if (checkForPage(getOption("zenpage_homepage"))) { // switch to a news page
		$ishomepage = true;
		include ('pages.php');
	} else {
		include ('combopage.php');
	}
} else { 
	include ('combopage.php');
}
?>