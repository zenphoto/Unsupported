<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?= $_zp_themeroot ?>/zen.css" type="text/css" />

</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="gallerytitle">
		<h2><?php echo getGalleryTitle(); ?></h2>
	</div>
	
	<div id="albums">
		<?php while (next_album()): ?>
		<div class="album">
			<a href="<?=getAlbumLinkURL();?>" title="View album: <?=getAlbumTitle();?>">
			<?php printAlbumThumbImage(getAlbumTitle()); ?>
			</a>
			<div class="albumdesc">
        <small><? printAlbumDate($before='Date Taken:', $nonemessage='no date', $format=null); ?></small>
				<h3><a href="<?=getAlbumLinkURL();?>" title="View album: <?=getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
				<p><?php printAlbumDesc(); ?></p>
			</div>
			<p style="clear: both; "></p>
		</div>
		<?php endwhile; ?>
	</div>
	
	<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>

</div>

<?php printZenphotoLink(); ?>

<?php 
	printAdminToolbox();
 	zp_apply_filter('theme_body_close'); 
 ?>
 
</body>
</html>
