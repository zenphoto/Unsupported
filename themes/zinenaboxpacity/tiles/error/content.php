<?php global $_zp_themeroot, $_zp_current_zenpage_news, $code, $tileSet; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>


<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">
		<?= $tileSet->title ?>
	</div>
	<div class="left">
		<img src="<?= $_zp_themeroot ?>/resources/images/<?=$code?>.png" width="64" height="64"/>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>


<div>
	<div id="content-filler" class="error opa60">
		<div id="site-description" class="opa30 error">
			<?= getOption("simplicity2_error_" . $code . "_message") ?>
		</div>
	</div>	
</div>



