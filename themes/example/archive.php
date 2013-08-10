<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Archive View"); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
		<?php zp_apply_filter('theme_head'); ?>
		<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

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

<?php
zp_apply_filter('theme_body_close');
?>

</body>
</html>
