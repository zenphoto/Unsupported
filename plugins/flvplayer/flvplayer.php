<?php
/**
 * flvplayer -- plugin support for the flvplayer flash video player v4.5.
 *
 * Note: 1.1 now incorporates the former separate flv_playlist plugin to show the content of an media album with .flv/.mp4/.mp3 movie/audio files as a playlist or as separate players with flv player.
 * Note:</strong> No <em>FLVPlayer</em> player files are included with this plugin due to licensing considerations. Please download these files from the <a href="http://www.longtailvideo.com/players/jw-flv-player/">Longtail Video</a> site. Extract the files and place the files "player*.swf" and "swobjects.js" in the <code>zp-core/plugins/flvplayer/flvplayer</code> folder.
 *
 * IMPORTANT: Flash players do not support external albums!
 *
 * @author Malte Müller (acrylian), Stephen Billard (sbillard)
 * @package plugins
 */

$plugin_description = sprintf(gettext('Enable <strong>FLV player 4.x</strong> to handle multimedia files.').'<p class="notebox">'.gettext('<strong>No <em>FLVPlayer</em> player files are included with this plugin due to licensing considerations.</strong> Please download these files from the <a href="http://www.longtailvideo.com/players/jw-flv-player/">Longtail Video</a> site. Extract the files "player*.swf" and "swobjects.js" into <code>/%s/flvplayer/</code>. <br /><strong>IMPORTANT:</strong> Only one multimedia player plugin can be enabled at the time. The class-video plugin must be enabled.').'</p>',USER_PLUGIN_FOLDER);
$plugin_author = "Malte Müller (acrylian), Stephen Billard (sbillard)";
$plugin_version = '1.3.1';
$plugin_disable = (getOption('album_folder_class') === 'external')?gettext('Flash players do not support <em>External Albums</em>.'):false;

if ($plugin_disable) {
	setOption('zp_plugin_flvplayer',0);
} else {
	$option_interface = new flvplayer();
	$_zp_flash_player = $option_interface; // claim to be the flash player.
	if (version_compare(ZENPHOTO_VERSION,'1.3.2') < 0) {
		ob_start();
		flvplayerJS();
		$str = ob_get_contents();
		ob_end_clean();
		addPluginScript($str);
	} else {
		zp_register_filter('theme_head', 'flvplayerJS');
	}
}
function flvplayerJS() {
	?>
	<script type="text/javascript" src="<?php echo WEBPATH.'/'.USER_PLUGIN_FOLDER; ?>/flvplayer/swfobject.js"></script>
	<?php
}
define ('FLV_PLAYER_MP3_HEIGHT', 20);
// load the script needed
$curdir = getcwd();
chdir(SERVERPATH."/".USER_PLUGIN_FOLDER.'/flvplayer');
$_playerlist = safe_glob('*.swf');
if (count($_playerlist) > 0) {
	$_flv_player = array_shift($_playerlist);
} else {
	$_flv_player = '';
}
chdir($curdir);

/**
 * Plugin option handling class
 *
 */
class flvplayer {

	function flvplayer() {
		setOptionDefault('flv_player_width', '320');
		setOptionDefault('flv_player_height', '240');
		setOptionDefault('flv_player_backcolor', '#FFFFFF');
		setOptionDefault('flv_player_frontcolor', '#000000');
		setOptionDefault('flv_player_lightcolor', '#000000');
		setOptionDefault('flv_player_screencolor', '#000000');
		setOptionDefault('flv_player_autostart', '');
		setOptionDefault('flv_player_buffer','0');
		setOptionDefault('flv_player_controlbar','over');
		setOptionDefault('flv_player_stretching','uniform');
		//setOptionDefault('flv_player_ignoresize_for_mp3', 'true');

		// flv_playlist options
		setOptionDefault('flvplaylist_width', '600');
		setOptionDefault('flvplaylist_height', '240');
		setOptionDefault('flvplaylist_size', '240');
		setOptionDefault('flvplaylist_position', 'right');
		setOptionDefault('flvplaylist_repeat', 'list');
	}

