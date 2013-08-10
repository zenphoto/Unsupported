<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html>

<html>
<head>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); echo "\n"; ?>
	
	<script type="text/javascript">
	// <!-- <![CDATA[
	$(document).ready(function(){
		$(".colorbox").colorbox({
			inline: true,
			href: "#imagemetadata",
			close: '<?php echo gettext("close"); ?>'
			});
		$("a.gallery").colorbox({
			maxWidth: "98%",
			maxHeight: "98%",
			photo: true,
			close: '<?php echo gettext("close"); ?>'
			});
	});
	// ]]> -->
	</script>
	
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

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
			<div>
				<a class="gallery" href="<?php echo html_encode(getFullImageURL()); ?>" rel="gallery" title="<?php printBareImageTitle();?>"><?php printDefaultSizedImage(getBareImageTitle()); ?></a>
			</div>
				<div id="image_data">
						<?php
						$fullimage = getFullImageURL();
						if (!empty($fullimage) && !isImageVideo()) {
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
						if (getImageMetaData()) {
							printImageMetadata(NULL, 'colorbox');
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
				</div> <!-- \\ .image -->
				<?php
				if (function_exists('printCommentForm')) {
					printCommentForm();
				}
				?>

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
			<?php printf(gettext("%s seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
		</div> <!-- \\ #credit -->
</div> <!-- \\ #main -->

<?php
zp_apply_filter('theme_body_close');
?>

</body>
</html>
