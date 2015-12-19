<?php
/**
 * Zenphoto plugin to utilize Disqus comments
 * You must register an account on Disqus and enter your shortname into the plugin settings.
 * You can choose what objects to allow commenting on in the plugin options (albums, images, news).
 *
 * @author gjr (oswebcreations.com), v1.4.5
 * @package plugins
 * @subpackage misc
 */
 
$plugin_is_filter = 6|THEME_PLUGIN;
$plugin_description = gettext('Zenphoto plugin to utilize Disqus comments.');
$plugin_author = 'oswebcreations (gjr)';
$plugin_disable = (getOption('zp_plugin_comment_form')) ? gettext('Only one commenting plugin can be activated at a time, please disable the core commenting plugin to use the disqus plugin.') : false; 
if ($plugin_disable) {
	setOption('zp_plugin_zpdisqus',0);
} else {
	$option_interface = 'zpdisqus';
}

class zpdisqus {

	function comment_form() {
		setOptionDefault('zpdisqus_shortname', '');
	}

	function getOptionsSupported() {
		$checkboxes = array(gettext('Albums') => 'disqus_comment_form_albums', gettext('Images') => 'disqus_comment_form_images');
		if (getOption('zp_plugin_zenpage')) {
			$checkboxes = array_merge($checkboxes, array(gettext('Pages') => 'disqus_comment_form_pages', gettext('News') => 'disqus_comment_form_articles'));
		}
		$options = array(
			gettext('Disqus Short Name') => array(
				'key' => 'zpdisqus_shortname', 
				'type' => OPTION_TYPE_TEXTBOX,
				'order' => 0,
				'desc' => gettext('Enter your Disqus account short name here.')),
			gettext('Allow Disqus comments on') => array(
				'key' => 'disqus_comment_form_allowed', 
				'type' => OPTION_TYPE_CHECKBOX_ARRAY,
				'order' => 1,
				'checkboxes' => $checkboxes,
				'desc' => gettext('Comment forms will be presented on the checked page types.<div class="notebox">Note: Toggling comments on/off is also controlled on each individual image/album/article admin page.  Also, theme must have the appropriate comment form function call on each page type as well.</div>')),
			);
		return $options;
	}

	function handleOption($option, $currentValue) {
	}
}

	function printCommentForm() { 
		global $_zp_gallery_page,$_zp_current_image,$_zp_current_album,$_zp_current_zenpage_news,$_zp_current_zenpage_page;
		$zpdisqus_shortname = getOption('zpdisqus_shortname');
		switch ($_zp_gallery_page) {
			case 'image.php':
				if (!getOption('disqus_comment_form_images')) return;
				$comments_open = OpenedForComments(IMAGE);
				$zpdisqus_id = 'image'.$_zp_current_image->getID();
				$zpdisqus_title = $_zp_current_image->getTitle();
				break;
			case 'album.php':
				if (!getOption('disqus_comment_form_albums')) return;
				$comments_open = OpenedForComments(ALBUM);
				$zpdisqus_id = 'album'.$_zp_current_album->getID();
				$zpdisqus_title = $_zp_current_album->getTitle();
				break;
			case 'news.php':
				if (!getOption('disqus_comment_form_articles')) return;
				$comments_open = zenpageOpenedForComments();
				$zpdisqus_id = 'news'.getNewsID();
				$zpdisqus_title = $_zp_current_zenpage_news->getTitle();
				break;
			case 'page.php':
				if (!getOption('disqus_comment_form_pages')) return;
				$comments_open = zenpageOpenedForComments();
				$zpdisqus_id = 'page'.getPageID;
				$zpdisqus_title = $_zp_current_zenpage_page->getTitle();
				break;
		}	
		if (($zpdisqus_shortname != '') && ($comments_open)) { ?>
		
		<div id="disqus_thread"></div>
		<script type="text/javascript">
			var disqus_shortname = '<?php echo $zpdisqus_shortname; ?>';
			var disqus_identifier = '<?php echo $zpdisqus_id; ?>';
			var disqus_title = '<?php echo $zpdisqus_title; ?>';
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
		<?php }
	}
	
	function printLatestDisqus($zpdisqus_count=5,$zpdisqus_length=200) { 
		$zpdisqus_shortname = getOption('zpdisqus_shortname');
		?>
		<div id="recentcomments" class="dsq-widget">
			<script type="text/javascript" src="http://<?php echo $zpdisqus_shortname; ?>.disqus.com/recent_comments_widget.js?num_items=<?php echo $zpdisqus_count; ?>&hide_avatars=0&avatar_size=32&excerpt_length=<?php echo $zpdisqus_length; ?>"></script>
		</div>
	<?php }
	
?>