<?php 
	$m = SERVERPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/menus/secondary.php";

	if ( file_exists($m) ) {
		include($m);
	}

	if ( getOption('simplicity2_enable_archive') ) :
		MenuUtil::printSecondaryLinkItem('browse-archive', getCustomPageURL('archive'), gettext('Archives'), THEME_SEARCH); 
	endif;

	if ( getOption('simplicity2_print_contact_menu_item') && getOption('simplicity2_contact_is_secondary') ) : 
		$pageName = getOption('simplicity2_contact_page_name');
		$text = gettext("Contact");

		if ( is_null($pageName) or trim($pageName) == '' ) :
			MenuUtil::printSecondaryLinkItem('contact-link', getCustomPageURL('contact'), $text, THEME_CONTACT); 
		else: 
			MenuUtil::printSecondaryPageLinkItem('contact-link', $pageName, $text); 
		endif;

	endif;
?>

