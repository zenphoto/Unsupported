<?php
	if ( $_REQUEST["fo"] == true ) {
		if ( $_REQUEST['confirm'] == 'confirm' ) {
			require_once('classes/PluginOverrides.php');
			ContactOverride::sendMail();
?>
			<script>
			(function(w) {
				w.$.modal.close();
				w.zin.createModalBox(
		 			"<?= gettext('Thanks for your message') ?>",
					"<?= gettext('A copy of your message has also been sent to the provided e-mail adress for your own records') ?>");
			})(window.parent);
		    </script>
<?php		
		} 
		else {
?>
		<script type="text/javascript" src="<?= WEBPATH . '/' . ZENFOLDER . '/js/jquery.js' ?>"></script>
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/contact.css" media="screen" />
		<div id="page-body" class="modal contact opa60">
			<div class="opa60">
				 <?php printContactForm(); ?>
			</div>
		</div>	
			<script>
			(function(w) {
				$("form#discard").click(function() {
					w.$.modal.close();
					return true;
				});
			}(window.parent));
		</script>
<?php	
		}
	}
	else {
		require_once('theme_functions.php');
		TileSet::init(gettext("Contact"), "contact", THEME_CONTACT);
		include_once('template.php');
	}
?>
