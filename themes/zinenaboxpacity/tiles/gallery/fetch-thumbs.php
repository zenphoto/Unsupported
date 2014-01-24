<?php 
	global $_zp_themeroot, $_zp_current_album;
	$isAlbumPage = true;
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
?>
</div>
