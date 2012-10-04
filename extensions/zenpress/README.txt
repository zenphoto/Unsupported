==============================
      ZenPress 1.2.2
------------------------------
http://www.simbul.net/zenpress
==============================

ZenPress is a plugin for WordPress.
It is designed to provide an easy way to include
Zenphoto images into your blog posts.

ZenPress 1.2.2 is fully compatible with
WordPress 2.1 and Zenphoto 1.0.6.
It is NOT compatible with older versions of
Wordpress (you can always install 1.1.1, in that case).

INSTALLATION
------------
1. Expand the compressed archive in your
   WordPress plugins directory (most likely
   wordpress/wp-content/plugins).
2. Open WordPress and activate the plugin from
   the Plugins menu.
3. Configure ZenPress. Open the Options menu
   and select ZenPress. Insert the URL of your
   Zenphoto gallery. The path should be automatically
   calculated; if not, enter it manually.

Please notice that you may need to clear your browser cache in
order to see the ZenPress icon in the rich text editor.

UPGRADE
-------
Since version 1.2 the fileystem structure of the plugin has
changed a little: to avoid possible conflicts it is recommended
to uninstall previous ZenPress versions before installing 1.2.
To uninstall, simply deactivate your plugin from the Wordpress
Plugins menu and then delete the two ZenPress folders (most
likely wordpress/wp-content/plugins/zenpress and
wordpress/wp-includes/js/tinymce/plugins/zenpress).
This will not destroy your configuration options.

STYLING
-------
Since ZenPress 1.1, the thumbnails created by the plugin are
assigned a CSS class named .ZenPress_thumb. When using Word Wrap,
the thumbnails are also assigned classes .ZenPress_left (when the
image is positioned on the left side and the text wraps on the right
one) and .ZenPress_right (in the opposite situation).
Notice that, since ZenPress automatically adds a margin to the
elements belonging to the last two classes, in may be necessary to
use "!important" to override the value associated to the margin,
in the theme stylesheet.

LICENSE
-------
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

CHANGELOG
---------
1.2.2
Fixed a bug causing conflicts with other plugins

1.2.1
Small bugfix

1.2
Changed filesystem structure (no more files in wp-includes!)
Added popup customization options
Code has been cleaned a little
Popup radio buttons don't look ugly in IE anymore
Fixed a bug which made the popup scroll to top when
 opening/closing a menu
Better options management (more WP-like)

1.1.1
Custom-size thumbnails now use ZenPhoto resizing for better quality

1.1
Added full internationalization support (zenpress.pot)
Added italian translation
Added Text Wrap option
Added an option to set the size of the thumbnail
Support for zp-config.php is now default
Thumbnails can be styled

1.0
Clarified (hopefully) the configuration page
Added support for zp-config.php (future Zenphoto releases)

0.9.4
It is now possible to set the number of images to show
It is now possible to set the sorting order of images
Brand new error handling, to ease debugging and support
Brand new database interface class
Better code organization

0.9.3
The popup now works in IE (at the price of uglier code, though... -_-)
Added some more error messages

0.9.2
Added support for Zenphoto database table prefix

0.9.1
Added some error messages to ease debugging

0.9
First beta release
