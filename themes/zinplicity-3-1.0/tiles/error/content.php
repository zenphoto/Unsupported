<?php global $_zp_themeroot; ?>
<div id="gallery-desc" class="error">
	<img src='<?= $_zp_themeroot ?>/resources/images/error.gif' width='48' height='48' />
	<div class='text'><?php printGalleryDesc(); ?></div>
</div>	
<div id="page-content" class='error'>
	<?php if ( defined('ERROR_MESSAGE') ) echo ERROR_MESSAGE; ?>
</div>	
