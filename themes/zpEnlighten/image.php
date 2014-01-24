<?php if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('2', '6');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareImageTitle();?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php require_once(SERVERPATH.'/'.ZENFOLDER.'/js/colorbox/colorbox_ie.css.php')?>
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
	<script type="text/javascript">
		// <!-- <![CDATA[
		$(document).ready(function(){
			$(".colorbox").colorbox({inline:true, href:"#imagemetadata"});
			$("a.thickbox").colorbox({maxWidth:"98%", maxHeight:"98%"});
		});
		// ]]> -->
	</script>
	<?php printZDRoundedCornerJS(); ?>
		<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>

<div style="margin-top: 16px;"><!-- somehow the thickbox.css kills the top margin here that all other pages have... -->
</div>
<div id="main">
<div id="header">
		<h3 style="float:left; padding-left: 32px;">
        <a href="<?php echo getGalleryIndexURL(false); ?>"><img src="<?php echo $_zp_themeroot; ?>/images/banner.png"/></a>
    </h3>
	<div class="imgnav" style="margin-top: 33px;">
			<?php if (hasPrevImage()) { ?>
			<div class="imgprevious"><a href="<?php echo htmlspecialchars(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>">&laquo; <?php echo gettext("prev"); ?></a></div>
			<?php } else {  ?>
            <div class="imgprevious disabled"><a>&laquo; <?php echo gettext("prev"); ?></a></div>
            <?php } if (hasNextImage()) { ?>
			<div class="imgnext"><a href="<?php echo htmlspecialchars(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext("next"); ?> &raquo;</a></div>
			<?php } else { ?>
            <div class="imgnext disabled"><a><?php echo gettext("next"); ?> &raquo;</a></div>
            <?php } ?>
		</div>
	</div>
	
<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(false);?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Index"); ?></a> &raquo; <a href="<?php echo htmlspecialchars(getCustomPageUrl('gallery'));?>" title="<?php echo gettext('Gallery'); ?>"><?php echo gettext("Gallery"); ?></a><?php printParentBreadcrumb(" &raquo; "," &raquo; "," &raquo; "); printAlbumBreadcrumb(" ", " &raquo; "); ?>
			 <strong><?php /* printImageTitle(true); */?><?php echo gettext("Image") . imageNumber()."/".getNumImages(); ?></strong> 
			</h2>
		</div>
	<div id="content-left">

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
			<a href="<?php echo htmlspecialchars($tburl); ?>"<?php echo $boxclass; ?> title="<?php echo getBareImageTitle();?>">
			<?php
		}
		printCustomSizedImageMaxSpace(getBareImageTitle(),580,580); ?>
		<?php
		if (!empty($tburl)) {
			?>
			</a>
			<?php
		}
		?>
	</div>
	<div id="narrow">
        <div style="text-align:center; font-weight: bold; color: #999;"><?php printImageTitle(true); ?></div>
		<?php $d = getImageDesc(); if ( !empty($d) ) { ?> <div class="imagedesc"><?php printImageDesc(true); ?></div> <?php } ?>
		<?php /* printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); */ ?>
		<br style="clear:both;" /><br />
		<?php if (function_exists('printSlideShowLink')) {
			echo '<span id="slideshowlink">';
			printSlideShowLink(gettext('View Slideshow')); 
			echo '</span>';
		}
		?>
		
		<?php
			if (getImageMetaData()) {echo "<div id=\"exif_link\"><a href=\"#\" title=\"".gettext("Image Info")."\" class=\"colorbox\">".gettext("Image Info")."</a></div>";
				echo "<div style='display:none'>"; printImageMetadata('', false); echo "</div>";
			}
		?>
	
		<br style="clear:both" />
		<?php if (function_exists('printRating')) { printRating(); }?>
		<?php if (function_exists('printImageMap')) printImageMap(); ?>
		<?php if (function_exists('printShutterfly')) printShutterfly(); ?>

</div>
		<?php if (function_exists('printCommentForm')) { ?>
			<div id="comments">
			<?php printCommentForm(); ?>
			</div>
		<?php } ?>

</div><!-- content-left -->

<div id="sidebar">
<?php include("sidebar.php"); ?>
</div>

	<div id="footer">
	<?php include("footer.php"); ?>
	</div>


	</div><!-- content -->

</div><!-- main -->
<?php printAdminToolbox(); ?>
</body>
</html>