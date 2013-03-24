<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>

<head>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo  $_zp_themeroot ?>/css/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<script type="text/javascript" src="<?php echo $_zp_themeroot ?>/js/reflection.js"></script>
</head>
	
<body>
<?php zp_apply_filter('theme_body_open'); ?>

	<div id="header">
		<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php echo getBareGalleryTitle(); ?>"><?php printGalleryTitle(); ?></a>
	</div>
		
	<div id="wrap">
		
		<div id="content">
				
				<?php
				$x = 0;
				while (next_album()): ?>
				<div class="album" style="float: left; width: 390px; padding-bottom: 20px;">
					
					<div class="albumthumb"><a href="<?php echo getAlbumLinkURL();?>" title="<?php echo getAlbumTitle();?>">
						<?php printAlbumThumbImage(getAlbumTitle(), "reflect rheight30 ropacity40"); ?></a>
					</div>
					
					<div class="albumtitle"><h1><a href="<?php echo getAlbumLinkURL();?>" title="<?php echo getAlbumTitle();?>">
						<?php printAlbumTitle(); ?></a></h1>
					</div>
					
					<div class="albumdesc">
						<?php printAlbumDesc(); ?>
					</div>

					<?php
					if ($x == 2) {
					?>
					<div class="clear"></div>
					<?php
					$x = 0;
					}
					?>
				
				</div>
				
				<?php
				$x++;
				endwhile; 
				?>
				
				<div id="footer">
					<a href="http://nilswindisch.de/contact/" target="_blank" title="click here to make contact">Contact</a>
				</div>
				<div class="clear"></div>
				<div id="add">
					<?php //printPageListWithNav("&laquo; prev", "next &raquo;"); // uncomment this line to support pagination ?>
					<?php printZenphotoLink(); ?> &amp; <a href="http://nilswindisch.de/code/zenphoto/theme-simple-plus/" target="_blank" title="theme: simple+ by Nils K. Windisch. visit http://nilswindisch.de/">simple+</a>
				</div>
		
			</div>
		
		</div>

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>
	
</body>

</html>