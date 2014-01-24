<?php

require_once(SERVERPATH . "/" . ZENFOLDER . "/admin-functions.php");

class ThemeOptions {
	function ThemeOptions() {
		setOptionDefault('simplicity3_header_scroll', 'banner');
		setOptionDefault('simplicity3_main_text', 'MAIN TEXT HEADER. SET IT IN THEME OPTION PAGE.');
		setOptionDefault('simplicity3_search_text', 'SEARCH TEXT HEADER. SET IT IN THEME OPTION PAGE.');
		setOptionDefault('simplicity3_contact_text', 'CONTACT TEXT HEADER. SET IT IN THEME OPTION PAGE.');
		setOptionDefault('simplicity3_use_fancybox', TRUE);
	}
		
	function getOptionsSupported() {
		return array(
			"Index about text" => array(
				'key' => 'simplicity3_main_text',
				'type' => OPTION_TYPE_TEXTAREA,
				'desc' => gettext('The header text that will appear on the index page.')),
			"Search text" => array(
				'key' => 'simplicity3_search_text',
				'type' => OPTION_TYPE_TEXTAREA,
				'desc' => gettext('The header text that will appear on the search page.')),
			"Contact text" => array(
				'key' => 'simplicity3_contact_text',
				'type' => OPTION_TYPE_TEXTAREA,
				'desc' => gettext('The header text that will appear on the contact page.')),
			"Use fancybox" => array(
				'key' => 'simplicity3_use_fancybox',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Whether to enable fancybox. If full view access if not allowed for a given image, fancybox won\'t be ' . 
								  'setup for that particular image (see Image \'Full image protection\' option).')),
			"Header scroll" => array(
				'key' => 'simplicity3_header_scroll',
				'type' => OPTION_TYPE_CUSTOM,
				'desc' => gettext('Set header attachment. Valid values: <ul style="margin-left: 20px;">' . 
					'<li><em>fixed</em>: header won\'t scroll</li>' . 
					'<li><em>banner</em>: only the banner (and menus) will scroll</li>' . 
					'<li><em>scroll</em>: the whole header (full width) will scroll</li></ul>'))
		);
	}

	function handleOption($option, $currentValue) {
		switch ($option) {
			case 'simplicity3_header_scroll':
				echo '<select id="themeselect" name="' . $option . '"' . ">\n";
				generateListFromArray(array($currentValue), array("fixed"=>"fixed", "banner"=>"banner", "scroll"=>"scroll"), false, true);
				echo "</select>\n";
				break;
		}
	}
}

?>
