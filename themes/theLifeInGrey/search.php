<?php
if (!defined('WEBPATH')) die();

header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html>
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getMainSiteName().', '.gettext('Search')); ?>" />
		<meta name="description" content="<?php echo html_encode(getMainSiteName().' / '.gettext('Search')); ?>" />
		<title><?php echo strip_tags(getMainSiteName().' / '.gettext('Search')); ?></title>
		<link rel="stylesheet" href="<?php echo  $zenCSS ?>" type="text/css" />
	</head>
	<body id="gallery-search" class="<?php echo 'search page-'.getCurrentPage(); ?>">
	<?php zp_apply_filter('theme_body_open'); ?>
		<div id="wrapper">
			<div id="header">
				<?php if (getOption('Allow_search')) {  printSearchForm(''); } ?>
				<ul class="path c">
					<?php if ( getMainSiteURL() ) { ?>
						<li><h1><a href="<?php echo getMainSiteURL(); ?>"><?php echo getMainSiteName(); ?></a></h1></li>
					<?php } ?>
					<li><h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo getGalleryTitle(); ?></a></h2></li>
					<li><h3><a><?php echo gettext('Search')  ?></a></h3></li>
				</ul>
				<ul class="move">
					<li><?php if (hasPrevPage()): ?><a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?></li>
					<li><?php if (hasNextPage()): ?><a href="<?php echo htmlspecialchars(getNextPageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?></li>
				</ul>	
			</div>
			<div id="content" class="c">
		<?php
		$c = 0;
		?>
				<div id="leftbox">
					<div id="albums">
						<ul class="list c">
						<?php while (next_album()): $c++;?>
							<li id="<?php echo 'album-'.getAlbumID(); ?>" class="album">
								<a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo htmlspecialchars(getAlbumURL()); ?>">
									<img src="<?php echo getCustomAlbumThumb(298, NULL, NULL, 298, 178, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle().' ('.getAlbumDate(getOption('date_format')).')'); ?>" />
								<span><?php echo getAlbumTitle().'<br />('.getAlbumDate(getOption('date_format')).')'; ?></span>
								</a>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>
					<div class="clear"></div>
					<div id="images">
						<ul class="list c">
						<?php while (next_image()): $c++;?>
							<li id="<?php echo ' image-'.getImageID(); ?>" class="image"><a title="<?php echo html_encode(getImageTitle()); ?>" href="<?php echo getImageURL(); ?>">
									<img src="<?php echo getCustomImageURL(298, NULL, NULL, 298, 178, NULL, NULL, true); ?>" alt="<?php echo html_encode(getAlbumTitle()); ?>" />
								</a></li>
						<?php endwhile;
							if ($c == 0) {
								echo "<p>".gettext("Sorry, no image matches. Try refining your search.")."</p>";
								}
						?>
						</ul>
					</div>
				</div>
				<div id="rightbox">
					<div class="data">
						<div class="box desc">
			<?php
			if (($total = getNumImages() + getNumAlbums()) > 0) {
				if (isset($_REQUEST['date'])){
					$searchwords = getSearchDate();
			} else { $searchwords = getSearchWords(); }
				echo '<p>'.sprintf(gettext('Total matches for <em>%1$s</em>: %2$u'), $searchwords, $total).'</p>';
			}
			?>
						</div>
						<div class="box diaporama">
							<?php	if (function_exists('printSlideShowLink')) {
									printSlideShowLink(gettext('View Slideshow'));
									} ?>
						</div>
					</div>
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
				</div>
			</div>
<?php include_once('footer.php'); ?>
		</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>