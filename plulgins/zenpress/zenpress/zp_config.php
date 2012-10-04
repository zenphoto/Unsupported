<?php
/**
 * Copyright 2006/2007  Alessandro Morandi  (email : webmaster@simbul.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
 
require_once('./admin.php');
load_plugin_textdomain('zenpress','wp-content/plugins/zenpress/locale');

?>
<script type="text/javascript">
	/**
	 * Build the absolute path for the ZenPhoto admin directory
	 */
	function buildPath(obj) {
		absPath = '<?php echo ABSPATH; ?>';
		siteUrl = '<?php echo get_settings('siteurl'); ?>';
		adm = document.getElementById('zp_admin_path');

		// Strip slashes at the end of the string
		absPath = absPath.replace(/[\\\/]+$/g,'');
		siteUrl = siteUrl.replace(/[\\\/]+$/g,'');
		// Use unix-like slashes
		absPath = absPath.replace(/\\/g,'/');
		
		var absPathArray = absPath.split('/');
		var siteUrlArray = siteUrl.split('/');
		var j=0;

		while (Math.min(siteUrlArray.length,absPathArray.length)>0) {
			tmp1 = siteUrlArray.pop();
			tmp2 = absPathArray.pop();
			if (tmp1 != tmp2) {
				siteUrlArray.push(tmp1);
				absPathArray.push(tmp2);
				break;
			}
		}
		basePath = absPathArray.join('/');
		baseUrl = siteUrlArray.join('/');

		adm.value = obj.value.replace(baseUrl,basePath)+"/zen";
	}
</script>
<?php
	if (isset($_POST['info_update'])) {
		if (!is_dir($_POST['zp_admin_path'])) {
			// Admin path is wrong -> error
			echo '<div id="message" class="error"><p><strong>';
			_e('The admin path you entered does not exist on the filesystem!', 'zenpress');
			echo '</strong></p></div>';
		} else {
			// Set path values
			update_option('zp_admin_path', $_POST['zp_admin_path']);
			update_option('zp_web_path', $_POST['zp_web_path']);

			// Set custom popup values
			update_option('zenpress_custom_what', $_POST['zenpress_custom_what']);
			update_option('zenpress_custom_link', $_POST['zenpress_custom_link']);
			update_option('zenpress_custom_close', $_POST['zenpress_custom_close']);
			update_option('zenpress_custom_show', $_POST['zenpress_custom_show']);
			update_option('zenpress_custom_orderby', $_POST['zenpress_custom_orderby']);
			update_option('zenpress_custom_wrap', $_POST['zenpress_custom_wrap']);
			update_option('zenpress_custom_size', $_POST['zenpress_custom_size']);
			update_option('zenpress_custom_width', $_POST['zenpress_custom_width']);
			update_option('zenpress_custom_height', $_POST['zenpress_custom_height']);
			
			echo '<div id="message" class="updated fade"><p><strong>';
			_e('ZenPress options updated successfully.', 'zenpress');
			echo '</strong></p></div>';
		}
	}
?>
<div class="wrap">
<h2><?php _e('ZenPress Configuration','zenpress') ?></h2>

