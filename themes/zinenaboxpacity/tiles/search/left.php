<?php 
	global $_zp_themeroot, $_zp_current_search, $_highlight_image, $_zp_current_image;
	$imageCount = isset($_zp_current_search) ? count($_zp_current_search->getImages()) : 0;
	AlbumUtil::setAlbumPage(false);
	ThemeUtil::$script .= "isAlbumPage = false;\n";
	ThemeUtil::$script .= "var images = [], initialImageThumbSelection = 0;\n";
	$cls = $isAlbumPage ? 'album-page' : 'left image-page';
?>

<div id="album-nav" class="left opa60">
	<div class="nav-cell filler"><span>&nbsp;</span></div>
	<?php 
		$prevText = "<div id='image-nav-prev' class='image-nav-scroll opa60'><img src='$_zp_themeroot/resources/images/arrow_up.png' width='16' height='16'/></div>";
		$nextText = "<div id='image-nav-next' class='image-nav-scroll opa60 $cls'><img src='$_zp_themeroot/resources/images/arrow_down.png' width='16' height='16'/></div>";
		if ( !in_context(ZP_SEARCH) ):
			$_zp_current_search = new SearchEngine();
			set_context(ZP_SEARCH);				
		endif;		
		$prevNext = AlbumUtil::printNavigation($prevText, $nextText, false, 7, true); 
	?>
	<div class="nav-cell filler end"><span>&nbsp;</span></div>
</div>

<div style="padding-left: 1px;">
	<div id="album-menu" class="opa60">
		<div id="album-thumb">
			<img src="<?= getRandomImages()->getCustomImage(NULL, 192, 48, 192, 48, NULL, null, false) ?>" width="195" height="48"/>
		</div>
	</div>

	<div id="search-tabs" class="shadow">
		<span class="active opa60"><?= gettext('Images') ?></span> 
		<span class="opa20"><?= gettext('Albums') ?></span> 
		<span class="opa20"><?= gettext('News') ?></span> 
	</div>

	<div id="album-count" class="opa60">
		<?= $imageCount . " " . (ngettext('image', 'images', $imageCount)) ?> found
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
				ThemeUtil::$script .= "images.push({" .
						   "  title: '$imageTitle', \n" . 
						   "  description: '$desc', \n" . 
						   "  location: '" . getCustomImageURL(NULL, 383) . "', \n" .
						   "  url: '" . getFullImageURL() . "',\n" .
						   "  width: " . $size[0] . ",\n" .
						   "  height: " . $size[1] . "\n" .
						   "});\n";

				if ( isset($_highlight_image) && $_highlight_image == $_zp_current_image->filename ) :
					ThemeUtil::$script .= "initialImageThumbSelection = $u; \n";
				endif;
		?>
			<div class="image-thumb left opa60 <?= $u%2 == 0 ? 'even' : 'odd' ?>">
				<img 
					index="<?= $u ?>" 
					id="img-<?= $u ?>"
					src="<?= getImageThumb() ?>" 
					width="95" height="95" />
			</div>

		<?php 
				$u++; 
			endwhile; 
			AlbumUtil::setMaxImageIndex($u > 0 ? $u : 0);
		?>
	
		
		<?php 
			//if ( $imageCount > 0 ) :
				while ( $u < getOption('images_per_page') ) :  
		?>
				<div class="image-thumb left opa20 <?= $u%2 == 0 ? 'even' : 'odd' ?>">
					<img index="<?= $u ?>" id="img-<?= $u ?>" width="95" height="95" src="<?= $_zp_themeroot ?>/resources/images/c.gif"/>
				</div>
		<?php 
					$u++; 
				endwhile; 
			//endif;
		?>

		<?php if ( $u%2 != 0 ) : ?>
			<div class="image-thumb left opa20 <?= $u%2 == 0 ? 'even' : 'odd' ?>">
				<a><img width="202" height="56" src="<?= $_zp_themeroot ?>/resources/images/c.gif"/></a>
			</div>
		<?php endif; ?>
		<?= $prevNext['next'] ?>
	</div>
	
	
</div>

<div id="workaround-non-xml-comment-crap" style="display: none;"></div>
<div id="page-filler" class="images opa20" style="margin-left: 41px;">&nbsp;</div>


