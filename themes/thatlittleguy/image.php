<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
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
</head>

<body>

<div id="main">

	<?php printAdminToolbox(); ?>

	<div id="gallerytitle">
		<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a>
		  | <a href="<?php echo getAlbumLinkURL();?>" title="Gallery Index"><?php echo getAlbumTitle();?></a>
		  | </span> <?php printImageTitle(true); ?></h2>
	</div>

<div id="imgnav_tlg">
		<?php if (hasPrevImage()) { ?>
		<div style="float:left;">
		<a href="<?php echo getPrevImageURL();?>">&laquo; previous photo</a>
		</div>
		<?php } if (hasNextImage()) { ?>
		<div style="float:right;">
		<a href="<?php echo getNextImageURL();?>">next photo &raquo;</a>
		</div>
		<?php } ?>
	<p style="margin:0px;padding:0px;clear: both; ">&nbsp;</p>
	</div>


	<div id="image">



		<a href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>"> <?php printDefaultSizedImage(getImageTitle()); ?></a>
	</div>

	<div id="narrow">

	    <div id="smaller_tlg">
		<?php printImageDesc(true); ?>
		</div>

		<div id="smaller_tlg">
		<?php echo"<h3>EXIF Data</h3>";printImageMetadata('', false);  ?>
		</div>

		<div id="comments">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>


	</div>
</div>

<div id="credit"><?php
	if (zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
	}
?>Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>
</body>
</html>
