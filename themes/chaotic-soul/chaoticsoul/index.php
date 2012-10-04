<?php
if (!defined('WEBPATH')) die();
$themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<?php header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo  getAlbumTitle();?> | <?php echo  getImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
</head>

<body>
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
				<a href="<?php echo getAlbumLinkURL(); ?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle()); ?></a>
			</div>
			<div class="albumdesc">
      			<? printAlbumDate("Date Taken: "); ?>
				<h2><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h2>
				<p><?php printAlbumDesc(); ?></p>
			</div>
		</div>
		<?php endwhile; ?>
	</div>

</div>
<?php printPageListWithNav("« prev", "next »"); ?>
</div>
</div>


<hr />
</div>
<?php printAdminToolbox(); ?>
</body>

</html>