	function getOptionsSupported() {
		global $_flv_player;
		if (empty($_flv_player)) {
			return array(gettext('No FLV Player') => array('key' => 'flvplayer', 'type' => OPTION_TYPE_CUSTOM,
										'desc' => gettext('No <em>FLVPlayer</em> player files are included with this plugin due to licensing considerations. Please download these files from the <a href="http://www.longtailvideo.com/players/jw-flv-player/">Longtail Video</a> site. Extract the files and place the files "player*.swf" and "swobjects.js" in a folder named <code>flvplayer</code> in the global plugins folder.')));
		}

		$result = array(gettext('flv player width') => array('key' => 'flv_player_width', 'type' => OPTION_TYPE_TEXTBOX,
																		'desc' => gettext("Player width (ignored for <em>mp3</em> files.)")),
										gettext('flv player height') => array('key' => 'flv_player_height', 'type' => OPTION_TYPE_TEXTBOX,
																		'desc' => gettext("Player height (ignored for .<em>mp3</em> files if there is no preview image available.)")),
										gettext('Autostart') => array('key' => 'flv_player_autostart', 'type' => OPTION_TYPE_CHECKBOX,
																		'desc' => gettext("Should the video start automatically. Yes if selected.")),
										gettext('BufferSize') => array('key' => 'flv_player_buffer', 'type' => OPTION_TYPE_TEXTBOX,
																		'desc' => /*xgettext:no-php-format*/ gettext("Size of the buffer in % before the video starts.")),
										gettext('Controlbar position') => array('key' => 'flv_player_controlbar', 'type' => OPTION_TYPE_SELECTOR,
																		'selections' => array(gettext('Bottom')=>"bottom", gettext('Over')=>"over", gettext('None')=>"none"),
																		'desc' => gettext("The position of the controlbar.")),
										gettext('Playlist position') => array('key' => 'flvplaylist_position', 'type' => OPTION_TYPE_SELECTOR,
																		'selections' => array(gettext('Bottom')=>"bottom", gettext('Over')=>"over", gettext('Right')=>"right",gettext('None')=>"none"),
																		'desc' => gettext("Position of the playlist (only if using the special <code>flvplaylist()</code> function).")),
										gettext('Playlist size') => array('key' => 'flvplaylist_size', 'type' => OPTION_TYPE_TEXTBOX,
																		'desc' => gettext("When <em>playlist</em> is set to <em>below</em> this refers to the height, when <em>right</em> this refers to the width of the playlist (only if using the special <code>flvplaylist()</code> function).")),
										gettext('Playlist repeat') => array('key' => 'flvplaylist_repeat','type' => OPTION_TYPE_SELECTOR,
																		'selections' => array(gettext('List')=>"list", gettext('Always')=>"always", gettext('Single')=>"single"),
																		'desc' => gettext("set to list to play the entire playlist once, to always to continously play the song/video/playlist and to single to continue repeating the selected file in a playlist. (only if using the special <code>flvplaylist()</code> function).")),
										gettext('flv player width for playlist') => array('key' => 'flvplaylist_width', 'type' => OPTION_TYPE_TEXTBOX,
																		'desc' => gettext("Player width for use with the playlist (ignored for <em>mp3</em> files.)")),
										gettext('flv player height for playlist') => array('key' => 'flvplaylist_height', 'type' => OPTION_TYPE_TEXTBOX,
																		'desc' => gettext("Player height for use with the playlist (ignored for .<em>mp3</em> files if there is no preview image available.)")),
										gettext('Backcolor') => array('key' => 'flv_player_backcolor', 'type' => OPTION_TYPE_COLOR_PICKER,
																		'desc' => gettext("Backgroundcolor of the controls, in HEX format.")),
										gettext('Frontcolor') => array('key' => 'flv_player_frontcolor', 'type' => OPTION_TYPE_COLOR_PICKER,
																		'desc' => gettext("Text &amp; buttons color of the controls, in HEX format. ")),
										gettext('Lightcolor') => array('key' => 'flv_player_lightcolor', 'type' => OPTION_TYPE_COLOR_PICKER,
																		'desc' => gettext("Rollover color of the controls, in HEX format.")),
										gettext('Screencolor') => array('key' => 'flv_player_screencolor', 'type' => OPTION_TYPE_COLOR_PICKER,
																		'desc' => gettext("Color of the display area, in HEX format.")),
										gettext('Stretching') => array('key' => 'flv_player_stretching', 'type' => OPTION_TYPE_SELECTOR,
																		'selections' => array(gettext('Exactfit')=>"exactfit", gettext('Uniform')=>"uniform", gettext('Fill')=>"fill", gettext('None')=>"none"),
																		'desc' => gettext("Defines how to resize images in the display. Can be none (no stretching), exactfit (disproportionate), uniform (stretch with black borders) or fill (uniform, but completely fill the display).")),
										);
		return $result;
	}

	/**
	 * handles any custom options
	 *
	 * @param string $option
	 * @param mixed $currentValue
	 */
	function handleOption($option, $currentValue) {
		echo gettext('FLV Player support files missing.');
	}

