<?php

if (!defined('ZENFOLDER')) { define('ZENFOLDER', 'zp-core'); }
require_once(ZENFOLDER . "/template-functions.php");

/*
Options:
- 'mode': which type of feed ('batch' = one item per album upload, 'photo' = one item per photo ; default 'batch')
- 'items': how many items in the feed (<=0 = default feed_items config var ; default <=0)
- 'size': size of included photos (0 or <0 = no photo, 1 = thumbnail, 2 = small view (400pix), 3 = normal view ; default 2)
- 'photos': if mode=batch, how many included photos per item at most (0 = no photo, <0 = no limit ; default <0)
- 'skiptime': if mode=batch, the minimum time between upload of two successive photos in the same album to generate two separate items (<0 = 2 hours ; default <0)
- 'albumnr'
- 'albumname'
*/

//Default option values:
$def_mode="batch";
$def_photos=-1;
$def_items=getOption('feed_items');
$def_size=2;
$def_skiptime=2 * 3600; 


header('Content-Type: application/xml');
$themepath = 'themes';

$albumnr = $_GET[albumnr];
$albumname = $_GET[albumname];
if (isset($_GET[mode]))
	$mode = $_GET[mode]; else
	$mode = $def_mode;
if (isset($_GET[photos]) && is_numeric($_GET[photos]) && $_GET[photos] >= 0)
	$photos = $_GET[photos]; else
	$photos = $def_photos;
if (isset($_GET[items]) && is_numeric($_GET[items]) && $_GET[items] > 0) 
	$items = $_GET[items]; else
	$items = $def_items;
if (isset($_GET[size]) && is_numeric($_GET[size]))
	$size = $_GET[size]; else
	$size = $def_size;
if (isset($_GET[skiptime]) && is_numeric($_GET[skiptime]) && $_GET[skiptime] >= 0)
	$skiptime = $_GET[skiptime]; else
	$skiptime = $def_skiptime;


if ($albumname != "") { $albumname = " - for album: ".$_GET[albumname]; }
if(getOption('mod_rewrite'))
 { $albumpath = "/"; $imagepath = "/"; $modrewritesuffix = getOption('mod_rewrite_image_suffix'); }
else
 { $albumpath = "/index.php?album="; $imagepath = "&image="; $modrewritesuffix = ""; }

?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<title><?php echo getOption('gallery_title'); ?><?php echo $albumname; ?></title>
<link><?php echo "http://".$_SERVER["HTTP_HOST"].WEBPATH; ?></link>
<description><?php echo getOption('gallery_title'); ?></description>
<language>en-us</language>
<pubDate><?php echo date("r", time()); ?></pubDate>
<lastBuildDate><?php echo date("r", time()); ?></lastBuildDate>
<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<generator>cyril42e's ZenPhoto RSS Generator based on Acrylian's ZenPhoto Album RSS Generator based on Alenônimo's ZenPhoto RSS Generator which is based on ThinkDreams' Generator</generator>
<managingEditor><?php echo getOption('admin_name'); ?></managingEditor>
<webMaster><?php echo getOption('admin_name'); ?></webMaster>
<?php 
//$iw = $cw = 400; // Image Width
//$ih = $ch = 300; // Image Height
switch($size)
{
	case 1: $is = "thumb"; break;
	case 2: $is = 400; break;
	case 3: $is = getOption('image_size'); break;
	default: $is = 400;
}



db_connect();

function getFullAlbumName($a)
{
				// get full album path
				$full_album="";
				$parenta=$a;
				while (true)
				{
					$full_album = ($parenta['parentid'] == NULL ? "" : " | ") . $parenta['title'] . $full_album;
					if ($parenta['parentid'] == NULL) break;
					$sql="SELECT * FROM ". prefix("albums") ." WHERE `show` = 1 AND id = ".$parenta['parentid']; 
					$parentalbum = mysql_query($sql);
					$parenta = mysql_fetch_array($parentalbum);
				}
				return $full_album;
}

/*
- the idea is to group together in the same rss entry all the photos that have been added at the same time in the same album
- photos are browsed by decreasing mtime (uploaded date, because id doesn't seem to be very reliable), and every time the album change, or a 1 hour gap occurred during uploading, a new entry is created, that contains the list of all photos with title and description, and optionally photo (?nophotos)
- rss entries are not created if the latest photo is less than 1 hour old, in order to avoid multiple entries for the same event (moreover it gives some time to edit titles and descriptions during this hour)

improvement suggestions: 
- merge entries with photos uploaded within 1 hour, but separated by photos uploaded to other albums. This is more difficult because you have to group non contiguous photos. The best way to do that is probably when an album change is detected, to keep scanning the database for photos in the same album uploaded less than one hour after, and then going back to where the gap was detected.
- is it possible with rss2 to force feed readers to show the description inside the feed rather than loading the link (in case subscribers forget to ask to show summary instead of loading the page, this is non sense to load the album page here ...) ?
*/

