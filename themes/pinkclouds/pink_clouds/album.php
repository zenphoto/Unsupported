<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); ?>
<?php
################################################################################
# Pink Clouds - Options
################################################################################
# This theme works best if you're using a resolution of 1024x768 or higher.

// Do you want the row of images to break after a certain number?
$pc_RowBreak = true;

// Edit this value to show how many images you'd like to see per row or break.
$pc_ImagesPerRow = 4;
$pc_AlbumsPerRow = 4;

$pc_AjaxFx = true;
################################################################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot; ?>/zen.css" type="text/css" />
	<script src="<?php echo WEBPATH . '/zp-core/js'; ?>/prototype.js" type="text/javascript"></script>
	<script src="<?php echo WEBPATH . '/zp-core/js'; ?>/scriptaculous/scriptaculous.js" type="text/javascript"></script>
	<?php zp_apply_filter('theme_head'); ?>
</head>
<body scroll="no"> <!-- scroll="no" to get rid of IE6 scrollbar -->
<?php printAdminToolbox(); ?>
<div id="main">

	<div id="header">
		<div id="gallerytitle">
			<h2>
				<a href="<?php echo getGalleryIndexURL(); ?>"
					title="Gallery Index"><?php echo getGalleryTitle() ;?></a>
					} <?php printAlbumTitle(true); ?>
			</h2>
		</div>

		<div id="img_header_bg">
			<div id="img_header">&nbsp;</div>
		</div>
	</div>

	<div id="navigation">
	   <ul>
<?php
   $totalPages = getTotalPages();
	$currentPage = getCurrentPage();

	if (hasPrevPage()) { $link = getPrevPageURL(); } else { $link = "#"; }
   echo "<li><a href=\"$link\" title=\"Previous Page\">&laquo;</a></li>\n";

	for ($i = 1; $i <= $totalPages; $i++) {
	   echo ($i == $currentPage)? '<li class="current">' : '<li>';
	   if ($i < 10) { $page = '0' . $i; } else { $page = $i; }
		printLink(getPageURL($i), $page, "Page $page");
		echo "</li>\n";
	}

	if (hasNextPage()) { $link = getNextPageURL(); } else { $link = "#"; }
   echo "<li><a href=\"$link\" title=\"Next Page\">&raquo;</a></li>";
?>
		</ul>
	</div>

	<div id="imageList">
<?php
	$imagesPerPage = getOption('images_per_page');
	$count = 1;
	while (next_image() && $count <= $imagesPerPage):
?>

			<div class="image">
				<a href="<?php echo getImageLinkURL();?>"
					title="<?php
		if (getImageDesc() == "") {
			echo getImageTitle();
		} else {
			echo getImageTitle() . ' - ' . getImageDesc();
		}
					?>"><img
					src="<?php echo getCustomImageURL(0, 100, 100); ?>"
					alt="<?php echo 'Image ' . ($count + (($currentPage - 1) * $imagesPerPage)) . ' of ' . getNumImages(); ?>"
					width="100" height="100"<?php
		if ($pc_AjaxFx) { echo '
				onLoad="new Effect.Fade(this, {from: 1 , to: .5, queue: \'parallel\', duration: .3});"
				onMouseOver="new Effect.Appear(this, {from: .5 , to: 1, queue: \'parallel\', duration: .3});"
				onMouseOut="new Effect.Fade(this, {from: 1 , to: .5, queue: \'parallel\', duration: .3});"
				';
		}
					?> /></a>
			</div>
<?php

		if (!($count % $pc_ImagesPerRow) && $pc_RowBreak) {
			echo '<br style="clear:both" />';
		}

		$count++;

	endwhile;
?>
	</div>

	<!-- subalbums -->
	<div id="albumList">
<?php
	$albumsPerPage = getOption('albums_per_page');
	$count = 1;
	while (next_album() && $count <= $albumsPerPage):
?>

			<div class="image">
				<a href="<?php echo getAlbumLinkURL();?>"
					title="<?php
		if (getAlbumDesc() == "") {
			echo getAlbumTitle();
		} else {
			echo getAlbumTitle() . ' - ' . getAlbumDesc();
		}
					?>"><img
					src="<?php echo getCustomAlbumThumb(0, 100, 100); ?>"
					alt="<?php echo 'Album ' . ($count + (($currentPage - 1) * $albumsPerPage)) . ' of ' . getNumAlbums(); ?>"
					width="100" height="100"<?php
		if ($pc_AjaxFx) { echo '
				onLoad="new Effect.Fade(this, {from: 1 , to: .5, queue: \'parallel\', duration: .3});"
				onMouseOver="new Effect.Appear(this, {from: .5 , to: 1, queue: \'parallel\', duration: .3});"
				onMouseOut="new Effect.Fade(this, {from: 1 , to: .5, queue: \'parallel\', duration: .3});"
				';
		}
					?> /></a>
			</div>
<?php

		if (!($count % $pc_AlbumsPerRow) && $pc_RowBreak) {
			echo '<br style="clear:both" />';
		}

		$count++;

	endwhile;
?>
	</div>

	<div id="text"><?php printAlbumDesc(true); ?></div>

	<div id="footer">
		<div id="logo">
			<a href="http://www.zenphoto.org"
				title="A simpler web photo album">Powered by Zenphoto</a>
		</div>
		<div id="options">
<?php
	if (zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
	}
?>
		</div>
		<div id="info">
			<?php
				echo round((array_sum(explode(" ",microtime())) - $startTime),4).' seconds';
				echo ' . Pink Clouds 1.0 . ';
				echo 'ZenPhoto ';
				printVersion();
			?>
		</div>
	</div>

</div>
</body>
</html>
