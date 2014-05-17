<?php if (!defined('WEBPATH')) die(); ?>
<?php header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT'); ?>
<!DOCTYPE html>
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.gettext('Register')); ?>" />
		<meta name="description" content="<?php echo html_encode(getMainSiteName().' / '.gettext('Register')); ?>" />
		<title><?php echo strip_tags(getMainSiteName().' / '.gettext('Register')); ?></title>
		<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
	</head>
	<body id="gallery-register">
	<?php zp_apply_filter('theme_body_open'); ?>
		<div id="wrapper">
			<div id="header">
				<ul class="path c">
					<?php if ( getMainSiteURL() ) { ?>
						<li><h1><a href="<?php echo getMainSiteURL(); ?>"><?php echo getMainSiteName(); ?></a></h1></li>
					<?php } ?>
					<li><h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo getGalleryTitle(); ?></a></h2></li>
					<li><h3><a><?php echo gettext('Register')  ?></a></h3></li>
				</ul>
			</div>
			<div id="content" class="c">
				<div class="box register">
					<h2><?php echo gettext('User Registration') ?></h2>
					<?php  printRegistrationForm();  ?>
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
