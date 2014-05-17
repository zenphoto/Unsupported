<?php header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT'); ?>
<!DOCTYPE html>
<head>
	<?php include_once('header.php'); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/slideshow.css" type="text/css" />
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>
	<div id="slideshowpage">
			<?php printSlideShow(true,true); ?>
	</div>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>