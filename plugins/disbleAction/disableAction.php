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
		if (!zp_loggedin(ADMIN_RIGHTS)) {
			switch ($_zp_admin_tab) {
				case 'upload':
		 				?>
						<script type="text/javascript">
							// <!-- <![CDATA[
							$(window).load(function() {
								$('#publishalbum').attr('disabled','disabled');
								$('#publishalbum').removeAttr('checked');
							});
						// ]]> -->
						</script>
						<?php
					break;

		 	case 'edit':
		 		switch ($subtab) {
		 			case 'imageinfo':
		 				?>
						<script type="text/javascript">
							// <!-- <![CDATA[
							$(window).load(function() {
								$('option[value=showall]').remove();
								$('option[value=hideall]').remove();
								$('input[name$=Visible]').attr('disabled','disabled');
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
				 		break;
			}
		}
	}

	static function save($allow) {
		if (!zp_loggedin(ADMIN_RIGHTS)) {
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'publish':
						unset($_GET['action']);
						break;
					case 'save':
						if (isset($_POST['album'])) {
							$folder = sanitize_path($_POST['album']);
							$album = new Album(NULL, $folder);
							if (isset($_POST['totalimages'])) {
								for ($i = 0; $i < $_POST['totalimages']; $i++) {
									$filename = sanitize($_POST["$i-filename"]);
									$image = newImage($album, $filename);
									if ($image->getShow()) {
										$_POST[$i.'-Visible'] = 1;
									}
								}
							} else {
								if ($album->getShow()) {
									$_POST['Published'] = 1;
								}
							}
						} else {
							if (isset($_POST['totalalbums'])) {
								$n = sanitize_numeric($_POST['totalalbums']);
								for ($i = 1; $i <= $n; $i++) {
									if ($i>0) {
										$prefix = $i."-";
									} else {
										$prefix = '';
									}
									$f = sanitize_path(trim(sanitize($_POST[$prefix.'folder'])));
									$album = new Album(NULL, $f);
									if ($album->getShow()) {
										$_POST[$prefix.'Published'] = 1;
									}
								}
							}
						}
					break;
				}
			}
		}
		return $allow;
	}

}

?>