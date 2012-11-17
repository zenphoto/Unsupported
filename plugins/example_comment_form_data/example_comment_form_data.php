<?php
/**
 * An example of the <var>comment_form_defaults</var> filter
 * @package plugins
 * @subpackage demo
 */

$plugin_description = gettext('An example of setting defaults for comment form data.');
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.3';

zp_register_filter('comment_form_data','example_comment_form_defaults');

/**
 * Adds default values to comment form data
 *
 * NOTE: the indices available are:
 * 	'name'
 * 	'website'
 * 	'anon'
 * 	'street'
 * 	'city'
 * 	'state'
 * 	'country'
 * 	'postal'
 * 	'private'
 *
 * @param array $defaults
 */
function example_comment_form_defaults($defaults) {

	// set the web field to the browser IP if it is not otherwise set.
	if (empty($defaults['data']['website'])) $defaults['data']['website'] = 'http://'.getUserIP();

	// disable the anonymous and private checkboxes (could also reset the options, but this is an example after all!)
	$defaults['data']['anon'] = 0;
	$defaults['disabled']['anon'] = ' disabled="disabled"';
	$defaults['data']['private'] = 0;
	$defaults['disabled']['private'] = ' disabled="disabled"';
	return $defaults;
}
?>