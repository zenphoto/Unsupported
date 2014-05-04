<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<?php printHeadTitle(); ?>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
</head>

<body>
	<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit albumtitle"><a href="<?php echo getGalleryIndexURL();?>"><?php echo getGalleryTitle();?></a></span>
		</h2>
	</div>
	
	<div id="padbox">
	<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-jutify: newspaper; padding: 40px 60px 40px 60px;">
		<div style="text-align:center; font-size: 15px; color: #666; font-weight: bold;padding: 20px;">
			<p>My internet ist kaputt</p>
			<p><a href="<?php echo getGalleryIndexURL();?>"><img class="rabbit" src="<?php echo $_zp_themeroot ?>/images/rabbit-500.png" /></a></p>
			<p>The rabbit smashed it</p>
		</div>
  	</div>
	</div>

	</div>
</div>

<div id="credit"><?php printRSSLink('News', '', 'News RSS', '', false); ?> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
