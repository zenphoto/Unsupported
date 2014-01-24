<?php global $_zp_themeroot; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">Contact</div>
	<div class="left">
		<img id='contact-icon' src="<?= PersonalityUtil::getPersonaIconURL("contact", "$_zp_themeroot/resources/images/contact.png") ?>" width="64" height="64"/>
		<?php PersonalityUtil::printPersonalityIconSwitcher('contact'); ?>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<div>
	<div id="page-body" class="contact page">
		<div class="opa60">
			 <?php printContactForm(); ?>
		</div>
	</div>	
</div>




