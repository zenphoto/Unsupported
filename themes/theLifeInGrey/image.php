<?php if (!defined('WEBPATH')) die(); getHitcounter($_zp_current_image); ?>
<!DOCTYPE html>
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle().', '.getAlbumTitle().', '.getImageTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getImageTitle().' / '.getImageDesc()); ?>" />
		<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle().' / '.getAlbumTitle().' / '.getImageTitle()); ?></title>
	</head>
	<body id="gallery-image" class="<?php echo 'album-'.$_zp_current_album->getID().' image-'.$_zp_current_image->getID(); ?>">
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
					<li><?php if (hasPrevImage()): ?><a href="<?php echo htmlspecialchars(getPrevImageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?></li>
					<li><?php if (hasNextImage()): ?><a href="<?php echo htmlspecialchars(getNextImageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?></li>
				</ul>	
			</div>
			<div id="content" class="c">
				<div id="leftbox">
					<div class="view c" id="image">
						<div class="choice">
							<?php if (function_exists('printUserSizeImage') && isImagePhoto()) printUserSizeSelectior(); ?>
						</div>
						<?php
						$fullimage = getFullImageURL();
						if (!empty($fullimage)) {
							?>
							<a href="<?php echo htmlspecialchars($fullimage);?>" title="<?php echo getBareImageTitle();?>">
							<?php
						}
						if (function_exists('printUserSizeImage') && isImagePhoto()) {
							printUserSizeImage(html_encode(getImageTitle()), null, 'image', 'player');
						} else {
							printDefaultSizedImage(html_encode(getImageTitle()), 'image', 'player'); 
						}
						if (!empty($fullimage)) {
							?>
							</a>
							<?php
						}
						?>
					</div>
					<div class="diaporama">
						<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
					</div>
					<div class="rating">
						<div>
							<?php if (function_exists('printRating')) { printRating(); }?>
						</div>
					</div>
				</div>
				<div id="rightbox">
					<div class="data">
						<div class="c">
							<h4 class="box title">
								<?php echo printImageTitle(true); ?>
							</h4>
						</div>
						<?php 
							if(getImageDesc() or zp_loggedin()){
								echo '<div class="c"><div class="box desc">';
								echo printImageDesc(true);
								echo '</div></div>';
							}
						?>
						<?php	if(getImageLocation()) echo '<div class="c"><small class="box location">'.getImageLocation().'</small></div>'; ?>
						<?php if(getImageDate()) echo '<div class="c"><small class="box date">'.getImageDate('%d.%m.%y %H:%M').'</small></div>'; ?>
						<div class="c">
							<div class="box metadonnees">
								<?php if (getImageMetaData()) echo '<div>'.printImageMetadata().'</div>'; ?>
							</div>
						</div>
						<?php
						if(getTags() or zp_loggedin()){
							echo '<div class="c"><div class="box tags">';
							printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', '');
							echo '</div></div>';
						}
						?>
						<?php
						if ( function_exists('printGoogleMap') ) {
							echo '<div class="c"><div class="box googleMap">';
							printGoogleMap();
							echo '</div></div>';
						}
						?>
					</div>
				</div>
				<div class="clear"></div>
				<div class="commentaires">
				<?php
				if (function_exists('printCommentForm')) {
					printCommentForm();
				}
				?>
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
