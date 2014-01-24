<?php if (!defined('WEBPATH')) die(); normalizeColumns(3, 5); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?> | Archive View</title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	<?php zenJavascript(); ?>
</head>

<body>
<?php printAdminToolbox(); ?>

<div id="main">
	<div id="sd-wrapper">	
	<div id="gallerytitle" style="margin-bottom: 30px;">
   		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL(false);?>"><?php echo getGalleryTitle();?></a>
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

<div id="credit"><?php printRSSLink('Gallery','','Gallery RSS', ' | ', false); ?> <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
