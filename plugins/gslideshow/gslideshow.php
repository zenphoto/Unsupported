<?php
/**
 * Responsive/fluid slideshows of images using Galleria jQuery script {@link http://galleria.io/ }.
 *
 * The provided theme file <var>slideshow.php</var> must reside in the theme folder for calling slideshow from album, image, favorites, and search pages.
 * You can also embed a slideshow of an album (including dynamic), or image statistic set (popular, latest, random, most rated, etc) directly into a theme page or codeblock.
 * See documentation on oswebcreations.com.
 * <b>NOTE:</b> Slideshow does not support movie and audio files, they will simply not be included.
 *
 * @author gjr (oswebcreations.com), v1.4.5, code based off core plugins cycle slideshow and image/album statisitcs
 * @package plugins
 * @subpackage media
 */

$plugin_description = gettext("Slideshow addon for core slideshow extension.  Uses jQuery Galleria to present a fluid/responsive, fullscreen image slideshow.");
$plugin_author = "GJR (oswebcreations.com), code based off core cycle plugin";
$option_interface = 'gslideshow';

class gslideshow {
	function gslideshow() {
		setOptionDefault('gslideshow_transition', 'fade');
		setOptionDefault('gslideshow_playspeed', '4000');
		setOptionDefault('gslideshow_clicknext', false);
		setOptionDefault('gslideshow_upscale', false);
		setOptionDefault('gslideshow_always', false);
		setOptionDefault('gslideshow_thumbsize', '100');
		setOptionDefault('gslideshow_mediumsize', '800');
		setOptionDefault('gslideshow_bigsize', '1200');
		setOptionDefault('gslideshow_style', 'dark');
		if (class_exists('cacheManager')) {
			cacheManager::deleteThemeCacheSizes('gslideshow');
			cacheManager::addThemeCacheSize('gslideshow',getOption('gslideshow_thumbsize'),null,null,null,null,null,null,null,null,null,true);
			cacheManager::addThemeCacheSize('gslideshow',getOption('gslideshow_mediumsize'),null,null,null,null,null,null,null,null,null,true);
			cacheManager::addThemeCacheSize('gslideshow',getOption('gslideshow_bigsize'),null,null,null,null,null,null,null,null,null,true);
		}
	}
	function getOptionsSupported() {
		$options = array(
			gettext('Slideshow Transition') => array('key' => 'gslideshow_transition', 'type' => OPTION_TYPE_SELECTOR,
				'order'=>0,
				'selections' => array(gettext("Fade")=>"fade", gettext("Flash")=>"flash", gettext("Slide")=>"slide", gettext("Fadeslide")=>"fadeslide",gettext("Pulse")=>"pulse"),
				'desc' => gettext('The transition that is used when displaying the images. <em>fade</em> crossfades betweens images, <em>flash</em> fades into background color between images, <em>pulse</em> quickly removes the image into background color then fades the next image, <em>slide</em> slides the images depending on image position, <em>fadeslide</em> fade between images and slide slightly at the same time.')
				),
			gettext('Slideshow Speed') => array('key' => 'gslideshow_playspeed', 'type' => OPTION_TYPE_TEXTBOX,
				'order'=>1,
				'desc' => gettext('Speed of the slideshow in milliseconds.')
				),
			gettext('Click Next') => array('key' => 'gslideshow_clicknext', 'type' => OPTION_TYPE_CHECKBOX,
				'order'=>2,
				'desc' => gettext('This options adds a click event over the stage that navigates to the next image in the gallery. Useful for mobile browsers and other simpler applications.')
				),
			gettext('Allow Upscale') => array('key' => 'gslideshow_upscale', 'type' => OPTION_TYPE_CHECKBOX,
				'order'=>3,
				'desc' => gettext('Check this box to allow upscaling of images to fit the slideshow stage.')
				),
			gettext('Scripts Always Available?') => array('key' => 'gslideshow_always', 'type' => OPTION_TYPE_CHECKBOX,
				'order'=>4,
				'desc' => gettext('Check this box to always load the necessary scripts and css in every page.  Must do this when you are embedding slideshows in other than slideshow.php, such as codeblocks or other themepages.  See docs.')
				),
			gettext('Thumbsize') => array('key' => 'gslideshow_thumbsize', 'type' => OPTION_TYPE_TEXTBOX,
				'order'=>5,
				'desc' => gettext('Thumb image size created by Zenphoto, default 100.  Slideshow css actually scales this image down to fit thumb carousel.')
				),
			gettext('Medium Image Size') => array('key' => 'gslideshow_mediumsize', 'type' => OPTION_TYPE_TEXTBOX,
				'order'=>6,
				'desc' => gettext('Medium image size created by Zenphoto, default 800.  Slideshow css scales this image down in default displays to fit slideshow stage.')
				),
			gettext('Big Image Size') => array('key' => 'gslideshow_bigsize', 'type' => OPTION_TYPE_TEXTBOX,
				'order'=>7,
				'desc' => gettext('Big image size created by Zenphoto, default 1200.  Slideshow css scales this image in fullscreen displays to fit slideshow stage.')
				),
			gettext('Style') => array('key' => 'gslideshow_style', 'type' => OPTION_TYPE_RADIO,
				'order' => 8,
				'buttons' => array(gettext('Dark')=>'dark', gettext('Light')=>'light'),
				'desc' => gettext('Choose the style to best match your theme.')
				)
		);
		return $options;
	}
	function handleOption($option, $currentValue) {
	}
}

