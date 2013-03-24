<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>
<head>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
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
	
	<script type="text/javascript">
	$(document).ready(function() {
    jQuery('a.gallery').colorbox({photo:true, rel:'gallery', slideshow:true});
    });
	</script>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="gallerytitle">
		<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?><?php printAlbumBreadcrumb();?> | <?php printImageTitle(); ?></span></h2>
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



		<a class="gallery" href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>"> <?php printDefaultSizedImage(getImageTitle()); ?></a>
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
	if (!zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
	}
?><?php printZenphotoLink(); ?></div>

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

</body>
</html>
