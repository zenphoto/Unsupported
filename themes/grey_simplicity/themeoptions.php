<?php

/* Plug-in for theme option handling 
 * The Options page of admin.php tests for the presence of this file in a theme folder
 * If it is present admin.php links to it with a require_once call.
 * If it is not present, no theme options are displayed.
 * 
 * Interface functions:
 *     getOptionsSupported()
 *        returns an array of the option names the theme supports
 *        the array is indexed by the option name. The value for each option
 *          a value of 0 says for admin to use standard processing for the option
 *          a value of 1 will cause admin to call handleThemeOption to generate the HTML for the option
 *             
 *     handleThemeOption($option, $currentValue)
 *       $option is the name of the option being processed
 *       $currentValue is the "before" value of the option
 *
 *       this function is called by admin from within the table row/column where the option field is placed
 *       It must write the HTML that does the option handling UI
 *
 *       the version below provides a dropdown list of all the CSS files in the theme folder. It is used by themes
 *       which support selectable CSS files for different color schemes.
 */

require_once(SERVERPATH . "/" . ZENFOLDER . "/admin-functions.php");

class ThemeOptions {

 
  function ThemeOptions() {
  	setThemeOption('thumb_size', 120, NULL, 'grey-simplicity');
  	setThemeOptionDefault('highslide', 1);
  }
  
  function getOptionsDisabled() {
		return array('thumb_size');
	}
	
  function getOptionsSupported() {
		return array(gettext('Highslide')	 => array('key' => 'highslide', 'type' => OPTION_TYPE_CHECKBOX, 'desc' => gettext('Check to enable the Highslide script.'))
		);
	}

  function handleOption($option, $currentValue) {
 
  }
}
?>
