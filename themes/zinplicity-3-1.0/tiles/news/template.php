<?php 
	global $_zp_themeroot; 
	$dt = strtotime(getNewsDate()); 	
?>
<div class='news-holder'>	
	<div class="news-header">
		<div class="news-date">
			<img src="<?= $_zp_themeroot ?>/resources/images/calendar.png">
			<span class="year"><?= zpFormattedDate('%Y', $dt) ?></span>
			<span class="month"><?= zpFormattedDate('%b', $dt) ?></span>
			<span class="day"><?= date('jS', $dt) ?></span>
		</div>
		<div class="news-info">
			<div class="news-title"><?= getNewsTitle() ?></div>
			<div class="news-categories">In: <?php printNewsCategories(',', false, false); ?></div>
		</div>
	</div>
	<div class="news-content">
		<?php 
			$c = getNewsContent();
			if ( defined('CROP_NEWS') ):
				$c = Utils::crop($c, 200, '<p><a>', '<a href="' . getNewsURL(getNewsTitleLink()) . '">(...)</a>');
			endif;
			echo $c;
		?>
	</div>
</div>

