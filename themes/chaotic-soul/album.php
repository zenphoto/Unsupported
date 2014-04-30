<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo  getAlbumTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
</head>


<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="page">
<?php include("header.php") ?>

<div id="wrapper" class="clearfix">
	<div id="content" class="widecolumn">
	<div id="post">
		<h2 class="title"><span><a href="<?php echo  getGalleryIndexURL();?>" title="Gallery Index"><?php echo  getGalleryTitle();?></a> | </span> <?php printAlbumTitle(true);?></h2>
	</div>
	</div>
<div id="main">

	<p class="albumdesc2"><?php printAlbumDesc(true); ?></p>

    <div id="albums"><!-- subalbums -->
		<?php while (next_album()): ?>

		<div class="album">
			<div class="imagethumb">
				<a href="<?php echo  getAlbumURL();?>" title="View album: <?php echo  getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle()); ?></a>
			</div>
			<div class="albumdesc">
      			<? printAlbumDate("Date Taken: "); ?>
				<h2><a href="<?php echo  getAlbumURL();?>" title="View album: <?php echo  getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h2>
				<p><?php printAlbumDesc(); ?></p>
			</div>
		</div>
		<?php endwhile; ?>
	</div>

	<div id="zpimages">
		<?php while (next_image()): ?>
		<div class="zpimage">
			<div class="imagethumb"><a href="<?php echo getImageURL();?>" title="<?php echo getImageTitle();?>"><?php printImageThumb(getImageTitle()); ?></a></div>
		</div>
		<?php endwhile; ?>
	</div>

	<?php printPageListWithNav("« " . gettext("prev"), gettext("next") . " »"); ?>


</div>
<hr class="hr-bottom" />
</div>

</div>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
