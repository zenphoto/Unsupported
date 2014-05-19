<?php 
	global $_zp_themeroot, $_zp_current_album, $_highlight_image, $_zp_current_image;
	$albumCount = count($_zp_current_album->getSubalbums());
	$imageCount = count($_zp_current_album->getImages());
	$isAlbumPage = $albumCount > 0;
	AlbumUtil::setAlbumPage($isAlbumPage);
	ThemeUtil::$script .= "var images = [], initialImageThumbSelection = 0;\n";
	$cls = $isAlbumPage ? 'album-page' : 'left image-page';
?>

<div id="album-nav" class="left opa60">
	<div class="nav-cell filler"><span>&nbsp;</span></div>
	<?php 
		$prevText = "<div id='image-nav-prev' class='image-nav-scroll opa60'><img src='$_zp_themeroot/resources/images/arrow_up.png' width='16' height='16'/></div>";
		$nextText = "<div id='image-nav-next' class='image-nav-scroll opa60 $cls'><img src='$_zp_themeroot/resources/images/arrow_down.png' width='16' height='16'/></div>";
		$prevNext = AlbumUtil::printNavigation($prevText, $nextText, false, 7, true); 
	?>
	<div class="nav-cell filler end"><span>&nbsp;</span></div>
</div>

<div style="padding-left: 1px;">
	<div id="album-menu" class="opa60">
		<div id="album-thumb">
			<img src="<?= getCustomAlbumThumb(NULL, 192, 48, 192, 48, NULL, null, false) ?>" width="195" height="48"/>
		</div>
	</div>
	
	<?php 
		$desc = getAlbumDesc(); 
		if ( !$isAlbumPage && isset($desc) && trim($desc) != '') : 
	?>
		<div id="album-description" class="opa60">
			<?= getAlbumDesc(); ?>
		</div>
	<?php endif; ?>

	
	<?php if ( $isAlbumPage ) : ?>
		<div id="album-count" class="opa60">
			<?= $albumCount . " " . ngettext('subalbum', 'subalbums', $albumCount) ?>
		</div>
		<?= $prevNext['prev'] ?>
		<div id="subalbum-thumb-container">
			<?php 
				$u = 0;
				while (next_album()): 
					$a = $_zp_current_album;
					$thumb = $a->getAlbumThumbImage();
					$title = $a->getTitle();
					$desc = $a->getDesc();
					$customThumb = $thumb->getCustomImage(NULL, 202, 56, 202, 56, NULL, NULL, false);
			?>
			<div class="subalbum-wrapper  opa60">
				<div class="subalbum-link" id="subalbum-<?= $u ?>">
					<a href="<?= getAlbumURL() ?>"><img width="202" height="56" src="<?= $customThumb ?>"/></a>
				</div>
			<?php 
					if ( isset($title) && trim($title) != '') : 
						echo "<div class='subalbum-description' id='subalbum-description-$u'>$title</div>";
						else: echo "<div class='subalbum-description' id='subalbum-description-$u'>&nbsp;</div>";
					endif;
				
					echo "</div>";			
					$u++;	 
				endwhile; 
			?>
			
			<?php 
				while ( $u < getOption('albums_per_page') ) : 
			?>
			<div class="subalbum-wrapper  opa60">
				<div class="subalbum-link empty opa20" id="subalbum-<?= $u ?>">
					<a><img width="202" height="56" src="<?= $_zp_themeroot ?>/resources/images/c.gif"/></a>
				</div>
				<div class='subalbum-description opa20' id='subalbum-description-<?= $u ?>'>&nbsp;</div>
			</div>
			<?php $u++; endwhile; ?>
			<?= $prevNext['next'] ?>
		</div>
	<?php else: ?>
		<div id="album-count" class="opa60">
			<?= $imageCount . " " . ngettext('image', 'images', $imageCount) ?>
		</div>
		<?= $prevNext['prev'] ?>
		<div id="image-thumb-container">
			<?php 
				$u = 0;
				while (next_image()): 
					$imageTitle = getImageTitle(); 
					$size = getSizeCustomImage(NULL, 383);
					$desc = getImageDesc();
					if ( !empty($desc) ) { 
						$desc = ThemeUtil::clean($desc);
					}
					else {
						$desc = '';
					}
					$rating = $_zp_current_image->get('rating');
					ThemeUtil::$script .= "images.push({" .
							   "  title: '$imageTitle', \n" . 
							   "  description: '$desc', \n" . 
							   "  location: '" . getCustomImageURL(NULL, 383) . "', \n" .
 							   "  url: '" . getFullImageURL() . "',\n" .
							   "  width: " . $size[0] . ",\n" .
							   "  height: " . $size[1] . ",\n" .
							   "  rating: " . (isset($rating) ? $rating : 0) . ", \n" .
							   "  object_id: " . $_zp_current_image->id .
							   "});\n";

					if ( isset($_highlight_image) && $_highlight_image == $_zp_current_image->filename ) :
						ThemeUtil::$script .= "initialImageThumbSelection = $u; \n";
					endif;
			?>
				<div class="image-thumb left opa60 <?= $u%2 == 0 ? 'even' : 'odd' ?>">
					<img 
						index="<?= $u ?>" 
						id="img-<?= $u ?>"
						object_id="<?= $_zp_current_image->id ?>"
						src="<?= getImageThumb() ?>" 
						width="95" height="95" />
				</div>

			<?php 
					$u++; 
				endwhile; 
				AlbumUtil::setMaxImageIndex($u - 1);
			?>
		
			<?php while ( $u < getOption('images_per_page') ) :  ?>
				<div class="image-thumb left opa20 <?= $u%2 == 0 ? 'even' : 'odd' ?>">
					<img index="<?= $u ?>" id="img-<?= $u ?>" width="95" height="95" src="<?= $_zp_themeroot ?>/resources/images/c.gif"/>
				</div>
			<?php $u++; endwhile; ?>

			<?php if ( $u%2 != 0 ) : ?>
				<div class="image-thumb left opa20 <?= $u%2 == 0 ? 'even' : 'odd' ?>">
					<a><img width="202" height="56" src="<?= $_zp_themeroot ?>/resources/images/c.gif"/></a>
				</div>
			<?php endif; ?>
			<?= $prevNext['next'] ?>
		</div>
		<div id="preloader" style="display:none;"></div>
	<?php endif; ?>
</div>
<div id="workaround-non-xml-comment-crap" style="display: none;"></div>
<div id="page-filler" class="<?= $isAlbumPage ? '' : 'images' ?> opa20" style="margin-left: 41px;">&nbsp;</div>

