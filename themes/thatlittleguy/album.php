<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
</head>

<body>

<div id="main">

	<?php printAdminToolbox(); ?>

	<div id="gallerytitle">
		<h2><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | <?php printAlbumTitle(true);?></h2>
	</div>

	<div id="album_desc_interior">
	<?php printAlbumDesc(true); ?>
	</div>

	<div id="albums">
		<?php while (next_album()): ?>
		<div class="album">
			<div class="albumtitle">
				<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
			</div>

			<div id="album_box">
				<div id="album_position"><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle()); ?></a></div>
			</div>

			<div class="albumdesc">
				<? printAlbumDate("Date Taken: "); ?>
				<p><?php printAlbumDesc(); ?></p>
			</div>
			<p style="margin:0px;padding:0px;clear: both; ">&nbsp;</p>
		</div>
		<?php endwhile; ?>
	</div>

    <div id="images_tlg">
		<?php while (next_image()): ?>

		<div class="image">
			<div id="image_box">
			<div id="image_position">
			<a href="<?php echo getImageLinkURL();?>" title="<?php echo getImageTitle();?>"><?php printImageThumb(getImageTitle()); ?></a>
			</div>
			</div>
		</div>


		<?php endwhile; ?>
	<p style="margin:0px;padding:0px;clear: both; ">&nbsp;</p>
	</div>

	<?php printPageListWithNav("« prev", "next »"); ?>

</div>

<div id="credit"><?php
	if (zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
	}
?>Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
