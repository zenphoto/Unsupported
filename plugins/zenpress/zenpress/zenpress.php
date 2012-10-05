<?php
/*
Plugin Name: ZenPress
Plugin URI: http://www.simbul.net/zenpress
Description: This plugin adds an interface for inserting ZenPhoto thumbnails in WP posts. Works with WP 2.1 and ZenPhoto 1.0.6.
Author: Alessandro Morandi
Version: 1.2.2
Author URI: http://www.simbul.net
*/

/**
 * Copyright 2006/2007  Alessandro Morandi  (email : webmaster@simbul.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

load_plugin_textdomain('zenpress','wp-content/plugins/zenpress/locale');

/**
 * This class is meant to avoid name collisions with existing WP functions
 */
class zenpress {
	
	/**
	 * Add the configuration page to the "Options" WP menu.
	 */
	function add_pages() {
		if ( current_user_can('manage_options') ) {
			add_options_page(__('ZenPress Configuration','zenpress'), 'ZenPress', 'manage_options', 'zenpress/zp_config.php');
		}
	}
	
	/**
	 * Add CSS definitions (margin for thumbnails when Word Wrap is used)
	 */
	function add_style() {
		$output = '<style type="text/css">.ZenPress_left {margin-right:1em;} .ZenPress_right {margin-left:1em;}</style>';
		echo $output;
	}
	
	/**
	 * Add the plugin for the tinyMCE editor
	 * @param $plugins	Plugins array
	 * @return	Updated plugins array
	 */
	function extended_editor_mce_plugins($plugins) {
		array_push($plugins, '-zenpress');
		return $plugins;
	}
	
	/**
	 * Add the button for the tinyMCE editor
	 * @param buttons	Buttons array
	 * @return	Updated buttons array
	 */
	function extended_editor_mce_buttons($buttons) {
		array_push($buttons, 'separator', 'zenpress');
    	return $buttons;
	}
	
	/**
	 * Add javascript code to make tinyMCE load the plugin
	 */
	function add_tinymce_js() {
		$url = get_bloginfo('wpurl') . '/' . PLUGINDIR . '/zenpress/tinymce/';
		echo 'tinyMCE.loadPlugin("zenpress", "' . $url . '");' . "\n";
	}

	/**
	 * Add javascript to make ZenPress available with the plain text editor
	 */
	function add_plainTextEditor_js() {
		$url = get_bloginfo('wpurl') . '/' . PLUGINDIR . '/zenpress/tinymce';
		?>
		<script type="text/javascript">
			var qttoolbar = document.getElementById("ed_toolbar");

			if (qttoolbar) {
				var anchor = document.createElement("input");
				alt = "ZenPress"
				anchor.type = "button";
				anchor.value = alt;
				anchor.className = "ed_button";
				anchor.title = alt;
				anchor.id = "ed_" + alt;
				anchor.onclick = zp_open;
				qttoolbar.appendChild(anchor);
			}

			function zp_open() {
				var url = "<?php echo $url; ?>/popup_zp.php?tinyMCE=0";
				var name = "zenpress_popup";
				var w = 480;
				var h = 480;
				var valLeft = (screen.width) ? (screen.width-w)/2 : 0;
				var valTop = (screen.height) ? (screen.height-h)/2 : 0;
				var features = "width="+w+",height="+h+",left="+valLeft+",top="+valTop+",resizable=1,scrollbars=1";
				var zenpressWindow = window.open(url, name, features);
				zenpressWindow.focus();
			}
		</script>
		<?php
	}
}

// Add actions
add_action('admin_menu', array('zenpress','add_pages'));
add_action('wp_head', array('zenpress','add_style'));
add_action('tinymce_before_init', array('zenpress','add_tinymce_js'));

// Add filters
add_filter('mce_plugins',array('zenpress','extended_editor_mce_plugins'),0);
add_filter('mce_buttons',array('zenpress','extended_editor_mce_buttons'),0);
add_filter('admin_footer',array('zenpress','add_plainTextEditor_js'));

?>
