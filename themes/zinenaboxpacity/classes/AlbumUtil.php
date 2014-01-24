<?php
	class AlbumUtil {
		static $theme_image_index = 0;
		static $theme_is_album_page = 0;	

		function getLatestImages($limit=3) {
			if ( !isset($limit) || !is_numeric($limit) ) $limit = 3;
			$t_images = prefix("images");
			$t_albums = prefix("albums");
			$query = "SELECT i.filename, i.title, a.folder FROM $t_images i " .
					 "LEFT JOIN $t_albums a ON i.albumid=a.id " . 
					 "ORDER BY i.id DESC LIMIT $limit";
			$result = query_full_array($query);
			return self::createImages($result);
		}

		static function getRandomImages($limit=3, $albums=NULL) {
			if ( $limit == 0 ) $limit = 1;

			$t_images = prefix("images");
			$t_albums = prefix("albums");

			$idQuery = "select img.id from $t_images img";
		
			$where = "";
			if ( !is_null($albums) && count($albums) > 0 ) :
				$all = '';
				for ($u = 0; $u < count($albums); $u++):
					if ( $u > 0 ) $all .= ", ";
					$all .= "'" . $albums[$u] . "'";
				endfor;
				$where = " LEFT JOIN $t_albums album ON img.albumid=album.id " .
						 "WHERE album.folder IN ($all) ORDER BY img.id";	
			endif;

			$idQuery .= $where;

			$result = query_full_array($idQuery);
		
			$rowCount = count($result);
		
			$u = 0; 
			$ids = "";
			while ( $u < $limit ) {
				$id = rand(0, $rowCount - 1);
				if ( $u > 0 ) $ids .= ", ";
				$ids .= $result[$id]['id'];
				$u++;
			}
			$query = "SELECT i.filename, i.title, a.folder FROM $t_images i " .
					 "LEFT JOIN $t_albums a ON i.albumid=a.id WHERE i.id IN ($ids)";
			$result = query_full_array($query);

			return self::createImages($result);		
		}
		
		static function setCurrentAlbumPage() {
			global $_zp_page, $_zp_current_album, $_zp_current_image;

			$images = $_zp_current_album->loadFileNames();
			$images = $_zp_current_album->sortImageArray($images);

			$images_per_page = max(1, getOption('images_per_page'));

			$index = 1;
			foreach ( $images as $image ) {
				if ( $image == $_zp_current_image->filename ):
					break;
				endif;
				$index++;
			}

			$pageNumber = ceil($index / $images_per_page);
			$_zp_page = $pageNumber;
		}
		
		static function printNavigation($prevtext, $nexttext, $oneImagePage=false, $navlen=7, $firstlast=true) {
			$total = getTotalPages($oneImagePage);
			$current = getCurrentPage();
			if ($total < 2) {
				$class .= ' disabled_nav';
			}
			if ($navlen == 0) {
				$navlen = $total;
			}
			$extralinks = 2;
			if ($firstlast) { 
				$extralinks += 2;
			}
			$len = floor(($navlen-$extralinks) / 2);
			$j = max(round($extralinks/2), min($current-$len-(2-round($extralinks/2)), $total-$navlen+$extralinks-1));
			$ilim = min($total, max($navlen-round($extralinks/2), $current+floor($len)));
			$k1 = round(($j-2)/2)+1;
			$k2 = $total-round(($total-$ilim)/2);
	

			if ($firstlast) {
				echo '<div class="nav-cell ' . ($current==1?'current':'first') . '">';
				echo "<span class='valign'>";
				printLink(getPageURL(1, $total), 1, "Page 1");
				echo "</span></div>\n";
				if ($j>2) {
					echo '<div class="nav-cell">';
					echo "<span class='valign'>";
					printLink(getPageURL($k1, $total), ($j-1>2)?'...':$k1, "Page $k1");
					echo "</span></div>\n";
				}
			}
			for ($i=$j; $i <= $ilim; $i++) {
				echo '<div class="nav-cell' . (($i == $current) ? " current" : "") . '">';
				echo "<span class='valign'>";			
				printLink(getPageURL($i, $total), $i, "Page $i" . (($i == $current) ? ' '.gettext("(Current Page)") : ""));
				echo "</span></div>\n";	
			}
			if ($i < $total) {
				echo '<div class="nav-cell">';
				echo "<span class='valign'>";
				printLink(getPageURL($k2, $total), ($total-$i>1)?'...':$k2, "Page $k2");
				echo "</span></div>\n";
			}
			if ($firstlast && $i <= $total) {
				echo '<div class="nav-cell last">';
				echo "<span class='valign'>";
				printLink(getPageURL($total, $total), $total, "Page {$total}");
				echo "</span></div>\n";
			}

			$prevNextLinks = array();
			$prevNextLinks['prev'] = ThemeUtil::getLink(getPrevPageURL(), $prevtext) . "\n";
			$prevNextLinks['next'] = ThemeUtil::getLink(getNextPageURL(), $nexttext) . "\n";

			return $prevNextLinks;
		}

		function printCollage() {
			global $_zp_current_album;

			if ( getOption('simplicity2_printcollage') ):

				echo '<div id="composite-album-random-selection" class="gallery">';

				if ( !is_null($_zp_current_album) ) :
					$subalbums = $_zp_current_album->getSubalbums();
					$images = self::getRandomImages(4, $subalbums);
				else:
					$images = self::getRandomImages(4, $subalbums);					
				endif;

				$width = 403;
				$h1 = 90;
				$h2 = 90;
				$w2 = 280;
				$sizes = array(
					array($width, $h1),
					array($h1, $h2),
					array($w2, $h2)
				);
				$sizes[] = array($width - ($h1 + $w2), $h2);

				echo "<div id='image-composite' class='opa60'>";
				for ( $u = 0; $u < 4; $u++ ) :
					$s = $sizes[$u]; 
					$img = $images[$u];
					echo "<a href='" . $img->getImageLink() . "'>" .
						"<img src='" . 
						 $img->getCustomImage(NULL,  $s[0], $s[1], $s[0], $s[1], NULL, NULL, true, false) . 
						 "' width='" . $s[0] . 
						 "' height='" . $s[1] . 
						 "'/></a>";
				endfor;

				echo "</div>";

				echo '<div id="random-collage-name" class="opa60">' . getOption("simplicity2_collage_title") . '</div></div>';

			endif;

		}

		static function getMaxImageIndex() {
			return self::$theme_image_index;
		}

		static function setMaxImageIndex($i) {
			self::$theme_image_index = $i;
		}

		static function isAlbumPage() {
			return self::$theme_is_album_page;
		}

		static function setAlbumPage($i) {
			self::$theme_is_album_page = $i;
		}

		static function createImages($rows) {
			$images = array();
			foreach ( $rows as $r ) {
				$image = newImage(new Album(new Gallery(), $r['folder']), $r['filename']);
				$images[] = $image;
			}
			return $images;
		}
	}

	

?>
