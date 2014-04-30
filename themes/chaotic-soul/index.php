<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo  getAlbumTitle();?> | <?php echo  getImageTitle();?></title>
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
		<h2 class="title"><?php echo getGalleryTitle(); ?></h2>
	</div>

<div id="main">

    <div id="albums">
		<?php while (next_album()): ?>

		<div class="album">
			<div class="imagethumb">
				<a href="<?php echo getAlbumURL(); ?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle()); ?></a>
			</div>
			<div class="albumdesc">
      			<? printAlbumDate("Date Taken: "); ?>
				<h2><a href="<?php echo getAlbumURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h2>
				<p><?php printAlbumDesc(); ?></p>
			</div>
		</div>
		<?php endwhile; ?>
	</div>

</div>
<?php printPageListWithNav("« prev", "next »"); ?>
</div>
<hr class="hr-bottom" />
</div>

</div>
<?php zp_apply_filter('theme_body_close'); ?>
</body>

</html>
