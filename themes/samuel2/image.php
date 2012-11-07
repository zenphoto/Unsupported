<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/zen.css" type="text/css" />
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

</head>

<body>
<?php printAdminToolbox(); ?>
<div>
	<div class="spiffy_content">

		<div class="imgnav">
			<?php if (hasPrevImage()) { ?>
			<a href="<?php echo getPrevImageURL();?>" title="Previous Image">&laquo; prev</a>
			<?php } if (hasNextImage()) { ?>
			<a href="<?php echo getNextImageURL();?>" title="Next Image">next &raquo;</a>
			<?php } ?>
		</div>

		<h1><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a>
		  | <a href="<?php echo getAlbumLinkURL();?>" title="Gallery Index"><?php echo getAlbumTitle();?></a>
		  | </span> <?php printImageTitle(true); ?></h1>

	</div>
	<b class="spiffy">
		<b class="spiffy5"></b>
		<b class="spiffy4"></b>
		<b class="spiffy3"></b>
		<b class="spiffy2"><b></b></b>
		<b class="spiffy1"><b></b></b>
	</b>
</div>

<div>
	<b class="contentbox">
		<b class="contentbox1"><b></b></b>
		<b class="contentbox2"><b></b></b>
		<b class="contentbox3"></b>
		<b class="contentbox4"></b>
		<b class="contentbox5"></b>
	</b>
	<div class="contentbox_content">

	<div id="image">
		<MAP NAME = "imagenav">
		<?php if (hasPrevImage()) { ?>
		<AREA SHAPE="rect" COORDS="0,0 297,297" href="<?php echo getPrevImageURL();?>">
		<?php } if (hasNextImage()) { ?>
		<AREA SHAPE="rect" COORDS="299,0 595,595" href="<?php echo getNextImageURL();?>">
		<?php } ?>
		</MAP>
		<IMG src="<?php echo getDefaultSizedImage();?>" USEMAP="#imagenav">
	</div>


	<div id="narrow">

		<p class="imgdesc"><?php printImageDesc(true); ?></p>

		<p class="imgdesc"><a href="<?php echo getFullImageURL();?>" title="view original full size" target="_blank">view original size</a></p>

		<div id="comments">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>

		</div>
	</div>
	</div>

	<b class="contentbox">
		<b class="contentbox5"></b>
		<b class="contentbox4"></b>
		<b class="contentbox3"></b>
		<b class="contentbox2"><b></b></b>
		<b class="contentbox1"><b></b></b>
	</b>
</div>

</div>
</body>
</html>
