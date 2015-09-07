<?php
/**
 *
 * This module helps you to keep track of your Zenphoto visitors through the Piwik platform.
 * It places the <i>piwik JavaScript tag</i> at the bottom of your webpages using the <i>theme_body_close</i>
 * filter. If you do not want particular pages to be tracked you should pass an array containing <var>"piwik_tag"</var> as the
 * <i>exclude</i> parameter to the theme page body close filter application. e.g.
 * <pre>zp_apply_filter('theme_body_close',array("pwik_tag"));</pre>
 *
 *  Please visit the Piwik site for the piwik software and installation instructions.
 *
 * <hr>
 *
 * Quoted from [piwik.org](http://piwik.org).
 *
 *  Piwik is a downloadable, open source (GPL licensed) real time web analytics software program.
 *  It provides you with detailed reports on your website visitors:
 *  the search engines and keywords they used, the language they speak, your popular pages... and so much more.
 *
 *  Piwik aims to be an open source alternative to Google Analytics.
 *
 * @package plugins
 * @subpackage seo
 */
$plugin_is_filter = 9|THEME_PLUGIN;
$plugin_description = gettext('A plugin to insert your Piwik JavaScript tag into your theme pages.');
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.7';

$option_interface = 'piwik_tag';

if (!getOption('piwik_admintracking') || !zp_loggedin(ADMIN_RIGHTS)) {
	zp_register_filter('theme_body_close', 'piwik_tag::placeTag');
}

class piwik_tag {
	function __construct() {
	}

	function getOptionsSupported() {
		return array(gettext('piwik url') => array('key' => 'piwik_url', 'type' => OPTION_TYPE_TEXTBOX,
												'order' => 0,
												'desc' => gettext('Enter your Piwik installation URL.')),
								gettext('site id') => array('key' => 'piwik_id', 'type' => OPTION_TYPE_TEXTBOX,
												'order' => 1,
												'desc'=> gettext('Enter the site id assigned by Piwik.')),
								gettext('Enable Admin tracking') => array ('key' => 'piwik_admintracking', 'type' => OPTION_TYPE_CHECKBOX,
												'order' => 2,
												'desc' => gettext('Controls if you want Piwik to track users with <code>Admin</code> rights.'))

		);
	}

	static function placeTag($exclude=NULL) {
		if (empty($exclude) || !in_array('piwik_tag', $exclude)) {
			$piwik_url = getOption('piwik_url');
			$piwik_id = getOption('piwik_id');
			?>
			<!-- Piwik -->
				<script type="text/javascript">
  				var _paq = _paq || [];
  				_paq.push(['trackPageView']);
  				_paq.push(['enableLinkTracking']);
  				(function() {
    				var u=(("https:" == document.location.protocol) ? "https://" : "http://") + "<?php echo $piwik_url ?>/";
    				_paq.push(['setTrackerUrl', u+'piwik.php']);
    				_paq.push(['setSiteId', <?php echo $piwik_id; ?>]);
    				var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    				g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  				})();
			</script>
			<noscript><p><img src="http://<?php echo $piwik_url ?>/piwik.php?idsite=<?php echo $piwik_id ?>" style="border:0" alt="" /></p></noscript>
			<!-- End Piwik Tag -->
			<?php
		}
		return $exclude;
	}
}
?>