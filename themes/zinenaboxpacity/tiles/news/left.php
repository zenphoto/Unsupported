<?php 
	global $_zp_themeroot, $_zp_current_zenpage_news, $_zp_current_album; 
?>

<div id="album-nav" class="left opa60">
	<div class="nav-cell filler"><span>&nbsp;</span></div>
	<?php 
		$nextText = "<div id='news-nav-prev' class='news-nav-scroll opa60'><img src='$_zp_themeroot/resources/images/arrow_up.png' width='16' height='16'/></div>";
		$prevText = "<div id='news-nav-next' class='news-nav-scroll opa60 $cls'><img src='$_zp_themeroot/resources/images/arrow_down.png' width='16' height='16'/></div>";
		$prevNext = NewsUtil::printNewsNavigation($prevText, $nextText); 
	?>
	<div class="nav-cell filler end"><span>&nbsp;</span></div>
</div>

<div style="padding-left: 1px;">
	<div id="album-menu" class="opa60">
		<div id="album-thumb">
			<img src="<?= getRandomImages()->getCustomImage(NULL, 192, 48, 192, 48, NULL, null, false) ?>" width="195" height="48"/>
		</div>
	</div>

	<?= isset($prevNext['prev']) ? $prevNext['prev'] : "<div id='news-nav-prev' class='proxy'></div>"; ?>

	<div id="news-wrappers">
	<?php 
		$u= 0; 
		ThemeUtil::$script .= "var news = []; \n";
		$sel = "var initialSelection = 0;";
		$current = $_zp_current_zenpage_news;
		while ( next_news() ) :
			 if ( $current == $_zp_current_zenpage_news ) $sel = "var initialSelection = $u;";
	?>
		<div id="news-<?= $u ?>" index="<?= $u ?>" class="news-preview-wrapper opa40" titleLink="<?= $_zp_current_zenpage_news->getTitleLink() ?>">
			<div class="news-preview">
				<div class="news-preview-title">
					<span><?php printNewsTitle(); ?></span>
				</div>
				<div class="news-preview-content">
					<?= ThemeUtil::clean(getNewsContent(), FALSE, 120, FALSE); ?>
				</div>
			</div>
		</div>
	<?php 
		ThemeUtil::$script .= 'news.push({' .
	 		       '	"titleLink": \'' . $_zp_current_zenpage_news->getTitleLink() . '\',' .
	 		       '	"title": \'' . ThemeUtil::clean(getNewsTitle(), FALSE) . '\',' .
				   '	"content": \'' . ThemeUtil::clean(getNewsContent()) . '\',' .
				   '	"date": ' . zpFormattedDate("{day: %d, month:  '%b', year: %Y}", strtotime($_zp_current_zenpage_news->getDateTime())) . ', ' .
				   '	"categories": \'' . ThemeUtil::clean(NewsUtil::printNewsCategories(',', false, false), FALSE) . '\', ' .
				   '    "commentson": ' . (NewsUtil::commentsAllowed() ? "true" : "false") . "," .
				   '	"commentCount": ' . ($_zp_current_zenpage_news->getCommentCount()) .
				   '}); ' ;
		$u++; 
		endwhile;	
		ThemeUtil::$script .= $sel;
	?>
	</div>

	<?= isset($prevNext['next']) ? $prevNext['next'] : "<div id='news-nav-next' class='proxy'></div>"; ?>
	
	<div id="page-filler" class="opa20">&nbsp;</div>

</div>

<div id="workaround-non-xml-comment-crap" style="display: none;"></div>

