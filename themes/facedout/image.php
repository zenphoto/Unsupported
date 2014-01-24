<?php if (!defined('WEBPATH')) die();
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">

<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareImageTitle();?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
	<script type="text/javascript">
		// <!-- <![CDATA[
		$(document).ready(function(){
			$(".colorbox").colorbox({inline:true, href:"#imagemetadata"});
			$("a.thickbox").colorbox({maxWidth:"98%", maxHeight:"98%"});
		});
		// ]]> -->
	</script>
		<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div style="margin-top: 16px;"><!-- somehow the thickbox.css kills the top margin here that all other pages have... -->
</div>
<div id="main">
<div id="header">
		<h1><?php echo getGalleryTitle();?></h1>

	</div>
	
<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(false);?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Home"); ?></a> &raquo; <?php echo gettext("Gallery"); ?><?php printParentBreadcrumb(" &raquo; "," &raquo; "," &raquo; "); printAlbumBreadcrumb(" ", " &raquo; "); ?>
			 <strong><?php printImageTitle(true); ?></strong> (<?php echo imageNumber()."/".getNumImages(); ?>)
			</h2>
		</div>
        
	<div id="sidebar">
		<?php include("sidebar-left.php"); ?>
	</div><!-- sidebar-left -->
        
	<div id="content-right">

	<!-- The Image -->
 <?php
 //
 if (function_exists('printjCarouselThumbNav')) {
 	printjCarouselThumbNav(6,50,50,50,50,FALSE);
 }
 else {
 	if (function_exists("printPagedThumbsNav")) {
 		printPagedThumbsNav(6, FALSE, gettext('&laquo; prev thumbs'), gettext('next thumbs &raquo;'), 40, 40);
 	}
 }

 ?>
	<div id="image">
		<?php if(getOption("Use_thickbox")) {
			$boxclass = " class=\"thickbox\"";
			$tburl = getUnprotectedImageURL();
		} else {
			$thickboxclass = "";
			$tburl = getFullImageURL();
		}
		if (!empty($tburl)) {
			?>
			<a href="<?php echo html_encode($tburl); ?>"<?php echo $boxclass; ?> title="<?php echo getBareImageTitle();?>">
			<?php
		}
		printCustomSizedImageMaxSpace(getBareImageTitle(),480,480); ?>
		<?php
		if (!empty($tburl)) {
			?>
			</a>
			<?php
		}
		?>
	</div>
	<div id="narrow">
    	<div align="center">Click image for larger view.</div>
		<p><br />Image Description:<br /><?php printImageDesc(true); ?></p>
		<br />Image Tags: <br /><?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); ?>
		<br style="clear:both;" /><br />
		<?php if (function_exists('printSlideShowLink')) {
			echo '<span id="slideshowlink">' . '';
			printSlideShowLink(gettext('View Slideshow')); 
			echo '' . '</span>';
		}
		?>
		
		<?php
			if (getImageMetaData()) {echo "<div id=\"exif_link\"><a href=\"#\" title=\"".gettext("Image Info")."\" class=\"colorbox\">".gettext("Image Info")."</a></div>";
				echo "<div style='display:none'>"; printImageMetadata('', false); echo "</div>";
			}
		?>
   		<div id="google-map"><?php if (function_exists('printImageMap')) printImageMap(); ?></div>
		<br style="clear:both" />
		<?php if (function_exists('printRating')) { printRating(); }?><br />
		<?php if (function_exists('printShutterfly')) printShutterfly(); ?><br />
		<div align="center"><?php if (function_exists('zenFBComments')) { zenFBComments(); } ?></div>
</div>

</div><!-- content-right -->


	<div id="fb-bar">
		<?php include("rightbar.php"); ?> 
	</div><!-- fb-bar -->

	<div id="footer">
	<?php include("footer.php"); ?>
	</div>


	</div><!-- content -->

</div><!-- main -->
<?php
printAdminToolbox();
zp_apply_filter('theme_body_close');
?>
</body>
</html>