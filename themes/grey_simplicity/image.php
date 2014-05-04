<?php if (!defined('WEBPATH')) die();?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	
	<?php if (zp_has_filter('theme_head', 'colorbox::css')) { ?>
		<script type="text/javascript">
			// <!-- <![CDATA[
			$(document).ready(function() {
				$(".colorbox").colorbox({
					inline: true,
					href: "#imagemetadata",
					close: '<?php echo gettext("close"); ?>'
				});
				$("a.thickbox").colorbox({
					maxWidth: "98%",
					maxHeight: "98%",
					photo: true,
					close: '<?php echo gettext("close"); ?>'
				});
			});
			// ]]> -->
		</script>
	<?php } ?>
</head>

<body>
	<?php zp_apply_filter('theme_body_open'); ?>


<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL();?>"><?php echo getGalleryTitle();?></a></span>
		<span class="linkit"><a href="<?php echo getCustomPageURL('gallery'); ?>">Gallery</a></span>
		<?php if ( getParentAlbums() != null ) { ?><span class="linkit"><?php printParentBreadcrumb('', '', ''); ?> </span><?php } ?>
		<span class="linkit"><a href="<?php echo $_zp_current_image->album->getLink() ?>"><?php echo $_zp_current_album->getTitle();?></a></span>
		<span class="albumtitle"><span><?php echo $_zp_current_image->getTitle();?></span></span>
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
		<a href="<?php echo getPrevImageURL(); ?>"><span class="prev"></span></a>
		<?php } else { ?>
		<span class="prev-disabled"></span>
		<?php } ?>
		
		<?php 
		
		?>
		<?php if ( $width > 650 ) { 
			if ( extensionEnabled('colorbox_js') && isImagePhoto()) { 
					$boxclass = " class=\"thickbox\"";
					} else {
						if ( !extensionEnabled('colorbox_js') ) {
						$boxclass = NULL;
					}
				} ?>
			<a href="<?php echo getFullImageURL(); ?>"<?php echo $boxclass; ?> id="zoom"><span class="zoom"></span></a>
		<?php }  ?>		

		<?php if (hasNextImage()) { ?>
		<a href="<?php echo getNextImageURL(); ?>"><span class="next"></span></a>
		<?php } else { ?>
		<span class="next-disabled"></span>		
		<?php } ?>
	</div>
	</div>

	</div>
</div>

<div id="credit"><?php printRSSLink('Gallery','','Gallery RSS', ' | ', false); ?> <a href="<?php echo getCustomPageURL("archive"); ?>">Archives</a> | <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
