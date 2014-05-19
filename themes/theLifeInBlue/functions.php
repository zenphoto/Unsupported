<?php

function getFormattedMainSiteName( $pref='', $suf='' ){
	if( getMainSiteName() != '' ){
		return $pref . getMainSiteName() . $suf;
	} else {
		return '';
	}
}

function getGalleryTitleHeader(){
	return '<h1>' . getGalleryTitle() . '</h1>';
}

function getGalleryLogo(){
}

function printThemeMenu(){
	echo '<ul id="main">';
	if( getMainSiteName() != '' ){
		echo '<li class="title">' . gettext('Main site') . '</li>';
		echo '<ul>';
			echo '<li><a href="' . getMainSiteURL() . '" title="' . getMainSiteName() . '">' . getMainSiteName() . '</a></li>';
		echo '</ul>';
	}
	if( function_exists( 'printAlbumMenu' ) ){
		echo '<li class="title">' . gettext( 'Gallery' ) . '</li>';
		$temp = getGalleryTitle();
		printAlbumMenu( 'list', false, '', 'menu-active', 'submenu', 'menu-active', $temp, true );
	} else {
		echo '<li class="title">' . gettext( 'Gallery' ) . '</li>';
		echo '<ul>';
			echo '<li><a href="' . getGalleryIndexURL() . '" title="' . getGalleryTitle() . '">' . getGalleryTitle() . '</a></li>';
		echo '</ul>';
	}
	if( function_exists( 'printNewsIndexURL' ) ){
		echo '<li class="title">' . gettext( 'News blog' ) . '</li>';
			printAllNewsCategories("All news",FALSE,"","menu-active");
	}
	if(function_exists("printPageMenu")) {
		echo '<li class="title">' . gettext( 'Pages' ) . '</li>';
		printPageMenu("list","","menu-active","submenu","menu-active");
	}
		echo '<li class="title">' . gettext('Stay informed') . '</li>';
		echo '<ul>';
			echo '<li><a href="' . getCustomPageURL( 'archive' ) . '">' . gettext('Archives') . '</a></li>';
		echo '</ul>';
	echo '</ul>';
	echo '<div id="login">';
	echo '<div class="title">' . gettext( 'Connection' ) . '</div>';
	if (function_exists('printUserLogin_out') AND !zp_loggedin()) {
		printUserLogin_out();
	}
	echo '</div>';
	if(function_exists("printLanguageSelector")) {
		echo '<div id="languages">';
			echo '<div class="title">' . gettext( 'Languages' ) . '</div>';
			printLanguageSelector();
			echo '<div class="clear_left"></div>';
		echo '</div>';
	}
}

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

function getParentBreadcrumbTLB($before='', $after='') {
	global $_zp_current_album, $_zp_last_album;

	$parents = getParentAlbums();
	$n = count($parents);

	if ($n > 0) {
		foreach($parents as $parent) {
			$url = rewrite_path("/".pathurlencode($parent->name)."/", "/index.php?album=".urlencode($parent->name));
			echo $before;
			echo '<li><a href="'.htmlspecialchars($url).'">'.html_encode($parent->getTitle()).'</a></li>';
			echo $after;
		}
	}
	
}

function getParentHeaderTitle($before='', $after='') {
	global $_zp_current_album, $_zp_last_album;
	$tmp = '';

	$parents = getParentAlbums();
	$n = count($parents);

	if ($n > 0) {
		foreach($parents as $parent) {
			$tmp .= $before . $parent->getTitle() . $after;
		}
	}
	
	return $tmp;
}


/**
 * Displays a list of all news in zenphoto
 *
 */
function newsListDisplay(){
	while (next_news()) {
?>
		<div class="newslist_article">
			<div class="newslist_title">
				<span class="italic date_news"><?php printNewsDate(); ?></span>
				<h4><?php printNewsURL(); ?></h4>
				<div class="newslist_detail">
					<div class="italic newslist_type">
						<?php
							$cat = getNewsCategories();
							if ( !empty( $cat ) ) {
								printNewsCategories(", ",gettext("Categories: "),"newslist_categories"); 
							}
						?>
					</div>
				</div>
			</div>
			<div class="newslist_content">
				<?php printCodeblock(1); ?>
				<?php printNewsContent(); ?>
				<?php printCodeblock(2); ?>
			</div>
		</div>
<?php
	}
}

function commentFormDisplay(){
?>
	<div class="clear_left"></div>
	<div id="commentaires">
	<?php
	if (function_exists('printCommentForm')) {
		printCommentForm();
	}
	?>
	</div>
<?php
}

?>