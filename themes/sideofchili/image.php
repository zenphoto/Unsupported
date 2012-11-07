<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php
	require ('chili-functions.php');
	
	printChiliJavascript();

//Variables
//$size = 480;
	?>


</head>

<body>

<?php printAdminToolbox(); ?>

<div id="main">
	<div id="gallerytitle">
		<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a>
		  | <a href="<?php echo getAlbumLinkURL();?>" title="Gallery Index"><?php echo getAlbumTitle();?></a>
		  | </span> <?php printImageTitle(true); ?></h2>
	</div>



		<?php zp_side_bar();?>

	<div id="image_left">

		<div class="image_container">
			<a href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>"> <?php printCustomSizedImage("", 480, ""); ?></a>
		</div>
		<div id="narrow">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>
		</div>
	</div>

<?php zp_footer();?>
</div>
</body>
</html>
<!-- Prints JavaScript After Page Loads -->
<script type="text/javascript">
Effect.OpenUp = function(element) {
     element = $(element);
     new Effect.BlindDown(element, arguments[1] || {});
 }

 Effect.CloseDown = function(element) {
     element = $(element);
     new Effect.BlindUp(element, arguments[1] || {});
 }

 Effect.Combo = function(element) {
     element = $(element);
     if(element.style.display == 'none') {
          new Effect.OpenUp(element, arguments[1] || {});
     }else {
          new Effect.CloseDown(element, arguments[1] || {});
     }
 }
 </script>