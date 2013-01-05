<?php  if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<?php  zp_apply_filter('theme_head'); ?>
	<title><?php  printGalleryTitle(); ?> | <?php  echo getAlbumTitle();?> | <?php  echo getImageTitle();?></title>
	<link rel="stylesheet" href="<?php  echo  $_zp_themeroot ?>/zen.css" type="text/css" />
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
</head>

<body style="background-color:#2b3239; background-image: url('/themes/default/images/px_trans.gif');">
<?php zp_apply_filter('theme_body_open'); ?>
<?php  printAdminToolbox(); ?>

<table id="photo" align='center'>
<tr>
<td><img src='<?php  echo  $_zp_themeroot ?>/images/px_trans.gif' width='20' height='1'></td>
<td>
	<div id="gallerytitle">
		<h2><span><a href="<?php  echo getGalleryIndexURL();?>" title="Gallery Index"><?php  echo getGalleryTitle();?></a>
		  | <a href="<?php  echo getAlbumLinkURL();?>" title="Gallery Index"><?php  echo getAlbumTitle();?></a>
		  | </span> <?php  printImageTitle(true); ?></h2>
	</div>



	<div class="imgnav">
	<table cellpadding='0' cellspacing='0' width='100%'>
	<tr>
	<td align='right'>
		<table cellpadding='0' cellspacing='0'>
		<tr>
		<td>
			<?php if (hasPrevImage()) { ?>
				<div class="imgprevious"><a href="<?php  echo getPrevImageURL();?>" title="Previous Image">&laquo; prev</a></div>
			<?php } else { ?>
				<div class='imgdisabledlink'>&laquo; prev</div>
			<?php } ?>
		</td>
		<td><img src='<?php  echo  $_zp_themeroot ?>/images/px_trans.gif' width='15' height='1'></td>
		<td>
			<?php if (hasNextImage()) { ?>
				<div class="imgnext"><a href="<?php  echo getNextImageURL();?>" title="Next Image">next &raquo;</a></div>
			<?php } else { ?>
				<div class='imgdisabledlink'>next &raquo;</div>
			<?php } ?>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
	</div>

	<div><img src='<?php  echo  $_zp_themeroot ?>/images/px_trans.gif' width='1' height='30'></div>

	<div id="image">
	<table cellpadding='0' cellspacing='0' align='center'><tr><td>
		<div class='photo'><a href="<?php  echo getFullImageURL();?>" title="<?php  echo getImageTitle();?>"> <?php  printDefaultSizedImage(getImageTitle()); ?></a></div>
	</td></tr></table>
	</div>

	<div id="narrow">

		<div align='center'><?php  printImageDesc(true); ?></div>

		<div id="comments">

			<?php 
			if (function_exists('printCommentForm')) {
				printCommentForm();
			}
			?>

			</div>
		</div>
	</div>
</td>
<td><img src='<?php  echo  $_zp_themeroot ?>/images/px_trans.gif' width='20' height='1'></td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' border='0' width='880' align='center'>
<tr>
<td>
	<div id="credit">
	Desgin by <a href='http://www.andreyphoto.com'>Andrey Samodeenko</a> - Theme by <a href='http://www.andreyphoto.com'>andreyphoto.com</a> |
	Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a>
	</div>
</td>
</tr>
</table>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
