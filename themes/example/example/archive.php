<?php if (!defined('WEBPATH')) die(); ?>
<?php
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
header('Content-Type: text/html; charset=' . getOption('charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Archive View"); ?></title>
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
		<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
<div id="main">
		<div id="gallerytitle">
			<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo getGalleryTitle();?></a></span> | <?php echo gettext("Archive View"); ?>
		<?php if (getOption('Allow_search')) {  printSearchForm(); } ?></h2>
		</div>

		<hr />

		<div id="archive"><?php printAllDates(); ?></div>
	<div id="tag_cloud">
			<p><? echo gettext('Popular Tags'); ?></p>
		<?php printAllTagsAs('cloud', 'tags'); ?>
	</div>

	<div id="credit"><?php printRSSLink('Gallery','','RSS', ' | '); ?> 
	<?php printZenphotoLink(); ?>
		<?php
	if (function_exists('printUserLogin_out')) {
		printUserLogin_out(" | ");
	}
	?>
</div>

</div>

<?php printAdminToolbox(); ?>

</body>
</html>
