<?php if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('2', '5');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Search"); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
	<?php printZDSearchToggleJS(); ?>
	<?php printZDRoundedCornerJS(); ?>
</head>
<body>
<div id="main">
		<?php include("header.php"); ?>
        
<div id="breadcrumb">
<?php 
    $numimages = getNumImages();
		$numalbums = getNumAlbums();
		$total = $numimages + $numalbums;
        $zenpage = getOption('zp_plugin_zenpage');
		if ($zenpage && !isArchive()) {
			$numpages = getNumPages();
			$numnews = getNumNews();
			$total = $total + $numnews + $numpages;
		} else {
			$numpages = $numnews = 0;
		}
?>
		<h2><a href="<?php echo getGalleryIndexURL(false);?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Index"); ?></a> &raquo; <?php echo gettext("Search"); ?> &raquo; <strong><?php echo getSearchWords(); ?></strong> (<?= $total ?> results)
			</h2>
			</div>

		<div id="content">
		<div id="content-left">
		<?php
		
		$searchwords = getSearchWords();
		$searchdate = getSearchDate();
		if (!empty($searchdate)) {
			if (!empty($searchwords)) {
				$searchwords .= ": ";
			}
			$searchwords .= $searchdate;
		}
		if ($total > 0 ) {
			?>
			
			<?php
		}
		if ($_zp_page == 1) { //test of zenpage searches
			if ($numpages > 0) {
				$number_to_show = 5;
				$c = 0;
				?>
				<hr />
				<h3 class="searchheader"><?php printf(gettext('Pages (%s)'),$numpages); ?> <small><?php	printZDSearchShowMoreLink("pages",$number_to_show); ?></small></h3>
					<ul class="searchresults">
					<?php
					while (next_page()) {
						$c++;
						?>
						<li<?php printZDToggleClass('pages',$c,$number_to_show); ?>>
						<h4><?php printPageTitlelink(); ?></h4>
							<p class="zenpageexcerpt"><?php echo shortenContent(strip_tags(getPageContent()),80,getOption("zenpage_textshorten_indicator")); ?></p>
						</li>
						<?php
					}
					?>
					</ul>
				<?php
				}
			if ($numnews > 0) {
				$number_to_show = 3;
				$c = 0;
                $art = 'article';
                if ( $numnews > 1 ) $art .= 's' 
				?>
                
				<h3 class="searchheader"><?php printf(gettext('%s ' . $art . ' found'),$numnews); ?> </h3>
                    <div style="text-align: right; margin-right: 20px;" class="moreresults"><small><?php	printZDSearchShowMoreLink("news",$number_to_show); ?></small></div>
					<ul class="searchresults news">
					<?php
					while (next_news()) {
						$c++;
						?>
						<li<?php printZDToggleClass('news',$c,$number_to_show); ?>>
						<h4><?php printNewsTitleLink(); ?></h4>
							<p class="zenpageexcerpt"><?php echo shortenContent(strip_tags(getNewsContent()),80,getOption("zenpage_textshorten_indicator")); ?></p>
						</li>
						<?php
					}
					?>
					</ul>
				<?php
				}
			}
			?>
			<h3 class="searchheader imgresults">
			<?php		
                $alb = 'album'; $imgs = 'image';
                if ( $numalbums > 1 ) $alb .= 's';
                if ( $numimages > 1 ) $imgs .= 's';
				if (getOption('search_no_albums')) {
					if (!getOption('search_no_images') && ($numpages + $numnews) > 0) {
						printf(gettext('%s ' . $imgs . ' found'),$numimages);
					}
				} else {
					if (getOption('search_no_images')) {
						if (($numpages + $numnews) > 0) {
							printf(gettext('%s ' . $alb . ' found'),$numalbums);
						}
					} else {
						printf(gettext('%1$s ' . $alb . ' and %2$s ' . $imgs . ' found'),$numalbums,$numimages);
					}
				}
			?>
			</h3>
		<?php if (getNumAlbums() != 0) { $u = 0; ?>
			<div id="albums">
				<?php while (next_album()): $u++; ?>
					<div class="album" <?php if ( $u%2 == 0 ) { echo 'style="margin-left: 8px;"'; } ?>>
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
			<?php } ?>
<?php if (getNumImages() > 0) { $u=0;?>
			<div id="images">
				<?php while (next_image(false, $firstPageImages)): $c++; $u++;?>
				<div class="image">
					<div class="imagethumb"><a href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getBareImageTitle()); ?></a></div>
				</div>
				<?php endwhile; ?>
                <?php while ( $u%5 != 0 ) : $u++;?>
            <div class="imagethumb"><a><img style="width: 88px; height: 88px;  border: 1px #efefef solid;" src="<?= $_zp_themeroot ?>/images/trans.png"/></a></div>
            <?php endwhile ?>
			</div>
		<br clear="all" />
<?php } ?>
		<?php
		if (function_exists('printSlideShowLink')) { echo '<div id="slideshowlink" class="search">'; printSlideShowLink(gettext('View Slideshow')); echo '</div>'; }
		if ($total == 0) {
				echo "<p>".gettext("Sorry, no matches found. Try refining your search.")."</p>";
			}

			printPageListWithNav("&laquo; ".gettext("prev"),gettext("next")." &raquo;");
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