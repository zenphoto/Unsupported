<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>

<head>
	<title><?php echo getBareGalleryTitle(); ?> | Album: <?php echo getBareAlbumTitle(); ?> | Image:  | Album: <?php echo getBareImageTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<?php zp_apply_filter('theme_head'); ?>
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/css/zen.css" type="text/css" />
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/js/reflection.js"></script>
</head>
	
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="header">
	<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php echo getBareGalleryTitle(); ?>"><?php printGalleryTitle(); ?></a>
</div>
		
	<div id="wrap">
		
		<div id="content">
				
			<div class="imgnav">
					<?php if (hasPrevImage()) { ?>
					<div class="imgprevious"><a href="<?php echo getPrevImageURL();?>" title="Previous Image">&laquo; prev</a></div>
					<?php } if (hasNextImage()) { ?>
					<div class="imgnext"><a href="<?php echo getNextImageURL();?>" title="Next Image">next &raquo;</a></div>
					<?php } ?>
			</div>
			
			<div id="gallerytitle">
				<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a>
					| <a href="<?php echo getAlbumLinkURL();?>" title="Gallery Index"><?php echo getAlbumTitle();?></a>
					| </span> <?php printImageTitle(true); ?></h2>
			</div>
	
			<div id="image">
				<a href="<?php echo getImageLinkURL();?>" title="<?php echo getBareImageTitle();?>"> <?php printDefaultSizedImage(getBareImageTitle()); ?></a> 
			</div>

		</div>
		
	</div>

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

</body>

</html>
