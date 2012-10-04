<?php
/**
 * shutterfly -- Supports using Shutterfly for printing images from a gallery.
 * 
 * @author Darrell Dudics (GameDudeX) adapted as a plugin by Stephen Billard (sbillard)
 * @version 1.0.1
 * @package plugins 
 */

$plugin_description = gettext("Adds a link to allow requesting a single image print through Shutterfly.");
$plugin_author = gettext("Darrell Dudics (GameDudeX) adapted as a plugin by Stephen Billard (sbillard)");
$plugin_version = '1.0.1';
$plugin_URL = "http://www.zenphoto.org/documentation/plugins/_plugins---shutterfly.php.html";

// register the scripts needed
addPluginScript('<link rel="stylesheet" href="'.FULLWEBPATH."/".ZENFOLDER.PLUGIN_FOLDER.'shutterfly/shutterfly.css" type="text/css" />');

/**
 * Prints the Shutterfly logo and links to print an image.
 *
 */
function printShutterfly() {
echo '<script type="text/javascript">'."\n";
echo '<!--/* Code from http://www.netlobo.com/div_hiding.html */-->'."\n"; 
echo '	function toggleLayer(whichLayer) {'."\n";
echo '		if (document.getElementById) {'."\n";
echo '// this is the way the standards work'."\n";
echo '			var style2 = document.getElementById(whichLayer).style;'."\n";
echo '			style2.display = style2.display? "":"block";'."\n";
echo '		} else if (document.all) {'."\n";
echo '// this is the way old msie versions work'."\n";
echo '			var style2 = document.all[whichLayer].style;'."\n";
echo '			style2.display = style2.display? "":"block";'."\n";
echo '		} else if (document.layers) {'."\n";
echo '// this is the way nn4 works'."\n";
echo '			var style2 = document.layers[whichLayer].style;'."\n";
echo '			style2.display = style2.display? "":"block";'."\n";
echo '		}'."\n";
echo '	}'."\n";
echo '</script>'."\n";

echo "<div id=\"zp-shutterfly\" onClick=\"toggleLayer('extended')\">\n";
echo '	<div id="extended">'."\n";
echo '		<form action="http://www.shutterfly.com/c4p/UpdateCart.jsp" method="post">'."\n";
echo '			<input type="hidden" name="addim" value="1" />'."\n";
echo '			<input type="hidden" name="protocol" value="SFP,100" />'."\n";
echo '			<input type="hidden" name="pid" value="C4P" />'."\n";
echo '			<input type="hidden" name="psid" value="AFFL" />'."\n";
echo '			<input type="hidden" name="puid" value="visitor" />'."\n";
echo '			<input type="hidden" name="imnum" value="1" />'."\n";
echo '			<input type="hidden" name="imraw-1" value="http://'.$_SERVER['HTTP_HOST'].htmlspecialchars(getUnprotectedImageURL()).'" />'."\n";
echo '			<input type="hidden" name="imrawwidth-1" value="'.getFullWidth().'" />'."\n";
echo '			<input type="hidden" name="imrawheight-1" value="'.getFullHeight().'" />'."\n";
echo '			<input type="hidden" name="imthumb-1" value="http://'.$_SERVER['HTTP_HOST'].getImageThumb().'" />'."\n";
echo '			<input type="hidden" name="imthumbheight-1" value="'.getOption('thumb_crop_height').'" />'."\n";
echo '			<input type="hidden" name="imthumbwidth-1" value="'.getOption('thumb_crop_width').'" />'."\n";
echo '			<input type="hidden" name="returl" value="http://'.$_SERVER['HTTP_HOST'].htmlspecialchars(getImageLinkURL()).'" />'."\n";
echo '			<input type="submit" value="Add to Shutterfly Cart &raquo;" />'."\n";
echo '		</form>'."\n";
echo '	</div>'."\n";
echo '</div>'."\n";
}
?>
