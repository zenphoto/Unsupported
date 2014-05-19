<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html>
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.getGalleryTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getMainSiteName().' / '.getGalleryTitle().' / '.getGalleryDesc()); ?>" />
		<title><?php echo strip_tags(getMainSiteName().' / '.getGalleryTitle()); ?></title>
	</head>
	<body id="gallery-index" class="<?php echo 'page-'.getCurrentPage(); ?>">
	<?php zp_apply_filter('theme_body_open'); ?>
		<div id="wrapper">
			<div id="header">
				<?php if (getOption('Allow_search')) {  printSearchForm(''); } ?>
				<ul class="path c">
					<?php if ( getMainSiteURL() ) { ?>
						<li><h1><a href="<?php echo getMainSiteURL(); ?>"><?php echo getMainSiteName(); ?></a></h1></li>
					<?php } ?>
					<li><h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo getGalleryTitle(); ?></a></h2></li>
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
						<li id="<?php echo 'album-'.$_zp_current_album->getID(); ?>" class="album">
							<a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo htmlspecialchars(getAlbumURL()); ?>">
								<img src="<?php echo getCustomAlbumThumb(298, NULL, NULL, 298, 178, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle().' ('.getAlbumDate(getOption('date_format')).')'); ?>" />
							<span><?php echo getAlbumTitle().'<br />('.getAlbumDate(getOption('date_format')).')'; ?></span>
							</a>
						</li>
<?php endwhile; ?>
					</ul>
				</div>
				<div id="rightbox">
					<div id="login">
<?php
						if (!zp_loggedin() && function_exists('printUserLogin_out')) {
							printUserLogin_out();
						}
						if (!zp_loggedin() && function_exists('printRegistrationForm')) {
							printCustomPageURL(gettext('Register for this site'), 'register');
						}
?>
					</div>
					<?php if (zp_loggedin()) {
					echo '<div class="tagcloud">';
						echo '<p>' . gettext('Popular Tags') . '</p>';
						printAllTagsAs('cloud', 'tags');
					echo '</div>';
					} ?>
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>

