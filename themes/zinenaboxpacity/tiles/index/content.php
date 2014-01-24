<?php global $_zp_themeroot, $_zp_current_zenpage_news; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">
		<?= gettext("Home") ?>
	</div>
	<div class="left">
		<img id="home-icon" src="<?= PersonalityUtil::getPersonaIconURL("home", "$_zp_themeroot/resources/images/home.png") ?>" width="64" height="64"/>
		<?php PersonalityUtil::printPersonalityIconSwitcher('home'); ?>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<div>
	<div id="page-body" class="home">
		<div id="site-description" class="opa30">
			<?= getOption('simplicity2_main_page_text'); ?>
		</div>
		<div id="latest-stuff" class="opa60">
			<div id="latest-header" class="shadow"><?= gettext("Previously on") . " " . "<a style='cursor:default;'>" . getGalleryTitle() . "</a>..." ?></div>
			<div id="images" class="left">
				<?php 
					$images = AlbumUtil::getLatestImages(getOption('simplicity2_home_images_number'));
					foreach ($images as $img): 
						$thumb = $img->getCustomImage(NULL, 105, 105, 105, 105, NULL, NULL, false);
						$link = $img->getImageLink();
						echo "<div class='thumb'><a href='$link'><img src='$thumb' width='105' height='105'/></a></div>";
					endforeach;
				?>
			</div>
			
			<div id="latest-news" class="left">
			<?php 
				$n = getOption('simplicity2_home_news_number');
				if ( !isset($n) || !is_numeric($n) ) $n = 2;
				$news = getLatestNews($n); 
				foreach ( $news as $n ) : 
					$link = getNewsURL($n['titlelink']);
			?>			
				<div class="news home">
					<div class="news-header home"> 
						<!--
						<div id="news-categories-placeholder" class="right">In: <?php NewsUtil::printNewsCategories() ?></div>
						-->
						<div class="news-date-placeholder">
							<span class="left"><a href="<?= $link ?>"><?= $n['title'] ?></a></span>
							<span class="right" style="margin-top: 2px;text-align: right">
								<a href="<?= $link ?>"><img src="<?= $_zp_themeroot ?>/resources/images/chevron.png" width="12" height="12"/></a>
							</span>
						</div>
						<div class="clear"></div>
					</div>
					<div style="margin-top: 0; font-size: 9px; color: #131313;" class="opa40"><?= zpFormattedDate('%Y %b, %e', strtotime($n['date'])) ?></div>
					<div class="news-content-placeholder"><?= $n['content'] ?></div>
				</div>
			<?php endforeach; ?>
			</div>

			<div class="clear"></div>
		</div>
	</div>	
</div>