global $_zp_gallery_page;
$slideshow_instance = 0;
if (($_zp_gallery_page == 'slideshow.php') || (getOption('gslideshow_always'))) zp_register_filter('theme_head','printGslideshowJS');
if (!getOption('zp_plugin_slideshow')) setOption('zp_plugin_slideshow',1);
setOption('slideshow_mode','jQuery');

/**
 * Prints the Galleria slideshow for albums or search results.
 *
 * Two ways to use (see readme/documentation):
 * a) Used on the included theme slideshow.php page and called via printSlideShowLink() from the core slideshow plugin:
 * b) Calling directly via printGslideshow() function in a template file or codeblock.
 *
 * @param obj $albumobj The object of the album to show the slideshow of. Not needed if calling slideshow from album, image, or search.
 * @param obj $imageobj The object of the image to start the slideshow with. If not set the slideshow starts with the first image of the album, or current image if called from image.php. Not needed if calling slideshow from album, image, or search.
 * @param bool $linkslides Set to true if you want the slides to be linked to their image pages
 * @param mixed $autoplay true to autoplay slideshow with interval set in options, false to start with slideshow stopped.  Set integer in milliseconds to autoplay at that interval (Ex. 4000), overriding plugin option set.
 * @param bool $shuffle Set to true if you want random (shuffled) order of the slides
 *
 * */
