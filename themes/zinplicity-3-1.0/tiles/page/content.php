<?php 
	global $_zp_current_zenpage_page;
	zenpage_load_page(); 
	$link = $_zp_current_zenpage_page->getTitleLink();
?>

<?php Utils::printZenPagePageTitleLink(); ?>

<div>
	<div id="page-body" class="<?= $link ?>">
		<div id="page-desc" class="<?= $link ?>">
			<?php 
				printCodeBlock(2);
			?>
		</div>
		<div id="page-content" class="<?= $link ?>">
			<?php
				printPageContent();
				printCodeBlock(1);
			?>
		</div>
	</div>	
</div>
