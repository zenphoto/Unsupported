<?php $startTime = array_sum(explode(" ",microtime())); if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html>

<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/gallery.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
    <?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>

</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="wrap">

	<div id="header">
		<!--[if gte IE 5.5]>
			<p>Internet Explorer users should <a href="#">CLICK HERE</a> to activate the image rollovers.</p>
		<![endif]-->
	</div>

	<div id="gallerytitle"><h2><?php echo getGalleryTitle(); ?></h2></div>

	<div id="main-content">
		<ul>
		<?php
		   if(PAGINATED) {
         	while (next_album()){
         	   ji_show_thumb();
         	}
		   } else {
   			while (next_album()) { ji_show_thumb(); }
		   }
		?>
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
			<?php printZenphotoLink(); ?>
		</div>

		<div id="info">
			<?php	echo "\t\t" . round((array_sum(explode(" ",microtime())) - $startTime),4).' seconds'; ?> |
			<a href="http://joshuaink.com/blog/206/css-photo-gallery-template"><?php echo ji_ver(); ?></a> |
			ZenPhoto <?php echo ZENPHOTO_VERSION. "\n"; ?>
		</div>
	</div>

</div>

<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>
