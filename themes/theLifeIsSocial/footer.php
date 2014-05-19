<div id="bottom_menu">
	<?php
	printThemeFooter();
	if (function_exists('printFlagLanguageSelector')) {
		printFlagLanguageSelector();
	} elseif (function_exists('printLanguageSelector')) {
		printLanguageSelector();
	}
	?>
</div>
<p id="copyright">
	Theme "the Life is Social" by <em>theWholeLifeToLearn</em> for the web gallery <a href="http://www.zenphoto.org/">Zenphoto</a>.
</p>