<?php if (!defined('WEBPATH')) die();
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareAlbumTitle(); ?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

		<div id="header">
		<h1><?php echo getGalleryTitle();?></h1>
			<?php if (getOption('Allow_search')) {
				$album_list = array('albums'=>array($_zp_current_album->name),'pages'=>'0', 'news'=>'0');
				printSearchForm(NULL, 'search', NULL, gettext('Search album'), NULL, NULL, $album_list);
			} ?>
		</div>

<div id="content">

	<div id="breadcrumb">
<h2><a href="<?php echo html_encode(getGalleryIndexURL());?>" title="<?php echo gettext('Index'); ?>"><?php echo gettext("Home"); ?></a>	» <?php printParentBreadcrumb(""," » "," » "); ?><strong><?php printAlbumTitle(true);?></strong></h2>
</div>

	<div id="sidebar">
		<?php include("sidebar-left.php"); ?>
	</div><!-- sidebar-left -->

	<div id="content-right">
	<div><p><?php printAlbumDesc(true); ?></p></div>
<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>
			<div id="albums">
			<?php if($_zp_current_album->name == "audiovideo") {
				flowplayerPlaylist("playlist","audiovideo/audiovideo1");
				flowplayerPlaylist("playlist","audiovideo/bosnervos-demos");
			}

			?>
			<?php while (next_album()): ?>
			<div class="album">
				<div class="thumb" align="center">
					<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View album:'); ?> <?php getBareAlbumTitle();?>"><?php printCustomAlbumThumbImage(getBareAlbumTitle(), NULL, 133, 133, 133, 133); ?></a>
						</div>
				<div class="albumdesc" align="center">
					<h3><a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
						<?php printAlbumDate(""); ?>
<div align="justify"><?php echo truncate_string(getAlbumDesc(), 255); ?></div>
				</div>
				<p style="clear: both; "></p>
			</div>
			<?php endwhile; ?>
		</div>

			<div id="images">
			<?php while (next_image()): ?>
			<div class="image">
				<div class="imagethumb"><a href="<?php echo html_encode(getImageURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getBareImageTitle()); ?></a></div>
			</div>
			<?php endwhile; ?>

		</div>
				<p style="clear: both; "></p>
		<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); ?>
		<br style="clear:both;" /><br />
	<?php if (function_exists('printSlideShowLink')) {
			echo '<span id="slideshowlink">';
			printSlideShowLink(gettext('View Slideshow'));
			echo '</span>';
		}
		?>
	<br style="clear:both;" />
	<?php if (function_exists('zenFBComments')) { zenFBComments(); } ?>

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