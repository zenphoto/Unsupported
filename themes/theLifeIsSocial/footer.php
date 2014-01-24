	<div id="bottom_menu">
	<?php
	printThemeFooter();
	if ( function_exists('printFlagLanguageSelector') ) {
		printFlagLanguageSelector();
	} elseif ( function_exists('printLanguageSelector') ) {
		printLanguageSelector();
	}  
	?>
	</div>
	<p id="copyright">
		Theme "the Life is Social" by <a href="http://zenphoto.rkemps.fr/">theWholeLifeToLearn</a> for the web gallery <a href="http://www.zenphoto.org/">Zenphoto</a>.
	</p>