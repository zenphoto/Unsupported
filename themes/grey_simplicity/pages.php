<?php if (!defined('WEBPATH')) die();  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/jquery.js" type="text/javascript"></script>
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	<?php zenJavascript(); ?>
</head>

<body>
<div id="main">
	<div id="sd-wrapper">
		<div id="gallerytitle">
			<h2>
			<span class="linkit">
				<a href="<?php echo getGalleryIndexURL(false);?>"><?php echo getGalleryTitle();?></a>
			</span> 
			<span class="albumtitle"><span><?php printPageTitle();?></span></span>
			</h2>
		</div>
	
		<div id="padbox">
			<div class="imageit newsbody">
				<?php printPageContent(); ?>
		  	</div>
		</div>
	</div>
</div>

<div id="credit"><a href='<?php $host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, "UTF-8"); echo("http://".$host.WEBPATH."/rss-news.php"); ?>'>News RSS</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=archive');?>">Archives</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
