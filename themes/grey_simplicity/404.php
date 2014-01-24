<?php if (!defined('WEBPATH')) die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
</head>

<body>
<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit albumtitle"><a href="<?php echo getGalleryIndexURL(false);?>" title="Albums Index"><?php echo getGalleryTitle();?></a></span>
		</h2>
	</div>
	
	<div id="padbox">
	<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-jutify: newspaper; padding: 40px 60px 40px 60px;">
		<div style="text-align:center; font-size: 15px; color: #666; font-weight: bold;padding: 20px;">
			<p>Object found then stupidly lost</p>
			<p><a href="<?php echo getGalleryIndexURL();?>"><img class="rabbit" src="<?= $_zp_themeroot ?>/images/rabbit-404.png"/></a></p>
			<p>The rabbit must have eaten it</p>
		</div>
  	</div>
	</div>

	</div>
</div>

<div id="credit"><a href='<?php $host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, "UTF-8"); echo("http://".$host.WEBPATH."/rss-news.php"); ?>'>News RSS</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
