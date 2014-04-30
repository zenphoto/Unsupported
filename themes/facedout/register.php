<?php
if (!defined('WEBPATH')) die();
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

		<div id="header">
			
		<h1><?php printGalleryTitle(); ?></h1>
		</div>

<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(); ?>"><strong><?php echo gettext("Home"); ?></strong></a>
	</h2>
	</div>

	<div id="sidebar">
		<?php include("sidebar-left.php"); ?>
	</div><!-- sidebar-left -->

	<div id="content-right">
	<h1><?php echo gettext('User Registration') ?></h1>
	<?php  printRegistrationForm();  ?>
	</div><!-- content right-->
		
	
	<div id="fb-bar">
		<?php include("rightbar.php"); ?>
	</div><!-- fb-bar -->



	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>