<?php if (!defined('WEBPATH')) die(); ?>

<?php include ('theme-functions.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php printGalleryTitle(); ?></title>
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
	  <?php if (hasNextPage()) { ?>var nextURL="<?php echo getNextPageURL();?>";<?php } ?>
	  <?php if (hasPrevPage()) { ?>var prevURL="<?php echo getPrevPageURL();?>";<?php } ?>
	  function keyDown(e){
		if (!ie) {var keyCode=e.which;}
		if (ie) {var keyCode=event.keyCode;}
		if(keyCode==39){<?php if (hasNextPage()) { ?>window.location=nextURL<?php } ?>};
		if(keyCode==37){<?php if (hasPrevPage()) { ?>window.location=prevURL<?php } ?>};}
		document.onkeydown = keyDown;
		if (!ie)document.captureEvents(Event.KEYDOWN);
	-->
	</script>
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<?php printAdminToolbox(); ?>
<div id="framework">
	<div id="main">
	<div id="gallerytitle">
		<h2><?php echo getGalleryTitle(); ?></h2>
	</div>
	
	<div id="breadcrumb"><div class="left">Welcome to my gallery</div><div class="right dark">use arrow keys to navigate&nbsp;</div></div>
		
	<?php printPageListWithNav("«", "»"); ?>

	<div id="albums">
		<?php while (next_album()): ?>
			<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
				<?php printAlbumThumbImage(getAlbumTitle()); ?>
				<span class="num"><?php echo getNumImages();?></span>
				<strong class="title"><?php printAlbumTitle(); ?></strong>
				<? getAlbumDate("Date Taken: "); ?>
				<span class="desc"><?php printAlbumDescAlt(); ?></span>
			</a>
		<?php endwhile; ?>
	</div>
		
	</div><!-- close main -->
	<div id="credit">Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a> | theme by <a href="http://www.cimi.nl/">cimi</a></div>
</div><!-- close framework -->


</body>
</html>
