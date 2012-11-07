<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/zen.css" type="text/css" />

</head>
<?php
// RANDOM IMAGE    source: http://www.zenphoto.org/support/topic.php?id=7&replies=47
$randomImage = getRandomImages();
?>
<body style="background-image: url('<?php echo  $_zp_themeroot ?>/images/photography_background.gif');">
<?php printAdminToolbox(); ?>

<table id="main" align='center' style="background-image: url('<?php echo  $_zp_themeroot ?>/images/main_table_background.jpg');background-repeat: no-repeat;">
<tr>
<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='20' height='1'></td>
<td>
	<table class='header' width='100%'>
	<tr>
		<td align='right'><img class='header' src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' border='0' width='1' height='170'></td>
	</tr>
	</table>

	<div id="gallerytitle">
		<h2><?php echo getGalleryTitle(); ?></h2>
	</div>
	
	<div> 
	<table cellpadding='0' cellspacing='0'>
	<tr valign='top'>
		<? $zi = 0; ?>
		<? $zi2 = 0; ?>
		<?php while (next_album() && $zi = $zi+1): ?>
		<? if ($zi < 4) { ?>
			<td class="album" style="background-image: url('<?php echo  $_zp_themeroot ?>/images/album_pattern.gif');">
				<div class='albumthumb'>
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php //printAlbumThumbImage(getAlbumTitle()); ?>
					<? printCustomAlbumThumbImage(getAlbumTitle(), null, 211, 300, 211, 300); ?></a></div>
				<div class="albumdesc">
	        		<small><?php printAlbumDate("Date Taken: "); ?></small>
					<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
					<p><?php printAlbumDesc(); ?></p>
				</div>
			</td>
			<? if ($zi < 3) { ?>
				<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1' border='0'></td>
			<? } ?>
		<? } ?>
		<? if ($zi == 4) { ?>
			</tr>
			</table> 
			<? /* end the table for the first big album thumbnails */ ?>
			
			<? /* page content */ ?>
			<table cellpadding='0' cellspacing='0' border='0'>
			<tr valign='top' style="background-image: url('<?php echo  $_zp_themeroot ?>/images/guitar_background.jpg'); background-repeat: no-repeat;">
				<td style='font-size: 14px; line-height: 120%; padding: 20px;'>
					Hi there! You just installed a new theme! <br /> 
					You might want to edit andreyphoto/index.php to enter your own text here - look around line 85.<br/>
					<br /></br /><br />
					Enjoy!
				</td>
				<td style="padding: 20px 9px; font: Verdana; font-variant: small-caps;" width='350'>
				<div class="imagethumb" align='right' style='line-height:110%'><a href='<? echo $randomImageLinkURL; ?>'><img src='<? echo $randomImage->getCustomImage(null, 350, 250, 350, 250, null, null); ?>' alt='<? echo $randomImage->getTitle(); ?>'></a>random photo: <? echo strtolower(preg_replace('/_/', ' ', $randomImage->getTitle())); ?></div>
				</td>
			</tr>
			<tr>
			</table>
			<? /* end page content */ ?>
			
			<? /* start table for the rest of the thumbnails */ ?>
			<table cellpadding='0' cellspacing='0'>
			<tr>
		<? } ?>
		<? if ($zi > 3 && $zi < 8 ) { ?>
			<td class="album" style="background-image: url('<?php echo  $_zp_themeroot ?>/images/album_pattern.gif');">
				<div class='albumthumb'>
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php //printAlbumThumbImage(getAlbumTitle()); ?>
					<? printCustomAlbumThumbImage(getAlbumTitle(), null, 142, 142, null, null); ?></a></div>
				<div class="albumdesc">
	        		<small><?php printAlbumDate("Date Taken: "); ?></small>
					<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
					<p><?php printAlbumDesc(); ?></p>
				</div>
			</td>
			<? // print a spacer
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
			
		<? } elseif ($zi >= 8) { ?>
			<? 	$zi2++;
				if ($zi2 > 2) { $zi2 = 1; }
				if ($zi2 == 1) {
			?>
					</tr>
					<? if ($zi != 8) { ?>
						<tr><td colspan='7' style='line-height:10px'><img src='<? echo $_zp_themeroot; ?>/images/px_trans.gif' width='1' height='10'></td></tr>
					<? } ?>
					<tr>
			<?  } elseif ($zi2 == 2) { ?>
				<td><img src='<?php echo  $_zp_themeroot ?>/images/px_trans.gif' width='10' height='1'></td>
			<?  } ?>
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
						<?php printCustomAlbumThumbImage(getAlbumTitle(), null, 211, 300, 211, 300); ?></a></div>
					</td>
					

					</tr>
					</table>
				</td>
		<? } ?>
		<?php endwhile; ?>
	</tr>
	</table>
	</div>
	
	<div align='center'><?php //printPageListWithNav("&laquo; prev", "next &raquo;"); ?></div>
	

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

</body>
</html>
