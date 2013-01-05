<?php
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php zp_apply_filter('theme_head'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/scripts/BubbleTooltips.js"></script>
	<script type="text/javascript">
		window.onload=function(){enableTooltips()};
	</script>

</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="main">
	<?php printAdminToolbox(); ?>

	<div id="gallerytitle">
		<h2 id="title"><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a></h2>

		<h2 id="titlesub">Welcome to my gallery</h2>
	</div>

	<div id="albums">
		<?php while (next_album()): ?>
		<div class="album" onclick="location.href='<?php echo getAlbumLinkURL();?>';">
			<a href="<?php echo getAlbumLinkURL();?>" title="View album <?php echo getAlbumTitle();?>">
			<?php printAlbumThumbImage(getAlbumTitle()); ?>
			</a>
			<div class="albumdesc">
        <small><? printAlbumDate("Date Taken: "); ?></small>
				<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
				<p><?php printAlbumDesc(); ?></p>
			</div>
			<p style="clear: both; "></p>
		</div>
		<?php endwhile; ?>
	</div>

	<div class="center">
		<?php printPageListWithNav("« prev", "next »"); ?>
	</div>


</div>

<div id="credit">Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>
<br />
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
