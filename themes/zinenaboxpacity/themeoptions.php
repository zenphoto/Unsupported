<?php

require_once(SERVERPATH . "/" . ZENFOLDER . "/admin-functions.php");
require_once(dirname(__FILE__) . '/Properties.php');

class ThemeOptions {
	function ThemeOptions() {
		setOptionDefault('simplicity2_extra_text', '&copy; All rights reserved');
		setOptionDefault('simplicity2_print_home_menu_item', true);
		setOptionDefault('simplicity2_print_contact_menu_item', true);
		setOptionDefault('simplicity2_contact_page_name', 'Contact');
		setOptionDefault('simplicity2_main_page_text', 'Main page text - you can modify it on the theme options page.');
		setOptionDefault('simplicity2_no_album_description_text', 'Empty album description - you can modify it on the theme options page');
		setOptionDefault('simplicity2_allow_search', true);
		setOptionDefault('simplicity2_enable_mousewheel', true);
		setOptionDefault('simplicity2_mousewheel_image', false);
		setOptionDefault('simplicity2_enable_key_nav', false);
		setOptionDefault('simplicity2_gallery_subtitle', 'Gallery subtitle - you can modify it on the theme options page');
		setOptionDefault('simplicity2_contact_page_description', 'Use this form to send us a message of love or hate.');
		setOptionDefault('simplicity2_printcollage', true);
		setOptionDefault('simplicity2_contextual_search', true);
		setOptionDefault('simplicity2_enable_archive', true);
		setOptionDefault('simplicity2_contact_is_secondary', true);
        setOptionDefault('simplicity2_contact_is_modal', true);
		setOptionDefault('simplicity2_rate_images', true);
		setOptionDefault('simplicity2_collage_title', 'Collage');
		setOptionDefault('simplicity2_error_404_title', 'Where is my box?');
		setOptionDefault('simplicity2_error_404_message', 'The requested resource was not found, and most probably never will.');
		setOptionDefault('simplicity2_error_403_title', 'Keep out!');
		setOptionDefault('simplicity2_error_403_message', 'You are not allowed to access the requested resource.');
		setOptionDefault('simplicity2_error_500_title', 'Crash test');
		setOptionDefault('simplicity2_error_500_message', 'A serious error was encountered while processing your request.');
		setOptionDefault('simplicity2_use_page_loader', false);
		setOptionDefault('simplicity2_enable_cf', false);
		setOptionDefault('simplicity2_print_gallery_title', true);
		setOptionDefault('simplicity2_no_js_text', 'Javascript is required to view this site');
		setOptionDefault('simplicity2_personality', '');
		setOptionDefault('simplicity2_page_loader_message', 'Loading...');
		setOptionDefault('simplicity2_enable_persona_chooser', false);
		setOptionDefault('simplicity2_print_theme_id', true);
		setOptionDefault('simplicity2_enable_fancybox', false);
		setOptionDefault('simplicity2_home_images_number', 3);
		setOptionDefault('simplicity2_home_news_number', 2);
		setOptionDefault('simplicity2_print_album_list', true);
		setOptionDefault('simplicity2_nav_enable_updown', false);
	}
		
