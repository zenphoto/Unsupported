<?php
/*
Plugin Name: Zenphoto Recent Comments
Plugin URI: http://www.zenphoto.org/trac/wiki/ZenphotoPlugins#ZenphotoRecentComments
Description: This simple WP plugin will show <a href="http://www.zenphoto.org">Zenphoto</a>'s Most Recent Comments to your WordPress. Most of the codes here are from Zenphoto. To show Zenphoto's Recent Comments just put <code>&lt;?php zenphoto_recent_comments(); ?></code> in your template.
Version: 0.1
Author: Cary De Guzman
Author URI: http://www.bisayaonline.net/

   Copyright 2007  Cary De Guzman  (email : carydeguzman@gmail.com)

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
*/

function zenphoto_recent_comments()
{
////////////////////////////////////////////////////////////////////
/*------------------- START OF CONFIGURATION ---------------------*/
/*MySQL Settings*/
$zen_db = ''; //The name of the database
$zen_username = ''; //Your MySQL username
$zen_password = ''; //...and password
$zen_host = 'localhost'; //99% chance you won't need to change this value
$mysql_prefix = ''; //Zen Database Tables prefix (if any)

/*More...*/
$num_of_comments = '10'; //Number of comments you want to show up.
$mods_rewrite = true; //If you have Apache mod_rewrite, put true here, and you'll get nice cruft-free URLs.
$gallery_folder = 'zenphoto'; //eg. http://mysite.com/zenphoto
/*--------------------- END OF CONFIGURATION ---------------------*/
////////////////////////////////////////////////////////////////////

//we will try to connect to the database
@ $mysql_connection = mysql_connect($zen_host,$zen_username,$zen_password) or die('Could not connect to database.');
//selecting zenphoto database
@ mysql_select_db($zen_db) or die('Could not select database.');

$sql = "SELECT c.id, i.title, i.filename, a.folder, a.title AS albumtitle, c.name, c.website,"
            . " c.date, c.comment FROM ".prefix('comments')." AS c, ".prefix('images')." AS i, ".prefix('albums')." AS a "
            . " WHERE c.imageid = i.id AND i.albumid = a.id ORDER BY c.id DESC LIMIT 10";
            
$result = mysql_query($sql, $mysql_connection) or die('MySQL Query ( '.$sql.' ) Failed. Error: ' . mysql_error());

  $allrows = array();
  while ($row = mysql_fetch_assoc($result))
  $allrows[] = $row;

          foreach ($allrows as $comment) {
            $author = $comment['name'];
            $album = $comment['folder'];
            $image = $comment['filename'];
            $albumtitle = $comment['albumtitle'];
            if ($comment['title'] == "") $title = $image; else $title = $comment['title'];
            $website = $comment['website'];
            $comment = truncate_string($comment['comment'], 123);
            echo "<li><div>$author on <a href=\""
              . ($mods_rewrite ? "../$gallery_folder/$album/$image" : "../$gallery_folder/index.php?album=".urlencode($album)."&image=".urlencode($image))
              . "\">$albumtitle / $title</a>:</div><div>$comment</div></li>";
          }
}

//Prefix a table name with a user-defined string to avoid conflicts.
function prefix($tablename) {
  return '`' . $mysql_prefix . $tablename . '`';
}

function truncate_string($string, $length) {
  if (strlen($string) > $length) {
    $pos = strpos($string, ' ', $length);
    if ($pos === FALSE) return substr($string, 0, $length) . '...';
    return substr($string, 0, $pos) . '...';
  }
  return $string;
}

?>
