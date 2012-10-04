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

tinyMCE.importPluginLanguagePack('zenpress', 'en');

var TinyMCE_ZenPress = {

	/**
	 * Returns information about the plugin as a name/value array.
	 * The current keys are longname, author, authorurl, infourl and version.
	 *
	 * @returns Name/value array containing information about the plugin.
	 * @type Array 
	 */
	getInfo : function() {
		return {
			longname  : 'ZenPhoto Gallery Plugin for WordPress',
			author    : 'Alessandro Morandi',
			authorurl : 'http://www.simbul.net',
			infourl   : 'http://www.simbul.net/zenpress',
			version   : "1.2"
		};
	},

	/**
	 * Returns the HTML code for a specific control or empty string if this plugin doesn't have that control.
	 * A control can be a button, select list or any other HTML item to present in the TinyMCE user interface.
	 * The variable {$editor_id} will be replaced with the current editor instance id and {$pluginurl} will be replaced
	 * with the URL of the plugin. Language variables such as {$lang_somekey} will also be replaced with contents from
	 * the language packs.
	 *
	 * @param {string} cn Editor control/button name to get HTML for.
	 * @return HTML code for a specific control or empty string.
	 * @type string
	 */
	getControlHTML : function(cn) {
		switch (cn) {
			case "zenpress":
				return tinyMCE.getButtonHTML(cn, 'lang_zenpress_zenpress', '{$pluginurl}/images/zenpress.gif', 'mceZenPress');
		}

		return "";
	},

	/**
	 * Executes a specific command, this function handles plugin commands.
	 *
	 * @param {string} editor_id TinyMCE editor instance id that issued the command.
	 * @param {HTMLElement} element Body or root element for the editor instance.
	 * @param {string} command Command name to be executed.
	 * @param {string} user_interface True/false if a user interface should be presented.
	 * @param {mixed} value Custom value argument, can be anything.
	 * @return true/false if the command was executed by this plugin or not.
	 * @type
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		switch (command) {
			case "mceZenPress":
				var template = new Array();

				template['file']   = this.baseURL + '/popup_zp.php?tinyMCE=1';
				template['width']  = 480;
				template['height'] = 480;

				args = {
					resizable : 'yes',
					scrollbars : 'yes'
				};

				tinyMCE.openWindow(template, args);
				return true;
		}
		return false;
	}
};

// Adds the plugin class to the list of available TinyMCE plugins
tinyMCE.addPlugin("zenpress", TinyMCE_ZenPress);
