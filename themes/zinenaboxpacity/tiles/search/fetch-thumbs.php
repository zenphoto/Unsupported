<?php 
	global $_zp_themeroot, $_zp_current_album;
	$isAlbumPage = false;
?>
<div id="thumbs">
	<div id="thumbs-navigation" totalImages="<?= getNumImages() . ' ' . ngettext('image', 'images', getNumImages()) . ' found'?>" <?= hasNextPage() ? ("next='" . getNextPageUrl() . "'") : ""?><?= hasPrevPage() ? ("prev='" . getPrevPageUrl() . "'") : ""?>>
		<div id='bar'>
			<div class="nav-cell filler"><span>&nbsp;</span></div>
			<?php AlbumUtil::printNavigation($prevText, $nextText, false, 7, true); ?>
			<div class="nav-cell filler end"><span>&nbsp;</span></div>
		</div>
	</div>
<?php 
	$u = 0;
	while (next_image()): 
		$title = getImageTitle(); 
		$size = getSizeCustomImage(NULL, 383);
		$desc = getImageDesc();
		if ( !empty($desc) ) { 
			$desc = ThemeUtil::clean($desc);
		}
		else {
			$desc = '';
		}
		$thumb = getImageThumb();
		$small = getCustomImageURL(NULL, 383);
		$full = getFullImageURL();
		$width = $size[0];
		$height = $size[1];

		echo "\t<div class='thumb' index='$u' title='$title' \n\t\twidth='$width' " . 
			 "\n\t\theight='$height' \n\t\turl='$full' \n\t\tpreviewUrl='$small' \n\t\tlocation='$thumb'>" . 
			 "\n\t\t<description>\n\t\t\t$desc\n\t\t</description>\n\t</div>\n";
		$u++;
	endwhile;
	
?>	
</div>
