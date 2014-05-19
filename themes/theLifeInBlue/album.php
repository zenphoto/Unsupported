<?php
if (!defined('WEBPATH'))
	die();

if (getOption('Allow_imagesWithAlbums')) {
	$firstPageImages = normalizeColumns(2, 3);
} else {
	$firstPageImages = null;
}
?>
<!DOCTYPE html>
<head>
	<?php include_once('header.php'); ?>
	<meta name="keywords" content="<?php echo html_encode(getFormattedMainSiteName('', ', ') . getGalleryTitle() . ', ' . getBareAlbumTitle() . ', ' . implode(',', getTags())); ?>" />
	<meta name="description" content="<?php echo html_encode(getAlbumDesc()); ?>" />
	<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ') . getGalleryTitle() . getParentHeaderTitle(' / ') . ' / ' . getBareAlbumTitle()); ?></title>
</head>
<body id="gallery-index">
	<?php zp_apply_filter('theme_body_open'); ?>
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
				getParentBreadcrumbTLB('<li class="chevron"><a> &gt; </a></li>');
				echo '<li class="chevron"><a> &gt; </a></li>';
				echo '<li><a>' . getBareAlbumTitle() . '</a></li>';
				?>
			</ul>
		</div>
		<div id="menu">
			<?php printThemeMenu(); ?>
		</div>
		<div id="content" class="c">
			<div id="description">
				<div class="c">
					<div id="title" class="box"><h3><?php printAlbumTitle(true); ?></h3></div>
					<div id="date" class="box"><?php echo '( ' . getAlbumDate(getOption('date_format')) . ' )'; ?></div>
				</div>
				<?php
				if (getAlbumDesc() or zp_loggedin()) {

					echo '<div class="c"><div id="desc" class="box">';
					echo printAlbumDesc(true);
					echo '</div></div>';
				}
				if (getTags() or zp_loggedin()) {
					echo '<div class="c"><div id="tags" class="box">';
					printTags('links', '', '', ', ', true, '', true);
					echo '</div></div>';
				}
				if (function_exists('printRating')) {
					echo '<div class="c"><div id="rating">';
					printRating();
					echo '</div></div>';
				}
				?>
			</div>
			<div class="clear_left"></div>
			<div id="thumbs">
				<div>
					<ul class="list">
						<?php while (next_album()): ?>
							<li class="thumb album">
								<a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo htmlspecialchars(getAlbumURL()); ?>">
									<img src="<?php echo getCustomAlbumThumb(250, NULL, NULL, 250, 150, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle() . ' (' . getAlbumDate(getOption('date_format')) . ')'); ?>" />
									<span><?php echo getAlbumTitle() . '<br />(' . getAlbumDate(getOption('date_format')) . ')'; ?></span>
								</a>
							</li>
						<?php endwhile; ?>
						<div class="clear_left"></div>
						<div id="images">
							<?php while (next_image(false, $firstPageImages)): ?>
								<li class="thumb image">
									<a title="<?php echo html_encode(getBareImageDesc()); ?>" href="<?php echo htmlspecialchars(getImageURL()); ?>">
										<img src="<?php echo getCustomImageURL(250, NULL, NULL, 250, 150, NULL, NULL, true); ?>" alt="<?php echo html_encode(getBareImageTitle() . ' (' . getImageDate(getOption('date_format')) . ')'); ?>" />
										<span><?php echo getBareImageTitle() . '<br />(' . getImageDate(getOption('date_format')) . ')'; ?></span>
									</a>
								</li>
							<?php endwhile; ?>
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
			<?php commentFormDisplay(); ?>
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

