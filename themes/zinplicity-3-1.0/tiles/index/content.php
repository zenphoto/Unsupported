<?php global $_zp_themeroot; ?>
<div id="main-text">
	<?= getOption('simplicity3_main_text'); ?>
</div>	

<div id="latest-images">
	<?php 
		$images = Utils::getLatestImages(3);
		$cp = getCustomPageURL('rotate');
		$cp = $cp . (strpos($cp, '?') > 0 ? '&' : '?');
		for ($u = 0; $u < count($images); $u++): 
			$img = $images[$u];
			$thumb = $img->getCustomImage(NULL, 75, 75, 75, 75, NULL, NULL, false);
			$link = $img->getLink();
			echo "<span class='thumb" . ($u == count($images) - 1 ? " last" : "") . "'>" . 
				 "<img class='pin' src='$_zp_themeroot/resources/images/pin.png'/><br/>" .
 				 "<a href='$link'><img src='$thumb' width='75' height='75'/></a>" . 
			 	 "</span>";
		endfor;
	?>
	<div class="browse"><a href="<?= getGalleryIndexURL() ?>" class="gallery">Browse gallery</a></div>
</div>

<div id="latest-news">
<?php 
	$news = getLatestNews(1); 
	foreach ( $news as $n ) : 
		$link = getNewsURL($n['titlelink']);
?>			
	<div class="news">
		<div class="news-header"> 
			<div class="news-date-placeholder">
				<span class="left">Latest note: <a href="<?= $link ?>"><?= $n['title'] ?></a></span>
				<div class="opa40 right"><b>: </b><?= zpFormattedDate('%Y %b, %e', strtotime($n['date'])) ?></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="news-content-placeholder">
			<?= $n['content'] ?>
		</div>
		<div class="clear"></div>	
	</div>
<?php endforeach; ?>
	<div class="browse"><a href="<?= getCustomPageURL(ZENPAGE_NEWS) ?>" class="news">More notes</a></div>
</div>
