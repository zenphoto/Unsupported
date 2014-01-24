<?php
if (!defined('WEBPATH')) die();
require_once ('functions.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getFormattedMainSiteName('', ', ').getGalleryTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getGalleryDesc()); ?>" />
		<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ').getGalleryTitle() . getParentBreadcrumb(' / ') . ' / ' . html_encode( getBareAlbumTitle() )); ?></title>
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
					getParentBreadcrumb('<li class="chevron"><a> &gt; </a></li>');
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a>' . html_encode( getBareAlbumTitle() ) . '</a></li>';
				?>
				</ul>
			</div>
			<div id="content">
				<div class="description">
					<div class="title">
						<h3><?php echo html_encode( getAlbumTitle() ); ?></h3>
						<?php
						if( function_exists( 'zenFBLike' ) ) {
							zenFBLike();
						}
						?>
						<div class="date">
							<?php echo gettext( 'Taken on ' ) . getAlbumDate( getOption('date_format') ) ; ?>
						</div>
					</div>
					<?php
					if( getAlbumDesc() AND gettags() ) {
						$class = ' deux';
					} else {
						$class = ' un';
					}
					if( getAlbumDesc() ) {
					?>
					<div class="desc<?php echo $class; ?>">
						<?php echo html_encode( getAlbumDesc() ); ?>
					</div>
					<?php
					}
					if( gettags() ) {
						echo '<div class="tagsList' . $class . '">';
							printTags('links', 'Tags: ', '', ', ', false, '', true);
						echo '</div>';
					}
					if( function_exists( 'printRating' ) ) {
						echo '<div class="clear ratings">';
							printRating();
						echo '</div>';
					}
					?>
				</div>
				<div class="thumbs">
					<ul class="list">
						<?php while (next_album()): ?>
						<li>
							<div class="thumb">
								<a title="<?php echo html_encode(getAlbumDesc()); ?>" href="<?php echo htmlspecialchars(getAlbumLinkURL()); ?>">
									<img src="<?php echo getCustomAlbumThumb(150, NULL, NULL, 150, 150, NULL, NULL, false); ?>" alt="<?php echo html_encode(getAlbumTitle().' ('.getAlbumDate(getOption('date_format')).')'); ?>" />
								</a>
							</div>
							<div class="album">
								<div class="gras"><?php echo getAlbumTitle(); ?></div>
								<div class="italic"><small><?php echo '('.getAlbumDate(getOption('date_format')).')'; ?></small></div>
								<div><?php echo getAlbumDesc(); ?></div>
							</div>
						</li>
						<?php endwhile; ?>
						<?php while (next_image()): ?>
						<li>
							<div class="thumb">
								<a title="<?php echo html_encode(getImageDesc()); ?>" href="<?php echo htmlspecialchars(getImageLinkURL()); ?>">
									<img src="<?php echo getCustomImageURL(150, NULL, NULL, 150, 150, NULL, NULL, false); ?>" alt="<?php echo html_encode(getBareImageTitle().' ('.getImageDate(getOption('date_format')).')'); ?>" />
								</a>
							</div>
						</li>
						<?php endwhile; ?>
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
				<?php
				if( function_exists( 'printCommentForm' ) AND function_exists( 'zenFBComments' ) ) {
					$class=' deux';
				} else {
					$class=' un';
				}
				if( function_exists( 'printCommentForm' ) ) {
					echo '<div class="comments' . $class . '">';
					printCommentForm(true, '', false);
					echo '</div>';
				}
				if( function_exists( 'zenFBComments' ) ) {
					echo '<div class="facebook FBcomments comments' . $class . '">';
					zenFBComments();
					echo '</div>';
				}
				?>
				<div class="clear"></div>
			</div>
			<div id="footer">
					<?php include_once('footer.php'); ?>
			</div>
		</div>
		<?php include_once('analytics.php'); ?>
	</body>
</html>