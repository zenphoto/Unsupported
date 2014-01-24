<?php 
	global $_zp_themeroot, $_zp_current_album;
?>

<div id="album-nav" class="left opa60">
	<div class="nav-cell filler"><span>&nbsp;</span></div>
	<div class="nav-cell filler end"><span>&nbsp;</span></div>
</div>

<div style="padding-left: 1px;">
	<div id="album-menu" class="opa60">
		<div id="album-thumb">
			<img src="<?= getRandomImages()->getCustomImage(NULL, 192, 48, 192, 48, NULL, null, false) ?>" width="195" height="48"/>
		</div>
	</div>
	
	<div id="page-date" class="opa60">
		<?= getOption('simplicity2_contact_page_description') ?>
	</div>

	<div id="page-filler" class="opa20">&nbsp;</div>
	
</div>



