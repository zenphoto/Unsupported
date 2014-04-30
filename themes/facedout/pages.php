<?php if (!defined('WEBPATH')) die(); 
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html>
<head>
	<title><?php if(!isset($ishomepage)) { echo getBarePageTitle() . " | "; } ?> <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printRSSHeaderLink("News","", "Zenpage news", ""); ?>
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="header">
			<h1><?php printGalleryTitle(); ?></h1>
			<?php if (getOption('Allow_search')) {  printSearchForm("","search","",gettext("Search gallery")); } ?>
		</div>
				
<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(); ?>"><?php echo gettext("Home"); ?></a><?php if(!isset($ishomepage)) { printZenpageItemsBreadcrumb(" » ",""); } ?><strong><?php if(!isset($ishomepage)) { printPageTitle(" » "); } ?></strong>
	</h2>
	</div>
    
	<div id="sidebar">
		<?php include("sidebar-left.php"); ?>
	</div><!-- sidebar-left -->
    
<div id="content-right">
<div align="center"> <?php if (function_exists('zenFBLike')) { zenFBLike(); } ?></div>
<h2><?php // printPageTitle(); ?></h2>
<?php 
printPageContent(); 
printCodeblock(1); 
printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); 
?>
<br style="clear:both;" /><br />
<?php
if (function_exists('printRating')) { printRating(); }
?>

<?php if (function_exists('zenFBComments')) { zenFBComments(); } ?>

	</div><!-- content right-->
		
	<div id="fb-bar">
		<?php include("rightbar.php"); ?>
	</div><!-- fb-bar -->


	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>