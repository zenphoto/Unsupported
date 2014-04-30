<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();
$startTime = array_sum(explode(" ",microtime()));
?>
<!DOCTYPE html>

<html>
<head>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Search"); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
	<div id="gallerytitle">
		<?php
			printSearchForm();
		?>
		<h2><span><?php printHomeLink('', ' | '); ?><a href="
		<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Gallery Index') ?>">
		<?php echo getGalleryTitle();?></a> |
		<?php
		  echo "<em>".gettext("Search")."</em>";
		?>
		</span></h2>
		</div>

		<hr />

		<?php
			if (($total = getNumImages() + getNumAlbums()) > 0) {
				if (isset($_REQUEST['date']))	{
					$searchwords = getSearchDate();
	 		} else {
	 			$searchwords = getSearchWords(); }
				echo "<p>".sprintf(gettext('Total matches for <em>%1$s</em>: %2$u'),$searchwords,$total).'</p>';
			}
			$c = 0;
		?>
<div id="albums">
			<?php while (next_album()): $c++;?>
			<div class="album">
					<div class="albumthumb"><a href="<?php echo htmlspecialchars(getAlbumURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
						<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
						</div>
					<div class="albumtitle">
									<h3><a href="<?php echo htmlspecialchars(getAlbumURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
							<?php printAlbumTitle(); ?></a></h3> <?php printAlbumDate(); ?>
								</div>
						<div class="albumdesc"><?php printAlbumDesc(); ?></div>
				</div>
				<hr />
 		<?php endwhile; ?>
		</div>

		<div id="images">
		<?php while (next_image()): $c++;?>
			<div class="image">
					<div class="imagethumb">
							<a href="<?php echo htmlspecialchars(getImageURL());?>" title="<?php echo getBareImageTitle();?>">
						<?php printImageThumb(getAnnotatedImageTitle()); ?></a>
						</div>
			</div>
				<?php endwhile; ?>
		</div>

	<br clear="all" />
	<?php
			if (function_exists('printSlideShowLink')) {
				echo "<p align=\"center\">";
				printSlideShowLink(gettext('View Slideshow'));
				echo "</p>";
			}
			if ($c == 0) {
				echo "<p>".gettext("Sorry, no image matches. Try refining your search.")."</p>";
			}

			echo '<br clear="all" />';
			printPageListWithNav("« ".gettext('prev'), gettext('next')." »");
	?>


		<div id="credit">
			<?php printRSSLink('Gallery', '', gettext('Gallery RSS'), ' | '); ?>
		<?php printZenphotoLink(); ?>
			 | <?php printCustomPageURL(gettext("Archive View"),"archive"); ?>
		<?php
		if (function_exists('printUserLogin_out')) {
			printUserLogin_out(" | ");
		}
		?>
		<br />
			<?php printf(gettext("%s seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
	</div>
</div>

<?php
zp_apply_filter('theme_body_close');
?>

</body>
</html>
