<?php if( getOption('google_analytics_key') != '' ) { ?>
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www."); document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		try { var pageTracker = _gat._getTracker("<?php echo getOption('google_analytics_key'); ?>"); pageTracker._trackPageview(); } catch(err) {}
	</script>
<?php } ?>
<?php if( ( getOption('piwik_adress') != '' ) AND ( getOption('piwik_number') != '' ) ) { ?>
<!-- Piwik -->
<script type="text/javascript">
	var pkBaseURL = (("https:" == document.location.protocol) ? "https://<?php echo getOption('piwik_adress'); ?>/" : "http://<?php echo getOption('piwik_adress'); ?>/");
	document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	try {
		var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", <?php echo getOption('piwik_number'); ?>);
		piwikTracker.trackPageView();
		piwikTracker.enableLinkTracking();
	} catch( err ) {}
</script>
<noscript>
	<p>
		<img src="http://piwik.rkemps.fr/piwik.php?idsite=1" style="border:0" alt="" />
	</p>
</noscript>
<!-- End Piwik Tag -->
<?php } ?>