	/**
	 * Prints the JS configuration of flv player
	 *
	 * @param string $moviepath the direct path of a movie (within the slideshow), if empty (within albums) the ZenPhoto function getUnprotectedImageURL() is used
	 * @param string $imagetitle the title of the movie to be passed to the player for display (within slideshow), if empty (within albums) the function getImageTitle() is used
	 * @param string $count unique text for when there are multiple player items on a page
	 */
	function getPlayerConfig($moviepath='',$imagetitle='',$count ='') {
		global $_zp_current_image, $_zp_current_album, $_flv_player;
		if(empty($moviepath)) {
			$moviepath = getUnprotectedImageURL();
			$ext = strtolower(strrchr(getUnprotectedImageURL(), "."));
		} else {
			$ext = strtolower(strrchr($moviepath, "."));
		}
		if(empty($imagetitle)) {
			$imagetitle = getImageTitle();
		}
		if(!empty($count)) {
			$count = "-".$count;
		}
		$imgextensions = array(".jpg",".jpeg",".gif",".png");
		if(is_null($_zp_current_image)) {
			$albumfolder = $moviepath;
			$filename = $imagetitle;
			$videoThumb = '';
		} else {
			$album = $_zp_current_image->getAlbum();
			$albumfolder = $album->name;
			$filename = $_zp_current_image->filename;
			$videoThumb = $_zp_current_image->objectsThumb;
			if (!empty($videoThumb)) {
				$videoThumb = getAlbumFolder(WEBPATH).$albumfolder.'/'.$videoThumb;
			}
		}
		$output = '';
		$output .= '<p id="player'.$count.'">'.gettext('The flv player is not installed. Please install or activate the flv player plugin.').'</p>
			<script type="text/javascript">'."\n\n";
		if($ext === ".mp3" AND !isset($videoThumb)) {
			$output .= 'var so = new SWFObject("'.WEBPATH."/".USER_PLUGIN_FOLDER.'/flvplayer/'.$_flv_player.'","player'.$count.'","'.getOption('flv_player_width').'","'.FLV_PLAYER_MP3_HEIGHT.'",7);'."\n";
		} else {
			$output .= 'var so = new SWFObject("'.WEBPATH."/".USER_PLUGIN_FOLDER.'/flvplayer/'.$_flv_player.'","player'.$count.'","'.getOption('flv_player_width').'","'.getOption('flv_player_height').'","7");'."\n";
		}

		$output .= 'so.addVariable("file","' . $moviepath . '&amp;title=' . strip_tags($imagetitle) . '");'."\n";
		if (!empty($videoThumb)) {
			$output .= 'so.addVariable("image","' . $videoThumb . '");'."\n";
		}
		$output .= 'so.addVariable("backcolor","'.getOptionColor('flv_player_backcolor').'");'."\n";
		$output .= 'so.addVariable("frontcolor","'.getOptionColor('flv_player_frontcolor').'");'."\n";
		$output .= 'so.addVariable("lightcolor","'.getOptionColor('flv_player_lightcolor').'");'."\n";
		$output .= 'so.addVariable("screencolor","'.getOptionColor('flv_player_screencolor').'");'."\n";
		$output .= 'so.addVariable("autostart",' . (getOption('flv_player_autostart') ? 'true' : 'false') . ');'."\n";
		$output .= 'so.addVariable("stretching","'.getOption('flv_player_stretching').'");'."\n";
		$output .= 'so.addVariable("bufferlength",'.getOption('flv_player_buffer').');'."\n";
		$output .= 'so.addVariable("controlbar","'.getOption('flv_player_controlbar').'");'."\n";

		$output .= 'so.addParam("allowfullscreen",true);'."\n";
		$output .= 'so.write("player'.$count.'");'."\n";
		$output .= "\n</script>\n";
		return $output;
	}

	/**
	 * outputs the player configuration HTML
	 *
	 * @param string $moviepath the direct path of a movie (within the slideshow), if empty (within albums) the ZenPhoto function getUnprotectedImageURL() is used
	 * @param string $imagetitle the title of the movie to be passed to the player for display (within slideshow), if empty (within albums) the function getImageTitle() is used
	 * @param string $count unique text for when there are multiple player items on a page
	 */
	function printPlayerConfig($moviepath='',$imagetitle='',$count ='') {
		echo $this->getPlayerConfig($moviepath,$imagetitle,$count);
	}

	/**
	 * Returns the height of the player
	 * @param object $image the image for which the width is requested
	 *
	 * @return int
	 */
	function getVideoWidth($image=NULL) {
		return getOption('flv_player_width');
	}

	/**
	 * Returns the width of the player
	 * @param object $image the image for which the height is requested
	 *
	 * @return int
	 */
	function getVideoHeigth($image=NULL) {
		if (!is_null($image) && strtolower(strrchr($image->filename, ".") == '.mp3')) {
			return FLV_PLAYER_MP3_HEIGHT;
		}
		return getOption('flv_player_height');
	}

}

