<?php 
	global $_zp_themeroot, $_zp_current_album;
	$albumCount = count($_zp_current_album->getSubalbums());
	$isAlbumPage = $albumCount > 0;
?>
<div id="thumbs">
	<div id="thumbs-navigation" <?= hasNextPage() ? ("next='" . getNextPageUrl() . "'") : ""?><?= hasPrevPage() ? ("prev='" . getPrevPageUrl() . "'") : ""?>>
		<div id='bar'>
			<div class="nav-cell filler"><span>&nbsp;</span></div>
			<?php AlbumUtil::printNavigation($prevText, $nextText, false, 7, true); ?>
			<div class="nav-cell filler end"><span>&nbsp;</span></div>
		</div>
	</div>
<?php 
	if ( $isAlbumPage ) : 
		$u = 0;
		while (next_album()): 
			$a = $_zp_current_album;
			$thumb = $a->getAlbumThumbImage();
			$title = $a->getTitle();
			$desc = $a->getDesc();
			$customThumb = $thumb->getCustomImage(NULL, 202, 56, 202, 56, NULL, NULL, false);
			$url = getAlbumLinkURL();
			echo "\t<div class='thumb' index='$u' title='$title' location='$customThumb' url='$url'><description>$desc</description></div>\n";
			$u++;
		endwhile; 
	else:
		$u = 0;
		while (next_image()): 
			$title = getImageTitle(); 
			$size = getSizeCustomImage(NULL, 383);
			$desc = getImageDesc();
			if ( !empty($desc) ) { 
				$desc = theme_clean($desc);
			}
			else {
				$desc = '';
			}
			$thumb = getImageThumb();
			$small = getCustomImageURL(NULL, 383);
			$full = getFullImageURL();
			$width = $size[0];
			$height = $size[1];
			$rating = $_zp_current_image->get('rating');

			echo "\t<div class='thumb' index='$u' title='$title' \n\t\twidth='$width' " . 
				 "\n\t\theight='$height' \n\t\turl='$full' \n\t\tpreviewUrl='$small'" . 
				 "\n\t\tlocation='$thumb' \n\t\trating='$rating' \n\t\tobject_id='" . $_zp_current_image->id ."'>" . 
				 "\n\t\t<description>\n\t\t\t$desc\n\t\t</description>\n\t</div>\n";
			$u++;
		endwhile;
	endif;
?>	
</div>
