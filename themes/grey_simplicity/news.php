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
<?php printAdminToolbox(); ?>
<?php 
	$newsUrl = rewrite_path(urlencode(ZENPAGE_NEWS), "/index.php?p=".ZENPAGE_NEWS); 
	
	function getNewsLink($dir) {
		$article_url = getNextPrevNews($dir);
		if(array_key_exists('link', $article_url) && $article_url['link'] != "") {
			return $article_url['link'];
		}
		else {
			return "#";
		}
	}
	
	if ( !isset($_zp_current_zenpage_news) ) { 
		next_news();
	}
?>
<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL(false);?>" ><?php echo getGalleryTitle();?></a></span>
		<span class="linkit"><span><a href="<?php echo $newsUrl; ?>">News</a></span></span>		
		<?php if ( isset($_zp_current_zenpage_news) ) { ?>
		<span class="albumtitle"><span><?php echo $_zp_current_zenpage_news->getTitle();?></span></span>
		<?php } ?>
		</h2>
	</div>
	
	<div id="padbox">
	<div class="imageit newsbody">
		<?php printNewsContent();?>
  	</div>
	<?php if ( isset($_zp_current_zenpage_news) ) { ?>
	<div id="tools" style="text-align: center; margin-top: 20px;">
		<?php
		$next = getNewsLink("next");
		$prev = getNewsLink("prev");
		?>
		<?php if ( $prev ==	'#' ) {  ?><img width="32px" src="<?= $_zp_themeroot ?>/images/o_left-disabled.png"><?php } else {?>
		<a style="padding-right: 5px;" href="<?php echo $prev; ?>"><img width="32px" src="<?= $_zp_themeroot ?>/images/o_left.png"></a> <?php } ?>
	
		<?php if ( $next ==	'#' ) {  ?><img width="32px" src="<?= $_zp_themeroot ?>/images/o_right-disabled.png"><?php } else {?>
		<a style="padding-left: 5px;"href="<?php echo $next; ?>"><img width="32px" src="<?= $_zp_themeroot ?>/images/o_right.png"></a>
		<?php } ?>
	</div>
	<?php } ?>
	</div>

	</div>
</div>

<div id="credit"><a href='<?php $host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, "UTF-8"); echo("http://".$host.WEBPATH."/rss-news.php"); ?>'>News RSS</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=archive');?>">Archives</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
