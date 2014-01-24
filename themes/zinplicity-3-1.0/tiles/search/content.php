<?php 
	global $_zp_current_search;
	Utils::import('SearchController');
	$controller = new SearchController();
?>

<div id="page-desc">
	<?= getOption('simplicity3_search_text') ?>
</div>

<div id="album-wrapper">

	<div id="page-content" class="Archives">
		<?php printAllDates('archive', 'year', 'month', 'desc'); ?>

		<div id="search-form">
			<form action="<?= getCustomPageUrl('search')?>" method='post'>	
				<input type="submit" id="search_submit" value="search:" />
				<input name="words" value="" id="search_input" size="10" type="text"/>
				<input name="p" value="search" type="hidden" />
			</form>
		</div>

		<div id="search-results">
				<?= $controller->getHitResults(); ?>
		</div>
	</div>

	<?php if ( isset($_zp_current_search) ) : ?>
		<div id="album-content">
			<?= $controller->getSubalbumsHTML() ?>
			<?= $controller->getImagesHTML() ?>
			<?php $controller->printAlbumNav(); ?>
		</div>
		<div id="search-news-result">
			<?php $controller->printNewsHTML(3) ?>
		</div>
	<?php endif; ?>

</div>



<?= $controller->getGalleryPageAlbums() ?>
