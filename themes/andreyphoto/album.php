<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>

<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/zen.css" type="text/css" />
	
</head>

<body style="background-image: url('<?php echo  $_zp_themeroot ?>/images/photography_background.gif');">
<?php zp_apply_filter('theme_body_open'); ?>

<?php printAdminToolbox(); ?>

<table id="main" align='center' style="background-image: url('<?php echo  $_zp_themeroot ?>/images/dimmed_table_background.jpg');background-repeat: no-repeat;">
<tr>
<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='20' height='1'></td>
<td>
	<table class='header' width='100%'>
	<tr>
		<td align='right'><img class='header' src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' border='0' width='1' height='35'></td>
	</tr>
	</table>
	
	<div id="gallerytitle">
		<h2><span><a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | </span> <?php printAlbumTitle(true);?></h2>
	</div>
	

	<?php printAlbumDesc(true); ?>
	
	<div> 
	<table cellpadding='0' cellspacing='0'>
	<tr valign='top'>
		<?php $zi = 0; ?>
		<?php $zi2 = 0; ?>
		<?php while (next_album() && $zi = $zi+1): ?>
		<?php if ($zi < 4) { ?>
			<td class="album" style="background-image: url('<?php echo  $_zp_themeroot ?>/images/album_pattern.gif');">
				<div class='albumthumb'>
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php //printAlbumThumbImage(getAlbumTitle()); ?>
					<?php printCustomAlbumThumbImage(getAlbumTitle(), null, 211, 300, 211, 300); ?></a></div>
				<div class="albumdesc">
	        		<small><?php printAlbumDate("Date Taken: "); ?></small>
					<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
					<p><?php printAlbumDesc(); ?></p>
				</div>
			</td>
			<?php if ($zi < 3) { ?>
				<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1' border='0'></td>
			<?php } ?>
		<?php } ?>
		<?php if ($zi == 4) { ?>
			</tr>
			</table> 
			<?php /* end the table for the first big album thumbnails */ ?>
			
			<?php /* page content */ ?>
			<table cellpadding='0' cellspacing='0' border='0'>
			<tr valign='top' style="background-image: url('<?php echo  $_zp_themeroot ?>/images/guitar_background.jpg'); background-repeat: no-repeat;">
				<td style='font-size: 14px; line-height: 120%; padding: 20px;'>
					Hi there! You just installed a new theme! <br /> 
					You might want to edit andreyphoto/index.php to enter your own text here - look around line 85.<br/>
					<br /></br /><br />
					Enjoy!
				</td>
				<td style="padding: 20px 9px; font: Verdana; font-variant: small-caps;" width='350'>
				<div class="imagethumb" align='right' style='line-height:110%'><a href='<?php echo $randomImageLinkURL; ?>'><img src='<?php echo $randomImage->getCustomImage(null, 350, 250, 350, 250, null, null); ?>' alt='<?php echo $randomImage->getTitle(); ?>'></a>random photo: <?php echo strtolower(preg_replace('/_/', ' ', $randomImage->getTitle())); ?></div>
				</td>
			</tr>
			<tr>
			</table>
			<?php /* end page content */ ?>
			
			<?php /* start table for the rest of the thumbnails */ ?>
			<table cellpadding='0' cellspacing='0'>
			<tr>
		<?php } ?>
		<?php if ($zi > 3 && $zi < 8 ) { ?>
			<td class="album" style="background-image: url('<?php echo  $_zp_themeroot ?>/images/album_pattern.gif');">
				<div class='albumthumb'>
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php //printAlbumThumbImage(getAlbumTitle()); ?>
					<?php printCustomAlbumThumbImage(getAlbumTitle(), null, 142, 142, null, null); ?></a></div>
				<div class="albumdesc">
	        		<small><?php printAlbumDate("Date Taken: "); ?></small>
					<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
					<p><?php printAlbumDesc(); ?></p>
				</div>
			</td>
			<?php // print a spacer
			/*
			$zi2++;
			if ($zi2 > 4) {
				$zi2 = 0;
			?>	</tr><tr> <?
			} else {*/
			?>
				<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1' border='0'></td>
			<?
			//} // end print a spacer
			?>
			
		<?php } elseif ($zi >= 8) { ?>
			<?php 	$zi2++;
				if ($zi2 > 2) { $zi2 = 1; }
				if ($zi2 == 1) {
			?>
					</tr>
					<?php if ($zi != 8) { ?>
						<tr><td colspan='7' style='line-height:10px'><img src='<?php echo $_zp_themeroot; ?>/images/px_trans.gif' width='1' height='10'></td></tr>
					<?php } ?>
					<tr>
			<?php } elseif ($zi2 == 2) { ?>
				<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1'></td>
			<?php } ?>
				<td class="album" colspan='3' style="background-image: url('<?php echo  $_zp_themeroot ?>/images/album_pattern.gif'); padding:5px;">
					<table cellpadding='0' cellspacing='0' border='0' width='100%'>
					<tr valign='top'>
					<td>
					<div class="albumdesc" style='text-align:left; margin: 0 5px'>
		        		<small><?php printAlbumDate("Date Taken: "); ?></small>
						<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
						<p style='line-height: 110%'><?php printAlbumDesc(); ?></p>
					</div>
					</td>
					<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1'></td>
					<td>
					<div class='albumthumb' style='float:right;'>
						<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
						<?php //printAlbumThumbImage(getAlbumTitle()); ?>
						<?php printCustomAlbumThumbImage(getAlbumTitle(), null, 178, 70, 178, 70); ?></a></div>
					</td>
					

					</tr>
					</table>
				</td>
		<?php } ?>
		<?php endwhile; ?>
	</tr>
	</table>
	</div>
    
    <div>
	<table cellpadding='0' cellspacing='0'>
	<tr valign='top'>
		<?php $zi = 0; ?>
		<?php while (next_image() && $zi = $zi+1): ?>
		<?php if ($zi > 4) { ?>
			</tr><tr>
			<?php $zi = 1; ?>
		<?php } ?>
			<td class='image_td'>
				<div class="imagethumb"><a href="<?php echo getImageLinkURL();?>" title="<?php echo getImageTitle();?>"><?php printImageThumb(getImageTitle()); ?></a></div>
			</td>
			<?php if ($zi < 4) { ?>
				<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1' border='0'></td>
			<?php } ?>
		<?php endwhile; ?>
	</tr>
	</table>
	</div>
	
	<div align='center'>
	<?php printPageListWithNav("« prev", "next »"); ?>
	</div>

</td>
<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='20' height='1'></td>
</tr>	
</table>

<table cellpadding='0' cellspacing='0' border='0' width='880' align='center'>
<tr>
<td>
	<div id="credit">
	Desgin by <a href='http://www.andreyphoto.com'>Andrey Samodeenko</a> - Theme by <a href='http://www.andreyphoto.com'>andreyphoto.com</a> |
	Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a>
	</div>
</td>
</tr>
</table>
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
