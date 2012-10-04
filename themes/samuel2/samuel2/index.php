<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/reflection.js"></script>
	<?php zp_apply_filter('theme_head'); ?>
</head>

<body>
<?php printAdminToolbox(); ?>
<div>
	<div class="spiffy_content">
		<h1><?php echo getGalleryTitle(); ?></h1>
	</div>
	<b class="spiffy">
		<b class="spiffy5"></b>
		<b class="spiffy4"></b>
		<b class="spiffy3"></b>
		<b class="spiffy2"><b></b></b>
		<b class="spiffy1"><b></b></b>
	</b>
</div> 

<div>
<b class="contentbox">
<b class="contentbox1"><b></b></b>
<b class="contentbox2"><b></b></b>
<b class="contentbox3"></b>
<b class="contentbox4"></b>
<b class="contentbox5"></b>
</b> <div class="contentbox_content">

	
	<div id="albums">
		<?php while (next_album()): ?>
		<div class="album">
			<div class="imagethumb">
				<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle(),'reflect'); ?></a>
			</div>
			<div class="albumdesc">
      			<small><? printAlbumDate("Date Taken: "); ?></small>
				<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
				<p><?php printAlbumDesc(); ?></p>
				<p><em>(<? $number = getNumImages(); if ($number > 1) $number .= " photos"; else $number .=" photo"; echo$number; ?>)</em> <?php $text = getAlbumDesc(); if( strlen($text) > 50) $text = preg_replace("/[^ ]*$/", '', substr($text, 0, 50))."&#8230;"; echo$text; ?></p>
			</div>
			<p style="clear: both; "></p>
		</div>
		<?php endwhile; ?>
	</div>
	
	<?php printPageListWithNav("« prev", "next »"); ?>

</div>
<b class="contentbox">
<b class="contentbox5"></b>
<b class="contentbox4"></b>
<b class="contentbox3"></b>
<b class="contentbox2"><b></b></b>
<b class="contentbox1"><b></b></b>
</b>
</div> 

</body>
</html>
