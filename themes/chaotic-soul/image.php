<?php
if (!defined('WEBPATH')) die();
$themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<?php header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo  getAlbumTitle();?> | <?php echo  getImageTitle();?></title>
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

<div id="page">
<?php include("header.php") ?>



<div id="wrapper" class="clearfix">


	<div id="content" class="widecolumn">
	<div id="post">
	</div>

		<h2 class="title"><a href="<?php echo  getGalleryIndexURL();?>" title="Gallery Index"><?php echo  getGalleryTitle();?></a>
		  | <a href="<?php echo  getAlbumLinkURL();?>" title="Gallery Index"><?php echo  getAlbumTitle();?></a>
		  | <?php printImageTitle(true); ?></h2>
	</div>

	<div class="imgnav">
		<?php if (hasPrevImage()) { ?>
		<a href="<?php echo  getPrevImageURL();?>" title="Previous Image">&laquo; Prev</a>

		<?php } if (hasPrevImage() && hasNextImage()) { ?>
		|

		<?php } if (hasNextImage()) { ?>
		<a href="<?php echo  getNextImageURL();?>" title="Next Image">Next &raquo;</a>
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
	</div>
	</div>
</div>

<hr />
</div>

<?php printAdminToolbox(); ?>
</body>
</html>
