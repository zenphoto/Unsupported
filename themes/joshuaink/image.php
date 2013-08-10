<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html>

<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/css/gallery.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	
<script type="text/javascript">
	$(document).ready(function() {
    jQuery('a.gallery').colorbox({photo:true, rel:'gallery', slideshow:true});
    });
</script>
	
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="wrap">
	<div id="header">
		<?php printAlbumDesc(); ?>
	</div>

	<div id="gallerytitle">
	<h2><span>
		<a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a><?php printParentBreadcrumb(" | ","",""); ?><?php printAlbumBreadcrumb(" | ");?> | <?php printImageTitle(true); ?></span>
		<?php printImageTitle(true); ?></h2>
	</div>

	<div id="main-content">
		<div id="fullplate-photo">
			<h2><?php printImageDesc(true); ?></h2>
			<?php

				$mw = IMG_MAX_WIDTH;
				$mh = IMG_MAX_HEIGHT;
				$iw = getFullWidth();
				$ih = getFullHeight();

				if (isLandscape()) {
				   if ($iw >= $mw) {
				      list($nw, $nh) = getSizeCustomImage(null, $mw);
				      $iw = $nw;
				      $ih = null;

				      if ($nh > $mh) {
				      	list($nw, $nh) = getSizeCustomImage(null, null, $mh);
					      $iw = null;
					      $ih = $nh;
						}
					}
/*
						echo 'o: ' . getFullWidth() . 'x' . getFullHeight() . "<br />\n";
						echo 'i: ' . $iw . 'x' . $ih . "<br />\n";
						echo 'm: ' . $mw . 'x' . $mh . "<br />\n";
						echo 'n: ' . $nw . 'x' . $nh . "<br />\n";
*/
				} else {
				   if ($ih >= $mh) {
				      list($nw, $nh) = getSizeCustomImage(null, null, $mh);
				      $iw = null;
				      $ih = $nh;

				      if ($nw > $mw) {
				      	list($nw, $nh) = getSizeCustomImage(null, $mw);
					      $iw = $nw;
					      $ih = null;
						}
					}
/*
						echo 'o: ' . getFullWidth() . 'x' . getFullHeight() . "<br />\n";
						echo 'i: ' . $iw . 'x' . $ih . "<br />\n";
						echo 'm: ' . $mw . 'x' . $mh . "<br />\n";
						echo 'n: ' . $nw . 'x' . $nh . "<br />\n";
*/
				}
				list($imgw, $imgh) = getSizeCustomImage(null, $iw, $ih);
			?>
			<img src="<?php echo getCustomImageURL(null, $iw, $ih); ?>"
				alt="<?php echo getImageTitle(); ?>"
				width="<?php echo $imgw; ?>" height="<?php echo $imgh; ?>" /></a>
		</div>
	</div>

<?php
/*
	if (hasPrevImage()) { $link = getPrevImageURL(); } else { $link = "#"; }
   echo "\t\t" . '<li id="previous"><a href="' . $link . '" title="Previous Image">' .
		'<img src="' . $_zp_themeroot . '/images/arrow_left.png" width="16" ' .
		'height="16" alt="left arrow" /></a></li>' . "\n";
	echo "\t\t" . '<li><a href="' . getFullImageURL() . '" title="Full Size Image">' .
	   '<img src="' . $_zp_themeroot . '/images/arrow_out.png" width="16" ' .
		'height="16" alt="arrows pointing out" /></a></li>' . "\n";
	if (hasNextImage()) { $link = getNextImageURL(); } else { $link = "#"; }
   echo "\t\t" . '<li id="next"><a href="' . $link . '" title="Next Image">' .
		'<img src="' . $_zp_themeroot . '/images/arrow_right.png" width="16" ' .
		'height="16" alt="right arrow" /></a></li>' . "\n";
*/
?>

   <div id="fullplate-navigation">
      <ul>
   <?php
      if (hasPrevImage()) {
         echo "\t\t" . '<li id="previous"><a href="' . getPrevImageURL() .
            '" title="Previous Image"><img src="' . $_zp_themeroot .
            '/images/arrow_left.png" width="16" height="16" alt="left ' .
            'arrow" /></a></li>' . "\n";
      } else {
            echo "\t\t" . '<li>&nbsp;</li>' . "\n";
      }
      if (in_context(ZP_IMAGE)) {
         echo "\t\t" . '<li><a class="gallery" href="' . getFullImageURL() .
            '" title="Full Size Image"><img src="' . $_zp_themeroot .
            '/images/arrow_out.png" width="16" height="16" alt="arrows ' .
            'pointing out" /></a></li>' . "\n";
      } else {
            echo "\t\t" . '<li>&nbsp;</li>' . "\n";
      }
      if (hasNextImage()) {
         echo "\t\t" . '<li id="next"><a href="' . getNextImageURL() .
            '" title="Next Image"><img src="' . $_zp_themeroot .
            '/images/arrow_right.png" width="16" height="16" alt="right ' .
            'arrow" /></a></li>' . "\n";
      } else {
            echo "\t\t" . '<li>&nbsp;</li>' . "\n";
      }
         ?>
      </ul>
   </div>


	<?php if (function_exists('printCommentForm')) {
				printCommentForm();
		 } ?>


	<div id="foot">
		<div id="logo">
			<?php printZenphotoLink(); ?>
		</div>

		<div id="info">
			<?php	echo "\t\t" . round((array_sum(explode(" ",microtime())) - $startTime),4).' seconds'; ?> |
			<a href="http://joshuaink.com/blog/206/css-photo-gallery-template"><?php echo ji_ver(); ?></a> |
			ZenPhoto <?php echo ZENPHOTO_VERSION. "\n"; ?>
		</div>
	</div>

</div>
</div>

<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>
