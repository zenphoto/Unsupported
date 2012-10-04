<?php
/**
 * Allows/Denies access to the gallery to specified IP address ranges
 *
 * This does not block access to validated users, only anonomous visitors. But
 * a user will have to log on via the admin pages if out of the IP ranges as
 * he will get a Forbidden error on any front-end page including a logon form
 *
 * @author Stephen Billard (sbillard)
 * @package plugins
 */
$plugin_is_filter = 8|CLASS_PLUGIN;
$plugin_description = gettext("Gates access to the gallery by IP address range.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.0';

$option_interface = 'filterIPAccess';

zp_register_filter('load_theme_script', 'filterIPAccess_load',2);
zp_register_filter('custom_option_save', 'filterIPAccess::filterIPAccess_save',2);

/**
 * Option handler class
 *
 */
class filterIPAccess {
	/**
	 * class instantiation function
	 *
	 * @return security_logger
	 */
	function filterIPAccess() {
		setOptionDefault('filterIPAccess_IP_list', Serialize(array()));
		setOptionDefault('filterIPAccess_IP_type', 'allow');
	}


	/**
	 * Reports the supported options
	 *
	 * @return array
	 */
	function getOptionsSupported() {
		$options = array(	gettext('IP list') => array('key' => 'filterIPAccess_IP', 'type' => OPTION_TYPE_CUSTOM,
																									'desc' => gettext('List of IP ranges to gate.')),
											gettext('Action') =>array('key' => 'filterIPAccess_IP_type', 'type' => OPTION_TYPE_RADIO,
																								'buttons' => array(	gettext('Allow')=>'allow',
																																		gettext('Block')=>'block'
																																		),
																								'desc' => gettext('How the plugin will interpret the IP list.'))
		);
			if (!getOption('zp_plugin_filterIPAccess')) {
			$options['note'] = array('key'=>'filterIPAccess_note', 'type'=>OPTION_TYPE_NOTE,
															'order'=>0,
															'desc'=>'<p class="notebox">'.gettext('IP list ranges cannot be saved with the plugin disabled').'</p>');
		}
		return $options;
	}

	function handleOption($option, $currentValue) {
		$list = unserialize(getOption('filterIPAccess_IP_list'));
		if (getOption('zp_plugin_filterIPAccess')) {
			$disabled = '';
		} else {
			$disabled = ' disabled="disabled"';
		}
		$key = 0;
		foreach ($list as $key=>$range) {
			?>
			<input type="textbox" size="20" name="filterIPAccess_ip_start_<?php echo $key; ?>" value="<?php echo html_encode($range['start']); ?>"<?php echo $disabled; ?> />
			-
			<input type="textbox" size="20" name="filterIPAccess_ip_end_<?php echo $key; ?>" value="<?php echo html_encode($range['end']); ?>"<?php echo $disabled; ?> />
			<br />
			<?php
		}
		$i = $key;
		while ($i < $key+4) {
			$i++;
			?>
			<input type="textbox" size="20" name="filterIPAccess_ip_start_<?php echo $i; ?>" value=""<?php echo $disabled; ?> />
			-
			<input type="textbox" size="20" name="filterIPAccess_ip_end_<?php echo $i; ?>" value=""<?php echo $disabled; ?> />
			<br />
			<?php
		}
	}

	function filterIPAccess_save($notify,$themename,$themealbum) {
		$list = array();
		foreach ($_POST as $key=>$param) {
			if ($param) {
				if (strpos($key, 'filterIPAccess_ip_') !== false) {
					if (preg_match( "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $param)){
						$p = explode('_', substr($key,18));
						$list[$p[1]][$p[0]] = $param;
					}
				}
			}
		}
		foreach ($list as $key=>$range) {
			if (!array_key_exists('start', $range) || !array_key_exists('end', $range)) {
				unset($list[$key]);
				$notify .= gettext('IP address format error').'<br />';
			}
		}
		setOption('filterIPAccess_IP_list', serialize($list));
		return $notify;
	}

}

/**
 * Monitors Login attempts
 * @param bit $loggedin will be "false" if the login failed
 * @param string $user ignored
 * @param string $pass ignored
 */
function filterIPAccess_login($loggedin, $user, $pass) {
	if (!$loggedin) {
		failed_access_blocker_adminGate('', '');
	}
	return $loggedin;
}

function filterIPAccess_load($path) {
	$list = getOption('filterIPAccess_IP_list');
	$list = unserialize($list);
	$allow = getOption('filterIPAccess_IP_type') == 'allow';
	if (!empty($list)) {
		$ip = getUserIP();
		foreach ($list as $range) {
			if ($ip >= $range['start'] && $ip <= $range['end']) {
				if ($allow) {
					return $path;
				} else {
					header("HTTP/1.0 403 ".gettext("Forbidden"));
					header("Status: 403 ".gettext("Forbidden"));
					exit();	//	terminate the script with no output
				}
			}
		}
	}
	if ($allow) {
		//	fallthrough means we did not find a range allowing the ip, so deny
		header("HTTP/1.0 403 ".gettext("Forbidden"));
		header("Status: 403 ".gettext("Forbidden"));
		exit();	//	terminate the script with no output
	}
	return $path;
}

?>