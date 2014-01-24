<?php
	Utils::import('NewsController');

	global $_zp_themeroot, $_zp_gallery_page;
	
	$controller = new NewsController();

	$currentPage = $_zp_gallery_page;
	$_zp_gallery_page = 'news.php';

	echo "<div id='gallery-desc'>";
	printGalleryDesc();
	echo "</div>";

	echo "<div class='pagelist news-nav'>";
	$controller->printNewsPageListWithNav(
		"<img src='$_zp_themeroot/resources/images/arrow_right.png' height='12'/>",
		"<img src='$_zp_themeroot/resources/images/arrow_left.png' height='12'/>");
	echo "</div>";

	if ( !isset($_REQUEST['category']) ):
		$links = $controller->prepare();
		
		echo "<div id='news-header-wrapper'>";
		echo $links;
		echo $controller->getRss();
		echo "</div>";

		include(SERVERPATH . '/themes/' . basename(dirname(dirname(dirname(__FILE__)))) . '/tiles/news/template.php');
	else:
		$u = 0;
		while ( next_news() ) :
			$u++;			
			include(SERVERPATH . '/themes/' . basename(dirname(dirname(dirname(__FILE__)))) . '/tiles/news/template.php');
		endwhile;

		if ( $u == 0 ) :
			echo "<div id='no-such-news-category'>No such category <em>" . $_REQUEST['category'] . "</em></div>";
		endif;

	endif;

	$_zp_gallery_page = $currentPage;
?>


