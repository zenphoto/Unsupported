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
	</head>
	<body id="gallery-search" class="<?php echo 'search page-'.getCurrentPage(); ?>">
	<?php zp_apply_filter('theme_body_open'); ?>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<?php echo getGalleryLogo(); ?>
				</div>
				<div id="gallery_title">
					<?php echo getGalleryTitleHeader(); ?>
				</div>
				<?php printSearchForm(); ?>
			</div>
			<div id="menu">
				<?php printThemeMenu(); ?>
			</div>
			<div id="breadcrumb">
				<ul>
				<?php
					getFormattedMainSiteName('<li class="page">', '</li><li class="chevron"> > </li>');
					echo '<li><a href="' . getGalleryIndexURL() . '" class="activ">' . getBareGalleryTitle() . '</a></li>';
					getParentBreadcrumbTLS('<li class="chevron"><a> &gt; </a></li>');
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a>' . html_encode( getBareAlbumTitle() ) . '</a></li>';
				?>
				</ul>
			</div>
			<div id="content">
		<?php
		$c = 0;
		?>
					<div class="thumbs">
					<ul class="list">
						<?php while (next_album()): $c++; ?>
						<li>
							<div class="thumb">
								<a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo htmlspecialchars(getAlbumURL()); ?>">
									<img src="<?php echo getCustomAlbumThumb(150, NULL, NULL, 150, 150, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle().' ('.getAlbumDate(getOption('date_format')).')'); ?>" />
								</a>
							</div>
							<div class="album">
								<div class="gras"><?php echo getAlbumTitle(); ?></div>
								<div class="italic"><small><?php echo '('.getAlbumDate(getOption('date_format')).')'; ?></small></div>
							</div>
						</li>
						<?php endwhile; ?>
						<?php while (next_image()): $c++; ?>
						<li>
							<div class="thumb">
								<a title="<?php echo html_encode(getImageDesc()); ?>" href="<?php echo htmlspecialchars(getImageURL()); ?>">
									<img src="<?php echo getCustomImageURL(150, NULL, NULL, 150, 150, NULL, NULL, true); ?>" alt="<?php echo html_encode(getBareImageTitle().' ('.getImageDate(getOption('date_format')).')'); ?>" />
								</a>
							</div>
						</li>
						<?php endwhile; 
						if ($c == 0) {
								echo "<p>".gettext("Sorry, no image matches. Try refining your search.")."</p>";
							} ?>
					</ul>
				</div>
				<div class="clear"></div>
				<div id="move">
					<div id="prev" <?php if (hasPrevPage()) {echo 'class="active"';}?>>
					<?php if (hasPrevPage()): ?><a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
					</div>
					<div id="next" <?php if (hasNextPage()) {echo 'class="active"';}?>>
					<?php if (hasNextPage()): ?><a href="<?php echo htmlspecialchars(getNextPageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
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
			<div id="footer">
					<?php include_once('footer.php'); ?>
			</div>
		</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>