<?php
if (!defined('WEBPATH'))
	die();
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
?>
<!DOCTYPE html>
<head>
	<title><?php echo gettext("News"); ?> <?php echo getBareNewsTitle(""); ?><?php printCurrentNewsCategory(" | ");
printCurrentNewsArchive(); ?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
<?php printRSSHeaderLink("News", "", "Zenpage news", ""); ?>
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

	<div id="main">

		<div id="header">
			<h1><?php printGalleryTitle(); ?></h1>
			<?php
			if (getOption('Allow_search')) {
				if (is_NewsCategory()) {
					$catlist = array('news' => array($_zp_current_category->getTitlelink()), 'albums' => '0', 'images' => '0', 'pages' => '0');
					printSearchForm(NULL, 'search', NULL, gettext('Search category'), NULL, NULL, $catlist);
				} else {
					$catlist = array('news' => '1', 'albums' => '0', 'images' => '0', 'pages' => '0');
					printSearchForm(NULL, "search", "", gettext("Search news"), NULL, NULL, $catlist);
				}
			}
			?>
		</div>

		<div id="content">

			<div id="breadcrumb">
				<h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo gettext("Home"); ?></a> <?php printNewsIndexURL(gettext('News'), ' » '); ?><strong><?php printZenpageItemsBreadcrumb(' » ', '');
			printCurrentNewsCategory(" » "); ?><?php printNewsTitle(" » ");
			printCurrentNewsArchive(" » "); ?></strong>
				</h2>
			</div>

			<div id="sidebar">
				<?php include("sidebar-left.php"); ?>
			</div><!-- sidebar-left -->

			<div id="content-right">
				<?php
// single news article
				if (is_NewsArticle()) {
					?>
					<?php if (getPrevNewsURL()) { ?><div class="singlenews_prev"><?php printPrevNewsLink(); ?></div><?php } ?>
					<?php if (getNextNewsURL()) { ?><div class="singlenews_next"><?php printNextNewsLink(); ?></div><?php } ?>
					<?php if (getPrevNewsURL() OR getNextNewsURL()) { ?><br style="clear:both" /><?php } ?>
					<?php if (function_exists('zenFBLike')) {
						zenFBLike();
					} ?>
					<h3><?php printNewsTitle(); ?></h3>
					<div class="newsarticlecredit"><span class="newsarticlecredit-left"><?php printNewsDate(); ?> | | </span> <?php printNewsCategories(", ", gettext("Categories: "), "newscategories"); ?></div>
					<?php printNewsContent(); ?>
					<?php printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ', '); ?>
					<br style="clear:both;" /><br />
					<?php if (function_exists('printRating')) {
						printRating();
					} ?>
	<?php//Comments  ?>
					<div align="center"><?php if (function_exists('zenFBComments')) {
		zenFBComments();
	} ?></div><?php
						} else {
							printNewsPageListWithNav(gettext('next »'), gettext('« prev'));
							echo "<hr />";
// news article loop
							while (next_news()):;
								?>
						<div class="newsarticle">
							<h3><?php printNewsURL(); ?><?php echo " <span class='newstype'>[" . getNewsURL() . "]</span>"; ?></h3>
							<div class="newsarticlecredit"><span class="newsarticlecredit-left"><?php printNewsDate(); ?> | <?php echo gettext("Comments:"); ?> <?php echo getCommentCount(); ?></span>
							<?php
							if (is_NewsPage()) {
								echo "<br />";
							} else {
								echo ' | ';
								printNewsCategories(", ", gettext("Categories: "), "newscategories");
							}
							?>
							</div>
		<?php printNewsContent(); ?>
		<?php printCodeblock(1); ?>
		<?php printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ', '); ?>
							<br style="clear:both;" /><br />
						</div>
		<?php
	endwhile;
	printNewsPageListWithNav(gettext('next »'), gettext('« prev'));
}
?>


			</div><!-- content right-->


			<div id="fb-bar">
	<?php include("rightbar.php"); ?>
			</div><!-- fb-bar -->


			<div id="footer">
<?php include("footer.php"); ?>
			</div>

		</div><!-- content -->

	</div><!-- main -->
<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>