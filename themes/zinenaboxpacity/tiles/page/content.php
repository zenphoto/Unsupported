<?php global $_zp_themeroot; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right"><?= gettext(getPageTitle()); ?></div>
	<div class="left">
		<img id='page-icon' src="<?= PersonalityUtil::getPersonaIconURL("page", "$_zp_themeroot/resources/images/page.png") ?>" width="64" height="64"/>
		<?php PersonalityUtil::printPersonalityIconSwitcher('page'); ?>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<div>
	<div id="page-body">
		<div class="opa60">
			<?php printPageContent(); ?>
			<?php printCodeBlock(1); ?>
		</div>
	</div>	
</div>



