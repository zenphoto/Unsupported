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
		<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ') . getGalleryTitle() . ' / ' .getPageTitle() ); ?></title>
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
					echo '<li><a>' . strip_tags( getPageTitle() ) . '</a></li>';
				?>
				</ul>
			</div>
			<div id="menu">
				<?php printThemeMenu(); ?>
			</div>
			<div id="content" class="c">
				<div id="news">
					<div>
						<div id="description">
							<div class="c">
								<div id="title" class="box"><h3><?php echo getPageTitle(); ?></h3></div>
								<div id="date" class="box"><?php echo '( ' . getPageDate( getOption('date_format') ) . ' )'; ?></div>
							</div>
							<?php
							if ( function_exists('printRating') ){
								echo '<div class="c"><div id="rating">';
								printRating();
								echo '</div></div>';
							}
							?>
						</div>
						<div class="clear_left"></div>
						<div class="newsArticle">
						<?php
							printCodeblock(1);
							printPageContent();
							printCodeblock(2);
						?>
						</div>
					</div>
				</div>
				<?php commentFormDisplay(); ?>
				<div class="clear"></div>
			</div>
			<div id="footer">
				<?php include_once('footer.php'); ?>
			</div>
		</div>
		<?php include_once('analytics.php'); ?>
	</body>
</html>

