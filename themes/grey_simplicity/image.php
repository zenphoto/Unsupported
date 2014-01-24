<?php if (!defined('WEBPATH')) die();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/jquery.js" type="text/javascript"></script>
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	<?php zenJavascript(); ?>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/fancybox/jquery.fancybox-1.2.6.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $_zp_themeroot; ?>/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
</head>

<body>
<?php printAdminToolbox(); ?>

<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL(false);?>"><?php echo getGalleryTitle();?></a></span>
		<span class="linkit"><a href="<?php echo getGalleryIndexURL(true);?>">Gallery</a></span>
		<?php if ( $_zp_current_album->getParent() != null ) { ?> <?php printParentBreadcrumb('<span class="linkit">', '', '</span>'); ?><?php } ?>
		<span class="linkit"><a href="<?php echo $_zp_current_image->album->getAlbumLink() ?>"><?php echo $_zp_current_album->get('title');?></a></span>
		<span class="albumtitle"><span><?php echo $_zp_current_image->get('title');?></span></span>
		</h2>
	</div>
	
	<?php $width = $_zp_current_image->getWidth(); ?>
	<div id="padbox">
	<div id="image" class="imageit">
		<?if ( $width < 650 ) { printCustomSizedImage('', 600); } else { ?>
		<a href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>"> <?php printCustomSizedImage('', 600); ?></a> 
		<?php } ?>
  	</div>
	<div id="tools">
		<?php if (hasPrevImage()) { ?>
		<a href="<?php echo  getPrevImageURL(); ?>"><img width="32px" src="<?= $_zp_themeroot ?>/images/o_left.png"></a>
		<?php } else { ?>
		<img width="32px" src="<?= $_zp_themeroot ?>/images/o_left-disabled.png">
		<?php } ?>

		<?if ( $width > 650 ) {  ?>
		<a href="<?php echo  getFullImageURL(); ?>" id="zoom"><img width="32px" src="<?= $_zp_themeroot ?>/images/o_zoom.png"></a>
		<?php }  ?>		

		<?php if (hasNextImage()) { ?>
		<a href="<?php echo  getNextImageURL(); ?>"><img width="32px" src="<?= $_zp_themeroot ?>/images/o_right.png"></a>
		<?php } else { ?>
		<img width="32px" src="<?= $_zp_themeroot ?>/images/o_right-disabled.png">		
		<?php } ?>
	</div>
	</div>

	</div>
</div>

<script type="text/javascript">
$(function() {
	$('#image a').fancybox({ 'hideOnContentClick': true, imageScale: true, showCloseButton: false });
	$('#tools a#zoom').fancybox({ 'hideOnContentClick': true, imageScale: true, showCloseButton: false });
});
</script>

<div id="credit"><?php printRSSLink('Gallery','','Gallery RSS', ' | ', false); ?> <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=archive');?>">Archives</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
