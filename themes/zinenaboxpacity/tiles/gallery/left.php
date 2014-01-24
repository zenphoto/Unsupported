<?php 
	global $_zp_themeroot, $_zp_current_album, $_zp_gallery;
	$isAlbumPage = true;
	AlbumUtil::setAlbumPage($isAlbumPage);
	ThemeUtil::$script .= "var images = [], initialImageThumbSelection = 0;\n";
	$cls = 'album-page';
	$albumCount = getNumAlbums(false, true)
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
			<img src="<?= getRandomImages()->getCustomImage(NULL, 192, 48, 192, 48, NULL, null, false) ?>" width="195" height="48"/>
		</div>
	</div>
	<div id="album-count" class="opa60">
		<?= $albumCount . " " . ngettext('album', 'albums', $albumCount) ?>
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
				<a href="<?= getAlbumLinkURL() ?>"><img width="202" height="56" src="<?= $customThumb ?>"/></a>
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
		
</div>

<div id="workaround-non-xml-comment-crap" style="display: none;"></div>

<div id="page-filler" class="opa20" style="margin-left: 41px;">&nbsp;</div>


