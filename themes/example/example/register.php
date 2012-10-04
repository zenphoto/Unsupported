<?php if (!defined('WEBPATH')) die(); ?>
<?php
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
header('Content-Type: text/html; charset=' . getOption('charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
		<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
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

<?php printAdminToolbox(); ?>

</body>
</html>
