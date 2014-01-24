<?php global $_zp_themeroot, $_zp_current_zenpage_news; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<?php 
	$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
	$rssLinkUrl = "http://" . $host . WEBPATH . "/rss-news.php?lang=" . $lang;
?>
<div id="image-title" class="news opa60 shadow">
	<div id="image-title-placeholder" class="news right">&nbsp;</div>
	<div class="left">
		<a href="<?= $rssLinkUrl ?>" rel="nofollow">
			<img id='news-rss-icon'
				 src="<?= PersonalityUtil::getPersonaIconURL("rss", "$_zp_themeroot/resources/images/rss.png") ?>" width="64" height="64"/>
		</a>
		<?php PersonalityUtil::printPersonalityIconSwitcher('rss', 'news-rss-icon'); ?>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<div>
	<div id="page-body" class="news">
		<div class="opa60">
			<div id="news-header" class="shadow">
				<div id="news-categories-placeholder" class="right"></div>
				<div id="news-date-placeholder" class="left"></div>
				<div class="clear"></div>
			</div>
			<div id="news-content-placeholder">&nbsp;</div>
		</div>
		<?php if (function_exists('printCommentForm')) : ?>
		<div>
			<div id="news-comments" style="display: none;">
				<div id="news-comment-header" class="shadow opa60">
					<div id="news-comment-control" class="right">
						<img class="control" src="<?= $_zp_themeroot ?>/resources/images/arrow_left.png" width="12"/>
					</div>			
					<div id="news-comment-count" class="left">
						<span class="count"></span>
						<span class="singular"><?= gettext("Comment so far") ?></span>
						<span class="plural"><?= gettext("Comments so far") ?></span>
					</div>
					<div class="clear"></div>
				</div>
				<div id="loaded-comments"></div>
			</div>
		</div>
		<?php endif; ?>
	</div>	
</div>


