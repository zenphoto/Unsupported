<?php if (!defined('WEBPATH')) die(); require_once ('functions.php'); getHitcounter($_zp_current_album); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle().', '.getAlbumTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getAlbumTitle().' / '.getAlbumDesc()); ?>" />
		<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle().' / '.getAlbumTitle()); ?></title>
	</head>
	<body id="gallery-album" class="<?php echo 'album-'.$_zp_current_album->getID().' page-'.getCurrentPage(); ?>">
		<div id="wrapper">
			<div id="header">
				<ul class="path c">
					<li><h1><a href="<?php echo getMainSiteURL(); ?>"><?php echo getMainSiteName(); ?></a></h1></li>
					<li><h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo getGalleryTitle(); ?></a></h2></li>
					<?php m9PrintBreadcrumb(); ?>
					<li><a href="<?php echo getAlbumLinkURL(); ?>"><?php echo getAlbumTitle(); ?></a></li>
				</ul>
				<ul class="move">
					<li><?php if (hasPrevPage()): ?><a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?></li>
					<li><?php if (hasNextPage()): ?><a href="<?php echo htmlspecialchars(getNextPageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?></li>
				</ul>	
			</div>
			<div id="content" class="c">
				<ul class="list c">
<?php while (next_album()): ?>
					<li id="<?php echo 'album-'.$_zp_current_album->getID(); ?>" class="album"><a title="<?php echo html_encode(getAlbumTitle()); ?>" href="<?php echo getAlbumLinkURL(); ?>">
						<img src="<?php echo getCustomAlbumThumb(298, NULL, NULL, 298, 178, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle()); ?>" />
						<span><?php echo getAlbumTitle(); ?></span>
					</a></li>
<?php endwhile; ?>
<?php while (next_image()): ?>
					<li id="<?php echo ' image-'.$_zp_current_image->getID(); ?>" class="image"><a title="<?php echo html_encode(getImageTitle()); ?>" href="<?php echo getImageLinkURL(); ?>">
						<img src="<?php echo getCustomImageURL(298, NULL, NULL, 298, 178, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle()); ?>" />
					</a></li>
<?php endwhile; ?>
				</ul>
				<div class="data">
					<?php if(getAlbumTitle()) echo '<div class="c"><h4 class="box title">'.getAlbumTitle().'</h4></div>'; ?>
					<?php if(getAlbumDesc()) echo '<div class="c"><div class="box desc">'.getAlbumDesc().'</div></div>'; ?>
					<?php if(getAlbumDate()) echo '<div class="c"><small class="box date">'.getAlbumDate('%d.%m.%y %H:%M').'</small></div>'; ?>
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
	</body>
</html>