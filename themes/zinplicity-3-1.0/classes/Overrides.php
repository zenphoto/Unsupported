<?php

	class SlideshowOverrides {
		private function SlideshowOverrides() {

		}

		//350 lines of copy/paste for 1 (one!) missing line
		static function printSlideShow($heading = true, $speedctl = false, $albumobj = "", $imageobj = "", $width = "", $height = "") {
			if (!isset($_POST['albumid']) AND !is_object($albumobj)) {
				echo "<div class=\"errorbox\" id=\"message\"><h2>".gettext("Invalid linking to the slideshow page.")."</h2></div>";
				echo "</div></body></html>";
				exit();
			}
			global $_zp_flash_player, $_zp_current_image, $_zp_current_album, $_zp_gallery;
	
			//getting the image to start with
			if(!empty($_POST['imagenumber']) AND !is_object($imageobj)) {
				$imagenumber = ($_POST['imagenumber']-1); // slideshows starts with 0, but zp with 1.
			} elseif (is_object($imageobj)) {
				makeImageCurrent($imageobj);
				$imagenumber = (imageNumber()-1);
			} else {
				$imagenumber = 0;
			}
	
			// set pagenumber to 0 if not called via POST link
			if(isset($_POST['pagenr'])) {
				$pagenumber = sanitize_numeric($_POST['pagenr']);
			} else {
				$pagenumber = 0;
			}
			// getting the number of images
			if(!empty($_POST['numberofimages'])) {
				$numberofimages = sanitize_numeric($_POST['numberofimages']);
			} elseif (is_object($albumobj)) {
				$numberofimages = $albumobj->getNumImages();
			}
	
			//getting the album to show
			if(!empty($_POST['albumid']) AND !is_object($albumobj)) {
				$albumid = sanitize_numeric($_POST['albumid']);
			} elseif(is_object($albumobj)) {
				$albumid = $albumobj->id;
			} else {
				$albumid = -1;
			}

			// setting the image size
			if (!empty($width) AND !empty($height)) {
				$width = sanitize_numeric($width);
				$height = sanitize_numeric($height);
			} else {
				$width = getOption("slideshow_width");
				$height = getOption("slideshow_height");
			}

			$option = getOption("slideshow_mode");
			// jQuery Cycle slideshow config
			// get slideshow data
			$gallery = new Gallery();
			if ($albumid <= 0) { // search page
				$dynamic = 2;
				$search = new SearchEngine();
				$params = $_POST['preserve_search_params'];
				$search->setSearchParams($params);
				$images = $search->getImages(0);
				$searchwords = $search->words;
				$searchdate = $search->dates;
				$searchfields = $search->fields;
				$page = $search->page;
				if (empty($_POST['imagenumber'])) {
					$albumq = query_single_row("SELECT title, folder FROM ". prefix('albums') ." WHERE id = ".abs($albumid));
					$album = new Album($gallery, $albumq['folder']);
					$returnpath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
					//$returnpath = rewrite_path('/'.pathurlencode($album->name).'/page/'.$pagenumber,'/index.php?album='.urlencode($album->name).'&page='.$pagenumber);
				} else {
					$returnpath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
				}
				$albumtitle = gettext('Search');
			} else {
				$albumq = query_single_row("SELECT title, folder FROM ". prefix('albums') ." WHERE id = ".$albumid);
				$album = new Album($gallery, $albumq['folder']);
				$albumtitle = $album->getTitle();
				if(!checkAlbumPassword($albumq['folder'], $hint)) {
					echo gettext("This album is password protected!"); exit;
				}
				$dynamic = $album->isDynamic();
				$images = $album->getImages(0);
				// return path to get back to the page we called the slideshow from
				if (empty($_POST['imagenumber'])) {
					$returnpath = rewrite_path('/'.pathurlencode($album->name).'/page/'.$pagenumber,'/index.php?album='.urlencode($album->name).'&page='.$pagenumber);
				} else {
					$returnpath = rewrite_path('/'.pathurlencode($album->name).'/'.rawurlencode($_POST['imagefile']).getOption('mod_rewrite_image_suffix'),'/index.php?album='.urlencode($album->name).'&image='.urlencode($_POST['imagefile']));
				}
			}
			// slideshow display section
			switch($option) {
				case "jQuery":
					$validtypes = array('jpg','jpeg','gif','png','mov','3gp');
					?>
					<script type="text/javascript">
						$(document).ready(function(){
							$(function() {
								var ThisGallery = '<?php echo html_encode($albumtitle); ?>';
								var ImageList = new Array();
								var TitleList = new Array();
								var DescList = new Array();
								var ImageNameList = new Array();
								var DynTime=(<?php echo getOption("slideshow_timeout"); ?>) * 1.0;	// force numeric
								<?php
								for ($imgnr = 0, $cntr = 0, $idx = $imagenumber; $imgnr < $numberofimages; $imgnr++, $idx++) {
									if ($dynamic) {
										$filename = $images[$idx]['filename'];
										$album = new Album($gallery, $images[$idx]['folder']);
										$image = newImage($album, $filename);
									} else {
										$filename = $images[$idx];
										$image = newImage($album, $filename);
									}
									$ext = is_valid($filename, $validtypes);
									if ($ext) {
										makeImageCurrent($image);
										$img = getCustomSizedImageMaxSpace($width,$height);
										//$img = WEBPATH . '/' . ZENFOLDER . '/i.php?a=' . pathurlencode($image->album->name) . '&i=' . urlencode($filename) . '&s=' . $imagesize;
										echo 'ImageList[' . $cntr . '] = "' . $img . '";'. "\n";
										echo 'TitleList[' . $cntr . '] = "' . js_encode($image->getTitle()) . '";'. "\n";
										if(getOption("slideshow_showdesc")) {
											$desc = $image->getDesc();
											$desc = str_replace("\r\n", '<br />', $desc); 
											$desc = str_replace("\r", '<br />', $desc); 
											echo 'DescList[' . $cntr . '] = "' . js_encode($desc) . '";'. "\n";
										} else {
											echo 'DescList[' . $cntr . '] = "";'. "\n";
										}
										if ($idx == $numberofimages - 1) { $idx = -1; }
										echo 'ImageNameList[' . $cntr . '] = "'.urlencode($filename).'";'. "\n";
										$cntr++;
									}
								}
								echo "\n";
								$numberofimages = $cntr;
								?>
								var countOffset = <?php echo $imagenumber; ?>;
								var totalSlideCount = <?php echo $numberofimages; ?>;
								var currentslide = 2;
			
								function onBefore(curr, next, opts) {
									//$(next).parent().animate({opacity: 0});

									if (opts.timeout != DynTime) {
										opts.timeout = DynTime;
									}
									if (!opts.addSlide)
										return;
							
									var currentImageNum = currentslide;
									currentslide++;
									if (currentImageNum == totalSlideCount) {
										opts.addSlide = null;
										return;
									}
									var relativeSlot = (currentslide + countOffset) % totalSlideCount;
									if (relativeSlot == 0) {relativeSlot = totalSlideCount;}
									var htmlblock = "<span class='slideimage'><h4><strong>" + ThisGallery + ":</strong> ";
									htmlblock += TitleList[currentImageNum]  + " (" + relativeSlot + "/" + totalSlideCount + ")</h4>";
									htmlblock += "<img src='" + ImageList[currentImageNum] + "'/>";
									htmlblock += "<p class='imgdesc'>" + DescList[currentImageNum] + "</p></span>";
									opts.addSlide(htmlblock);

								}
			
								function onAfter(curr, next, opts){
									<?php if (!isMyALbum($album->name, ALL_RIGHTS)) { ?>
									//Only register at hit count the first time the image is viewed.
									if ($(next).attr( 'viewed') != 1) {
										$.get("<?php echo FULLWEBPATH .'/'. ZENFOLDER . '/'.PLUGIN_FOLDER; ?>/slideshow/slideshow-counter.php?album=<?php echo pathurlencode($album->name); ?>&img="+ImageNameList[opts.currSlide]);
										$(next).attr( 'viewed', 1 );
									}
									<?php } ?>

									//THE MISSING LINE
									$(next).parent().height(
										$(next).find('img').height() + $(next).find('p').height() + $(next).find('h4').height() + 40
									); //.animate({opacity: 1}, 'normal', 'linear');
									//getOption('slideshow_onafter'); //make it generic
									//END MISSING LINE
								}
			
								$('#slides').cycle({
										fx:     '<?php echo getOption("slideshow_effect"); ?>',
										speed:   <?php echo getOption("slideshow_speed"); ?>,
										timeout: DynTime,
										next:   '#next',
										prev:   '#prev',
										cleartype: 1,
										before: onBefore,
										after: onAfter
								});
			
								$('#speed').change(function () {
									DynTime = this.value;
									return false;
								});
			
								$('#pause').click(function() { $('#slides').cycle('pause'); return false; });
								$('#play').click(function() { $('#slides').cycle('resume'); return false; });
							});
			
						});	// Documentready()
			
						</script>
						<div id="slideshow" align="center">
						<?php
						// 7/21/08dp
						if ($speedctl) {
							echo '<div id="speedcontrol">'; // just to keep it away from controls for sake of this demo
							$minto = getOption("slideshow_speed");
							while ($minto % 500 != 0) {
								$minto += 100;
								if ($minto > 10000) { break; }  // emergency bailout!
							}
							$dflttimeout = getOption("slideshow_timeout");
							/* don't let min timeout = speed */
							$thistimeout = ($minto == getOption("slideshow_speed")? $minto + 250 : $minto);
							echo 'Select Speed: <select id="speed" name="speed">';
							while ( $thistimeout <= 60000) {  // "around" 1 minute :)
								echo "<option value=$thistimeout " . ($thistimeout == $dflttimeout?" selected='selected'>" :">") . round($thistimeout/1000,1) . " sec</option>";
								/* put back timeout to even increments of .5 */
								if ($thistimeout % 500 != 0) { $thistimeout -= 250; }
								$thistimeout += ($thistimeout < 1000? 500:($thistimeout < 10000? 1000:5000));
							}
							echo "</select> </div>";
						}
						if(!is_object($albumobj)) { // disable controls if calling the slideshow directly on homepage for example 
						?>
						<div id="controls">
						<div><span><a href="#" id="prev"
							title="<?php echo gettext("Previous"); ?>"></a></span> <a
							href="<?php echo $returnpath; ?>" id="stop"
							title="<?php echo gettext("Stop and return to album or image page"); ?>"></a>
						<a href="#" id="pause"
							title="<?php echo gettext("Pause (to stop the slideshow without returning)"); ?>"></a>
						<a href="#" id="play" title="<?php echo gettext("Play"); ?>"></a> <a
							href="#" id="next" title="<?php echo gettext("Next"); ?>"></a>
						</div>
						</div>
						<?php } ?>
						<div id="slides" class="pics">
						<?php
						if ($cntr > 1) $cntr = 1;
						for ($imgnr = 0, $idx = $imagenumber; $imgnr <= $cntr; $idx++) {
							if ($idx >= $numberofimages) { $idx = 0; }
							if ($dynamic) {
								$folder = $images[$idx]['folder'];
								$dalbum = new Album($gallery, $folder);
								$filename = $images[$idx]['filename'];
								$image = newImage($dalbum, $filename);
								$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".urlencode($filename);
							} else {
								$folder = $album->name;
								$filename = $images[$idx];
								//$filename = $animage;
								$image = newImage($album, $filename);
								$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".urlencode($filename);
				
							}
							$ext = is_valid($filename, $validtypes);
							if ($ext) {
								$imgnr++;
								echo "<span class='slideimage'><h4><strong>".$albumtitle.gettext(":")."</strong> ".$image->getTitle()." (". ($idx + 1) ."/".$numberofimages.")</h4>";
					
								if ($ext == "3gp") {
									echo '</a>
												<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="352" height="304" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
												<param name="src" value="' . $imagepath. '"/>
												<param name="autoplay" value="false" />
												<param name="type" value="video/quicktime" />
												<param name="controller" value="true" />
												<embed src="' . $imagepath. '" width="352" height="304" autoplay="false" controller"true" type="video/quicktime"
												pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
												</object>
												<a>';
								}	elseif ($ext == "mov") {
									echo '</a>
									 			<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="640" height="496" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
										 		<param name="src" value="' . $imagepath. '"/>
										 		<param name="autoplay" value="false" />
										 		<param name="type" value="video/quicktime" />
										 		<param name="controller" value="true" />
										 		<embed src="'  . $imagepath. '" width="640" height="496" autoplay="false" controller"true" type="video/quicktime"
										 		pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
												</object>
												<a>';
								} else {
									makeImageCurrent($image);
									printCustomSizedImageMaxSpace($alt='',$width,$height,NULL,NULL,false);
									//echo "<img src='".WEBPATH."/".ZENFOLDER."/i.php?a=".urlencode($folder)."&i=".urlencode($filename)."&s=".$imagesize."' alt='".html_encode($image->getTitle())."' title='".html_encode($image->getTitle())."' />\n";
								}
								if(getOption("slideshow_showdesc")) {
									$desc = $image->getDesc();
									$desc = str_replace("\r\n", '<br />', $desc);
									$desc = str_replace("\r", '<br />', $desc);
									echo "<p class='imgdesc'>".$desc."</p>";
								}
								echo "</span>";
							}
						}
				
						break;

				case "flash":
					if ($heading) {
						echo "<span class='slideimage'><h4><strong>".$albumtitle."</strong> (".$numberofimages." images) | <a style='color: white' href='".$returnpath."' title='".gettext("back")."'>".gettext("back")."</a></h4>";
					}
					echo "<span id='slideshow'></span>";
					?> 
					<script type="text/javascript">
					$("#slideshow").flashembed({
						  src:'<?php echo FULLWEBPATH . '/' . ZENFOLDER.'/'.PLUGIN_FOLDER; ?>/flowplayer/FlowPlayerLight.swf',
						  width:<?php echo getOption("slideshow_flow_player_width"); ?>,
						  height:<?php echo getOption("slideshow_flow_player_height"); ?>
						},
						{config: {
						  autoPlay: true,
						  useNativeFullScreen: true,
						  playList: [
													<?php
													echo "\n";
													$count = 0;
													foreach($images as $animage) {
															if ($dynamic) {
																$folder = $animage['folder'];
																$filename = $animage['filename'];
																$salbum = new Album($_zp_gallery, $folder);
																$image = newImage($salbum, $filename);
																$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($salbum->name)."/".urlencode($filename);
															} else {
																$folder = $album->name;
																$filename = $animage;
																$image = newImage($album, $filename);
																$imagepath = FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".pathurlencode($filename);
															}
														$ext = is_valid($filename, array('jpg','jpeg','gif','png','flv','mp3','mp4'));
														if ($ext) {
															if (($ext == "flv") || ($ext == "mp3") || ($ext == "mp4")) {
																$duration = "";
															} else {
																$duration = ", duration: ".getOption("slideshow_speed")/10;
															}
															if($count > 0) { echo ",\n"; }
															echo "{ url: '".FULLWEBPATH.getAlbumFolder('').pathurlencode($folder)."/".urlencode($filename)."'".$duration." }";
															$count++;
														}
													}
													echo "\n";
													?>
												],
						  showPlayListButtons: true,
						  showStopButton: true,
						  controlBarBackgroundColor: 0,
						 	showPlayListButtons: true,
						 	controlsOverVideo: 'ease',
						 	controlBarBackgroundColor: '<?php echo getOption('flow_player_controlbarbackgroundcolor'); ?>',
						  controlsAreaBorderColor: '<?php echo getOption('flow_player_controlsareabordercolor'); ?>'
						}}
				  );
					</script> 
					<?php
					echo "</span>";
					echo "<p>";
					printf (gettext("Click on %s on the right in the player control bar to view full size."), "<img style='position: relative; top: 4px; border: 1px solid gray' src='".WEBPATH . "/" . ZENFOLDER.'/'.PLUGIN_FOLDER."/slideshow/flowplayerfullsizeicon.png' />");
					echo "</p>";
					break;
			}
			?>
			</div>
		</div>
			<?php
		}
	}
?>
