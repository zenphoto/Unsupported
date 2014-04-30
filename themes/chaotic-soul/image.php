<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo  getAlbumTitle();?> | <?php echo  getImageTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />

	<script type="text/javascript">

	function toggleComments() {
      	  var commentDiv = document.getElementById("comments");
      	  if (commentDiv.style.display == "block")
      	    commentDiv.style.display = "none";
      	  else
      	    commentDiv.style.display = "block";
	  }

	function toggleDiv(id) {
      	  var targetDiv = document.getElementById(id);
      	  if(targetDiv){
      	    targetDiv.style.display = (targetDiv.style.display == "block") ? "none" : "block";
      	  }
	}

	function commentPreview(field){

	  var previewDiv = document.getElementById("previewDiv");
	  var typedText = field.value;

	  previewDiv.style.display = (typedText.length == 0) ? "none" : "block";

	  var preview = "<h3>Comment Preview</h3>\n";
	  preview += typedText.split(/\n/).join("<br />");
	  previewDiv.innerHTML = preview;
	}

	function setImageBg(){
	  var image = document.getElementById("photo");
	  var imageDiv = document.getElementById("image");
	  if(image && imageDiv){
	    var className = (image.width > 500) ? "wideImage" : "tallImage";
	    imageDiv.className = className;
	  }
	}

	</script>

</head>

<body onload="setImageBg()">
<?php zp_apply_filter('theme_body_open'); ?>

<div id="page">
<?php include("header.php") ?>

<div id="wrapper" class="clearfix">


	<div id="content" class="widecolumn">
	<div id="post">
	</div>

		<h2 class="title"><a href="<?php echo  getGalleryIndexURL();?>" title="Gallery Index"><?php echo  getGalleryTitle();?></a>
		  | <a href="<?php echo  getAlbumURL();?>" title="Gallery Index"><?php echo  getAlbumTitle();?></a>
		  | <?php printImageTitle(true); ?></h2>
	</div>

	<div class="imgnav">
		<?php if (hasPrevImage()) { ?>
		<a href="<?php echo  getPrevImageURL();?>" title="Previous Image">&laquo; prev</a>

		<?php } if (hasPrevImage() && hasNextImage()) { ?>
		|

		<?php } if (hasNextImage()) { ?>
		<a href="<?php echo  getNextImageURL();?>" title="Next Image">next &raquo;</a>
		<?php } ?>
	</div>
	<div id="main">

	<div id="image">
		<a href="<?php echo  getFullImageURL();?>" title="<?php echo  getImageTitle();?>"> <?php printDefaultSizedImage(getImageTitle()); ?></a>
	</div>

	<div id="narrow">

		<p class="imgdesc"><?php printImageDesc(true); ?></p>

		<div id="comments">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>
		<br />
		<br />
	</div>
	</div>
	<hr class="hr-bottom" />
</div>

</div>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