function printGslideshow($albumobj=null,$imageobj=null,$linkslides=true,$autoplay=true,$forceheight=false,$shuffle=false) {

	$data = 'data';

	// no POST data from slidehow link and $albumobj provided is not valid, exit
	if (!isset($_POST['albumid']) AND !is_object($albumobj)) {
		echo "<div class=\"errorbox\" id=\"message\"><h2>".gettext("Invalid linking to the slideshow page.")."</h2></div>";
		echo "</div></body></html>";
		exitZP();
	}

	global $_zp_current_image, $_zp_current_album, $_zp_gallery,$_myFavorites, $_zp_conf_vars;
	$imagenumber = 0;

	//getting the image to start with
	if(!empty($_POST['imagenumber']) AND !is_object($imageobj)) {
		$imagenumber = sanitize_numeric($_POST['imagenumber'])-1; // slideshows starts with 0, but zp with 1.
	} elseif (is_object($imageobj)) {
		makeImageCurrent($imageobj);
		$imagenumber = (imageNumber()-1);
	}
	// set pagenumber to 0 if not called via POST link
	if(isset($_POST['pagenr'])) {
		$pagenumber = sanitize_numeric($_POST['pagenr']);
	} else {
		$pagenumber = 1;
	}
	// getting the number of images
	if(!empty($_POST['numberofimages'])) {
		$numberofimages = sanitize_numeric($_POST['numberofimages']);
	} elseif (is_object($albumobj)) {
		$numberofimages = $albumobj->getNumImages();
	} else {
		$numberofimages = 0;
	}
	if($imagenumber < 2 || $imagenumber > $numberofimages) {
		$imagenumber = 0;
	}
	//getting the album to show
	if(!empty($_POST['albumid']) && !is_object($albumobj)) {
		$albumid = sanitize_numeric($_POST['albumid']); $embedded = false;
	} elseif(is_object($albumobj)) {
		$albumid = $albumobj->getID(); $embedded = true;
	} else {
		$albumid = 0; $embedded = false;
	}
	if($numberofimages == 0) {
		return NULL;
	}
	// get slideshow data
	if (isset($_POST['preserve_search_params'])) { // search page
		$search = new SearchEngine();
		$params = sanitize($_POST['preserve_search_params']);
		$search->setSearchParams($params);
		$images = $search->getImages(0);
		$searchwords = $search->getSearchWords();
		$searchdate = $search->getSearchDate();
		$searchfields = $search->getSearchFields(true);
		$page = $search->page;
		$returnpath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
		$albumtitle = gettext('Search');
	} else {
		if (isset($_POST['favorites_page'])) {
			$album = $_myFavorites;
			$albumtitle = gettext('My Favorites');
			$images = $album->getImages(0);
			$returnpath = rewrite_path(favorites::getFavorites_link() . '/' . $pagenumber, FULLWEBPATH . '/index.php?p=favorites' . '&page=' . $pagenumber);
		} else {
			$albumq = query_single_row("SELECT title, folder FROM ". prefix('albums') ." WHERE id = ".$albumid);
			$album = newAlbum($albumq['folder']);
			$albumtitle = $album->getTitle();
			if(!$album->isMyItem(LIST_RIGHTS) && !checkAlbumPassword($albumq['folder'])) {
				echo gettext("This album is password protected!");
				exitZP();
			}
			$dynamic = $album->isDynamic();
			$images = $album->getImages(0);
			// return path to get back to the page we called the slideshow from
			if (empty($_POST['imagenumber'])) {
				$returnpath = rewrite_path('/'.pathurlencode($album->name).'/page/'.$pagenumber,'/index.php?album='.urlencode($album->name).'&page='.$pagenumber);
			} else {
				$returnpath = rewrite_path('/'.pathurlencode($album->name).'/'.rawurlencode(sanitize($_POST['imagefile'])).getOption('mod_rewrite_image_suffix'),'/index.php?album='.urlencode($album->name).'&image='.urlencode($_POST['imagefile']));
			}
		}
	}
	if($shuffle) shuffle($images);
	// slideshow display section
	?>

			<script>
				var data = [
				<?php
				for ($imgnr = 0, $cntr = 0, $idx = 0; $imgnr < $numberofimages; $imgnr++, $idx++) {
					if (is_array($images[$idx])) {
						$filename = $images[$idx]['filename'];
						$album = newAlbum($images[$idx]['folder']);
						$image = newImage($album, $filename);
					} else {
						$filename = $images[$idx];
						$image = newImage($album, $filename);
					}
					$ext = isImagePhoto($image);
					if ($ext) {
						makeImageCurrent($image);
						echo '{'."\n";
							echo 'thumb: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_thumbsize'),getOption('gslideshow_thumbsize')).'\','."\n";
							echo 'image: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_mediumsize'),getOption('gslideshow_mediumsize')).'\','."\n";
							echo 'big: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_bigsize'),getOption('gslideshow_bigsize')).'\','."\n";
							echo 'title: \''.js_encode($image->getTitle()).'\','."\n";
							$desc = $image->getDesc();
							$desc = str_replace("\r\n", '<br />', $desc);
							$desc = str_replace("\r", '<br />', $desc);
							echo 'description: \''.js_encode($desc).'\','."\n";
							if($linkslides) echo 'link: \''.html_encode($image->getLink()).'\''."\n";
						if ($imgnr == $numberofimages - 1) { echo '}'."\n"; } else { echo '},'."\n"; }
					}
				}
				echo "\n";
				?>
				];
			</script>
			<?php
			printGalleriaRun($data,$linkslides,$autoplay,$embedded,$forceheight,$imagenumber,$albumtitle,$returnpath);
			//restore_context(); // needed if the slideshow is for example called directly via album object before the next_album loop on index.php
}

