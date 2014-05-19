<?php if (!defined('WEBPATH')) die();  ?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<?php printHeadTitle(); ?>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	
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
	<?php zp_apply_filter('theme_body_open'); ?>
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
			<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-justify: newspaper; padding: 40px 60px 0px 60px;">
				<div id="menu">
					<a style="margin-left: 0px;" href="<?php echo getCustomPageURL("gallery");?>">Gallery</a>&nbsp;
					<?php if (class_exists('Zenpage')) printNewsIndexURL("News"); ?>
				</div>				
				<div id="rabbit">
					<p>The rabbit wants to fade away</p>							
					<p>
						<img class="rabbit" src="<?php echo $_zp_themeroot ?>/images/rabbit.png" />
					</p>													
					<p>fade into this grey emptiness</p>										
				</div>
		</div>
	</div>
</div>

<div id="credit"><a href="<?php echo getCustomPageURL("archive"); ?>">Archives</a> | <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
