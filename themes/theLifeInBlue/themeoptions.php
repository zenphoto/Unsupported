<?php

/* Plug-in for theme option handling 
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 * 
*/

class ThemeOptions {
	
	function ThemeOptions() {
		setThemeOptionDefault('Allow_images_with_albums', true);
		setThemeOptionDefault('google_analytics_key', '');
		setThemeOptionDefault('piwik_adress', '');
		setThemeOptionDefault('piwik_number', '');
	}
	
	function getOptionsSupported() {
		return array(
			gettext('Allow images with albums') => array(
				'key' => 'Allow_images_with_albums',
				'type' => OPTION_TYPE_CHECKBOX,
				'desc' => gettext('Check to enable the display of albums and pictures on the same page.')
			),
			gettext('Google Analytics key') => array(
				'key' => 'google_analytics_key',
				'type' => OPTION_TYPE_TEXTBOX,
				'desc' => gettext('Insert your Google Analytics key if you have one.')
			),
			gettext('Piwik server address') => array(
				'key' => 'piwik_adress',
				'type' => OPTION_TYPE_TEXTBOX,
				'desc' => gettext('Insert your piwik server adress (for example: www.piwik.com).')
			),
			gettext('Piwik ID') => array(
				'key' => 'piwik_number',
				'type' => OPTION_TYPE_TEXTBOX,
				'desc' => gettext('Insert your piwik ID for your Zenphoto gallery.')
			)
		);
	}

	function handleOption($option, $currentValue) {
	}
}
?>