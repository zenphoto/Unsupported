<?php
	define('COMMENT_SUCCESS', 10001);

	class ContactOverride {
		static function sendMail() {
			$subject = sanitize($_POST['subject']);
			$message = sanitize($_POST['message'],1);
			$headers = sanitize($_POST['headers']);
			$mailaddress = sanitize($_POST['mailaddress']);
			$contactform_mailaddress = getOption("contactform_mailaddress");
			$contactform_mailaddress = str_replace(" ","",$contactform_mailaddress);
			zp_mail($subject, $message, $headers, array($contactform_mailaddress,$mailaddress));
		}
	}

	class RatingOverride {
		/* need override to hide form submit input and trigger submit on each star click */
		static function printRating($wrapperId='rating-wrapper') {
			if ( !function_exists('printRating') ) return;

			printRating(3, NULL, false);

			$table = "images";
		
			echo '<script>' . 
				 '$(window).load(function() { ' . 
				 '	$("#' . $wrapperId . ' .star-rating-live").click(function() { ' .
				 '      if ( !zin.ALBUM_PAGE || !zin.ALBUM_PAGE.lastThumbSelection ) return false; ' .
				 '		var id = images[zin.ALBUM_PAGE.lastThumbSelection.attr("index")]["object_id"];' .
	 			 '    	var dataString = $("#' . $wrapperId . ' form").serialize(); ' .
				 '      var idx = dataString.lastIndexOf("="); ' .
				 '      var value = dataString.substring(idx + 1); ' .
		         '      dataString = "star_rating-value_images_" + id + "=" + value; ' .
				 '		$.ajax({ ' .   
				 '			type: "POST", ' .   
				 '			url: "' . WEBPATH . '/' . ZENFOLDER . '/' . PLUGIN_FOLDER . '/rating' . '/update.php", ' .
				 '			data: dataString + "&id=" + id + ' . '"&table=images", ' .
				 '			success: function() { ' .
				 '				images[zin.ALBUM_PAGE.lastThumbSelection.attr("index")].rating = value; ' .
				 '			}' .
				 '      });' .
				 '	}); ' .
				 '});' .
				 '</script> '; 
		}
	}

	class AlbumMenuOverride {
		/* redefine print album to not include subalbums */
		static function printAlbumMenuJump($option="", $indexname="Gallery Index") {
			if ( $indexname == "Gallery Index" ) $indexname = gettext($indexname);

			global $_zp_gallery, $_zp_current_album, $_zp_gallery_page;
			$albumpath = rewrite_path("/", "/index.php?album=");
			if(!empty($_zp_current_album) || $_zp_gallery_page != 'album.php') {
				$currentfolder = $_zp_current_album->name;
			}
			?>
			<script type="text/javaScript">
				function gotoLink(form) {
				 	var OptionIndex=form.ListBoxURL.selectedIndex;
					parent.location = form.ListBoxURL.options[OptionIndex].value;
				}
			</script>
			<form name="AutoListBox" action="#">
				<p>
					<select name="ListBoxURL" size="1" onchange="gotoLink(this.form);">
					<?php
					if(!empty($indexname)) {
						$selected = self::checkSelectedAlbum("", "index");
						 ?>
					<option <?php echo $selected; ?> value="<?php echo htmlspecialchars(getGalleryIndexURL()); ?>"><?php echo $indexname; ?></option>
					<?php 
					}
					$albums = $_zp_gallery->getAlbums();
					self::printAlbumMenuJumpAlbum($albums,$option,$albumpath);
					?>
					</select>
				</p>
			</form>
			<?php
		}

		static function printAlbumMenuJumpAlbum($albums,$option,$albumpath,$level=1) {
			global $_zp_gallery;
			foreach ($albums as $album) {

				$subalbum = new Album($_zp_gallery,$album,true);


				if($option === "count" AND $subalbum->getNumImages() > 0) {
					$count = " (".$subalbum->getNumImages().")";
				} else {
					$count = "";
				}
				$arrow = str_replace(':', '&raquo; ', str_pad("", $level-1, ":"));
						
				$selected = self::checkSelectedAlbum($subalbum->name, "album");
				$link = "<option $selected value='".htmlspecialchars($albumpath.pathurlencode($subalbum->name)).
						"'>".$arrow.strip_tags($subalbum->getTitle()).$count."</option>";
				echo $link;
			}
		}

		static function checkSelectedAlbum($checkalbum, $option) {
			global $_zp_current_album, $_zp_gallery_page;
			if(is_object($_zp_current_album)) {
				$currentalbumname = $_zp_current_album->name;
			} else {
				$currentalbumname = "";
			}
			$selected = "";
			switch ($option) {
				case "index":
					if($_zp_gallery_page === "index.php") {
						$selected = "selected";
					}
					break;
				case "album":
					if($currentalbumname === $checkalbum) {
						$selected = "selected";
					}
					break;
			}
			return $selected;
		}
	}

	class CommentOverride {
		//we want to bypass zp comment handling as the default behaviour doesn't suit our page flow at all
		function handleComment() {
			global $_zp_current_image, $_zp_current_album, $_zp_comment_stored, $_zp_current_zenpage_news, $_zp_current_zenpage_page;
			$activeImage = false;
			$comment_error = 0;
			$cookie = zp_getCookie('zenphoto');
			if (isset($_POST['comment'])) {
				if ((in_context(ZP_ALBUM) || in_context(ZP_ZENPAGE_NEWS_ARTICLE) || in_context(ZP_ZENPAGE_PAGE))) {
					if (isset($_POST['name'])) {
						$p_name = sanitize($_POST['name'],3);
					} else {
						$p_name = '';
					}
					if (isset($_POST['email'])) {
						$p_email = sanitize($_POST['email'], 3);
					} else {
						$p_email = "";
					}
					if (isset($_POST['website'])) {
						$p_website = sanitize($_POST['website'], 3);
					} else {
						$p_website = "";
					}
					if (isset($_POST['comment'])) {
						$p_comment = sanitize($_POST['comment'], 1);
					} else {
						$p_comment = '';
					}
					$p_server = ThemeUtil::getUserIP();
					if (isset($_POST['code'])) {
						$code1 = sanitize($_POST['code'], 3);
						$code2 = sanitize($_POST['code_h'], 3);
					} else {
						$code1 = '';
						$code2 = '';
					}
					$p_private = isset($_POST['private']);
					$p_anon = isset($_POST['anon']);

					if (isset($_POST['imageid'])) {  //used (only?) by the tricasa hack to know which image the client is working with.
						$activeImage = zp_load_image_from_id(sanitize_numeric($_POST['imageid']));
						if ($activeImage !== false) {
							$commentadded = $activeImage->addComment($p_name, $p_email,	$p_website, $p_comment,
																									$code1, $code2,	$p_server, $p_private, $p_anon);
							$redirectTo = $activeImage->getLink();
							}
					} else {
						if (in_context(ZP_IMAGE) AND in_context(ZP_ALBUM)) {
							$commentobject = $_zp_current_image;
							$redirectTo = $_zp_current_image->getLink();
						} else if (!in_context(ZP_IMAGE) AND in_context(ZP_ALBUM)){
							$commentobject = $_zp_current_album;
							$redirectTo = $_zp_current_album->getAlbumLink();
						} else 	if (in_context(ZP_ZENPAGE_NEWS_ARTICLE)) {
							$commentobject = $_zp_current_zenpage_news;
							$redirectTo = FULLWEBPATH . '/index.php?p='.ZENPAGE_NEWS.'&title='.$_zp_current_zenpage_news->getTitlelink();
						} else if (in_context(ZP_ZENPAGE_PAGE)) {
							$commentobject = $_zp_current_zenpage_page;
							$redirectTo = FULLWEBPATH . '/index.php?p='.ZENPAGE_PAGES.'&title='.$_zp_current_zenpage_page->getTitlelink();
						}
						$commentadded = $commentobject->addComment($p_name, $p_email, $p_website, $p_comment,
															$code1, $code2,	$p_server, $p_private, $p_anon);
					}
					$comment_error = $commentadded->getInModeration();
					$_zp_comment_stored = array($commentadded->getName(), $commentadded->getEmail(), $commentadded->getWebsite(), $commentadded->getComment(), false,
																			$commentadded->getPrivate(), $commentadded->getAnon(), $commentadded->getCustomData());
					if (isset($_POST['remember'])) $_zp_comment_stored[4] = true;
					if (!$comment_error) {
						if (isset($_POST['remember'])) {
							// Should always re-cookie to update info in case it's changed...
							$_zp_comment_stored[3] = ''; // clear the comment itself
							zp_setcookie('zenphoto', implode('|~*~|', $_zp_comment_stored), time()+COOKIE_PESISTENCE, '/');
						} else {
							zp_setcookie('zenphoto', '', time()-368000, '/');
						}
						
						return COMMENT_SUCCESS;

					} else {
						$comment_error++;
						if ($activeImage !== false AND !in_context(ZP_ZENPAGE_NEWS_ARTICLE) AND !in_context(ZP_ZENPAGE_PAGE)) { // tricasa hack? Set the context to the image on which the comment was posted
							$_zp_current_image = $activeImage;
							$_zp_current_album = $activeImage->getAlbum();
							set_context(ZP_IMAGE | ZP_ALBUM | ZP_INDEX);
						}
					}
				}
			} else  if (!empty($cookie)) {
				// Comment form was not submitted; get the saved info from the cookie.
				$_zp_comment_stored = explode('|~*~|', stripslashes($cookie));
				$_zp_comment_stored[4] = true;
				if (!isset($_zp_comment_stored[5])) $_zp_comment_stored[5] = false;
				if (!isset($_zp_comment_stored[6])) $_zp_comment_stored[6] = false;
				if (!isset($_zp_comment_stored[7])) $_zp_comment_stored[7] = false;
			} else {
				$_zp_comment_stored = array('','','', '', false, false, false, false);
			}

			return $comment_error;
		}
	}


?>
