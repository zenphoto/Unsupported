<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php require ('chili-functions.php'); ?>
	
</head>

<body>

<?php printAdminToolbox(); ?>

<div id="main">

	<div id="gallerytitle">
		<h2><?php echo getGalleryTitle(); ?></h2>
	</div>
	
	<div id="index_left">
	
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
	<?php show_pagenav(); ?>	
	</div>
	
<?php zp_footer();?>

</div>

</body>
</html>
