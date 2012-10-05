<?php if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('1', '5'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?> | <?=getAlbumTitle();?></title>
	
	<link rel="stylesheet" href="<?= $_zp_themeroot ?>/zen.css" type="text/css" />
    <script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/prototype.js" type="text/javascript"></script>
    <script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/scriptaculous/scriptaculous.js?load=effects" type="text/javascript"></script>
	<script src="<?= $_zp_themeroot ?>/js/lightbox.js" type="text/javascript"></script>
	<?php zenJavascript(); ?>
	
</head>

<body>
<?php printAdminToolbox(); ?>
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
		<?php while (next_image(false, $firstPageImages)): ?>
		<div class="image">
			<div class="imagethumb"><a href="<?=getFullImageURL();?>" rel="lightbox[<?=getAlbumTitle();?>]" title="<?=getImageTitle();?>"><?php printImageThumb(getImageTitle()); ?></a></div>
		</div>
		<?php endwhile; ?>
	</div>
	
	<?php printPageListWithNav("&laquo; prev", "next &raquo;"); ?>
	
</div>

<div id="credit">Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
