<?php if (!defined('WEBPATH')) die(); getHitcounter($_zp_current_album); ?>

<!DOCTYPE html>

<html>
	<head>
		<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle().' / '.getAlbumTitle()); ?></title>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle().', '.getAlbumTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getAlbumTitle().' / '.getAlbumDesc()); ?>" />
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
				<ul class="list c">
<?php while (next_album()): ?>
					<li id="<?php echo 'album-'.$_zp_current_album->getID(); ?>" class="album"><a title="<?php echo html_encode(getAlbumTitle()); ?>" href="<?php echo getAlbumURL(); ?>">
						<img src="<?php echo getCustomAlbumThumb(298, NULL, NULL, 298, 178, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle()); ?>" />
						<span><?php echo getAlbumTitle(); ?></span>
					</a></li>
<?php endwhile; ?>

<?php while (next_image()):
				if ( isImagePhoto() && extensionEnabled('colorbox_js') && zp_has_filter('theme_head', 'colorbox::css') ) {
					$imgURL = getFullImageURL();
					$boxclass = " class=\"fullimage\"";
					$cbRel = " data-rel=\"gallery\"";
				} else {
					$imgURL = getImageURL();
					$boxclass = "";
					$cbRel = "";
				}
				?>
					<li id="<?php echo ' image-'.$_zp_current_image->getID(); ?>" class="image">
						<a title="<?php echo html_encode(getImageTitle()); ?>" href="<?php echo html_encode($imgURL); ?>"<?php echo $boxclass . $cbRel; ?>>
							<img src="<?php echo getCustomImageURL( NULL, 298, 187, 298, 187, NULL, NULL, true ); ?>" alt="<?php echo html_encode(getImageTitle()); ?>" />
						</a>
					</li>
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