<form method="post" action="">

 <p class="submit">
  <input type="submit" name="info_update" value="<?php _e('Update Options','zenpress') ?> &raquo;" />
 </p>

 <fieldset class="options" name="paths">
  <p><?php _e('Both paths are required. The <b>base path</b> is an URL, with its "http://" and whatnot. The <b>admin path</b> is a <i>filesystem path</i>.','zenpress') ?></p>
  <?php if (get_settings('siteurl')!="" && ABSPATH!="") { ?>
   <p><?php printf(__('For example, the URL for your current WordPress environment is <i>%s</i>, while the filesystem path is <i>%s</i>. The Zenphoto paths will have a similar structure.','zenpress'),get_settings('siteurl'),ABSPATH) ?></p>  
  <?php } ?>
  <p><?php _e('ZenPress will try to guess the admin path from the base path, but this may not work for all the configurations. If it does not work, you will have to enter the path manually.','zenpress') ?></p>

  <table class="optiontable"> 
   <tr valign="top"> 
    <th scope="row"><?php _e('Zenphoto base path:','zenpress') ?></th> 
    <td>
     <input name="zp_web_path" type="text" id="zp_web_path" value="<?php form_option('zp_web_path'); ?>" size="40" onKeyUp="buildPath(this);return false;"/>
     <br />
     <?php _e('For example: http://www.example.com/gallery','zenpress') ?>
    </td> 
   </tr> 
   <tr valign="top"> 
    <th scope="row"><?php _e('Zenphoto admin path:','zenpress') ?></th> 
    <td>
     <input name="zp_admin_path" type="text" id="zp_admin_path" value="<?php form_option('zp_admin_path'); ?>" size="40" />
     <br />
     <?php _e('For example: /var/www/example.com/gallery/zen','zenpress') ?>
    </td> 
   </tr> 
  </table>
 </fieldset>

 <fieldset class="options" name="options">
  <legend><?php _e('Custom popup options') ?></legend>
  <p><?php _e('These options will override the defaults for the popup window, in order to avoid repetitive menu selections. They are not mandatory (ZenPress will fallback on the default ones).','zenpress') ?></p>
  <table class="optiontable"> 
   <tr valign="top"> 
    <th scope="row"><?php _e('What do you want to include?','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('value' => 'thumb','title' => __('Image Thumbnail','zenpress')),
						array('value' => 'title','title' => __('Image Title','zenpress')),
						array('value' => 'album','title' => __('Album Name','zenpress')),
						array('value' => 'custom','title' => __('Custom Text','zenpress')));
	 zp_printFormSelect('zenpress_custom_what',$options,get_option('zenpress_custom_what'));
	 ?>
    </td> 
   </tr> 
   <tr valign="top"> 
	<th scope="row"><?php _e('Do you want to link it?','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('value' => 'image','title' => __('Link to Image','zenpress')),
						array('value' => 'album','title' => __('Link to Album','zenpress')),
						array('value' => 'none','title' => __('No Link','zenpress')),
						array('value' => 'custom','title' => __('Custom URL','zenpress')));
	 zp_printFormSelect('zenpress_custom_link',$options,get_option('zenpress_custom_link'));
	 ?>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Do you want to close the popup window?','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('value' => 'true','title' => __('Close after inserting','zenpress')),
						array('value' => 'false','title' => __('Keep open','zenpress')));
	 zp_printFormSelect('zenpress_custom_close',$options,get_option('zenpress_custom_close'));
	 ?>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Images to show in a popup page','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('title' => 10, 'value' => 10),
						array('title' => 15, 'value' => 15),
						array('title' => 20, 'value' => 20),
						array('title' => 30, 'value' => 30),
						array('title' => 50, 'value' => 50)); 
	 zp_printFormSelect('zenpress_custom_show',$options,get_option('zenpress_custom_show'));
	 ?>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Order images by','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('title' => __('Sort Order','zenpress'), 'value' => 'sort_order'),
	 					array('title' => __('Title','zenpress'), 'value' => 'title'),
						array('title' => __('ID','zenpress'), 'value' => 'id')); 
	 zp_printFormSelect('zenpress_custom_orderby',$options,get_option('zenpress_custom_orderby'));
	 ?>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Text Wrap','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('value' => 'none','title' => __('No wrap','zenpress')),
						array('value' => 'left','title' => __('Right','zenpress')),
						array('value' => 'right','title' => __('Left','zenpress')));
	 zp_printFormSelect('zenpress_custom_wrap',$options,get_option('zenpress_custom_wrap'));
	 ?>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Image Size','zenpress') ?></th> 
    <td>
	 <?php
	 $options = array(	array('value' => 'default','title' => __('Default size (thumbnail)','zenpress')),
						array('value' => 'full','title' => __('Full size','zenpress')),
						array('value' => 'custom','title' => __('Custom size','zenpress')));
	 zp_printFormSelect('zenpress_custom_size',$options,get_option('zenpress_custom_size'));
	 ?>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Custom size:','zenpress') ?> <?php _e('Width (px)','zenpress') ?></th> 
    <td>
     <input name="zenpress_custom_width" type="text" id="zp_custom_width" value="<?php form_option('zenpress_custom_width'); ?>" size="5"/>
    </td> 
   </tr>
   <tr valign="top"> 
	<th scope="row"><?php _e('Custom size:','zenpress') ?> <?php _e('Height (px)','zenpress') ?></th> 
    <td>
     <input name="zenpress_custom_height" type="text" id="zp_custom_height" value="<?php form_option('zenpress_custom_height'); ?>" size="5"/>
    </td> 
   </tr>  
  </table>
 </fieldset> 
 <p class="submit">
  <input type="submit" name="info_update" value="<?php _e('Update Options','zenpress') ?> &raquo;" />
 </p>
</form>

</div>

<?php

/**
 * Print a <select> HTML element.
 * @param $name	Name of the element
 * @param $options	Array of select options. Each option is an array of name and value
 * @param $selected	Value of the selected option (if any)
 */
function zp_printFormSelect($name,$options,$selected=NULL) {
	echo '<select name="'.$name.'">';
	foreach ($options as $value) {
		$value[value]==$selected ? $sel=' selected="selected"' : $sel = '';
		echo '<option value="'.$value[value].'"'.$sel.'>'.$value[title].'</option>';
	}
	echo '</select>';
}

?>
