<?php
	setOption('thumb_size', 376, false);
	setOption('thumb_crop_width', 376, false);
	setOption('thumb_crop_height', 140, false);
	setOption('albums_per_page', 9, false);
	setOption('albums_per_row', 3, false);
?>
<!DOCTYPE html>
<html>
    <head>
		<?php zp_apply_filter('theme_head'); ?>
        <title><?php echo getBareGalleryTitle(); ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/reset.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/text.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/1200_15_col.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/css/theme.css" type="text/css" media="screen" />
    </head>
    <body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div class="container_15">
			<div id="header" class="grid_15">
				<?php if (function_exists('printLanguageSelector')) { echo '<div class="languages grid_5">'; printLanguageSelector(true); echo '</div>'; } ?>
				<?php printLoginZone();	?>
				<h1><?php echo getBareGalleryTitle(); ?></h1>
			</div>
			<div class="clear"></div>
			<div id="menu">
				<div id="m_search" class="grid_8">
					<?php printSearchForm(''); ?>
				</div>
				<?php printMenu(); ?>
			</div>
			<div class="clear"></div>
			<div id="content">
				<ul class="gallery">
					<?php while (next_album()): ?>
					<li class="grid_5">
						<a href="<?php echo getAlbumLinkUrl(); ?>" title="<?php echo getAnnotatedAlbumTitle(); ?>">
							<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?>
						</a>
						<span class="title">
							<?php echo getAnnotatedAlbumTitle(); ?> 
							<span class="italic">
								[<?php printf(ngettext('%u image', '%u images', getNumImages()), getNumImages()); ?>]
							</span><br />
							<?php echo getAlbumDate("(%d/%m/%Y)"); ?>
						</span>
					</li>
					<?php endwhile; ?>
				</ul>
				<div class="clear"></div>
				<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;", false, true, 'pagelist', null, true, 5); ?>
			</div>
			<div id="footer" class="grid_15">
				<?php printFooter(); ?>
			</div>
		</div>
		<?php zp_apply_filter('theme_body_close'); ?>
    </body>
</html>
