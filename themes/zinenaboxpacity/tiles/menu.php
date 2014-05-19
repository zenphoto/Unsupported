<?php

if (getOption('simplicity2_print_home_menu_item')) {
	MenuUtil::printMenuItem(getGalleryIndexUrl(), gettext("Home"), THEME_HOME, "first");
}
MenuUtil::printMenuItem(getGalleryIndexUrl(), gettext("Gallery"), THEME_GALLERY, '', true);

if (function_exists('getNewsIndexURL')) : //if zenpage is enabled
	MenuUtil::printMenuItem(NewsUtil::getNewsIndexUrl(), gettext("Notes"), THEME_NEWS);
endif;

$m = SERVERPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/menus/main.php";
if (file_exists($m)) {
	include($m);
}

if (getOption('simplicity2_print_contact_menu_item') && !getOption('simplicity2_contact_is_secondary')) :
	$pageName = getOption('simplicity2_contact_page_name');
	if (is_null($pageName) or trim($pageName) == '') :
		MenuUtil::printMenuItem(getCustomPageURL("contact"), gettext("Contact"), THEME_CONTACT, '', false, 'contact-link');
	else:
		MenuUtil::printMenuPageLink($pageName, gettext('Contact'), 'contact-link');
	endif;
endif;
?>

