<?php 
	global $_zp_themeroot;
	
	Utils::import('GalleryController');
	Utils::import('Overrides');

	//required this soon because slideshow plugin outputs unprotected script 
	Utils::printScripts("slideshow"); 

	$controller = new GalleryController();
?>

<div id="gallery-desc">
	<?php printGalleryDesc(); ?>
</div>	

<?php $controller->printGalleryNav(); ?>

<div id="album-wrapper" class="slideshow">
	<div id="album-title">
		<div id="breadcrumb">
		<?php $controller->printBreadCrumb(' : Slideshow'); ?>
		</div>
	</div>

	<div id="album-description">
		<?= $controller->getDesc(); ?>	
	</div>
</div>

<noscript>
	<div id='noscript-warning'>
		<img src='<?= $_zp_themeroot ?>/resources/images/noscript.png' width="32" height="32" />
		<div id='noscript-text'>You need to enable Javascript to use the slideshow feature. </div>
	</div>
</noscript>

<div id="slideshowpage">
	<?php
		global $_zp_gallery; 

		$album = $_GET['album'];
		$image = $_GET['image'];
		$page = $_GET['page'];
	
		$_zp_current_album = new Album($_zp_gallery, $album);

		if ( $image ) $i = newImage($_zp_current_album, $image);

		$_POST['pagenr'] = $page;
		$_POST['albumid'] = $_zp_current_album->getAlbumID();
		$_POST['numberofimages'] = $_zp_current_album->getNumImages();
		$_POST['imagefile'] = $image; //?

		SlideshowOverrides::printSlideShow(true, false, NULL, $i, 330, 900); 
	?>
	
	<?= $controller->getGalleryPageAlbums() ?>
</div>


