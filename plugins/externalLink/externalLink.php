<?php

/**
 * Provides extensions to the image utilities to crop images.
 *
 * Adds fields to the image utilities that will let you specify an image size and will
 * provide a link to the image in that size that you can use outside of your Zenphoto
 * gallery.
 *
 * @author Stephen Billard (sbillard)
 * @package plugins
 * @subpackage media
 */
$plugin_is_filter = 5 | ADMIN_PLUGIN;
$plugin_description = gettext("Adds a copyable link in the image utilities box that can show the image outside of your gallery.");
$plugin_author = "Stephen Billard (sbillard)";

zp_register_filter('edit_image_utilities', 'externalLinkBox');
zp_register_filter('save_image_utilities_data', 'externalLinkBoxSave');

function externalLinkBox($prior, $image, $prefix, $subpage, $tagsort) {
	if ($prior) {
		$prior .= '<br /><hr>';
	}
	if (isset($_SESSION['externalLinksize_' . $prefix])) {
		$size = sanitize_numeric($_SESSION['externalLinksize_' . $prefix]);
		unset($_SESSION['externalLinksize_' . $prefix]);
	} else {
		$size = false;
	}
	$output = $img = '';
	if ($size) {
		$link = $image->getCustomImage($size, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
		$img = ' <img src="' . html_encode(pathurlencode($link)) . '" height="15" width="15" />';
		$output .= '<input type="text" style="width:100%" value="' . html_encode($link) . '" />';
	}
	$output .= gettext('link for image of size:') . ' <input type="text" name="externalLinksize_' . $prefix . '" size="3" value="' . $size . '" />' . $img;

	return $prior . $output;
}

function externalLinkBoxSave($object, $prefix) {
	if (isset($_POST['externalLinksize_' . $prefix])) {
		$_SESSION['externalLinksize_' . $prefix] = $_POST['externalLinksize_' . $prefix];
	}
	return $object;
}

?>