<?php if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('2', '5'); 
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareAlbumTitle(); ?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
	<?php printZDRoundedCornerJS(); ?>
</head>
<body>

<div id="main">

		<?php include("header.php"); ?>
<div id="content">

	<div id="breadcrumb">
<h2><a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Index'); ?>"><?php echo gettext("Index"); ?></a>	&raquo; <a href="<?php echo htmlspecialchars(getCustomPageUrl('gallery'));?>" title="<?php echo gettext('Gallery'); ?>"><?php echo gettext("Gallery"); ?></a>
<?php printParentBreadcrumb(" &raquo; "," &raquo; "," &raquo; "); ?><strong><?php printAlbumTitle(true);?></strong></h2>
</div>

	<div id="content-left">
	<?php $gd = getAlbumDesc(); if ( !empty($gd) ) { ?><div class="gallerydesc"><?php printAlbumDesc(true); ?></div><?php } ?>
			<div id="albums">
            <?php $u = 0; ?>
			<?php while (next_album()): $u++ ?>
			<div class="album" <?php if ( $u%2 == 0 ) { echo 'style="margin-left: 8px;"'; } ?> > 
						<div class="thumb">
					<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php getBareAlbumTitle();?>"><?php printCustomAlbumThumbImage(getBareAlbumTitle(), NULL, 255, 75, 255, 75); ?></a>
						</div>
				<div class="albumdesc">
					<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
						<h3 class="date"><?php printAlbumDate(""); ?></h3>
					<!-- p><?php echo truncate_string(getAlbumDesc(), 45); ?></p --></h3>
				</div>
				<p style="clear: both; "></p>
			</div>
			<?php endwhile; ?>
            <?php while ( $u%2 != 0 ) : $u++;?>
            <div class="album" style="margin-left: 8px;">
                <div class="thumb"><a><img style="width: 255px; height: 75px;  border: 1px #efefef solid;" src="<?= $_zp_themeroot ?>/images/trans.png" /></a></div>
                <div class="albumdesc">
					<h3 style="color: transparent;">No album</h3>
					<h3 class="date" style="color: transparent;">No Date</h3>
				</div>
            </div>
            <?php endwhile ?>
		</div>

			<div id="images">
            <?php $u = 0; ?>
			<?php while (next_image(false, $firstPageImages)): $u++; ?>
			<div class="image">
				<div class="imagethumb"><a href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getBareImageTitle()); ?></a></div>
			</div>
			<?php endwhile; ?>
            <?php while ( $u%5 != 0 ) : $u++;?>
            <div class="imagethumb"><a><img style="width: 88px; height: 88px;  border: 1px #efefef solid;" src="<?= $_zp_themeroot ?>/images/trans.png"/></a></div>
            <?php endwhile ?>
		</div>
				<p style="clear: both; "></p>
		<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;"); ?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); ?>
		<br style="clear:both;" /><br />
	<?php if (function_exists('printSlideShowLink')) {
			echo '<span id="slideshowlink">';
			printSlideShowLink(gettext('View Slideshow')); 
			echo '</span>';
		}
		?>
	<br style="clear:both;" />
	<?php if (function_exists('printRating')) { printRating(); }?>
	<?php
	if (function_exists('printCommentForm')) {
		?>
		<div id="comments">
			<?php printCommentForm(); ?>
		</div>
		<?php
	}
	?>


	</div><!-- content left-->
	
	
	
	<div id="sidebar">
		<?php include("sidebar.php"); ?>
	</div><!-- sidebar -->



	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php printAdminToolbox(); ?>
</body>
</html>