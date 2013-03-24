<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?> | <?=getAlbumTitle();?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?= $_zp_themeroot ?>/zen.css" type="text/css" />

	<?php if(zp_has_filter('theme_head','colorbox::css')) { ?>
		<script type="text/javascript">
			// <!-- <![CDATA[
			$(document).ready(function(){
				$("div.imagethumb a").colorbox({
					maxWidth:"98%",
					maxHeight:"98%",
					photo:true,
					close: '<?php echo gettext("close"); ?>'
				});
			});
			// ]]> -->
		</script>
	<?php } ?>
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

	<div id="gallerytitle">
		<h2><span><a href="<?=getGalleryIndexURL();?>" title="Gallery Index"><?=getGalleryTitle();?></a> | </span> <?php printAlbumTitle(true);?></h2>
	</div>
	
	<?php printAlbumDesc(true); ?>
	
	<div id="albums">
		<?php while (next_album()): ?>
		<div class="album">
			<a href="<?=getAlbumLinkURL();?>" title="View album: <?=getAlbumTitle();?>">
			<?php printAlbumThumbImage(getAlbumTitle()); ?>
			</a>
			<div class="albumdesc">
        		<small><? printAlbumDate("Date Taken: "); ?></small>
				<h3><a href="<?=getAlbumLinkURL();?>" title="View album: <?=getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
				<p><?php printAlbumDesc(); ?></p>
			</div>
			<p style="clear: both; "></p>
		</div>
		<?php endwhile; ?>
	</div>
    
    <div id="images">
		<?php while (next_image(false)): ?>
		<div class="image">
			<div class="imagethumb"><a href="<?=getFullImageURL();?>" rel="lightbox[<?=getAlbumTitle();?>]" title="<?=getImageTitle();?>"><?php printImageThumb(getImageTitle()); ?></a></div>
		</div>
		<?php endwhile; ?>
	</div>
	
	<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>
	
</div>

<?php printZenphotoLink(); ?>

</div>

<?php 
	printAdminToolbox();
 	zp_apply_filter('theme_body_close'); 
 ?>

</body>

</html>
