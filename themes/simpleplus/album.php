<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>

<head>
	<title><?php echo getBareGalleryTitle(); ?> | Album: <?php echo getBareAlbumTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/css/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/slimbox/css/slimbox2.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/slimbox/js/slimbox2.js"></script>
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/reflection-jquery/js/reflection.js"></script>	
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

	<div id="header">
		<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php echo getBareGalleryTitle(); ?>"><?php printGalleryTitle(); ?></a>
	</div>
		
		<div id="wrap">
			
			<div id="content">
			
				<div id="gallerytitle">
					<h1><?php printAlbumTitle(true);?></h1>
				</div>
				
				<?php printAlbumDesc(true); ?>
				<br clear="all" />
				<?php
				$x = 0;
				while (next_album()): ?>
				<div class="album">
					
					<div class="albumthumb"><a href="<?php echo getAlbumURL();?>" title="<?php echo getBareAlbumTitle();?>" rel="lightbox-album">
						<?php printAlbumThumbImage(getAlbumTitle(), "reflect"); ?></a>
					</div>
					
					<div class="albumtitle"><h1><a href="<?php echo getAlbumURL();?>" title="<?php echo getBareAlbumTitle();?>">
						<?php printAlbumTitle(); ?></a></h1>
					</div>
					
					<div class="albumdesc">
						<?php printAlbumDesc(); ?>
					</div>

					<? if ($x == 2) { echo "<div class=\"clear\"></div>"; $x = 0; } ?>
				
				</div>
                <?php $x++; endwhile; ?>
                
                <div id="images">
				<?php while (next_image()): ?>
					<div class="image">
						<div class="imagethumb">
							<a href="<?php echo getFullImageURL();?>" rel="lightbox[<?php echo getBareAlbumTitle();?>]" title="<?php echo getImageTitle();?>"><?php printImageThumb(getBareImageTitle(), "reflect rheight30 ropacity40"); ?></a>
						</div>
					</div>
				<?php endwhile; ?>
				</div>
				
				<div id="footer">
					<a href="http://nilswindisch.de/contact/" target="_blank" title="click here to make contact">Contact</a>
				</div>
				
				<div class="clear"></div>
				
				<div id="back">
					<a href="<?php echo getGalleryIndexURL(); ?>" title="click this link to go back to the album overview">back to album overview</a>
				</div>
				
				<div id="add">
					<?php //printPageListWithNav("« prev", "next »"); // uncomment this line to support pagination ?>
					<?php printZenphotoLink(); ?> &amp; <a href="http://nilswindisch.de" target="_blank" title="theme: simple+ by Nils K. Windisch. visit http://nilswindisch.de/">simple+</a>
				</div>				
				
			</div>
			
		</div>

<?php
zp_apply_filter('theme_body_close');
?>

</body>

</html>