<?php if (!defined('WEBPATH')) die(); getHitcounter($_zp_current_image); ?>

<!DOCTYPE html>

<html>
	<head>
		<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle().' / '.getAlbumTitle().' / '.getImageTitle()); ?></title>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle().', '.getAlbumTitle().', '.getImageTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getImageTitle().' / '.getImageDesc()); ?>" />
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
			<?php
			if ( isImagePhoto() && extensionEnabled('colorbox_js') && zp_has_filter('theme_head', 'colorbox::css') ) {
				$imgURL = getFullImageURL();
				$boxclass = " class=\"fullimage\"";
				$cb = true;
			} else {
				$cb = false;
			}
			?>
			<div id="content" class="c">
				<div class="view c">
					<?php
					if ( $cb == true ) { ?>
						<a href="<?php echo html_encode($imgURL); ?>"<?php echo $boxclass; ?> title="<?php printBareImageTitle(); ?>">
							<?php printDefaultSizedImage(html_encode(getImageTitle()), 'image', 'player'); ?>
						</a>
					<?php
					} else {
						printDefaultSizedImage(html_encode(getImageTitle()), 'image', 'player');
					}
					?>
				</div>
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

<?php
zp_apply_filter('theme_body_close');
?>
<?php
if ( extensionEnabled('colorbox_js') && zp_has_filter('theme_head', 'colorbox::css') ) { ?>
<script type="text/javascript">
$( document ).ready(function() {
	$(".fullimage").colorbox({
		maxWidth: "98%",
		maxHeight: "98%",
		rel: function() { return $(this).data('rel') },
		current: "{current}/{total}",
		photo: true,
		close: '<?php echo gettext("close"); ?>'
	});
})
</script>
<?php } ?>
</body>
</html>