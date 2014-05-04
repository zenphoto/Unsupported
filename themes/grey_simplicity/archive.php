<?php if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | Archive View</title>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	
</head>

<body>
	<?php zp_apply_filter('theme_body_open'); ?>


<div id="main">
	<div id="sd-wrapper">	
	<div id="gallerytitle" style="margin-bottom: 30px;">
   		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL();?>"><?php echo getGalleryTitle();?></a>
		</span>
		<span class="albumtitle"><span>Archives</span></span>
		</h2>
	</div>
    
    <div id="padbox" class="archive-wrapper">
    	<div class="imageit" style="padding:18px; padding-top: 8px;">
			<div id="archive"><?php printAllDates($class='archive', $yearid='year', $monthid='month', $order='desc'); ?></div>
        </div>
	</div>
	</div>
</div>

<div id="credit"><?php printRSSLink('Gallery','','Gallery RSS', ' | ', false); ?> <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
