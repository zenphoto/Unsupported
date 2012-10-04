﻿<?php if (!defined('WEBPATH')) die(); require_once ('functions.php'); getHitcounter($_zp_current_image); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle().', '.getAlbumTitle().', '.getImageTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getImageTitle().' / '.getImageDesc()); ?>" />
		<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle().' / '.getAlbumTitle().' / '.getImageTitle()); ?></title>
	</head>
	<body id="gallery-image" class="<?php echo 'album-'.$_zp_current_album->getID().' image-'.$_zp_current_image->getID(); ?>">
		<div id="wrapper">
			<div id="header">
				<ul class="path c">
					<li><h1><a href="<?php echo getMainSiteURL(); ?>"><?php echo getMainSiteName(); ?></a></h1></li>
					<li><h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo getGalleryTitle(); ?></a></h2></li>
					<?php m9PrintBreadcrumb(); ?>
					<li><a href="<?php echo getAlbumLinkURL(); ?>"><?php echo getAlbumTitle(); ?></a></li>
				</ul>
				<ul class="move">
					<li><?php if (hasPrevImage()): ?><a href="<?php echo htmlspecialchars(getPrevImageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?></li>
					<li><?php if (hasNextImage()): ?><a href="<?php echo htmlspecialchars(getNextImageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?></li>
				</ul>	
			</div>
			<div id="content" class="c">
				<div class="view c"><?php printDefaultSizedImage(html_encode(getImageTitle()), 'image', 'player'); ?></div>
				<div class="data">
					<?php if(getImageTitle()) echo '<div class="c"><h4 class="box title">'.getImageTitle().'</h4></div>'; ?>
					<?php if(getImageDesc()) echo '<div class="c"><div class="box desc">'.getImageDesc().'</div></div>'; ?>
					<?php	if(getImageLocation()) echo '<div class="c"><small class="box location">'.getImageLocation().'</small></div>'; ?>
					<?php if(getImageDate()) echo '<div class="c"><small class="box date">'.getImageDate('%d.%m.%y %H:%M').'</small></div>'; ?>
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
	</body>
</html>