	function getOptionsSupported() {
		return array(
			"[Navigation] Mousewheel navigates image" => array(
				'key' => 'simplicity2_mousewheel_image',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Used on album page. If true, images can be navigated with the mousewheel, ' . 
								  'otherwise the mousewheel allows to jump to the previous and next pages. ' . 
   								  'Only used if "Enable mousewheel is true.')),
			"[Navigation] Enable up/down keys" => array(
				'key' => 'simplicity2_nav_enable_updown',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Experimental. Used on album page: if true, up/down arrows switch to prev/next page respectively.')),
			"[Gallery] Print album list" => array(
				'key' => 'simplicity2_print_album_list',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Whether to print top album select list (by default, in the upper right corner)')),
			"[Home] About text" => array(
				'key' => 'simplicity2_home_about_text', 
				'type' => OPTION_TYPE_TEXTAREA, 
				'multilingual' => 1,
				'desc' => gettext('The presentation text that appears on the left side on the Home page.')),
			"[Home] Number of latest images" => array(
				'key' => 'simplicity2_home_images_number', 
				'type' => OPTION_TYPE_TEXTBOX, 
				'desc' => gettext('Limit the number of latest images displayed on the home page (default: 3).')),
			"[Home] Number of latest news" => array(
				'key' => 'simplicity2_home_news_number', 
				'type' => OPTION_TYPE_TEXTBOX, 
				'desc' => gettext('Limit the number of latest news displayed on the home page (default: 2).')),
			"[Gallery] Enable Fancybox" => array(
				'key' => 'simplicity2_enable_fancybox', 
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('If true clicking on an image preview (not thumbnail) will open the full size image.')),
			"[Main] Extra text" => array(
				'key' => 'simplicity2_extra_text', 
				'type' => OPTION_TYPE_TEXTBOX, 
				'multilingual' => 1,
				'desc' => gettext('The extra text that appears bottom right.')),
			"[Menu] Print home link" => array(
				'key' => 'simplicity2_print_home_menu_item', 
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Wether to include a link to the main page in the main menubar. If false the main title will link to the main page.')),
			"[Menu] Print contact link" => array(
				'key' => 'simplicity2_print_contact_menu_item', 
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Wether to include a link to the contact page in the main menubar.')),
			"[Contact] Contact page name" => array(
				'key' => 'simplicity2_contact_page_name', 
				'type' => OPTION_TYPE_TEXTBOX, 
				'desc' => gettext('The contact zenpage page name. If empty, the theme default contact page will ' . 
								  'be used instead. Only used if "Print contact link" is true.')),
			'[Contact] Contact page description' => array(
				'key' => 'simplicity2_contact_page_description',
				'multilingual' => 1,
				'type' => OPTION_TYPE_TEXTAREA, 
				'desc' => gettext('The contact page description that will appear on the left side. ' . 
 						  		  'Only used if "Print contact link" is true and "Contact page name" is not specified.')),
            '[Contact] Contact is modal' => array(
				'key' => 'simplicity2_contact_is_modal',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('If true, contact page won\'t be used. Instead the contact form will be presented to the ' .
		                          'the user through a modal dialog. In that case, all options related to the contact page (name, description, ' . 
		                          'etc.) won\'t be used.')),
			"[Main] Main page text" => array(
				'key' => 'simplicity2_main_page_text', 
				'type' => OPTION_TYPE_TEXTAREA, 
				'multilingual' => 1,
				'desc' => gettext('The text that appears on the main page.')),
			'[Gallery] Empty album description' => array(
				'key' => 'simplicity2_no_album_description_text',
				'type' => OPTION_TYPE_TEXTAREA, 
				'multilingual' => 1,
				'desc' => gettext('The text to display if an album has no attached description.')),
			'[Search] Allow search' => array(
				'key' => 'simplicity2_allow_search',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Enable search feature.')),
			'[Navigation] Enable mousewheel navigation' => array(
				'key' => 'simplicity2_enable_mousewheel',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Enable mousewheel thumbnail navigation.')),
			'[Navigation] Enable key navigation' => array(
				'key' => 'simplicity2_enable_key_nav',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Enable thumbnail key navigation.')),
			'[Main] Gallery subtitle' => array(
				'key' => 'simplicity2_gallery_subtitle', 
				'type' => OPTION_TYPE_TEXTBOX, 
				'multilingual' => 1,
				'desc' => gettext('A text that will be displayed below the "powered by" credit line.')),
			'[Gallery] Print collage' => array(
				'key' => 'simplicity2_printcollage', 
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Wether or not to print image collage for gallery and album containing subalbums.')),
			'[Search] Contextual search' => array(
				'key' => 'simplicity2_contextual_search',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('If in album context, Wether to restrict the search to the current album.')),
			'[Menu] Print archive link' => array(
				'key' => 'simplicity2_enable_archive',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Add a link to the archive page in the secondary menu.')),
			'[Menu] Print contact as secondary link' => array(
				'key' => 'simplicity2_contact_is_secondary',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('If true contact link will in the secondary links area (upper top). Only used if "Print contact link" is true.')),
			'[Plugins] Image rating' => array(
				'key' => 'simplicity2_rate_images',
				'type' => OPTION_TYPE_CHECKBOX, 
				'desc' => gettext('Allow image rating. Please note that right now rating is only supported for image.')),
			'[Gallery] Collage title' => array(
				'key' => 'simplicity2_collage_title',
				'type' => OPTION_TYPE_TEXTBOX, 
				'multilingual' => 1,
				'desc' => gettext('The collage title that appears on album container pages.')),
			'[Error pages] 404 Error page title' => array(
				'key' => 'simplicity2_error_404_title',
				'type' => OPTION_TYPE_TEXTBOX, 
				'multilingual' => 1,
				'desc' => gettext('The title that appears on the error 404 page.')),
			'[Error pages] 403 Error page title' => array(
				'key' => 'simplicity2_error_403_title',
				'multilingual' => 1,
				'type' => OPTION_TYPE_TEXTBOX, 
				'desc' => gettext('The title that appears on the error 403 page.')),
			'[Error pages] 500 Error page title' => array(
				'key' => 'simplicity2_error_500_title',
				'type' => OPTION_TYPE_TEXTBOX, 
				'multilingual' => 1,
				'desc' => gettext('The title that appears on the error 500 page.')),
			'[Error pages] 404 Error page message' => array(
				'key' => 'simplicity2_error_404_message',
				'type' => OPTION_TYPE_TEXTAREA, 
				'multilingual' => 1,
				'desc' => gettext('The message that appears on the error 404 page.')),
			'[Error pages] 403 Error page message' => array(
				'key' => 'simplicity2_error_403_message',
				'type' => OPTION_TYPE_TEXTAREA, 
				'multilingual' => 1,
				'desc' => gettext('The message that appears on the error 403 page.')),
			'[Error pages] 500 Error page message' => array(
				'key' => 'simplicity2_error_500_message',
				'type' => OPTION_TYPE_TEXTAREA, 
				'multilingual' => 1,
				'desc' => gettext('The message that appears on the error 500 page.')),
			'[Personality] Default personality' => array(
				'key' => 'simplicity2_personality',
				'type' => OPTION_TYPE_CUSTOM,
				'desc' => gettext('The personality to apply. \'Random\' is a virtual personality that will pick a concrete one randomly.')),
			'[Personality] Enable personality switch' => array(
				'key' => 'simplicity2_enable_persona_chooser',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('If true, the user can choose a personality from the ones installed. The chosen personality is then stored in a ' . 
								  'cookie that will only expire 10 year later')),
			'[Platform] Enable chrome frame' => array(
				'key' => 'simplicity2_enable_cf',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Wether to add a chrome frame directive. Note that no install check is made. ' . 
                                  'Chrome frame will be used if already installed, otherwise the directive will just be ignored.')), 
			'[Header] Print gallery title' => array(
				'key' => 'simplicity2_print_gallery_title',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('If true, the gallery title will appear in the header. Set it to false if you want the banner image to show the title. ' .
								  'Please note that banner is inserted through css, thus, if false, no home link will be added (see "Print home link" option)')),
			'[Loading] Use page loading mask' => array(
				'key' => 'simplicity2_use_page_loader',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Wether to use a page-loading mask to ensure every correctly laid out before showing anything to the user.')),
			'[Loading] No javascript text' => array(
				'key' => 'simplicity2_no_js_text',
				'type' => OPTION_TYPE_TEXTBOX,
				'multilingual' => 1,
				'desc' => gettext('The warning message that is delivered to the user if javascript is not activated on the client side.')),
			'[Loading] Page loader message' => array(
				'key' => 'simplicity2_page_loader_message',
				'type' => OPTION_TYPE_TEXTAREA,
				'multilingual' => 1,
				'desc' => gettext('The message that is displayed while the page loads/layouts')),
			'[Header] Print theme ID' => array(
				'key' => 'simplicity2_print_theme_id',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Print the theme name in the header'))

		);
	}

	function handleOption($option, $currentValue) {
		switch ($option) {
			case 'simplicity2_personality':
				$theme = basename(dirname(__FILE__));
				$themeroot = SERVERPATH . "/themes/$theme/personality";
				$folders = $this->getFolderList($themeroot);
				echo '<select id="themeselect" name="' . $option . '"' . ">\n";
				echo "<option value=''>&nbsp;</option>";
				echo "<option value='__random__'>Random</option>";
				generateListFromArray(array($currentValue), $folders, false, true);
				echo "</select>\n";
				break;
		}
	}

	function getFolderList($root) {
		$curdir = getcwd();
		chdir($root);
		$filelist = safe_glob('*');
		$list = array();
		foreach($filelist as $file) {
			if ( is_dir($file) && $file != '.' && $file != '..' ) {
				$internal = filesystemToInternal($file);
				if ( !file_exists("$root/$file/persona.properties") ) continue;
				$props = new Properties();
				$props->load(file_get_contents("$root/$file/persona.properties"));
				$name = $props->getProperty('name');
				if ( !isset($name) ) continue;
				$list[$name] = $internal;
			}
		}
		chdir($curdir);

		return $list;
	}
}
?>
