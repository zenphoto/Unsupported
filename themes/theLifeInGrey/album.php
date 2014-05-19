<?php
if (!defined('WEBPATH')) die();
getHitcounter($_zp_current_album);
?>
<!DOCTYPE html>
	<head>
	<?php include_once('header.php'); ?>
	<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle().', '.getAlbumTitle()); ?>" />
	<meta name="description" content="<?php echo html_encode(getAlbumTitle().' / '.getAlbumDesc()); ?>" />
	<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle().' / '.getAlbumTitle()); ?></title>
	</head>
	<body id="gallery-album" class="<?php echo 'album-'.$_zp_current_album->getID().' page-'.getCurrentPage(); ?>">
	<?php zp_apply_filter('theme_body_open'); ?>
		<div id="wrapper">
			<div id="header">
				<ul class="path c">
					<?php if ( getMainSiteURL() ) { ?>
						<li><h1><a href="<?php echo getMainSiteURL(); ?>"><?php echo getMainSiteName(); ?></a></h1></li>
					<?php } ?>
					<li><h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo getGalleryTitle(); ?></a></h2></li>
					<?php m9PrintBreadcrumb(); ?>
					<li><a href="<?php echo getAlbumURL(); ?>"><?php echo getAlbumTitle(); ?></a></li>
				</ul>
				<ul class="move">
					<li><?php if (hasPrevPage()): ?><a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?></li>
					<li><?php if (hasNextPage()): ?><a href="<?php echo htmlspecialchars(getNextPageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?></li>
				</ul>	
			</div>
			<div id="content" class="c">
				<div id="leftbox">
					<ul class="list c">
	<?php while (next_album()): ?>
						<li id="<?php echo 'album-'.$_zp_current_album->getID(); ?>" class="album"><a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo getAlbumURL(); ?>">
							<img src="<?php echo getCustomAlbumThumb(298, NULL, NULL, 298, 178, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle().' ('.getAlbumDate(getOption('date_format')).')'); ?>" />
							<span><?php echo getAlbumTitle().'<br /> ('.getAlbumDate(getOption('date_format')).')'; ?></span>
						</a></li>
	<?php endwhile; ?>
						<div class="clear"></div>
						<div id="images">
	<?php while (next_image()): ?>
							<li id="<?php echo ' image-'.$_zp_current_image->getID(); ?>" class="image">
								<a title="<?php echo html_encode(getImageTitle()); ?>" href="<?php echo getImageURL(); ?>">
									<img src="<?php echo getCustomImageURL(298, NULL, NULL, 298, 178, NULL, NULL, true); ?>" alt="<?php echo html_encode(getAlbumTitle()); ?>" />
								</a>
							</li>
	<?php endwhile; ?>
						</div>
					</ul>
				</div>
				<div id="rightbox">
					<div class="data">
						<div class="c">
							<h4 class="box title">
								<?php printAlbumTitle(true); ?>
							</h4>
							<div class="box diaporama">
								<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
							</div>
						</div>
						<?php 
							if(getAlbumDesc() or zp_loggedin()){
								echo '<div class="c"><div class="box desc">';
								echo printAlbumDesc(true);
								echo '</div></div>';
							}
						?>
						<?php if(getAlbumDate()) echo '<div class="c"><small class="box date">'.getAlbumDate('%d.%m.%y %H:%M').'</small></div>'; ?>
						<?php
						if(getTags() or zp_loggedin()){
							echo '<div class="c"><div class="box tags">';
							printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', '');
							echo '</div></div>';
						}
						?>
						<div class="c">
							<div class="rating">
								<?php if (function_exists('printRating')) { printRating(); }?>
							</div>
						</div>
						<?php
						if ( function_exists('printGoogleMap') ) {
							echo '<div class="c"><div class="box googleMap">';
							printGoogleMap();
							echo '</div></div>';
						}
						?>
					</div>
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>