<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
		<div id="gallerytitle">
		<h2>
		<?php printHomeLink('', ' | '); ?>
		<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo gettext('Gallery Index');?></a> | 
		<em><?php echo gettext('Register'); ?></em>
		</h2>
		</div>
		
		<h2><?php echo gettext('User Registration') ?></h2>
		<?php  printRegistrationForm();  ?>

		<?php if (function_exists('printLanguageSelector')) { printLanguageSelector(); } ?>

		<div id="credit"> 
		<?php printZenphotoLink(); ?>
		</div>
</div>

<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>
