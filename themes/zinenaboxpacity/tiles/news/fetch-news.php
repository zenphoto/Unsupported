<?php 
	global $_zp_themeroot, $_zp_current_album;

	$total = ceil(getTotalArticles() / getOption("zenpage_articles_per_page"));
	$current = getCurrentNewsPage();

	$prevUrl = NewsUtil::getPrevNewsPageURL();
	if ( $current < $total ) {
		$nextUrl = getNextNewsPageURL();
	}
?>
<div id="list">
	<div id="navigation" <?= $prevUrl ? ("next='" . $prevUrl . "'") : ""?><?= $nextUrl ? ("prev='" . $nextUrl . "'") : ""?>>
		<div id="bar">	
			<div class="nav-cell filler"><span>&nbsp;</span></div>
			<?php 
				$nextText = "<div id='news-nav-prev' class='news-nav-scroll opa60'><img src='$_zp_themeroot/resources/images/arrow_up.png' width='16' height='16'/></div>";
				$prevText = "<div id='news-nav-next' class='news-nav-scroll opa60 $cls'><img src='$_zp_themeroot/resources/images/arrow_down.png' width='16' height='16'/></div>";
				$prevNext = NewsUtil::printNewsNavigation($prevText, $nextText); 
			?>
			<div class="nav-cell filler end"><span>&nbsp;</span></div>
		</div>
		<div id="nav">
			<div class="prev"><?= isset($prevNext['prev']) ? $prevNext['prev'] : "<div id='news-nav-prev' class='proxy'></div>"; ?></div>
			<div class="next"><?= isset($prevNext['next']) ? $prevNext['next'] : "<div id='news-nav-next' class='proxy'></div>"; ?></div>
		</div>
	</div>

	<?php 
		$u= 0; 
		while ( next_news() ) : 
			$dt = strtotime(getNewsDate());  
			$commentsAllowed = NewsUtil::commentsAllowed();
	?>
		<div class='news' index="<?= $u ?>" 
			 title="<?= getNewsTitle() ?>" 
			 titleLink="<?= $_zp_current_zenpage_news->getTitleLink() ?>"
			 previewTitle="<?=printNewsTitle()?>" 
			 commentson="<?= $commentsAllowed  ? 'true' : 'false' ?>" 
			 commentCount="<?= ($_zp_current_zenpage_news->getCommentCount()) ?>">
			<div class='date' day="<?= zpFormattedDate('%e', $dt) ?>"
				  month="<?= zpFormattedDate('%b', $dt) ?>"
			      year="<?= zpFormattedDate('%Y', $dt) ?>"/>
			<div class='content'><?= getNewsContent() ?></div>
			<div class='categories'><?= ThemeUtil::clean(NewsUtil::printNewsCategories(',', false, false), FALSE) ?></div>
			<div class='preview'><?= ThemeUtil::clean(getNewsContent(), FALSE, 120, FALSE); ?></div>
		</div>
	<?php 
		$u++; 
		endwhile;	
	?>
</div>
