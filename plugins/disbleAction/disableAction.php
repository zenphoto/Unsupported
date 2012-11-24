<?php
/**
 *
 * Removes the specific image and album HTML from the DOM if the user does not have <var>ADMIN_RIGHTS</var>
 *
 * This instance of the plugin will disable the image/album "publish" action. But it is intended mostly as an example.
 * To disable other actions you will need to examine the page HTML and change/insert code as needed.
 *
 * @package plugins
 * @subpackage demo
 */
$plugin_is_filter = 5|ADMIN_PLUGIN;
$plugin_description = gettext("Disable publish/unpublish if user does not have <em>ADMIN_RIGHTS</em>.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.4.4';

zp_register_filter('admin_note', 'disableRight::disable');	// a convenient point since it is established what page and tab are selected
zp_register_filter('admin_managed_albums_access', 'disableRight::save');

class disableRight {

	/**
	 * removes the HTML for the action we wish to disable.
	 * @param string $tab
	 * @param string $subtab
	 */
	static function disable($tab, $subtab) {
		global $_zp_admin_tab;
		if (!zp_loggedin(ADMIN_RIGHTS) && $_zp_admin_tab == 'edit') {
			switch ($subtab) {
				case 'imageinfo':
					?>
					<script type="text/javascript">
						// <!-- <![CDATA[
						$(window).load(function() {
							$('option[value=showall]').remove();
							$('option[value=hideall]').remove();
							$('input[name$=Visible]').attr('disabled','disabled')
						});
					// ]]> -->
					</script>
					<?php
					break;
				case 'albuminfo':
					?>
					<script type="text/javascript">
						// <!-- <![CDATA[
						$(window).load(function() {
							$('input[name=Published]').attr('disabled','disabled');
						});
						// ]]> -->
					</script>
					<?php
					break;
				default:
					if (isset($_GET['massedit'])) {
						?>
						<script type="text/javascript">
							// <!-- <![CDATA[
							$(window).load(function() {
								$('input[name$=Published]').attr('disabled','disabled');
							});
						// ]]> -->
						</script>
						<?php
					} else {
						?>
						<script type="text/javascript">
							// <!-- <![CDATA[
							$(window).load(function() {
								$('option[value=showall]').remove();
								$('option[value=hideall]').remove();
								$('img[src*=action]').attr('alt',' ');
								$('img[src*=pass]').attr('alt',' ');
								$('img[src*=action]').attr('title',' ');
								$('img[src*=pass]').attr('title',' ');
								$('img[src*=action]').attr('src','images/icon_inactive.png');
								$('img[src*=pass]').attr('src','images/icon_inactive.png');
							});
						// ]]> -->
						</script>
						<?php
					}
					break;
			}
		}
	}

	static function save($allow) {
		global $_zp_admin_tab;
		if (!zp_loggedin(ADMIN_RIGHTS) && $_zp_admin_tab == 'edit') {
			if (@$_GET['action']=='publish') {
				unset($_GET['action']);
			} else {
				$bulk =	@$_POST['checkallaction'];
				if($bulk =='showall' || $bulk=='hideall') {
					unset($_GET['action']);
					unset($_POST['checkallaction']);
				} else {
					foreach ($_POST as $key=>$item) {
						if (strpos($key, 'Published')!==false) unset($_POST[$key]);
						if (strpos($key, 'Visible')!==false) unset($_POST[$key]);
					}
				}
			}
		}
		return $allow;
	}

}

?>