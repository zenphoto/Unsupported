<?php if (!defined('WEBPATH')) die();  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/jquery.js" type="text/javascript"></script>
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	<?php zenJavascript(); ?>
	<style>
		#padbox #rabbit { 
			text-align:center; font-size: 15px; color: #555; font-weight: bold; padding-top: 0px;
			margin-top: 60px; padding-bottom: 25px;
		}
		#menu { text-align: center; font-size: 15px !important; } 
		#padbox #menu a {
			 color: #666 !important; 
			font-weight: bold;
		   border: #000 1px dotted;
			background: #333;
			background: rgba(255, 255, 255,.1);
			-o-box-shadow: 5px 5px 10px #111111; 
			-icab-box-shadow: 5px 5px 10px #111111; 
			-khtml-box-shadow: 5px 5px 10px #111111; 
			-moz-box-shadow: 5px 5px 10px #111111; 
			-webkit-box-shadow: 5px 5px 10px #111111; 
			box-shadow: 5px 5px 10px #111111;
			margin-left: 10px;
			padding: 2px 6px 2px 6px;
		}
		#padbox #menu a:hover {
			color: #999 !important;
		}
	</style>
</head>

<body>
<div id="main">
	<div id="sd-wrapper">
		<div id="gallerytitle">
			<h2>
			<span class="albumtitle">
				<span><?php echo getGalleryTitle();?></span>
			</span>
			</h2>
		</div>
	
		<div id="padbox">
			<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-jutify: newspaper; padding: 40px 60px 0px 60px;">
				<div id="menu">
					<a style="margin-left: 0px;" href="<?php echo getGalleryIndexURL();?>">Gallery</a>&nbsp;
					<a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p='.ZENPAGE_NEWS);?>">News</a>
				</div>				
				<div id="rabbit">
					<p>The rabbit wants to fade away</p>							
					<p>
						<img class="rabbit" src="<?= $_zp_themeroot ?>/images/rabbit.png"/>
					</p>													
					<p>fade into this grey emptiness</p>										
				</div>
		</div>
	</div>
</div>

<div id="credit"><a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=archive');?>">Archives</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
