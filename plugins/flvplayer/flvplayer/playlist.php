<?php	
/**
 * xspf playlist for flv player
 * 
 * @author Malte Müller (acrylian), Stephen Billard (sbillard)
 * @version 1.0.5
 * @package plugins 
 */
header("content-type:text/xml;charset=utf-8");
require_once("../../zp-core/template-functions.php");
$albumid = sanitize_numeric($_GET["albumid"]);
$albumresult = query_single_row("SELECT folder from ". prefix('albums')." WHERE id = ".$albumid);
$album = new Album(new Gallery(), $albumresult['folder']);
$playlist = $album->getImages();

echo "<playlist version='1' xmlns='http://xspf.org/ns/0/'>\n";
echo "<title>Sample XSPF Playlist</title>";
echo "<info>http://www.what.de</info>";
echo "<annotation>An example of a playlist with commercial</annotation>";
echo "<trackList>\n";
$imgextensions = array(".jpg",".jpeg",".gif",".png");
foreach($playlist as $item) {
	$image = newImage($album, $item);
	$ext = strtolower(strrchr($item, "."));
	if (($ext == ".flv") || ($ext == ".mp3") || ($ext == ".mp4")) {
		$videoThumb = $image->objectsThumb;
		if (!empty($videoThumb)) {
			$videoThumb = '../../'.getAlbumFolder('').$album->name."/".$videoThumb;
		}
		echo "\t<track>\n";
		echo "\t\t<title>".$image->getTitle()." (".$ext.")</title>\n";
		
		// As documentated on the fvl player's site movies and mp3 have are called via differently relative urls...
		// http://www.jeroenwijering.com/?item=Supported_Playlists
		if($ext == ".flv" OR $ext == ".mp4") {
			echo "\t\t<location>../../".getAlbumFolder('').$album->name."/".$item."</location>\n";
		} else {
			echo "\t\t<location>..".getAlbumFolder('').$album->name."/".$item."</location>\n";
		}
		echo "\t\t<image>".$videoThumb."</image>\n";
		echo "\t\t<info>../../".WEBPATH.'/'.getAlbumFolder('').$item."</info>\n";
		echo "\t</track>\n";
	}
}
echo "</trackList>\n";
echo "</playlist>\n";
?>