<?php if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	<?php zenJavascript(); ?>
</head>

<body>
<?php printAdminToolbox(); ?>

<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle" style="margin-bottom: 60px;">
   		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL(false);?>"><?php echo getGalleryTitle();?></a>
		</span>
		<span class="albumtitle"><span>Gallery</span></span>
		</h2>
	</div>
    
    <div id="padbox" >

		<div id="albums">
			<?php while (next_album()): ?>
			<div style="float:left">
        		<div class="thumb">
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php printAlbumThumbImage(getAlbumTitle()); ?>
					</a>
					<div class="data">
						<?php if(getAlbumTitle()) echo '<div class="c"><h4 class="box title">'.getAlbumTitle().'</h4></div>'; ?>	
					</div>
       			 </div>
			</div>
			
			<?php endwhile; ?>
		</div>
	
		<?php printPageListWithNav("&laquo; prev", "next &raquo;"); ?>
        
        
	</div>
	</div>
</div>

<div id="credit"><?php printRSSLink('Gallery','','Gallery RSS', ' | ', false); ?> <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=archive');?>">Archives</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
