<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
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
	<?php zp_apply_filter('theme_head'); ?>


	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/scripts/BubbleTooltips.js"></script>
	<script type="text/javascript">
		window.onload=function(){enableTooltips()};
	</script>

</head>

<body>

<div id="main">
	<?php printAdminToolbox(); ?>

	<div class="imgnav">
		<?php if (hasPrevImage()) { ?>
		<div class="imgprevious"><a href="<?php echo getPrevImageURL();?>" title="Previous Image"><img src="<?php echo $_zp_themeroot ?>/images/prev.gif"></a></div>
		<?php } if (hasNextImage()) { ?>
		<div class="imgnext"><a href="<?php echo getNextImageURL();?>" title="Next Image"><img src="<?php echo $_zp_themeroot ?>/images/next.gif"></a></div>
		<?php } ?>
	</div>

	<div id="gallerytitle">
		<h2 id="title"><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a></h2>

		<h2 id="titlesub">Looking at "<?php printImageTitle(true); ?>" in the <a href="<?php echo getAlbumLinkURL();?>" title="Album Index"><?php echo getAlbumTitle();?></a> album</h2>
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

<div id="credit">Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>
<br />
</body>
</html>
