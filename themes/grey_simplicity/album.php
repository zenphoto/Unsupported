<?php 
if (!defined('WEBPATH')) die(); 
?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?></title>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
	<?php if ( !extensionEnabled('colorbox_js') && getOption('highslide')) { ?>
    	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/highslide/highslide/highslide-full.js"></script>
    	<link rel="stylesheet" type="text/css" href="<?php echo $_zp_themeroot; ?>/highslide/highslide/highslide.css" />
   		<script type="text/javascript">
    		// override Highslide settings here
    		// instead of editing the highslide.js file
   	 		hs.graphicsDir = '<?php echo $_zp_themeroot; ?>/highslide/highslide/graphics/';
		</script>
		<script type="text/javascript">
			hs.addSlideshow({
			// slideshowGroup: 'group1',
			interval: 3000,
			repeat: false,
			useControls: true,
			fixedControls: true,
			overlayOptions: {
				opacity: .6,
				position: 'top center',
				hideOnMouseOut: true
				}
			});

			// Optional: a crossfade transition looks good with the slideshow
			hs.transitions = ['expand', 'crossfade'];
		</script>
	<?php } ?>
	
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
		<a href="<?php echo getGalleryIndexURL();?>"><?php echo getGalleryTitle();?></a>
		</span>
		<span class="linkit"><a href="<?php echo getCustomPageURL('gallery'); ?>">Gallery</a></span>
		<?php if ( getParentAlbums() != null ) { ?><span class="linkit"><?php printParentBreadcrumb('', '', ''); ?> </span><?php } ?>
		<span class="albumtitle"><span><?php echo $_zp_current_album->getTitle();?></span></span>
		</h2>
	</div>
    
    <div id="padbox">
		
		<div class="palelinks" style="margin-bottom: 20px; margin-top: 6px; padding: 17px; font-weight: bold;">
		<?php printAlbumDesc(true); ?>
		<?php /* if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('Slideshow')); */ ?>
		</div>

  		<div id="albums">
			<?php while (next_album()): ?>
			<div class="albums-wrap">
        		<div class="thumb">
        			<div class="data">
						<?php if(getAlbumTitle()) echo '<div class="c"><h4 class="box title">'.getAlbumTitle().'</h4></div>'; ?>	
					</div>
					<a href="<?php echo getAlbumURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php printAlbumThumbImage(getAlbumTitle()); ?>
					</a>
       			 </div>
			</div>
			<?php endwhile; ?>
		</div>
    	
    	<div id="images" class="clear">
    	
    	<?php if ( extensionEnabled('colorbox_js') && getOption('highslide')) { ?>
    		<div id="padbox">
				<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-jutify: newspaper; padding: 40px 60px 40px 60px;">
					<div style="text-align:center; font-size: 15px; color: #666; font-weight: bold;padding: 20px;">
						<p>You cannot have the <em>colorbox_js</em> plugin and the theme option <em>Highslide</em> enabled at the same time !</p>
						<p><a href="<?php echo getGalleryIndexURL();?>"><img class="rabbit" src="<?php echo $_zp_themeroot ?>/images/rabbit.png" /></a></p>
					</div>
  				</div>
			</div>
    	<?php } ?>
    		
			<?php while (next_image()): ?>
			<div class="image">
				<div class="imagethumb">
				<?php if ( !extensionEnabled('colorbox_js') && getOption('highslide')) { ?>
					<?php if ( !isImageVideo() ) { ?>
						<a href="<?php echo getFullImageURL(); ?>" class="highslide" onclick="return hs.expand(this)">
							<?php } else { ?>
								<a href="<?php echo html_encode(getImageURL()); ?>">
							<?php } ?>
						<img src="<?php echo getImageThumb(); ?>" alt="<?php $_zp_current_image->getTitle(); ?>" />
					</a>
						<div class="highslide-caption">
    						<?php echo getImageDesc(); ?>
						</div>
					<?php } else { 
						if ( extensionEnabled('colorbox_js') && !getOption('highslide')) { 
							if ( isImagePhoto() ) {
								$boxclass = " class=\"thickbox\"";
								} else {
								$boxclass = NULL;
								}
					?>
					<?php if (isImagePhoto()) { ?>
						<a href="<?php echo getDefaultSizedImage(); ?>" <?php echo $boxclass; ?>>
							<img src="<?php echo getImageThumb(); ?>" alt="<?php $_zp_current_image->getTitle(); ?>" />
						</a>
					<?php } else { ?>
							<a href="<?php echo html_encode(getImageURL()); ?>">
								<img src="<?php echo getImageThumb(); ?>" alt="<?php $_zp_current_image->getTitle(); ?>" />
							</a>
							<?php } ?>
					<?php } else {
						if ( !extensionEnabled('colorbox_js') && !getOption('highslide')) { ?>
							<a href="<?php echo html_encode(getImageURL()); ?>">
								<img src="<?php echo getImageThumb(); ?>" alt="<?php $_zp_current_image->getTitle(); ?>" />
							</a>
						<?php } ?>
				<?php } ?>
				<?php } ?>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<div class="clear"></div>
		
	<div id="tools">
		<?php if (hasPrevPage()) { ?>
		<a href="<?php echo getPrevPageURL(); ?>"><span class="prev"></span></a>
		<?php } else { ?>
			<span class="prev-disabled"></span>
		<?php } ?>	

		<?php if (hasNextPage()) { ?>
		<a href="<?php echo getNextPageURL(); ?>"><span class="next"></span></a>
		<?php } else { ?>
			<span class="next-disabled"></span>		
		<?php } ?>
	</div>
		
	</div>
	</div>
</div>

<div id="credit"><?php printRSSLink('Album', '', 'Album RSS', '', false); ?> | <a href="<?php echo getCustomPageURL("archive"); ?>">Archives</a> | <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>