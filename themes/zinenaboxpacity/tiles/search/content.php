<?php global $_zp_themeroot; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa80 shadow">
	<div id="image-title-placeholder" class="right">
		
	</div>
	<div class="left">
		<img id='search-icon' src="<?= PersonalityUtil::getPersonaIconURL("search", "$_zp_themeroot/resources/images/search.png") ?>" width="64" height="64"/>
		<?php PersonalityUtil::printPersonalityIconSwitcher('search'); ?>
	</div>
	<div id="search_words" class="text left">
		<span>
			<em class="wrap"><?= gettext('Search') ?>: <a><?= SearchUtil::getSearchQuery() ?></a></em>
		</span>
	</div>
	<div class="clear"></div>
</div>

<div id="image-wrap-scroll">
	<div>
		<div id="image-wrapper">
			<div id="image-full-preview-container" class="opa80"></div>
		</div>	
	</div>

	<div id="scroller" class="opa80">
		<img id="left-scroll" src="<?= $_zp_themeroot ?>/resources/images/arrow_left_32.png" style="margin-right: 3px;"/>
		<img id="right-scroll" src="<?= $_zp_themeroot ?>/resources/images/arrow_right_32.png" />
	</div>
</div>

<div id="image-description" class="opa30" style="display: none;"></div>

<div id="content-filler" class="opa20" style="margin-top: 8px;"></div>


