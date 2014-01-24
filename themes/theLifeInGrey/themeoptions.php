<?php

/* Plug-in for theme option handling 
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 * 
*/

class ThemeOptions {
	
	function ThemeOptions() {
		setThemeOptionDefault('Allow_search', true);
		setThemeOptionDefault('Allow_images_with_albums', true); 
		setThemeOptionDefault('google_analytics_key', '');
	}
	
	function getOptionsSupported() {
		return array(	
			gettext('Allow search') => array(
				'key' => 'Allow_search',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Check to enable search form.')
			),
			gettext('Allow images with albums') => array(
				'key' => 'Allow_images_with_albums',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Check to enable the display of albums and pictures on the same page.')
			),
			gettext('Google Analytics key') => array(
				'key' => 'google_analytics_key',
				'type' => OPTION_TYPE_TEXTBOX,
				'desc' => gettext('Insert your Google Analytics key if you have one.')
			)
		);
	}

	function handleOption($option, $currentValue) {
	}
}
?>