<?php global $_zp_themeroot, $_zp_current_zenpage_news; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">
		<?= gettext("Authentication required") ?>
	</div>
	<div class="left">
		<img id='lock-icon' src="<?= PersonalityUtil::getPersonaIconURL("lock", "$_zp_themeroot/resources/images/lock.png") ?>" width="64" height="64"/>
		<?php PersonalityUtil::printPersonalityIconSwitcher('lock'); ?>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<div>
	<div id="page-body" class="home">
		<div id="password-form-wrapper" class="opa60">
			<?php
			//if we're here, password should be required. 
			//always print form, no matter what checkforPAssword may return

			//if ( checkforPassword(true) ) :
				$show = (getOption('search_user') != '');
				$hint = get_language_string(getOption('search_hint'));
				printPasswordForm($hint, true, getOption('login_user_field') || $show);
			//endif;

			?>
		</div>
	</div>	
</div>



