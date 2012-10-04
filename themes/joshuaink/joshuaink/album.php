<?php 
$startTime = array_sum(explode(" ",microtime())); 
if (!defined('WEBPATH')) die();
require_once ('joshuaink.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
  <title><?php printGalleryTitle(); ?></title>
  <link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/css/gallery.css" type="text/css" />
  <?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>
<div id="wrap">

	<div id="header">
		<?php printAlbumDesc(true); ?>
		<!--[if gte IE 5.5]>
			<p>Internet Explorer users should <a href="#">CLICK HERE</a> to activate the image rollovers.</p>
		<![endif]-->
	</div>

	<div id="gallerytitle">
		<h2>
			<a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle(); ?></a> | <?php echo getAlbumTitle(); ?>
		</h2>
	</div>

	<div id="main-content">
		<ul><?php if(PAGINATED) { while (next_album()){ ji_show_thumb();}} else {while (next_album()) { ji_show_thumb(); }}?></ul>

<!--		<ul> -->
		<?php
			while (next_image()):

			$ch = THM_HEIGHT;
			$cw = THM_WIDTH;

			if (isLandscape()) {
			   list($nw, $nh) = getSizeCustomImage(null, null, $ch);
			   $ih = $ch;
			   if ($nw < $cw) {
				   list($nw, $nh) = getSizeCustomImage(null, $cw);
				   $ih = $ch;
				   $iw = $nw;
				} else {
				   $iw = $cw;
				}
			} else {
			   list($nw, $nh) = getSizeCustomImage(null, $cw);
			   $iw = $cw;
			   $ih = $ch;
			}

			//$cx = ($iw - $cw) / 2;
			//$cy = ($ih - $ch) / 2;
		?>

			<li>
				<a href="<?php echo getImageLinkURL();?>"
					title="<?php echo getImageTitle();?>"><img
					src="<?php echo getCustomImageURL(null, $iw, $ih, $cw, $ch); ?>"
					alt="<?php echo getImageTitle(); ?>"
					width="<?php echo $iw; ?>" height="<?php echo $ih; ?>" />
					<span><?php
						echo 'image size: ' . getFullWidth() . 'x' . getFullHeight();
						if (getImageDesc() != '') {
							echo '<br /><br />' . getImageDesc();
						} ?></span></a>
			</li>

		<?php endwhile; ?>
		</ul>
        
	</div>

   <div id="fullplate-navigation">
      <ul>
   <?php
      if (hasPrevPage()) {
         echo "\t\t" . '<li id="previous"><a href="' . getPrevPageURL() .
            '" title="Previous Image"><img src="' . $_zp_themeroot .
            '/images/arrow_left.png" width="16" height="16" alt="left ' .
            'arrow" /></a></li>' . "\n";
      } else {
            echo "\t\t" . '<li>&nbsp;</li>' . "\n";
      }
      if (in_context(ZP_IMAGE)) {
         echo "\t\t" . '<li><a href="' . getFullImageURL() .
            '" title="Full Size Image"><img src="' . $_zp_themeroot .
            '/images/arrow_out.png" width="16" height="16" alt="arrows ' .
            'pointing out" /></a></li>' . "\n";
      } else {
            echo "\t\t" . '<li>&nbsp;</li>' . "\n";
      }
      if (hasNextPage()) {
         echo "\t\t" . '<li id="next"><a href="' . getNextPageURL() .
            '" title="Next Image"><img src="' . $_zp_themeroot .
            '/images/arrow_right.png" width="16" height="16" alt="right ' .
            'arrow" /></a></li>' . "\n";
      } else {
            echo "\t\t" . '<li>&nbsp;</li>' . "\n";
      }
         ?>
      </ul>
   </div>

	<div id="foot">
		<div id="logo">
			<a href="http://www.zenphoto.org"
				title="A simpler web photo album">Powered by Zenphoto</a>
		</div>

		<div id="info">
			<?php	echo "\t\t" . round((array_sum(explode(" ",microtime())) - $startTime),4).' seconds'; ?> |
			<a href="http://joshuaink.com/blog/206/css-photo-gallery-template"><?php echo ji_ver(); ?></a> |
			ZenPhoto <?php echo getOption('version') . "\n"; ?>
		</div>
	</div>

</div>
</body>
</html>
