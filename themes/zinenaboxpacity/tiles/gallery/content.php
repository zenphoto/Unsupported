<?php global $_zp_themeroot; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<?php 
	$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
	$rssLinkUrl = "http://" . $host . WEBPATH . "/rss.php?lang=" . $lang;
?>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">
		<?= gettext("Gallery") ?>
	</div>
	<div class="left">
		<a href="<?= $rssLinkUrl ?>" rel="nofollow">
			<img id='gallery-rss-icon' src="<?= PersonalityUtil::getPersonaIconURL("rss", "$_zp_themeroot/resources/images/rss.png") ?>" width="64" height="64"/>
		</a>
		<?php PersonalityUtil::printPersonalityIconSwitcher('rss', 'gallery-rss-icon'); ?>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<?php AlbumUtil::printCollage(); ?>

<div>
	<div id="page-body">
		<div id="site-description" class="gallery opa30">
			<?php printGalleryDesc(); ?>
		</div>
	</div>	
</div>


<div id="content-filler" class="gallery opa20" <?= getOption('simplicity2_printcollage') ? "" : "style='background-color: transparent'" ?>></div>



