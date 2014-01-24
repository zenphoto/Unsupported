<?php global $_zp_themeroot; ?>
<div id="gallery-desc" class="password">
	<img src='<?= $_zp_themeroot ?>/resources/images/lock.png' width='48' height='48' />
	<div class='text'><?php printGalleryDesc(); ?></div>
</div>	
<div id="page-content">
	<div id="password-form-wrapper">
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
