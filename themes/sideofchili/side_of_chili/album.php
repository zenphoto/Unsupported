<?php
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php include ('chili-functions.php'); ?>
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<div id="main">

<?php printAdminToolbox(); ?>

	<div id="gallerytitle">
		<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | </span> <?php printAlbumTitle(true);?></h2>
	</div>

	<?php zp_side_bar();?>

	<div id="album_left">

		<div id="albums">
		<?php while (next_album()): ?>
			<div class="index_list">
				<div class="imagethumb">
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle()); ?></a>
				</div>
				<div class="albumdesc">
					<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
					<span><? echo getNumImages();?> Pictures</span>
					<p><?php printAlbumDesc(); ?></p>
				</div>
			</div>
		<?php endwhile; ?>
		</div>

		<?php while (next_image()): ?>
		<div class="image_list">
				<div class="imagethumb">
					<a href="<?php echo getImageLinkURL();?>" title="<?php echo getImageTitle();?>"><?php printImageThumb(getImageTitle()); ?></a>
				</div>
		</div>
		<?php endwhile; ?>
        <?php show_pagenav(); ?>
	</div>


<?php zp_footer();?>
</div>
</body>
</html>
