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
		<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ').getGalleryTitle() . ' / ' . html_encode( getBarePageTitle() ) ); ?></title>
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
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a>' . html_encode( getBarePageTitle() ) . '</a></li>';
				?>
				</ul>
			</div>
			<div id="content">
				<div class="description">
					<div class="title">
						<h3><?php echo getPageTitle(); ?></h3>
						<?php
						if( function_exists( 'zenFBLike' ) ) {
							zenFBLike();
						}
						?>
						<div class="date">
							<?php echo gettext( 'Written by ' ) . getAuthor() . gettext( ' on ' ) . getPageDate( getOption('date_format') ); ?>
						</div>
					</div>
					<?php
					if( function_exists( 'printRating' ) ) {
						echo '<div class="clear ratings">';
							printRating();
						echo '</div>';
					}
					?>
				</div>
				<div id="page">
					<?php
					printCodeblock(1);
					printPageContent();
					printCodeblock(2);
					?>
				</div>
				<?php
				if( function_exists( 'printCommentForm' ) AND function_exists( 'zenFBComments' ) ) {
					$class = ' deux';
				} else {
					$class = ' un';
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

