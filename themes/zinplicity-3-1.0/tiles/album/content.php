
<?php 
	global $_zp_page, $_zp_gallery_page, $_zp_current_album, $_zp_themeroot, $_zp_gallery;

	Utils::import('GalleryController');

	$controller = new GalleryController();

?>

<div id="gallery-desc">
	<?php printGalleryDesc(); ?>
</div>	

<?php $controller->printGalleryNav(); ?>

<div id="album-wrapper">
	<div id="album-title">
		<div id="breadcrumb">
			<?php $controller->printBreadCrumb(); ?>
			<?= $controller->getRss(); ?>
		</div>
	</div>

	<div id="album-description">
		<?= $controller->getDesc(); ?>	
	</div>

	<div id="album-content">
		<?= $controller->getSubalbumsHTML() ?>
		<?= $controller->getImagesHTML() ?>
		<?php $controller->printAlbumNav(); ?>
	</div>
</div>

<?= $controller->getGalleryPageAlbums() ?>


