<?php
	require_once(SERVERPATH . '/themes/' . basename(dirname(dirname(__FILE__))) . '/classes/GalleryController.php');
	
	class SearchController extends GalleryController {
		function SearchController() {
			parent::GalleryController();
			set_context(ZP_SEARCH);
		}
	
		protected function getAlbums() {
			global $_zp_current_search;
			return $_zp_current_search->getSearchAlbums(false, false);
		}

		protected function showRandomImage() {
			return TRUE;
		}

		function getTotalResults() {
			return $this->getNumAlbums() + $this->getNumImages() + getNumNews();
		}

		function getHitResults() {
			$results = NULL;
			$total = $this->getTotalResults();
			$searchwords = getSearchWords();
			$searchdate = getSearchDate();

			if (!empty($searchdate)) {
				if (!empty($seachwords)) {
					$searchwords .= ": ";
				}
				$searchwords .= $searchdate;
			}

			if ( empty($searchwords) ) return NULL;

			if ($total > 0 ) {
				if ($total > 1) { 
					$results = "$total Hits for <em>$searchwords</em>"; 
				} 
				else {
					$results = "1 Hit for <em>$searchwords</em>"; 
				}
			}
			else  {
				$results = "No Hit for <em>$searchwords</em>"; 
			}
			return $results;
		}

		function printNewsHTML($num) {
			if ( !$_REQUEST['words'] ) return;

			global $_zp_current_zenpage_news, $_zp_current_search;
			if ( !defined('CROP_NEWS') ) define('CROP_NEWS', TRUE);
			save_context();
			add_context(ZP_ZENPAGE_NEWS_ARTICLE);

			$u = 0;

			processExpired('zenpage_news');
			$articles = $_zp_current_search->getSearchNews();

			if ( count($articles) == 0 ) return;

			$articles = $this->sortArticles($articles, 'id');
			
			echo "<div id='snr'>";
			echo "<div>Also found " . count($articles) . " news"; 
			if ( count($articles) > 3 ) echo " - showing the last 3</div>"; else echo "</div>";
			echo "</div>";

			$len = count($articles);
			for ( $u = $len - 1; $u >= 0 && $u > $len - 4; $u-- ) :
				$news = $articles[$u];
				$_zp_current_zenpage_news = new ZenpageNews($news['titlelink']);
				Utils::render("tiles/news/template.php");
			endfor;

			restore_context();
		}

		function printAlbumNav() {
			global $_zp_current_album;
			$i = $_zp_current_album;
			$_zp_current_album = NULL;
			parent::printAlbumNav(FALSE, ZP_SEARCH);
			$_zp_current_album = $i;
		}

		protected function setAlbum($album) {
			global $_zp_current_search;
			$this->album = $_zp_current_search;
			$this->albumPage = isset($this->requestedPage) ? $this->requestedPage : 1;
		}

		protected function setImage($image) {
			if ( isset($image) ):
				$this->context = $this->context | ZP_IMAGE;
				$album = $_REQUEST['album'];
				$this->image = newImage(new Album($_zp_gallery, $album), $image);
				$this->albumPage = $this->getImagePage();
				$this->albumPage = $this->albumPage == 0 ? 1 : $this->albumPage;
			else:
				parent::setImage($image);
			endif;
		}

		private function getImagePage() {
			global $_zp_current_search;

			if ( $_REQUEST['page'] ) return $_REQUEST['page'];

			return 1;
		}
			
		protected function getImage($i) {
			return newImage(new Album($_zp_gallery, $i['folder']), $i['filename']);
		}	

		protected function getAlbumImages($start) {
			$a = parent::getAlbumImages(0);
			return array_slice($a, ($start - 1) * getOption('images_per_page'), getOption('images_per_page'));
		}

		protected function getAlbumPage() {
			return $this->albumPage;
		}

		protected function getAncestorAlbum() {
			return NULL;
		}

		protected function getSlideshowLink() {
			return NULL;
		}

		protected function getAlbumTabLink() {
			return $this->getTabLink(1);
		}

		protected function getImageTabLink() {
			return $this->getTabLink($this->getFirstImagePage());
		}
	
		protected function getAlbumTabText($c) {
			return $c <= 1 ? "album" : "albums";
		}

		protected function getImageThumbLink() {
			global $_zp_current_image;
			return $this->getTabLink($_zp_page, 
					'image=' . $_zp_current_image->filename . 
					'&album=' . $_zp_current_image->album->getFilename() . 
					'&page=' . $this->getAlbumPage());
		}

		private function getTabLink($page, $params='') {
			global $_zp_current_search, $_zp_page;
			$p = $_zp_page;
			$page = !$page ? 1 : $page;
			$_zp_page = $page;
			$link = getCustomPageURL('search') . $_zp_current_search->getSearchParams();
			$link = ereg_replace('&searchfields&',  '&', $link);
			$link = ereg_replace('&searchfields$',  '', $link);
			$_zp_page = $p;
			return $link;
		}

		private function sortArticles(&$array) {
			function dosort($a, $b) {
				return $a['id'] == $b['id'] ? 0 : (($a['id'] < $b['id']) ? -1 : 1);
			}
			usort($array, "dosort");
			return $array;
		}
	}
?>
