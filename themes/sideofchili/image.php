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
	<?php require ('chili-functions.php'); ?>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/prototype.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/global.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/thickbox.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/scriptaculous.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/js/effects.js"></script>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
	<div id="gallerytitle">
		  <h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?><?php printAlbumBreadcrumb();?> | <?php printImageTitle(); ?></span></h2>
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

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

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