<?php if (!defined('WEBPATH')) die();  ?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<?php printHeadTitle(); ?>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php if (class_exists('RSS')) printRSSHeaderLink("News", "News", ""); ?>
	
</head>

<body>
	<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL();?>" ><?php echo getGalleryTitle();?></a></span>
		<span class="linkit"><span><?php printNewsIndexURL(); ?></span></span>		
		<?php if ( isset($_zp_current_zenpage_news) ) { ?>
		<span class="albumtitle"><span><?php printNewsTitle(''); ?></span></span>
		<?php } ?>
		<?php if ( isset($_zp_current_category) ) { ?>
		<span class="albumtitle"><span><?php printCurrentNewsCategory(''); ?></span></span>
		<?php } ?>
		</h2>
	</div>
	
	<div id="padbox">
	<div class="imageit newsbody">
	
	<?php
// single news article
	if (is_NewsArticle()) {
		?>
		<?php if (getPrevNewsURL()) { ?><div class="singlenews_prev"><?php printPrevNewsLink(''); ?></div><?php } ?>
		<?php if (getNextNewsURL()) { ?><div class="singlenews_next"><?php printNextNewsLink(''); ?></div><?php } ?>
		<?php if (getPrevNewsURL() OR getNextNewsURL()) { ?><br style="clear:both" /><?php } ?>
		<h3><?php printNewsTitle(); ?></h3>
		<div class="newsarticlecredit"><span class="newsarticlecredit-left"><?php printNewsDate(); ?> | <?php
				if (function_exists('getCommentCount')) {
					echo gettext("Comments:");
					?> <?php echo getCommentCount(); ?> |<?php } ?> </span> <?php printNewsCategories(", ", gettext("Categories: "), "newscategories"); ?></div>
		<?php
		printNewsContent();
		printCodeblock(1);
		?>
		<?php printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ', '); ?>
		<br style="clear:both;" /><br />
		<?php @call_user_func('printRating'); ?>
		<?php
		// COMMENTS TEST
		@call_user_func('printCommentForm');
	} else {
		echo "<hr />";
// news article loop
		while (next_news()):;
			?>
			<div class="newsarticle">
				<h3><?php printNewsURL(); ?><?php echo " <span class='newstype'>[" . gettext('news') . "]</span>"; ?></h3>
				<div class="newsarticlecredit">
					<span class="newsarticlecredit-left">
						<?php
						printNewsDate();
						if (function_exists('getCommentCount')) {
							?>
							|
							<?php
							echo gettext("Comments:");
							?>
							<?php
							echo getCommentCount();
						}
						?></span>
					<?php
					echo ' | ';
					printNewsCategories(", ", gettext("Categories: "), "newscategories");
					?>
				</div>
				<?php printNewsContent(); ?>
				<?php printCodeblock(1); ?>
				<?php
				if (getTags()) {
					echo gettext('<strong>Tags:</strong>');
				} printTags('links', '', 'taglist', ', ');
				?>
				<br style="clear:both;" /><br />
			</div>
			<?php
		endwhile;
	}
	?>
  	</div>
		</div>
		<div id="tools">
		<?php if (!is_NewsArticle()) {
			 if (hasPrevPage()) { ?>
			<a href="<?php echo getPrevNewsPageURL(); ?>"><span class="prev"></span></a>
			<?php } else { ?>
				<span class="prev-disabled"></span>
			<?php } ?>	

			<?php if (hasNextPage()) { ?>
			<a href="<?php echo getNextNewsPageURL(); ?>" ><span class="next"></span></a>
			<?php } else { ?>
				<span class="next-disabled"></span>		
			<?php } 
				} ?>
		</div>
	</div>
</div>

<div id="credit"><?php printRSSLink('News', '', 'News RSS', '', false); ?> | <a href="<?php echo getCustomPageURL("archive"); ?>">Archives</a> | <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
