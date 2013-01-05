<?php if (!defined('WEBPATH')) die(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php zp_apply_filter('theme_head'); ?>
	
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="imagetoolbar" content="false" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<script type="text/javascript">
	<!--
	var ua = navigator.userAgent;
	var opera = /opera [56789]|opera\/[56789]/i.test(ua);
	var ie = !opera && /msie [56789]/i.test(ua);
	var moz = !opera && /mozilla\/[56789]/i.test(ua);
	function toggle(obj) {document.getElementById(obj).style.display=(document.getElementById(obj).style.display!="block")? "block" : "none";}
	  <?php if (hasNextImage()) { ?>var nextURL="<?php echo getNextImageURL();?>";<?php } ?>
	  <?php if (hasPrevImage()) { ?>var prevURL="<?php echo getPrevImageURL();?>";<?php } ?>
	 function keyDown(e){
		if (!ie) {var keyCode=e.which;}
		if (ie) {var keyCode=event.keyCode;}
		if(keyCode==39){<?php if (hasNextImage()) { ?>window.location=nextURL<?php } ?>};
		if(keyCode==37){<?php if (hasPrevImage()) { ?>window.location=prevURL<?php } ?>};}
		document.onkeydown = keyDown;
		if (!ie)document.captureEvents(Event.KEYDOWN);
		document.oncontextmenu=new Function("return false");
		//document.onselectstart=new Function ("return false");
		document.ondragstart=new Function ("return false") ;
	function opacity(id, opacStart, opacEnd, millisec) {
		var speed = Math.round(millisec / 100);
		var timer = 0;
		if(opacStart > opacEnd) {
			for(i = opacStart; i >= opacEnd; i--) {
				setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
			timer++;
			}
		} else if(opacStart < opacEnd) {
			for(i = opacStart; i <= opacEnd; i++){
				setTimeout("changeOpac(" + i + ",'" + id + "')",(timer * speed));
				timer++;
				}
			}
		}
	function changeOpac(opacity, id) {
		var object = document.getElementById(id).style;
			object.opacity = (opacity / 100);
			object.MozOpacity = (opacity / 100);
			object.KhtmlOpacity = (opacity / 100);
			object.filter = "alpha(opacity=" + opacity + ")";
		}
	-->
	</script>

</head>

<body>
<?php printAdminToolbox(); ?>
<div id="framework">
	<div id="main">

	<div id="gallerytitle">
		<h2><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a></h2>
	</div>

	<div id="breadcrumb">
		<div class="left"><a title="Home" href="<?php echo getGalleryIndexURL();?>">home</a> > <a href="<?php echo getAlbumLinkURL();?>"> <?php printAlbumTitle(false);?></a>&nbsp;> <?php printImageTitle(true); ?></div><div class="right">use arrow keys to navigate&nbsp;</div>
	</div>

	<div id="imgnav">
	<?php if (hasNextImage()) { ?>
		<a id="forw" href="<?php echo getNextImageURL();?>" title="Next Image"><span>Next Image</span></a>
	<?php } else { ?>
		<div class="block"><span>Next Image</span></div>
	<?php } ?>
	<?php if (hasPrevImage()) { ?>
		<a id="prev" href="<?php echo getPrevImageURL();?>" title="Previous Image"><span>Previous Image</span></a>
	<?php } else { ?>
		<div class="block"><span>Previous Image</span></div>
	<?php } ?>
		<div><a class="block light" href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>">full size</a></div>
	</div>

	<div id="image">
		<a href="<?php echo getAlbumLinkURL();?>" title="<?php echo getImageTitle();?>"> <?php printDefaultSizedImageAlt(getImageTitle()); ?></a>
	</div>


	<div id="narrow">

	<?php if (getImageDesc() !='') { ?>
		<div id="desc">
			<?printImageDesc(true); ?>
		</div>
	<?php }?>

	<!-- exif -->


		<div id="comments">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>
		</div>

	</div>
	<div id="credit">Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a> | theme by <a href="http://www.cimi.nl/">cimi</a></div>
</div>



</body>
</html>