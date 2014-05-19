<?php
if (!defined('WEBPATH'))
	die();

if (getOption('Allow_imagesWithAlbums')) {
	$firstPageImages = normalizeColumns(2, 3);
} else {
	$firstPageImages = null;
}
if (($total = getNumImages() + getNumAlbums()) > 0) {
	if (isset($_REQUEST['date'])) {
		$searchwords = getSearchDate();
	} else {
		$searchwords = getSearchWords();
	}
}
$c = 0;
?>
<!DOCTYPE html>
<head>
	<?php include_once('header.php'); ?>
	<?php zp_apply_filter('theme_body_open'); ?>
	<meta name="keywords" content="<?php echo html_encode(getFormattedMainSiteName('', ', ') . getGalleryTitle() . ', ' . getBareAlbumTitle() . ', ' . implode(',', getTags())); ?>" />
	<meta name="description" content="<?php echo html_encode(getAlbumDesc()); ?>" />
	<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ') . getGalleryTitle() . ' / ' . gettext('Search') . ' / ' . $searchwords); ?></title>
</head>
<body id="gallery-index">
	<div id="wrapper">
		<div id="header">
			<div id="logo">
				<?php echo getGalleryLogo(); ?>
			</div>
			<div id="gallery_title">
				<?php echo getGalleryTitleHeader(); ?>
			</div>
		</div>
		<div id="breadcrumb">
			<ul>
				<?php
				getFormattedMainSiteName('<li class="page">', '</li><li class="chevron"> > </li>');
				echo '<li><a href="' . getGalleryIndexURL() . '">' . getBareGalleryTitle() . '</a></li>';
				echo '<li class="chevron"><a> &gt; </a></li>';
				echo '<li><a>' . gettext('Search') . ': ' . $searchwords . ' (' . $total . gettext(' results') . ')' . '</a></li>';
				?>
			</ul>
		</div>
		<div id="menu">
			<?php printThemeMenu(); ?>
		</div>
		<div id="content" class="c">
			<div id="thumbs">
				<div>
					<ul class="list">
						<?php while (next_album()): $c++ ?>
							<li class="thumb album">
								<a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo htmlspecialchars(getAlbumURL()); ?>">
									<img src="<?php echo getCustomAlbumThumb(250, NULL, NULL, 250, 150, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle() . ' (' . getAlbumDate(getOption('date_format')) . ')'); ?>" />
									<span><?php echo getAlbumTitle() . '<br />(' . getAlbumDate(getOption('date_format')) . ')'; ?></span>
								</a>
							</li>
						<?php endwhile; ?>
						<div class="clear_left"></div>
						<div id="images">
							<?php while (next_image(false, $firstPageImages)): $c++ ?>
								<li class="thumb image">
									<a title="<?php echo html_encode(getBareImageDesc()); ?>" href="<?php echo htmlspecialchars(getImageURL()); ?>">
										<img src="<?php echo getCustomImageURL(250, NULL, NULL, 250, 150, NULL, NULL, true); ?>" alt="<?php echo html_encode(getBareImageTitle() . ' (' . getImageDate(getOption('date_format')) . ')'); ?>" />
										<span><?php echo getBareImageTitle() . '<br />(' . getImageDate(getOption('date_format')) . ')'; ?></span>
									</a>
								</li>
								<?php
							endwhile;
							if ($c == 0) {
								echo "<p>" . gettext("Sorry, no image matches. Try refining your search.") . "</p>";
							}
							?>
						</div>
					</ul>
				</div>
			</div>
			<div class="clear_left"></div>
			<div id="move">
				<div id="prev" <?php if (hasPrevPage()) {
								echo 'class="active"';
							} ?>>
					<?php if (hasPrevPage()): ?><a href="<?php echo htmlspecialchars(getPrevPageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
				</div>
				<div id="next" <?php if (hasNextPage()) {
						echo 'class="active"';
					} ?>>
<?php if (hasNextPage()): ?><a href="<?php echo htmlspecialchars(getNextPageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
				</div>
			</div>
			<div class="clear_right"></div>
		</div>
		<div id="footer">
	<?php include_once('footer.php'); ?>
		</div>
	</div>
<?php include_once('analytics.php'); ?>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>

