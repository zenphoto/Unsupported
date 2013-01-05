<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); ?>
<?php
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
header('Content-Type: text/html; charset=' . getOption('charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); echo "\n"; ?>
	
	<script type="text/javascript">
	$(document).ready(function() {
    jQuery('a.gallery').colorbox({photo:true, rel:'gallery', slideshow:true});
    });
	</script>
	
</head>
<body>

<div id="main">
	<div id="gallerytitle">
			<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a>
      | <?php printParentBreadcrumb(); printAlbumBreadcrumb("", " | "); ?></span> <?php printImageTitle(true); ?></h2>
	</div>

	<hr />
	<!-- The Image -->
		<div class="image">
		<div class="imgnav">
			<?php if (hasPrevImage()) { ?> <a class="prev" href="<?php echo htmlspecialchars(getPrevImageURL());?>" title="<?php echo gettext('Previous Image'); ?>">« <?php echo gettext("prev"); ?></a>
			<?php } if (hasNextImage()) { ?> <a class="next" href="<?php echo htmlspecialchars(getNextImageURL());?>" title="<?php echo gettext('Next Image'); ?>"><?php echo gettext("next");?> »</a><?php } ?>
		</div>
				<?php printDefaultSizedImage(getImageTitle()); ?></a>

				<div id="image_data">
						<?php
						$fullimage = getFullImageURL();
						if (!empty($fullimage)) {
							?>
							<div id="fullsize_download_link">
								<em>
								<a class="gallery" href="<?php echo htmlspecialchars($fullimage);?>" title="<?php echo getBareImageTitle();?>"><?php echo gettext("Original Size:"); ?>
									<?php echo getFullWidth() . "x" . getFullHeight(); ?>
								</a>
								</em>
							</div>
							<?
						}
						?>

					<div id="meta_link">
						<?php
							if (getImageMetaData()) {echo "<a href=\"#TB_inline?height=345&amp;width=400&amp;inlineId=imagemetadata\" title=\"".gettext("Image Info")."\" class=\"thickbox\">".gettext("Image Info")."</a>";
								printImageMetadata('', false);
							}
					?>
					</div>

					<br clear="all" />
					<?php printImageDesc(true); ?>
					<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
					<?php if (function_exists('zenPaypal')) { zenPaypal(NULL, true); } ?>
					<?php if (function_exists('googleCheckout')) {
						printGoogleCartWidget();
						googleCheckout(NULL, true);
					} ?>



          <div class="rating"><?php if (function_exists('printRating')) printRating(); ?></div>
				</div>

				<?php
				if (function_exists('printCommentForm')) {
					printCommentForm();
				}
				?>

		</div>

		<div id="credit">
			<?php printRSSLink('Gallery','','RSS', ' | '); ?>
			<?php printZenphotoLink(); ?>
			 | <?php printCustomPageURL(gettext("Archive View"),"archive"); ?>
			<?php
			if (function_exists('printUserLogin_out')) {
				printUserLogin_out(" | ");
			}
			?>
			<br />
			<?php printf(gettext("%u seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
		</div>
</div>

<?php printAdminToolbox(); ?>

</body>
</html>
