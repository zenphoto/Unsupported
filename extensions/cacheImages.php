<?php
/**
 * Pre-caching is not considered necessary as Zenphoto will cache the images on the first display.
 * This plugin is not recommended nor supported but is provided for those of you who simply insist
 * on pre-caching.
 *
 * Note: The pre-caching process will cause your browser to display each and every image that has not
 * been previously cached. If your server does not do a good job of thread management this may swamp
 * your server!
 *
 * This plugin will examine the gallery and make image references to any images which have not
 * already been cached. NOTE: as coded the image and thumb caches are based on the gallery theme
 * default thumbnail and image sizes, etc. Should the theme use custom sized images or thumbs
 * caching these default sizes will be pointless. You should modify the plugin to produce your
 * customized sizes in this case.
 *
 */
$plugin_is_filter = 5|ADMIN_PLUGIN;
$plugin_description = gettext("Caches newly uploaded images.").' <p class="notebox">'.gettext('<strong>NOTE</strong>: as coded the image and thumb caches are based on the gallery theme default thumbnail and image sizes, etc.').'</p>';
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.1';

zp_register_filter('admin_utilities_buttons', 'cache_images::overviewbutton');
zp_register_filter('edit_album_utilities', 'cache_images::albumbutton');

class cache_images {
	static function overviewbutton($buttons) {
		$buttons[] = array(
									'category'=>gettext('deprecated'),
									'enable'=>true,
									'button_text'=>gettext('Pre-Cache Images'),
									'formname'=>'cache_images_button',
									'action'=>WEBPATH.'/plugins/cacheImages/cacheImages.php',
									'icon'=>'images/cache1.png',
									'alt'=>'',
									'hidden'=>'',
									'rights'=>ADMIN_RIGHTS,
									'XSRFTag'=>'cache_images',
									'title'=>gettext('Finds newly uploaded images that have not been cached and creates the cached version. It also refreshes the numbers above. If you have a large number of images in your gallery you might consider using the pre-cache image link for each album to avoid swamping your browser.')
		);
		return $buttons;
	}
	static function albumbutton($html, $object, $prefix) {
		if ($html) $html .= '<hr />';
		$html .= '<p class="buttons"><a href="'.WEBPATH.'/'.USER_PLUGIN_FOLDER.'/cacheImages/cacheImages.php?album='.html_encode($object->name).'&amp;XSRFToken='.getXSRFToken('cache_images').'"><img src="images/cache1.png" />'.gettext('Pre-Cache Images').'</a><br clear="all" /></p>';
		return $html;

	}
}
?>