/**
 * To show the content of an media album with .flv/.mp4/.mp3 movie/audio files only as a playlist or as separate players with flv player
 * NOTE: The flv player plugin needs to be installed (This plugin currently internally uses FLV player 3 because of FLV player 4 Api changes!)
 *
 * The playlist is meant to replace the 'next_image()' loop on a theme's album.php.
 * It can be used with a special 'album theme' that can be assigned to media albums with with .flv/.mp4/.mp3s

 * movie/audio files only. See the examples below
 * You can either show a 'one player window' playlist or show all items as separate players paginated

 * (set in the settings for thumbs per page) on one page (like on a audio or podcast blog).
 *
 * If there is no preview image for a mp3 file existing only the player control bar is shown.
 *
 * The two modes:
 * a) 'playlist'
 * Replace the entire 'next_image()' loop on album.php with this:
 * <?php flvPlaylist("playlist"); ?>
 *
 * It uses a xspf file found in 'zp-core/flvplayer/flvplayer/playlist.php' for the playlist that you also can modify. You can also use other XML formats for a playlist See http://developer.longtailvideo.com/trac/wiki/FlashFormats
 *
 * b) 'players'
 * Modify the 'next_image()' loop on album.php like this:
 * <?php
 * while (next_image():
 * printImageTitle();
 * flvPlaylist("players");
 * endwhile;
 * ?>
 * Of course you can add further functions to b) like title, description, date etc., too.
 *
 * @param string $option the mode to use "playlist" or "players"
 */
function flvPlaylist($option='') {
	global $_zp_current_album, $_zp_current_image, $_flv_player,$_zp_flash_player;
	if(checkAlbumPassword($_zp_current_album->getFolder(), $hint)) {
		if($option === "players") {
			$moviepath = getUnprotectedImageURL();
			$ext = strtolower(strrchr(getUnprotectedImageURL(), "."));
		}
		$imagetitle = getImageTitle();
	}
	$albumid = getAlbumID();

	switch($option) {
		case "playlist":
			if(getNumImages() != 0) {
			?>
	<div id="flvplaylist"><?php echo gettext("The flv player is not installed. Please install or activate the flv player plugin."); ?></div>
	<script type="text/javascript">

		var so = new SWFObject('<?php echo WEBPATH.'/'.USER_PLUGIN_FOLDER; ?>/flvplayer/<?php echo $_flv_player?>','flvplaylist','<?php echo getOption('flvplaylist_width'); ?>','<?php echo getOption('flvplaylist_height'); ?>','8');
		so.addParam('allowfullscreen','true');
		so.addVariable('stretching','<?php echo getOption('flv_player_stretching'); ?>');
		so.addVariable('playlist', '<?php echo getOption('flvplaylist_position'); ?>');
		so.addVariable('playlistsize','<?php echo getOption('flvplaylist_size'); ?>');
		so.addVariable('repeat','<?php echo getOption('flvplaylist_repeat'); ?>');
		so.addVariable('backcolor','<?php echo getOptionColor('flv_player_backcolor'); ?>');
		so.addVariable('frontcolor','<?php echo getOptionColor('flv_player_frontcolor'); ?>');
		so.addVariable('lightcolor','<?php echo getOptionColor('flv_player_lightcolor'); ?>');
		so.addVariable('screencolor','<?php echo getOptionColor('flv_player_screencolor'); ?>');
		so.addVariable('file','<?php echo WEBPATH."/".USER_PLUGIN_FOLDER; ?>/flvplayer/playlist.php?albumid=<?php echo $albumid; ?>');
		so.addVariable('javascriptid','jstest');
		so.addVariable('enablejs','true');
		so.write('flvplaylist');
	</script>
	<?php }
		break;

		case "players":
			if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4")) {
				if (is_null($_zp_flash_player)) {
					echo  "<img src='" . WEBPATH . '/' . ZENFOLDER . "'/images/err-noflashplayer.gif' alt='".gettext('The flv player is not installed. Please install or activate the flv player plugin.')."' />";
				} else {
					$_zp_flash_player->printPlayerConfig(getFullImageURL(),$_zp_current_image->getTitle(),$_zp_current_image->get("id"));
				}
			}
	break;
	}
}

/**
 * Returns the "color" setting of the option after converting it to connical form
 *
 * @param string $option
 * @return string
 */
function getOptionColor($option) {
	$color = getOption($option);
	if (substr($color,0,1) == '#') {
		$color = '0x'.strtoupper(substr($color,1));
	}
	return $color;
}

?>