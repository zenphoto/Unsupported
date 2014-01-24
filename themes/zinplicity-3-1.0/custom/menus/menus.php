<?php 
	Menu::main()->register(new MenuItem("Home", array('tile'=>"index", 'href'=>getGalleryIndexURL(FALSE)), "home-menu-item", HOME));
	Menu::main()->register(new MenuItem("Gallery", array('tile'=>"album", 'href'=>getGalleryIndexURL()), "gallery-menu-item", GALLERY));
	
	if ( function_exists('getNewsIndexURL') ):
		Menu::main()->register(new MenuItem("Notes", array('tile'=>"news", 'href'=>Utils::getNewsIndexURL()), "news-menu-item", NEWS));
	endif;

	//custom zenpage page
	Menu::main()->register(new PageItem("Publications", "publi-menu-item", "publi"));

	Menu::secondary()->register(new MenuItem("Theme info", array('tile'=>"theme", 'href'=>getCustomPageURL("theme-info")), "theme-menu-item", 'THEME'));
	Menu::secondary()->register(new MenuItem("Contact", array('tile'=>"contact", 'href'=>getCustomPageURL("contact")), "contact-menu-item", "CONTACT"));
	Menu::secondary()->register(new MenuItem("Search", array('tile'=>"search", 'href'=>getCustomPageURL('search')), "search-menu-item", ARCHIVES));
?>
