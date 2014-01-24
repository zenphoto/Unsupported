<?php
if (!defined('WEBPATH')) die();
require_once ('functions.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode( getFormattedMainSiteName('', ', ').getGalleryTitle() . ', ' . getBareImageTitle() . ', ' . getTags() ); ?>" />
		<meta name="description" content="<?php echo html_encode(getImageDesc()); ?>" />
		<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ').getGalleryTitle() . getParentHeaderTitle(' / ') . ' / ' . getBareAlbumTitle() . ' / ' . getBareImageTitle()); ?></title>
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
					getParentBreadcrumb('<li class="chevron"><a> &gt; </a></li>');
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a href="' . getAlbumLinkURL() . '">' . getBareAlbumTitle() . '</a></li>';
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a>' . getBareImageTitle() . '</a></li>';
				?>
				</ul>
			</div>
			<div id="menu">
				<?php printThemeMenu(); ?>
			</div>
			<div id="content" class="c">
				<div id="description">
					<div class="c">
						<div id="title" class="box"><h3><?php printImageTitle(true); ?></h3></div>
						<div id="date" class="box"><?php echo '( ' . getImageDate( getOption('date_format') ) . ' )'; ?></div>
					</div>
					<?php
					if( getImageDesc() or zp_loggedin() ){
						
						echo '<div class="c"><div id="desc" class="box">';
						echo printImageDesc(true);
						echo '</div></div>';
					}
					if( getTags() or zp_loggedin() ){
						echo '<div class="c"><div id="tags" class="box">';
						printTags('links', '', '', ', ', true, '', true);
						echo '</div></div>';
					}
					if ( function_exists('printRating') ){
						echo '<div class="c"><div id="rating">';
						printRating();
						echo '</div></div>';
					}
					?>
				</div>
				<div class="clear_left"></div>
				<div id="image">
					<div>
						<?php
						$fullimage = getFullImageURL();
						if (!empty($fullimage)) {
							?>
							<a href="<?php echo htmlspecialchars($fullimage);?>" title="<?php echo getBareImageTitle();?>">
							<?php
						}
						printDefaultSizedImage(html_encode(getImageTitle()), 'image', 'player'); 
						if (!empty($fullimage)) {
							?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<div id="data">
				<?php if (getImageMetaData()) echo '<div>'.printImageMetadata().'</div>'; ?>
				</div>
				<div class="clear_left"></div>
				<div id="move">
					<?php
					if( function_exists( 'printjCarouselThumbNav' ) ){
						printjCarouselThumbNav(3, 50, 50, 50, 50, NULL);
					} else {
					?>
					<div id="prev" <?php if (hasPrevImage()) {echo 'class="active"';}?>>
					<?php if (hasPrevImage()): ?><a href="<?php echo htmlspecialchars(getPrevImageURL()); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
					</div>
					<div id="next" <?php if (hasNextImage()) {echo 'class="active"';}?>>
					<?php if (hasNextImage()): ?><a href="<?php echo htmlspecialchars(getNextImageURL()); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
					</div>
					<?php
					}
					?>
				</div>
				<?php commentFormDisplay(); ?>
				<div class="clear_right"></div>
			</div>
			<div id="footer">
				<?php include_once('footer.php'); ?>
			</div>
		</div>
		<?php include_once('analytics.php'); ?>
	</body>
</html>

