<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>

<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php require ('chili-functions.php'); ?>
	
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

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

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

</body>
</html>
