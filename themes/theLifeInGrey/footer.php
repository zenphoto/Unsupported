<div id="footer">
	<div class="archives">
		<?php printCustomPageURL(gettext("Archive View"),"archive"); ?>
	</div>
	<?php
	if (function_exists('printLanguageSelector')) {
		echo ' - ';
		printLanguageSelector();
	} 
	if (zp_loggedin() && function_exists('printUserLogin_out')) {
		echo ' - <div class="logout">';
		printUserLogin_out();
		echo '</div>';
	}
	?>
	<p>
		Theme by theWholeLifeToLearn for <a href="http://www.zenphoto.org/">Zenphoto</a> based on M9 & Default themes.
	</p>
</div>