/**
 * Prints an image or album statistic slideshow using the {@link http://galleria.io/  jQuery plugin Galleria}
 *
 * See readme/documentation for usage:
 * Call directly in a template file or codeblock.
 *
 * NOTE: movie and audio files not supported.
 *
 * @param string $type return statistics of either 'images' or 'albums'
 * @param integer $number the number of items to get (images or albums, depending on $type set)
 * @param string $option
 *  	"popular" for the most popular
 *		"latest" for the latest uploaded by id (Discovery)
 * 		"latest-date" for the latest by date
 * 		"latest-mtime" for the latest by mtime
 *   	"latest-publishdate" for the latest by publishdate
 *      "mostrated" for the most voted
 *		"toprated" for the best voted
 *		"latestupdated" for the latest updated
 *		"random" for random order (yes, strictly no statistical order...)
 * @param string $albumfolder foldername of a specific album to pull items from
 * @param bool $collection only if $albumfolder is set: true if you want to get statistics from this album and all of its subalbums
 * @param bool $linkslides true to link to image or album on slide, else click advances slideshow instead
 * @param mixed $autoplay true to autoplay slideshow with interval set in options, false to start with slideshow stopped.  Set integer in milliseconds to autoplay at that interval (Ex. 4000), overriding plugin option set.
 * @param integer $threshold the minimum number of ratings an image must have to be included in the list. (Default 0)
 *
 */
function printGslideshowStatistic($type, $number, $option, $albumfolder='', $collection=false, $linkslides=true, $autoplay=true, $threshold=0) {
	save_context();
	$data = 'data';
	$embedded = true;
	$forceheight = true;
	$imagenumber = 0;
	$albumtitle = '';
	$returnpath = '';
	require_once(SERVERPATH.'/'.ZENFOLDER.'/'.PLUGIN_FOLDER.'/image_album_statistics.php');
	if (($type == 'album') || ($type == 'albums')) {
	$albums = getAlbumStatistic($number, $option, $albumfolder);
	} else {
	$images = getImageStatistic($number, $option, $albumfolder, $collection, $threshold);
	}
	?>

			<script>
				var data = [

	<?php if (($type == 'album') || ($type == 'albums')) {
				$c=1;
				foreach ($albums as $album) {
					$tempalbum = newAlbum($album['folder']);
					$albumpath = html_encode(rewrite_path("/".pathurlencode($tempalbum->name), "index.php?album=".pathurlencode($tempalbum->name)));
					$albumthumb = $tempalbum->getAlbumThumbImage();
					$image = newImage($tempalbum, $albumthumb->filename);
					$ext = isImagePhoto($image);
					if ($ext) {
						makeImageCurrent($image);
						echo '{'."\n";
							echo 'thumb: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_thumbsize'),getOption('gslideshow_thumbsize')).'\','."\n";
							echo 'image: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_mediumsize'),getOption('gslideshow_mediumsize')).'\','."\n";
							echo 'big: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_bigsize'),getOption('gslideshow_bigsize')).'\','."\n";
							echo 'title: \''.html_encode($tempalbum->getTitle()).'\','."\n";
							$desc = $tempalbum->getDesc();
							$desc = str_replace("\r\n", '<br />', $desc);
							$desc = str_replace("\r", '<br />', $desc);
							echo 'description: \''.js_encode($desc).'\','."\n";
							echo 'link: \''.$albumpath.'\''."\n";
						if ($c == $number) { echo '}'."\n"; } else { echo '},'."\n"; }
					}
					$c++;
				}
				echo "\n";
	} else {
				$c=1;
				foreach ($images as $image) {
					$ext = isImagePhoto($image);
					if ($ext) {
						makeImageCurrent($image);
						echo '{'."\n";
							echo 'thumb: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_thumbsize'),getOption('gslideshow_thumbsize')).'\','."\n";
							echo 'image: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_mediumsize'),getOption('gslideshow_mediumsize')).'\','."\n";
							echo 'big: \''.getCustomSizedImageMaxSpace(getOption('gslideshow_bigsize'),getOption('gslideshow_bigsize')).'\','."\n";
							echo 'title: \''.html_encode($image->getTitle()).'\','."\n";
							$desc = $image->getDesc();
							$desc = str_replace("\r\n", '<br />', $desc);
							$desc = str_replace("\r", '<br />', $desc);
							echo 'description: \''.js_encode($desc).'\','."\n";
							echo 'link: \''.html_encode($image->getLink()).'\''."\n";
						if ($c == $number) { echo '}'."\n"; } else { echo '},'."\n"; }
					}
					$c++;
				}
				echo "\n";
	}
	?>
				];
			</script>
			<?php
			printGalleriaRun($data,$linkslides,$autoplay,$embedded,$forceheight,$imagenumber,$albumtitle,$returnpath);
			restore_context(); // needed if the slideshow is for example called directly via album object before the next_album loop on index.php
}

