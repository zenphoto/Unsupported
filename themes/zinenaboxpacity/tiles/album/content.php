<?php global $_zp_themeroot, $_zp_current_album; ?>
<div id="content-top-filler" class="opa20">
	<div id="rating-wrapper" class="opa60">
		<?php 
			if ( getOption('simplicity2_rate_images') &&  count($_zp_current_album->getSubAlbums()) == 0 ) {
				RatingOverride::printRating();
			}
			else {
				echo "&nbsp;";
			}
		?>
	</div>
	<div class="clear"></div>
</div>

<?php 
	$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
	$rssLinkUrl = "http://" . $host . WEBPATH . "/rss.php?albumtitle=" . urlencode(getAlbumTitle()) . 
                  "&amp;albumname=" . urlencode($_zp_current_album->getFilename()) . "&amp;lang=" . $lang; 
?>
<div id="image-title" class="clear <?= count($_zp_current_album->getSubalbums()) > 0 ? "opa60" : "opa80" ?> shadow">
	<div id="image-title-placeholder" class="right"></div>
	<div class="left">
		<a href="<?= $rssLinkUrl ?>" rel="nofollow">
			<img id='album-rss-icon' src="<?= PersonalityUtil::getPersonaIconURL("rss", "$_zp_themeroot/resources/images/rss.png") ?>" width="64" height="64"/>
		</a>
		<?php PersonalityUtil::printPersonalityIconSwitcher('rss', 'album-rss-icon'); ?>
	</div>
	<div class="text left">
		<span>
			<?php if ( !is_null($_zp_current_album->getParent()) ) : printParentBreadcrumb('<em class="wrap">', '</em><em class="wrap">', '</em>'); endif; ?>
			<em class="wrap"><?= getAlbumTitle() ?></em>
		</span>
	</div>
	<div class="clear"></div>
</div>

<?php 
	if ( count($_zp_current_album->getSubalbums()) > 0 ) :
		$desc = getAlbumDesc(); 
		if ( !isset($desc) || trim($desc) == '') : 
			$desc = getOption('simplicity2_no_album_description_text');
		endif;
?>
	<?php AlbumUtil::printCollage(); ?>

	<div id="site-description" class="album opa30">
		<?= $desc ?>
	</div>

<?php 
	else:
?>


<div id="image-wrap-scroll">
	<div>
		<div id="image-wrapper">
			<div id="image-full-preview-container" class="opa80"></div>
		</div>	
	</div>

	<div id="scroller" class="opa80">
		<img id="left-scroll" src="<?= $_zp_themeroot ?>/resources/images/arrow_left_32.png" style="margin-right: 3px;"/>
		<img id="right-scroll" src="<?= $_zp_themeroot ?>/resources/images/arrow_right_32.png" />
	</div>
</div>

<div id="image-description" class="opa30"></div>
<?php 
	endif; 
?>

<div id="content-filler" class="opa20"></div>
