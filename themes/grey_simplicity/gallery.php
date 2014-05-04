<?php if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<?php printHeadTitle(); ?>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	
</head>

<body>
	<?php zp_apply_filter('theme_body_open'); ?>


<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle" style="margin-bottom: 60px;">
   		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL();?>"><?php echo getGalleryTitle();?></a>
		</span>
		<span class="albumtitle"><span>Gallery</span></span>
		</h2>
	</div>
    
    <div id="padbox" >

		<div id="albums">
			<?php while (next_album()): ?>
			<div class="albums-wrap">
        		<div class="thumb">
        			<div class="data">
						<?php if(getAlbumTitle()) echo '<div class="c"><h4 class="box title">'.getAlbumTitle().'</h4></div>'; ?>	
					</div>
					<a href="<?php echo getAlbumURL(); ?>" title="View album: <?php echo getAlbumTitle(); ?>">
					<?php printAlbumThumbImage(getAlbumTitle()); ?>
					</a>
					
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

<div id="credit"><?php printRSSLink('Gallery','','Gallery RSS', ' | ', false); ?> <a href="<?php echo getCustomPageURL("archive"); ?>">Archives</a> | <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
