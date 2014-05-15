<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); ?>
<?php
################################################################################
# Pink Clouds - Options
################################################################################
# This theme works best if you're using a resolution of 1024x768 or higher.

$pc_AjaxFx = true;
################################################################################
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot; ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<script src="<?php echo $_zp_themeroot; ?>/js/lib/prototype.js" type="text/javascript"></script>
	<script src="<?php echo $_zp_themeroot; ?>/js/src/scriptaculous.js" type="text/javascript"></script>
	
<?php if ($pc_AjaxFx) { ?>
	<script type="text/javascript">
		Effect.OpenUp = function(element) {
			element = $(element);
			new Effect.BlindDown(element, arguments[1] || {});
		}

		Effect.CloseDown = function(element) {
			element = $(element);
			new Effect.BlindUp(element, arguments[1] || {});
		}

		Effect.Combo = function(element) {
			element = $(element);

			if(element.style.display == 'none') {
				new Effect.OpenUp(element, arguments[1] || {});
			}else {
				new Effect.CloseDown(element, arguments[1] || {});
			}
		}
	</script>
<?php } ?>
</head>
<body scroll="no"> <!-- scroll="no" to get rid of IE6 scrollbar -->
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="header">
		<div id="gallerytitle">
			<h2>
				<a href="<?php echo getGalleryIndexURL();?>"
					title="Gallery Index"><?php echo getGalleryTitle();?></a> }
				<a href="<?php echo getAlbumURL();?>"
					title="Gallery Index"><?php echo getAlbumTitle();?></a> }
            <?php printImageTitle(true); ?>
			</h2>
		</div>

		<div id="img_header_bg">
			<div id="img_header">&nbsp;</div>
		</div>
	</div>

	<div id="navigation">
	   <ul>
<?php
	if (hasPrevImage()) { $link = getPrevImageURL(); } else { $link = "#"; }
   echo "<li><a href=\"$link\" title=\"Previous Image\">&laquo;</a></li>\n";
/*
	for ($i = 1; $i <= $totalPages; $i++) {
	   echo ($i == $currentPage)? '<li class="current">' : '<li>';
	   if ($i < 10) { $page = '0' . $i; } else { $page = $i; }
		printLinkHTML(getPageURL($i), $page, "Page $page");
		echo "</li>\n";
	}
*/
	if (hasNextImage()) { $link = getNextImageURL(); } else { $link = "#"; }
   echo "<li><a href=\"$link\" title=\"Next Image\">&raquo;</a></li>";
?>
		</ul>
	</div>

	<div id="imageList">
		<?php printCustomSizedImage(getImageTitle(), 320); ?>
	</div>

	<div id="text">
	   <?php printImageDesc(true); ?>
		<div id="commentbox">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>


		</div>
	</div>

	<div id="footer">
		<div id="logo">
			<?php printZenphotoLink(); ?>
		</div>
		<div id="options">
<?php
	if (zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLinkHTML(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
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

<?php
zp_apply_filter('theme_body_close');
?>

</body>
</html>
