<?php
/**
 * Provides an example of the use of the custom data filters
 * 
 * @package plugins
 */
$plugin_is_filter = 5;
$plugin_description = gettext("Example filter for custom data.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.2.9'; 

zp_register_filter('save_image_custom_data', 'custom_data_save_image');
zp_register_filter('edit_image_custom_data', 'custom_data_edit_image');
zp_register_filter('save_album_custom_data', 'custom_data_save_album');
zp_register_filter('edit_album_custom_data', 'custom_data_edit_album');
/* 
 * these are commented out so as not to conflict with the comment_form
 * plugin implementation. They are still valid examples, though.
 * 
zp_register_filter('save_comment_custom_data', 'custom_data_save_comment');
zp_register_filter('edit_comment_custom_data', 'custom_data_edit_comment');
zp_register_filter('save_admin_custom_data', 'custom_data_save_admin');
zp_register_filter('edit_admin_custom_data', 'custom_data_edit_admin');
*/

/**
 * Returns a processed custom data item
 * called when an image is saved on the backend
 *
 * @param string $discard always empty
 * @param int $i prefix for the image being saved
 * @return string
 */
function custom_data_save_image($discard, $i) {
	return sanitize($_POST[$i.'-custom_data'], 1);
}

/**
 * Returns table row(s) for the edit of an image custom data field
 *
 * @param string $discard always empty
 * @param int $currentimage prefix for the image being edited
 * @param object $image the image object
 * @return string
 */
function custom_data_edit_image($discard, $image, $currentimage) {
	return 
		'<tr>
			<td valign="top">'.gettext("Special data:").'</td>
			<td><textarea name="'.$currentimage.'-custom_data" cols="'.TEXTAREA_COLUMNS.'"	rows="6">'.htmlentities($image->get('custom_data'),ENT_COMPAT,getOption("charset")).'</textarea></td>
		</tr>';
}

/**
 * Returns a processed album custom data item
 * called when an album is saved on the backend
 *
 * @param string $discard always empty
 * @param int $prefix the prefix for the album being saved
 * @return string
 */
function custom_data_save_album($discard, $prefix) {
	return sanitize($_POST[$prefix.'x_album_custom_data'], 1);
}

/**
 * Returns table row(s) for the edit of an album custom data field
 *
 * @param string $discard always empty
 * @param int $prefix prefix of the album being edited
 * @param object $album the album object
 * @return string
 */
function custom_data_edit_album($discard, $album, $prefix) {
	return
		'<tr>
			<td align="left" valign="top">'.gettext("Special data:").'</td>
			<td><textarea name="'.$prefix.'x_album_custom_data" cols="'.TEXTAREA_COLUMNS.'"	rows="6">'.htmlentities($album->get('custom_data'),ENT_COMPAT,getOption("charset")).'</textarea></td>
		</tr>';
}

/**
 * Returns a processed comment custom data item
 * Called when a comment edit is saved
 *
 * @param string $discard always empty
 * @return string
 */
function custom_data_save_comment($discard) {
	return sanitize($_POST['comment_custom_data'], 1);
}

/**
 * Returns table row(s) for edit of a comment's custom data
 *
 * @param string $discard always empty
 * @return string
 */
function custom_data_edit_comment($discard, $raw) {
	return
		'<tr>
			<td align="left" valign="top">'.gettext("Extra information:").'</td>
			<td><textarea name="comment_custom_data" cols="60"	rows="6">'.htmlentities($raw,ENT_COMPAT,getOption("charset")).'</textarea></td>
		</tr>';
}

/**
 * Saves admin custom data
 * Called when an admin is saved
 *
 * @param string $discard always empty
 * @param object $userobj admin user object
 * @param string $i prefix for the admin
 * @return string
 */
function custom_data_save_admin($discard, $userobj, $i) {
	$custom = array('street'=>sanitize($_POST[$i.'-admin_custom_street'], 1),
									'city'=>sanitize($_POST[$i.'-admin_custom_city'], 1),
									'state'=>sanitize($_POST[$i.'-admin_custom_state'], 1),
									'country'=>sanitize($_POST[$i.'-admin_custom_country'], 1),
									'postal'=>sanitize($_POST[$i.'-admin_custom_postal'], 1)
									);
	
	$userobj->setCustomData(serialize($custom));
}

/**
 * Returns table row(s) for edit of an admin user's custom data
 *
 * @param string $html always empty
 * @param $userobj Admin user object
 * @param string $i prefix for the admin
 * @param string $background background color for the admin row
 * @param bool $current true if this admin row is the logged in admin
 * @return string
 */
function custom_data_edit_admin($html, $userobj, $i, $background, $current) {
	$raw = $userobj->getCustomData();
	$needs = array('street'=>'', 'city'=>'', 'state'=>'', 'country'=>'', 'postal'=>'');
	if (!preg_match('/^a:[0-9]+:{/', $raw)) {
		$address = $needs;
	} else {
		$address = unserialize($userobj->getCustomData());
		foreach ($needs as $needed=>$value) {
			if (!isset($address[$needed])) {
				$address[$needed] = '';
			}
		}
	}
	
	return $html.
		'<tr'.((!$current)? ' style="display:none;"':'').' class="userextrainfo">
			<td width="20%"'.((!empty($background)) ? 'style="'.$background.'"':'').' valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.gettext("Street:").'</td>
			<td'.((!empty($background)) ? ' style="'.$background.'"':'').' valign="top"><input type="text" name="'.$i.'-admin_custom_street" cols="50"	rows="6" value="'.$address['street'].'"></td>
			<td'.((!empty($background)) ? ' style="'.$background.'"':'').' valign="top" rowspan="5">'.gettext('Address information. (Provided for you by the <code>filter-custom_data</code> <em>admin custom data</em> filters.)').'</td>
		</tr>'.
		'<tr'.((!$current)? ' style="display:none;"':'').' class="userextrainfo">
			<td width="20%"'.((!empty($background)) ? 'style="'.$background.'"':'').' valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.gettext("City:").'</td>
			<td'.((!empty($background)) ? ' style="'.$background.'"':'').' valign="top"><input type="text" name="'.$i.'-admin_custom_city" cols="50"	rows="6" value="'.$address['city'].'"></td>
		</tr>'.
		'<tr'.((!$current)? ' style="display:none;"':'').' class="userextrainfo">
			<td width="20%"'.((!empty($background)) ? 'style="'.$background.'"':'').' valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.gettext("State:").'</td>
			<td'.((!empty($background)) ? ' style="'.$background.'"':'').' valign="top"><input type="text" name="'.$i.'-admin_custom_state" cols="50"	rows="6" value="'.$address['state'].'"></td>
		</tr>'.
		'<tr'.((!$current)? ' style="display:none;"':'').' class="userextrainfo">
			<td width="20%"'.((!empty($background)) ? 'style="'.$background.'"':'').' valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.gettext("Country:").'</td>
			<td'.((!empty($background)) ? ' style="'.$background.'"':'').' valign="top"><input type="text" name="'.$i.'-admin_custom_country" cols="50"	rows="6" value="'.$address['country'].'"></td>
		</tr>'.
		'<tr'.((!$current)? ' style="display:none;"':'').' class="userextrainfo">
			<td width="20%"'.((!empty($background)) ? 'style="'.$background.'"':'').' valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.gettext("Postal code:").'</td>
			<td'.((!empty($background)) ? ' style="'.$background.'"':'').' valign="top"><input type="text" name="'.$i.'-admin_custom_postal" cols="50"	rows="6" value="'.$address['postal'].'"></td>
		</tr>';
}

?>