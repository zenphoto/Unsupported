<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<script type="text/javascript">
	  function toggleComments() {
      var commentDiv = document.getElementById("comments");
      if (commentDiv.style.display == "block") {
        commentDiv.style.display = "none";
      } else {
        commentDiv.style.display = "block";
      }
	  }
	</script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/scripts/BubbleTooltips.js"></script>
	<script type="text/javascript">
		window.onload=function(){enableTooltips()};
	</script>

</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="main">

	<div class="imgnav">
		<?php if (hasPrevImage()) { ?>
		<div class="imgprevious"><a href="<?php echo getPrevImageURL();?>" title="Previous Image"><img src="<?php echo $_zp_themeroot ?>/images/prev.gif"></a></div>
		<?php } if (hasNextImage()) { ?>
		<div class="imgnext"><a href="<?php echo getNextImageURL();?>" title="Next Image"><img src="<?php echo $_zp_themeroot ?>/images/next.gif"></a></div>
		<?php } ?>
	</div>

	<div id="gallerytitle">
		<h2 id="title"><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a></h2>

		<h2 id="titlesub">Looking at "<?php printImageTitle(true); ?>" in the <a href="<?php echo getAlbumURL();?>" title="Album Index"><?php echo getAlbumTitle();?></a> album</h2>
	</div>

	<div id="image">
		<a href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>"> <?php printDefaultSizedImage(getImageTitle()); ?></a>
	</div>

	<div id="narrow">

		<?php printImageDesc(true); ?>

		<div id="comments">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>

		</div>
	</div>
</div>

<div id="credit"><?php printZenphotoLink(); ?></div>
<br />
<?php 
 zp_apply_filter('theme_body_close'); 
 ?>
</body>
</html>
