<?php
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getFormattedMainSiteName('', ', ').getGalleryTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getGalleryDesc()); ?>" />
		<title><?php echo strip_tags(getFormattedMainSiteName('', ' / ') . getGalleryTitle() . ' / News' );
		if( is_NewsArticle() ){
			echo strip_tags( ' / ' . getNewsTitle() );
		}
		?></title>
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
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a';
					if( is_NewsArticle() ){
						echo ' href="' . getNewsURL() . '">News</a></li><li class="chevron"><a> &gt; </a></li><li><a>' . strip_tags( getNewsTitle() );
					}
					else {
						echo '>News';
					}
					echo '</a></li>';
				?>
				</ul>
			</div>
			<div id="menu">
				<?php printThemeMenu(); ?>
			</div>
			<div id="content" class="c">
				<div id="news">
					<div>
					<?php
					if( is_NewsArticle() ){
					?>
						<div id="description">
							<div class="c">
								<div id="title" class="box"><h3><?php echo getNewsTitle(); ?></h3></div>
								<div id="date" class="box"><?php echo '( ' . getNewsDate( getOption('date_format') ) . ' )'; ?></div>
							</div>
							<?php
							if( getNewsCategories() or zp_loggedin() ){
								$cat = getNewsCategories();
								if ( !empty( $cat ) ) {
									echo '<div class="c"><div id="tags" class="box">';
									printNewsCategories(", ",gettext("Categories: "),"newslist_categories"); 
									echo '</div></div>';
								}
							}
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
							printNewsContent();
							printCodeblock(2);
						?>
						</div>
						<?php commentFormDisplay(); ?>
					<?php
					}
					else {
						newsListDisplay();
					}
					?>
					</div>
				</div>
				<div class="clear_left"></div>
				<div id="move">
					<?php if(is_NewsArticle()) { ?>
					<div id="prev" <?php if (getPrevNewsURL()) {echo 'class="active"';}?>>
					<?php if (getPrevNewsURL()): ?><a href="<?php echo getPrevNewsURL()['link']; ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
					</div>
					<div id="next" <?php if (getNextNewsURL()) {echo 'class="active"';}?>>
					<?php if (getNextNewsURL()): ?><a href="<?php echo getNextNewsURL()['link']; ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
					</div>
					<?php }
					else { ?>
					<div id="prev" <?php if (getPrevNewsPageURL()) {echo 'class="active"';}?>>
					<?php if (getPrevNewsPageURL()): ?><a href="<?php echo getPrevNewsPageURL(); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
					</div>
					<div id="next" <?php if (getNextNewsPageURL()) {echo 'class="active"';}?>>
					<?php if (getNextNewsPageURL()): ?><a href="<?php echo getNextNewsPageURL(); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
					</div>
					<?php } ?>
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

