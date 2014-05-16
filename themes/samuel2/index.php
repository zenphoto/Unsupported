<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/reflection.js"></script>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

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
				<a href="<?php echo getAlbumURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumThumbImage(getAlbumTitle(),'reflect'); ?></a>
			</div>
			<div class="albumdesc">
      			<small><? printAlbumDate("Date Taken: "); ?></small>
				<h3><a href="<?php echo getAlbumURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
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

<?php
zp_apply_filter('theme_body_close');
?>

</body>
</html>