/**
 * Helper function to print the necessary slideshow js and css links in the <head>.  Called automatically by the theme_head filter.
 * See plugin option to make slideshow always available (scripts and css always called in <head>), so that you can call it directly in codeblocks and theme files.
 *
 * */
function printGslideshowJS() {
	?>
	<link rel="stylesheet" href="<?php echo WEBPATH; ?>/plugins/gslideshow/galleria.classic.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo WEBPATH; ?>/plugins/gslideshow/gslideshow.css" type="text/css" />
	<?php if ((getOption('gslideshow_style') == 'light')) { ?><link rel="stylesheet" href="<?php echo WEBPATH; ?>/plugins/gslideshow/gslideshow-light-overrides.css" type="text/css" /><?php } ?>
	<script src="<?php echo WEBPATH; ?>/plugins/gslideshow/galleria-1.2.9.min.js"></script>
	<script src="<?php echo WEBPATH; ?>/plugins/gslideshow/galleria.classic.min.js"></script>
	<?php
}

/**
 * Helper function to print the Galleria initiation.  Called elsewhere and not for standalone use.
 *
 * */
function printGalleriaRun($data,$linkslides,$autoplay,$embedded,$forceheight,$imagenumber,$albumtitle,$returnpath) {

			if(!$autoplay) { ?> <style>#galleria-control-play{display:block;}#galleria-control-pause{display:none;}</style> <?php } ?>
			<div id="galleria"></div>
			<script>
				Galleria.run('#galleria', {
					clicknext: <?php if ((!$linkslides) || (getOption("gslideshow_clicknext"))) { echo 'true'; } else { echo 'false'; } ?>,
					autoplay: <?php if (($autoplay) && (is_int($autoplay))) { echo $autoplay; } elseif ($autoplay) { echo getOption("gslideshow_playspeed"); } else { echo 'false'; } ?>,
					transition: '<?php echo getOption("gslideshow_transition"); ?>',
					dataSource: <?php echo $data; ?>,
					thumbnails: 'lazy',
					<?php if(($embedded) || ($forceheight)) { ?>height: 0.5625,<?php } ?>
					thumbQuality: 'auto',
					touchTransition: 'slide',
					show: <?php echo $imagenumber; ?>,
					responsive: true,
					extend: function() {
						$('#galleria-control-fullscreen').click(this.proxy(function(e) {
							e.preventDefault();
							this.toggleFullscreen();
						}));
						$('.galleria-image-nav-left').click(this.proxy(function(e) {
							e.preventDefault();
							this.pause();
							$('#galleria-control-play').css('display','block');
							$('#galleria-control-pause').css('display','none');
						}));
						$('.galleria-image-nav-right').click(this.proxy(function(e) {
							e.preventDefault();
							this.pause();
							$('#galleria-control-play').css('display','block');
							$('#galleria-control-pause').css('display','none');
						}));
						$('.galleria-image').click(this.proxy(function(e) {
							e.preventDefault();
							this.pause();
							$('#galleria-control-play').css('display','block');
							$('#galleria-control-pause').css('display','none');
						}));
						$('#galleria-control-play').click(this.proxy(function(e) {
							e.preventDefault();
							this.play();
							$('#galleria-control-pause').css('display','block');
							$('#galleria-control-play').css('display','none');
						}));
						$('#galleria-control-pause').click(this.proxy(function(e) {
							e.preventDefault();
							this.pause();
							$('#galleria-control-play').css('display','block');
							$('#galleria-control-pause').css('display','none');
						}));
					}
				});
				$('.galleria-info').append('<div id="galleria-custom-controls"<?php if($embedded) { ?> class="embedded"<?php } ?>><a id="galleria-control-return" title="<?php echo html_encode($albumtitle).'&raquo; '.gettext('Return'); ?>" href="<?php echo html_encode($returnpath); ?>"><span></span></a><a id="galleria-control-play" href="#"><span></span></a><a id="galleria-control-pause" href="#"><span></span></a><a href="#" id="galleria-control-fullscreen"><span></span></a></div>');
				Galleria.ready(function(options) {
					this.lazyLoadChunks(5);
				});
			</script>
<?php
}


?>