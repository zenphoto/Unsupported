<?php
if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('2', '5');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
	<?php printZDRoundedCornerJS(); ?>
</head>
<body>

<div id="main">

		<?php include("header.php"); ?>

<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(false);?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Index"); ?></a>&raquo; <strong><?php echo gettext("Gallery"); ?></strong></a>
	</h2>
	</div>

	<div id="content-left">	
	<?php if(!getOption("zenpage_zp_index_news") OR !function_exists("printNewsPageListWithNav")) { ?>
        <div class="gallerydesc" style="margin-right: 20px; margin-left: 2px;"><?php printGalleryDesc(); ?> </div>
			<div id="albums">
                <?php $u = 0; ?>
				<?php while (next_album()): $u++; ?>
					<div class="album">
						<div class="thumb">
					<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php getBareAlbumTitle();?>"><?php printCustomAlbumThumbImage(getBareAlbumTitle(), NULL, 255, 75, 255, 75); ?></a>
						</div>
				<div class="albumdesc">
					<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
						<h3 class="date"><?php printAlbumDate("", "", "%B %Y"); ?></h3>
					<!-- p><?php echo truncate_string(getAlbumDesc(), 45); ?></p --></h3>
				</div>
				<p style="clear: both; "></p>
			</div>
			<?php endwhile; ?>
            <?php while ( $u%2 != 0 ) : $u++;?>
            <div class="album">
                <div class="thumb"><a><img style="width: 255px; height: 75px;"src="<?= $_zp_themeroot ?>/images/trans.png" /></a></div>
                <div class="albumdesc">
					<h3 style="color: transparent;">No album</h3>
					<h3 class="date" style="color: transparent;">No Date</h3>
				</div>
            </div>
            <?php endwhile ?>
		</div>
		<br style="clear: both" />
		<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;"); ?>

	<?php } else { // news article loop
printNewsPageListWithNav(gettext('next &raquo;'), gettext('&laquo; prev')); 
echo "<hr />";	
while (next_news()): ;?> 
 <div class="newsarticle"> 
    <h3><?php printNewsTitleLink(); ?><?php echo " <span class='newstype'>[".getNewsType()."]</span>"; ?></h3>
        <div class="newsarticlecredit"><span class="newsarticlecredit-left"><?php printNewsDate();?> | <?php echo gettext("Comments:"); ?> <?php echo getCommentCount(); ?></span>
<?php
if(is_GalleryNewsType()) {
	if(!is_NewsType("album")) {
		echo " | ".gettext("Album:")."<a href='".getNewsAlbumURL()."' title='".getBareNewsAlbumTitle()."'> ".getNewsAlbumTitle()."</a>";
	} else {
		echo "<br />";
	}
} else {
	printNewsCategories(", ",gettext("Categories: "),"newscategories");
	
}
?>
</div>
    <?php printNewsContent(); ?>
    <p><?php printNewsReadMoreLink(); ?></p>
    <?php printCodeblock(1); ?>
    <?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); ?>
    </div>	
<?php
  endwhile; 
  printNewsPageListWithNav(gettext('next &raquo;'), gettext('&laquo; prev'));
} ?> 

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