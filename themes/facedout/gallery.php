<?php
if (!defined('WEBPATH')) die();
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

		<div id="header">
			
		<h1><?php printGalleryTitle(); ?></h1>
		<?php if (getOption('Allow_search')) {  printSearchForm("","search","",gettext("Search gallery")); } ?>
		</div>

<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(); ?>"><strong><?php echo gettext("Home"); ?></strong></a>
	</h2>
	</div>

		
	
	<div id="sidebar">
		<?php include("sidebar-left.php"); ?>
	</div><!-- sidebar-left -->

	<div id="content-right">	
	<?php printGalleryDesc(); ?> 
			<div id="albums">
				<?php while (next_album()): ?>
					<div class="album">
							<div class="thumb" align="center">
							<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getBareAlbumTitle();?>"><?php printCustomAlbumThumbImage(getBareAlbumTitle(), NULL, 133, 133, 133, 133); ?></a>
 							 </div>
								<div class="albumdesc" align="center">
									<h3><a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
 									<?php printAlbumDate(""); ?>
									<div align="justify"><?php echo truncate_string(getAlbumDesc(), 255); ?></div>
								</div>
					</div>
				<?php endwhile; ?>
		</div>
		<br style="clear: both" />
		<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>
</div><!-- content right-->

	<div id="fb-bar">
		<?php include("rightbar.php"); ?>
	</div><!-- fb-bar -->

	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>