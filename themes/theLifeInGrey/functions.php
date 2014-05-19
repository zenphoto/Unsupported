<?php
function m9GetRSS($option) {
	global $_zp_current_album;
	$host = htmlentities($_SERVER['HTTP_HOST'], ENT_QUOTES, 'UTF-8');
	$lang = getOption('locale');

	switch($option) {
		case 'gallery':
			return 'http://'.$host.WEBPATH.'/rss.php?lang='.$lang;
		case 'album':
			return 'http://'.$host.WEBPATH.'/rss.php?albumtitle='.urlencode(getAlbumTitle()).'&amp;albumname='.urlencode($_zp_current_album->getFilename()).'&amp;lang='.$lang;
		case 'collection':
			return 'http://'.$host.WEBPATH.'/rss.php?albumtitle='.urlencode(getAlbumTitle()).'&amp;folder='.urlencode($_zp_current_album->getFilename()).'&amp;lang='.$lang;
		case 'comments':
			return 'http://'.$host.WEBPATH.'/rss-comments.php?lang='.$lang;
		case 'comments-image':
			return 'http://'.$host.WEBPATH.'/rss-comments.php?id='.$_zp_current_image->getID().'&amp;title='.urlencode(getImageTitle()).'&amp;type=image&amp;lang='.$lang;
		case 'comments-album':
			return 'http://'.$host.WEBPATH.'/rss-comments.php?id='.$_zp_current_album->getID().'&amp;title='.urlencode(getAlbumTitle()).'&amp;type=album&amp;lang='.$lang;
		case 'albums-rss':
			return 'http://'.$host.WEBPATH.'/rss.php?lang='.$lang.'&amp;albumsmode';
	}
}

function m9PrintBreadcrumb() {
	global $_zp_current_album, $_zp_last_album;

	$parents = getParentAlbums();
	$n = count($parents);

	if ($n > 0) {
		foreach($parents as $parent) {
			$url = rewrite_path("/".pathurlencode($parent->name)."/", "/index.php?album=".urlencode($parent->name));
			echo '<li><a href="'.htmlspecialchars($url).'">'.html_encode($parent->getTitle()).'</a></li>';
		}
	}
	
}

?>