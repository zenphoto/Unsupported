<?php 
	class GalleryController {

		private $context;

		protected $requestedPage;
		protected $galleryPage;
		protected $albumPage;

		protected $album;
		
		private $image;
	

		function GalleryController() {
			global $_zp_gallery;
			
			zp_load_page();

			$this->requestedPage = getCurrentPage() >= 1 ? getCurrentPage() : 1;

			if ( !isset($_zp_gallery) ) load_gallery(); 

			list($album, $image) = rewrite_get_album_image('album','image');

			$this->setAlbum($album);

			$this->setImage($image);

		}

		function getAlbumLink($album=NULL, $page=1) {
			if ( !isset($album) ) $album = $this->album;
			$link = rewrite_path(
					"/" . pathurlencode($this->album->name) . "/page/" . $page,
					"/index.php?album=" . urlencode($this->album->name) . "&page=" . $page);
			return $link;
		}

		//workaround the fact that normalizeColumns does not work as expected.
		function getFirstImagePage() {
			global $_zp_current_album, $_zp_current_search;
			$albumsPerPage = getOption('albums_per_page');
			$totalSubalbums = $this->getNumAlbums();
			$lastAlbumPage = ceil($totalSubalbums / $albumsPerPage);
			return $lastAlbumPage + 1;
		}		

		function printBreadCrumb($after='') {
			global $_zp_current_album;
			if ( isset($this->album) ):
				$b = $_zp_current_album;
				$_zp_current_album = $this->album;
				echo "&lt; &nbsp;";
				if ( $_zp_current_album->getParent() ) printParentBreadCrumb('', ' : ', ' : '); 
				echo "<span id='album-title-span'>";
				printAlbumTitle();
				echo "</span>";
				echo $after;
				echo "&nbsp;&gt;";
				$_zp_current_album = $b;
			endif;
		}

		function getDesc() {
			if ( isset($this->album) ):
				return $this->album->getDesc();
			endif;
			return '';
		}

		function printGalleryNav() {
			global $_zp_themeroot, $_zp_page, $_zp_gallery_page;

			$p = $_zp_gallery_page;
			$_zp_gallery_page = 'gallery.php';
			$c = $this->context;
			$this->context = ZP_INDEX;
			save_context();
			set_context($this->context);
			$page = $_zp_page;
			$_zp_page = $this->galleryPage;

			printPageListWithNav(
				"<img src='$_zp_themeroot/resources/images/arrow_left.png' height='12' width='12'/>", 
				"<img src='$_zp_themeroot/resources/images/arrow_right.png' height='12' width='12'/>");

			$_zp_page = $page;
			$this->context = $c;
			restore_context();
			$_zp_gallery_page = $p;
		}

		function printAlbumNav($setCurrentAlbum = TRUE, $context=ZP_ALBUM) {
			global $_zp_themeroot, $_zp_page, $_zp_gallery_page, $_zp_current_album;
			
			if ( $this->getNumAlbums() == 0 && $this->getNumImages() == 0 ) return;

			$p = $_zp_gallery_page;
			$_zp_gallery_page = 'album.php';
			$c = $this->context;
			$this->context = $context;
			save_context();
			set_context($this->context);
			$page = $_zp_page;
			$_zp_page = $this->getAlbumPage();
			$album = $_zp_current_album;
			if ( $setCurrentAlbum ) $_zp_current_album = $this->album;

			printPageListWithNav(
				"<img src='$_zp_themeroot/resources/images/arrow_up.png' height='12' width='12'/>", 
				"<img src='$_zp_themeroot/resources/images/arrow_down.png' height='12' width='12'/>",
				false, true, "album-navigation", NULL, TRUE, 7);

			$_zp_page = $page;
			$this->context = $c;
			restore_context();
			$_zp_gallery_page = $p;
			$_zp_current_album = $album;
		}

		function getImagesHTML() {
			global $_zp_themeroot, $_zp_current_image, $_zp_current_album;
			$showImages = $this->getNumImages() > 0 && $this->albumPage >= $this->getFirstImagePage(); 
			$w = 318;

			if ( !$showImages ) return ''; 

			$inContext = ($this->context & ZP_IMAGE) || in_context(ZP_SEARCH);
			if ( $inContext && $_zp_current_image ) :
				$fileName = $_zp_current_image->getFileName();
				$folder = $_zp_current_image->album->getFolder();
			endif;
			$u = 0;
			$initialHeight = 0;
			$images = '';
			$start = $this->getAlbumPage() - ($this->getNumAlbums() > 0 ? ($this->getFirstImagePage() - 1): 0);
			$albumImages = $this->getAlbumImages($start);
			for ( $k = 0; $k < count($albumImages); $k++ ):
				$_zp_current_image = $this->getImage($albumImages[$k]);

				if ( $u == 0 ) $image = $_zp_current_image;

				$cls = '';
				if ( (!$inContext && $u == 0) || ($inContext && !$fileName && $u == 0 ) ||
					 ($inContext && $_zp_current_image && 
					  $fileName == $_zp_current_image->getFileName() && 
					  $folder == $_zp_current_image->album->getFolder()) ) :
					$cls = 'force-selection'; 
					$image = $_zp_current_image;
				endif;

				$title = getImageTitle(); 
				$size = getSizeCustomImage(NULL, $w);
				$desc = getImageDesc();

				if ( !empty($desc) ) { 
					//$desc = theme_clean($desc);
				}
				else {
					$desc = '';
				}

				$small = getCustomImageURL(NULL, $w);
				$full = getOption('protect_full_image') == 'Unprotected' ? getUnprotectedImageURL() : '';
				$thumb = getCustomImageURL(NULL, 32, 32);
				$width = $size[0];
				$height = $size[1];

				if ( $width < $w + 2 ) {
					$width = $w + 2;
					$height = $height * ($w + 2) / $width;
				}

				if ( $u == 0 ) $initialHeight = $height;

				$images .= "<span class='img img-$u' width='35' height='35'>" . 
						   "<a href='" . $this->getImageThumbLink() . "' sref='$small' title='$title' targetHeight='$height' >" . 
						   "<img src='$thumb' index='$u' width='35' height='35' title='$title' class='$cls' ref='$full' />" . 
						   "</a>" .	
						   "</span>";

				$u++;
			endfor; 
			$m = $u;
			while ( $u < 8 ) :
				$images .= "<span class='img img-$u'>" . 
						   "<img src='$_zp_themeroot/resources/images/opa/bg-b-20.png' width='35' height='35' />" . 
						   "</span>";
				$u++;
			endwhile;

			if ( !in_context(ZP_IMAGE) ):
				set_context(get_context() | ZP_IMAGE);
			endif;
			$_zp_current_image = $image;
			
			$numAlbums = $this->getNumAlbums();

			$slideshowLink = $this->getSlideshowLink();

			$s = ($this->getAlbumPage() - $this->getFirstImagePage()) * getOption('images_per_page');
			$batch = ($s + 1) . "-" . ($s + $m); 

			$imagesDivs = "<div id='subalbum-count' class='count'>" . 
						  (isset($slideshowLink) ? "<span id='album-slideshow-link' class='unselected'><a href='$slideshowLink'>Slideshow</a></span>" : "") . 
						  ($numAlbums > 0 ? ("<span id='subalbum-count' class='unselected'>" . 
											 "<a href='" . $this->getAlbumTabLink() . "'>" . $numAlbums . " " . 
											 gettext($this->getAlbumTabText($numAlbums)) . "</a>" . 
											 "</span>") : "") .
						  "<span class='selected last'>$batch / " . $this->getNumImages() . " " . gettext("images") . "</span></div>" .
					 	  "<div id='images'>$images</div>" .
						  "<div id='image-container'>" .
						  "<img src='" . getCustomImageURL(NULL, $w) . "' width='316' />".
						  "</div> ";

			return $imagesDivs;
		}

		function getSubalbumsHTML() {
			$numAlbums = $this->getNumAlbums();

			if ( $numAlbums <= 0 || $this->albumPage >= $this->getFirstImagePage() ) return '';
			global $_zp_themeroot, $_zp_gallery, $_zp_current_image, $_zp_current_album;
			
			$w = 318;

			$slideshowLink = $this->getSlideshowLink();
			
			$subalbums = "<div id='subalbums'>";
			$i = 0;
			$albums = $this->getAlbums();
			$page = $this->getAlbumPage();
			$start = ($page - 1) * getOption('albums_per_page');
			$albums = array_slice($albums, $start, getOption('albums_per_page')); 
			for ( $u = 0; $u < count($albums); $u++ ):
				$a = new Album($_zp_gallery, $albums[$u]);
				$thumb = $a->getAlbumThumbImage();
				$title = $a->getTitle();
				$desc = $a->getDesc();
				$customThumb = $thumb->getCustomImage(NULL, 104, 56, 104, 56, NULL, NULL, false);
				$subalbums .= "<span class='subalbum' id='subalbum-$u' width='104' height='56' >" . 
							  "<a href='" . getAlbumLinkURL($a) . "' >" . 
							  "<img width='104' height='56' src='$customThumb'/></a></span>";
				$i++;
			endfor; 
			$m = $i;
			$i++;				

			while ( $i <= getOption('albums_per_page') ) :
				$subalbums .= "<span class='subalbum' id='subalbum-$i'>" . 
							  "<img width='104' height='56' src='$_zp_themeroot/resources/images/opa/bg-b-20.png'/>" . 
							  "</span>";
				$i++;
			endwhile;
			$subalbums .= "</div>";

			$s = ($this->getAlbumPage() - 1) * getOption('albums_per_page');
			$batch = ($s + 1) . "-" . ($s + $m);
			$subalbums = "<div id='subalbum-count' class='count'>" .
						 (isset($slideshowLink) && $this->getNumImages() > 0 ?  
							"<span id='album-slideshow-link' class='unselected'><a href='$slideshowLink'>Slideshow</a></span>" : ""). 
						 "<span class='selected'>$batch / " . $numAlbums . " " . gettext($this->getAlbumTabText($numAlbums)) . "</span>" . 
						 ($this->getNumImages() > 0 ? 
								("<span class='unselected last'><a href='" . $this->getImageTabLink() . "'>" . 
								 $this->getNumImages() . " " . gettext("images") . "</a></span>") : 
								"<span class='unselected last'>" . $this->getNumImages() . " " . gettext("image") . "</span>") . 
						 "</div>" . $subalbums;

			if ( $this->showRandomImage() ) :
				$img = $this->getRandomAlbumImage();

				$subalbums .= "<div id='random-album-image'>";					
				$previous = $_zp_current_image;
				$_zp_current_image = $img;

				$size = getSizeCustomImage(NULL, $w + 2);

				$small = getCustomImageURL(NULL, $w + 2);
				$width = $img->getWidth();
				$height = $img->getHeight();

				$ratio = ($w + 2) / $width;

				$height = $height * $ratio;

				$subalbums .= "<img src='$small' width='" . ($w + 2) . "' height='$height'/>";
				$subalbums .= "<div class='caption'>Random selection</div>";
						   
				$subalbums .= "</div>";

				$_zp_current_image = $previous;
			endif;

			return $subalbums;
		}

		function getGalleryPageAlbums() {
			global $_zp_gallery, $_zp_page, $_zp_themeroot;

			$res = "<div id='albums'>";

			save_context();

			set_context(ZP_INDEX);

			$_zp_page = $contextPage;

			$u = 0;

			$folders = $_zp_gallery->getAlbums($this->galleryPage ? $this->galleryPage : 1);

			$_zp_page = NULL;

			$arr = array();

			$top = $this->getAncestorAlbum();

			foreach ( $folders as $folder ): 
				$cls = '';

				//Workaround the (breaking) weird thumb url if album is empty. Note that we really should check recursively
				$alb = new Album($_zp_gallery, $folder);
				$subalbs = method_exists($alb, 'getSubalbums') ? $alb->getSubalbums() : $alb->getAlbums();
				if ( count($subalbs) == 0 && $alb->getNumImages() == 0 ):
					$customThumb = "$_zp_themeroot/resources/images/opa/bg-b-20.png";
				else:
					$thumb = $alb->getAlbumThumbImage();
					$customThumb = ($thumb->getCustomImage(NULL, 90, 90, 90, 90, NULL, NULL, false));
				endif;
			
				if ( isset($top) && method_exists($top, 'getFolder') && $folder == $top->getFolder() ):
					$cls = ' over';
				endif;

				$res .= "<span class='album$cls'> " .
				  	 	"<a href='" . $alb->getAlbumLink() . "'>" .
					 	"<img width='90' height='90' src='$customThumb' " .
						"	   album='" . $alb->name . "' /> " .
						"</a>" .
						"<div class='caption'>" .
						$alb->getTitle() .
						"</div>" .
					 "</span>";
				$u++;
			endforeach; 

			while ( $u < 3 ):
				$res .= "<span class='subalbum subalbum-$u'> " .
					    "<img width='90' height='90' class='empty' src='$_zp_themeroot/resources/images/opa/bg-b-20.png' /> " .
					 	"</span>";
				$u++;
			endwhile;

			restore_context($context);
			$_zp_page = $pageParam;

			$res .= "</div>";

			return $res;
		}

		function getRss() {
			global $_zp_themeroot;
			$img = "<img src='$_zp_themeroot/resources/images/rss.png' height='20' width='20' />";
			$href = WEBPATH . "/rss.php"; 
			$link = getRSSHeaderLink('Gallery');
			return "<div id='rss' class='gallery'>$link<a href='$href'>$img</a></div>";
		}
	
		protected function getSlideshowLink() {
			if ( !function_exists('printSlideShow') ) return NULL;
			$i = "page=" . $this->albumPage . "&";
			$i .= isset($this->image) ? ('image=' . $this->image->getFileName() . '&') : '';
			$mw = getOption('mod_rewrite');
			setOption('mod_rewrite', FALSE, FALSE);
			$url = getCustomPageURL('slideshow', $i . "album=" . urlencode($this->album->getFolder()));
			setOption('mod_rewrite', $mw, FALSE);
			return $url;
		}

		protected function getAlbumTabLink() {
			return $this->getAlbumLink(NULL);
		}

		protected function getImageTabLink() {
			return $this->getAlbumLink(NULL, $this->getFirstImagePage());
		}

		protected function getImage($i) {
			return newImage($this->album, $i);;
		}

		protected function getAlbums() {
			global $_zp_gallery, $_zp_current_album;
			$albums = method_exists($this->album, 'getSubalbums') ? $this->album->getSubalbums() : $_zp_current_album->getAlbums();
			return $albums;
		}

		protected function showRandomImage() {
			return TRUE;
		}
			
		protected function getAlbumImages($start) {
			return $this->album->getImages($start);
		}
		
		protected function getAlbumTabText($c) {
			return $c <= 1 ? "subalbum" : "subalbums";
		}

		protected function getImageThumbLink() {
			global $_zp_current_image;
			return $_zp_current_image->getImageLink();
		}

		protected function setAlbum($album) {
			global $_zp_gallery;
			if ( isset($album) ):
				$this->album =  zp_load_album($album);
				$alb = $this->album;
				while ( $alb->getParent() ) :
					$alb = $alb->getParent();
				endwhile;
				$albums = $_zp_gallery->getAlbums();	
				$idx = 0;
				foreach ( $albums as $a ):
					if ( $a == $alb->getFolder() ) :
						break;
					endif;
					$idx++;
				endforeach;
				$this->galleryPage = floor($idx / getOption('albums_per_page')) + 1;
				$this->albumPage = $this->requestedPage;
			else:
				$galleryAlbums = $_zp_gallery->getAlbums();
				$idx = ($this->requestedPage - 1) * getOption('albums_per_page');
				$this->galleryPage = $this->requestedPage;
				$this->albumPage = 1;
				$this->album =  new Album($_zp_gallery, $galleryAlbums[$idx]);
			endif;
			$this->context = ZP_ALBUM;
		}

		protected function getAlbumPage() {
			if ( !($this->context & ZP_ALBUM) ):
				return $this->galleryPage;
			else: 
				return $this->albumPage;
			endif;
		}

		protected function getNumAlbums() {
			return count($this->getAlbums());
		}

		protected function getNumImages() {
			return count($this->album->getImages());
		}

		protected function setImage($image) {
			if ( isset($image) ):
				$this->context = $this->context | ZP_IMAGE;
				$this->image = newImage($this->album, $image);
				$this->albumPage = $this->getImagePage() + $this->getFirstImagePage() - 1;
				$this->albumPage = $this->albumPage == 0 ? 1 : $this->albumPage;
			elseif ( $this->album->getNumImages() > 0 ):
				$images = $this->album->getImages($this->albumPage);
				$this->image = newImage($this->album, $images[0]);
			endif;
		}

		protected function getAncestorAlbum() {
			$top = $this->album;
			while ( $top->getParent() ) :
				$top = $top->getParent();
			endwhile;
			return $top;
		}

		private function getImagePage() {
			if ( isset($this->image) ) :
				$images = $this->album->getImages();
				$i = 0;
				foreach ( $images as $img ) {
					$i++;
					if ( $img == $this->image->filename ) break;
				}
				$inc = ceil($i / getOption('images_per_page'));
				return $inc;
			endif;
		}

		private function getRandomAlbumImage() {
			global $_zp_current_album;

			$idList = $this->collectAlbumChildrenIds($_zp_current_album);
		
			$ids = implode(",", $idList);
			$t_images = prefix("images");
			$t_albums = prefix("albums");
			$query = "SELECT i.filename, i.title, a.folder FROM $t_images i " .
					 "LEFT JOIN $t_albums a ON i.albumid=a.id " . 
					 (isset($_zp_current_album) ? "WHERE a.id IN ($ids) " : "") .
					 "ORDER BY RAND() LIMIT 1";
			$result = query_full_array($query);
			$result = Utils::createImages($result);
			$res = count($result) == 1 ? $result[0] : NULL;
			return $res;
		}

		private function collectAlbumChildrenIds($a) {
			global $_zp_gallery;

			$list = array();

			if ( !isset($a) ) return $list;
		
			$sa = method_exists($a, 'getSubalbums') ? $a->getSubalbums() : $a->getAlbums();
			foreach ( $sa as $_s ) :
				$s = new Album($_z_gallery, $_s);
				$list[] = $s->getAlbumId();
				$list = array_merge($list, $this->collectAlbumChildrenIds($s));
			endforeach;
			
			return $list;
		}
	}
?>