if ($mode == "photo")
{
//### PHOTO MODE

if ($albumnr != "") { 
  $sql = "SELECT * FROM ". prefix("images") ." WHERE albumid = $albumnr AND `show` = 1 ORDER BY mtime DESC LIMIT ".$items;
} else { 
  $sql = "SELECT * FROM ". prefix("images") ." WHERE `show` = 1 ORDER BY mtime DESC LIMIT ".$items; 
}
 	
$result = mysql_query($sql);

while($r = mysql_fetch_array($result)) {
$id=$r['albumid'];

if ($albumnr != "") { 
  $sql="SELECT * FROM ". prefix("albums") ." WHERE `show` = 1 AND id = $albumnr"; 
} else { 
  $sql="SELECT * FROM ". prefix("albums") ." WHERE `show` = 1 AND id = $id"; 
}

$album = mysql_query($sql);
$a = mysql_fetch_array($album);
// get full album path
$full_album=getFullAlbumName($a);

?>
<item>
	<title><?php echo $r['title']; ?></title>
	<link><?php echo '<![CDATA[http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.$a['folder'].$imagepath.$r['filename'].$modrewritesuffix. ']]>';?></link>
    <category><?php echo $a['title']; ?></category>
	<guid><?php echo '<![CDATA[http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.$a['folder'].$imagepath.$r['filename'].$modrewritesuffix. ']]>';?></guid>
	<pubDate><?php echo $r['date']; ?></pubDate>
	<description><![CDATA[<?php
				echo "<b>Album</b> ".$full_album."<br/><br/>";
	
	echo $r['desc']."<br/>\n";
	if ($size > 0)
	{
		echo '<a title="'.$r['title'].'" href="http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.urlencode($a['folder']).$imagepath.urlencode($r['filename']).$modrewritesuffix.'"><img border="0" src="http://'.$_SERVER["HTTP_HOST"].WEBPATH.'/'.ZENFOLDER.'/i.php?a='.urlencode($a['folder']).'&i='.urlencode($r['filename']).'&s='.$is.'" alt="'. $r['title'] .'"></a><br/><br/>';
	}
	echo "]]>	</description>\n</item>\n";
	}
	
} else
{
//### BATCH MODE

$mtime_now=date("U");
$nentries=0;
$nphotos=0;
$item_opened=false;

for($i = 0; $nentries <= $items; $i++)
{
	// get the 100 next photos
	if ($albumnr != "") { 
		$sql = "SELECT * FROM ". prefix("images") ." WHERE albumid = $albumnr AND `show` = 1 ORDER BY mtime DESC LIMIT ".($i*100).",100";
	} else { 
		$sql = "SELECT * FROM ". prefix("images") ." WHERE `show` = 1 ORDER BY mtime DESC LIMIT ".($i*100).",100";
	}
	$result = mysql_query($sql);
	if ($result == "") break;

	// process these photos
	while($r = mysql_fetch_array($result)) 
	{
		// get album infos
		$id=$r['albumid'];
		if ($albumnr != "") { 
			$sql="SELECT * FROM ". prefix("albums") ." WHERE `show` = 1 AND id = $albumnr"; 
		} else { 
			$sql="SELECT * FROM ". prefix("albums") ." WHERE `show` = 1 AND id = $id"; 
		}
		$album = mysql_query($sql);
		$a = mysql_fetch_array($album);

		// sanitize database
		if (!file_exists(getAlbumFolder() . $a['folder'] . "/" . $r['filename']))
		{
			echo '<!-- file ' .getAlbumFolder() . $a['folder'] . "/" . $r['filename']. ' doesnt exist-->';
			$sql = "DELETE FROM ". prefix("images") ." WHERE id = ".$r['id'];
			mysql_query($sql);
			continue;
		}

		// check if new post : first photo, or album changed, or more than 1 hour between two photos
		if (!isset($preva) || ($preva['id'] != $a['id']) || ($prevr['mtime']-$r['mtime'] > $skiptime))
		{
			// check if this first photo of the post is older than 1 hour
			$skip = ($mtime_now - $r['mtime'] <= $skiptime+1);
			
			// begin new post
			if (!$skip)
			{
				$nentries++;
				if ($nentries > $items) break;
				$nphotos=0;
				
				// if not first photo, close previous post
				if ($item_opened) echo "]]>	</description>\n</item>\n";
				
				// get full album path
				$full_album=getFullAlbumName($a);
				?>
<item>
	<title><?php echo 'New photos in album: ' . $full_album; ?></title>
	<link><?php echo '<![CDATA[http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.$a['folder'].$modrewritesuffix. ']]>';?></link>
	<category><?php echo $full_album; ?></category>
	<guid><?php echo '<![CDATA[http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.$a['folder'].$imagepath.$r['filename'].$modrewritesuffix. ']]>';?></guid>
	<pubDate><?php echo date('r', $r['mtime']); ?></pubDate>
	<description><![CDATA[<?php
				if ($a['desc'] != "") echo "<b>Album description:</b> ".$a['desc']."<br/><br/>";
				echo "<b>New photos:</b><br/>";
				$item_opened=true;
			}
		}
		
		// add photo information
		if (!$skip)
		{
			$nphotos++;
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.urlencode($a['folder']).$imagepath.urlencode($r['filename']).$modrewritesuffix.'">'.$r['title'].'</a>: '.$r['desc'];
			echo "<br/>\n";
			if (($photos < 0 || $nphotos <= $photos) && $size > 0)
			{
				echo '<a title="'.$r['title'].'" href="http://'.$_SERVER["HTTP_HOST"].WEBPATH.$albumpath.urlencode($a['folder']).$imagepath.urlencode($r['filename']).$modrewritesuffix.'"><img border="0" src="http://'.$_SERVER["HTTP_HOST"].WEBPATH.'/'.ZENFOLDER.'/i.php?a='.urlencode($a['folder']).'&i='.urlencode($r['filename']).'&s='.$is.'" alt="'. $r['title'] .'"></a><br/><br/>';
			}
		}

		$prevr=$r;
		$preva=$a;
	}
}
// if not first photo, close previous post
if ($item_opened) echo "]]>	</description>\n</item>\n";
}

?>
<atom:link href="http://<?php echo $_SERVER["HTTP_HOST"].WEBPATH.'/rss.php'.($HTTP_SERVER_VARS["QUERY_STRING"] == "" ? '' : '?'.$HTTP_SERVER_VARS["QUERY_STRING"]); ?>" rel="self" type="application/rss+xml" />
</channel>
</rss>