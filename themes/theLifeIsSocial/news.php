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
		<title>
			<?php echo strip_tags(getFormattedMainSiteName('', ' / ').getGalleryTitle() . ' / ' . gettext('News') );
			if( is_NewsArticle() ){
				echo strip_tags( ' / ' . getNewsTitle() );
			}
			?>
		</title>
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
					echo '<li><a';
					if( is_NewsArticle() ){
						echo ' href="' . getNewsBaseUrl() . '">News</a></li><li class="chevron"><a> &gt; </a></li><li><a>' . strip_tags( getNewsTitle() );
					}
					else {
						echo '>News';
					}
					echo '</a></li>';
				?>
				</ul>
			</div>
			<div id="content">
				<?php
				if( is_NewsArticle() ){ // Affichage d'une news particulière
				?>
				<div class="description">
					<div class="title">
						<h3><?php echo html_encode( getNewsTitle() ); ?></h3>
						<?php
						if( function_exists( 'zenFBLike' ) ) {
							zenFBLike();
						}
						?>
						<div class="date">
							<?php
							if( !is_GalleryNewsType() ) {
								echo gettext( 'Written by ' ) . getNewsAuthor() . gettext( ' on ' ) . getNewsDate( );
							}
							?>
						</div>
					</div>
					<?php
					if( getNewsCategories() ){
						echo '<div class="tagsList">';
						printNewsCategories(", ",gettext("Categories: "),"newslist_categories"); 
						echo '</div>';
					}
					if( function_exists( 'printRating' ) ) {
						echo '<div class="clear ratings">';
							printRating();
						echo '</div>';
					}
					?>
				</div>
				<div id="news">
					<?php
						printCodeblock(1);
						printNewsContent();
						printCodeblock(2);
					?>
				</div>
				<?php
				} else { // Liste des news
				?>
				<div id="newses">
				<?php
					while (next_news()) {
				?>
					<div class="article">
						<div class="description">
							<div class="title">
								<h3>
								<?php
								if( !is_GalleryNewsType() ) { // C'est un article
									printNewsTitleLink();
								} else { // C'est un album
									echo '<a href="' . getNewsAlbumURL() . '" title="' . getNewsTitle() . '">' . getNewsTitle() . '</a>';
								}
								?>
								</h3>
								<?php
								if( function_exists( 'zenFBLike' ) ) {
									zenFBLike();
								}
								?>
								<div class="date">
									<?php
									if( !is_GalleryNewsType() ) { // C'est un article
										echo gettext( 'Written by ' ) . getNewsAuthor() . gettext( ' on ' ) . getNewsDate( );
									}
									?>
								</div>
							</div>
						</div>
						<div class="content">
							<?php printCodeblock(1); ?>
							<?php printNewsContent(); ?>
							<?php printCodeblock(2); ?>
							<?php if( getNewsReadMore() ){ ?>
							<p class="italic readmore"><?php printNewsReadMoreLink(); ?></p>
							<?php } ?>
						</div>
					</div>
				<?php
					}
				?>
				</div>
				<?php
				}
				?>
				<div class="clear"></div>
				<div id="move">
					<?php
					if(is_NewsArticle()) { // Affichage d'une news particulière
					?>
					<div id="prev" <?php if (getPrevNewsURL()) {echo 'class="active"';}?>>
						<?php if (getPrevNewsURL()): ?><a href="<?php echo getPrevNewsURL(); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
					</div>
					<div id="next" <?php if (getNextNewsURL()) {echo 'class="active"';}?>>
						<?php if (getNextNewsURL()): ?><a href="<?php echo getNextNewsURL(); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
					</div>
					<?php
					} else { // Affichage de la liste de news
					?>
					<div id="prev" <?php if (getPrevNewsPageURL()) {echo 'class="active"';}?>>
						<?php if (getPrevNewsPageURL()): ?><a href="<?php echo getPrevNewsPageURL(); ?>">Prev</a><?php else: ?><span>Prev</span><?php endif; ?>
					</div>
					<div id="next" <?php if (getNextNewsPageURL()) {echo 'class="active"';}?>>
						<?php if (getNextNewsPageURL()): ?><a href="<?php echo getNextNewsPageURL(); ?>">Next</a><?php else: ?><span>Next</span><?php endif; ?>
					</div>
					<?php
					}
					?>
				</div>
				<?php
				if( is_NewsArticle() ) {
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

