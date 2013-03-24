<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>
<head>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="gallerytitle">
		<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?><?php printAlbumTitle(); ?></span></h2>
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
	if (!zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
	}
?><?php printZenphotoLink(); ?></div>

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

</body>
</html>
