<?php	
	define('DEPLOY', 1);

	class Utils {
		private static $scripts = FALSE;

		private function Utils() { }

		static function exists($relativePath) {
			$file = SERVERPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/" . $relativePath;
			$e = file_exists($file);
			return $e;
		}

		static function getLatestImages($limit=3) {
			if ( !isset($limit) || !is_numeric($limit) ) $limit = 3;
			$t_images = prefix("images");
			$t_albums = prefix("albums");
			$query = "SELECT i.filename, i.title, a.folder FROM $t_images i " .
					 "LEFT JOIN $t_albums a ON i.albumid=a.id " . 
					 "ORDER BY i.id DESC LIMIT $limit";
			$result = query_full_array($query);
			return self::createImages($result);
		}

		static function createImages($rows) {
			$images = array();
			foreach ( $rows as $r ) {
				$image = newImage(new Album(new Gallery(), $r['folder']), $r['filename']);
				$images[] = $image;
			}
			return $images;
		}

		static function mergeStyleSheets($css) {
			global $_zp_themeroot;
			$a = self::getTileResources('css');
			$all = array_merge($css, array_values($a));
			$ret = '';
			foreach	( $all as $c ):
				$ret .= "/* file: " . str_replace(SERVERPATH, WEBPATH, $c) . "*/ \n";
				$content = file_get_contents($c) . "\n";
				$content = str_replace("url(/", "url($_zp_themeroot/", $content);
				$content = str_replace("url('/", "url('$_zp_themeroot/", $content);
				$content = str_replace("src='/", "src='$_zp_themeroot/", $content);
				$ret .= $content;
			endforeach;	
			return $ret;
		}

		static function getNewsIndexUrl() {
			return rewrite_path(urlencode(ZENPAGE_NEWS), "/index.php?p=".ZENPAGE_NEWS);
		}

		static function getTileDirWebPath() {
			return self::getThemeDir("tiles", TRUE);
		}

		static function getThemeDir($name, $web=TRUE) {
			$theme = basename(dirname(dirname(__FILE__)));
			return ($web ? WEBPATH : SERVERPATH) . "/themes/$theme/$name";
		}

		static function getTileResources($type, $folder = NULL) {
			$curdir = getcwd();
			
			$theme = basename(dirname(dirname(__FILE__)));
			$root = SERVERPATH . "/themes/$theme/tiles";
			chdir($root);

			$filelist = safe_glob('*');
			$list = array();

			foreach($filelist as $file) {
				if ( is_dir($file) && $file != '.' && $file != '..' ) {
					$internal = filesystemToInternal($file);
					$filename = "$root/$internal/$internal.$type";
					if ( !file_exists($filename) ) continue;
					$list[WEBPATH . "/themes/$theme/tiles/$internal/$internal.$type"] = $filename;
				}
			}

			$root = SERVERPATH . "/themes/$theme/$folder";
			if ( is_dir($root) ):
				chdir($root);
				$filelist = safe_glob("*.$type");
				foreach($filelist as $file) {
					$internal = filesystemToInternal($file);
					$list[WEBPATH . "/themes/$theme/$folder/$internal"] = SERVERPATH . "/themes/$theme/$folder/$internal";
				}			
			endif;

			chdir($curdir);

			return $list;
		}
		
		static function printScripts($name) {
			if ( self::$scripts ) return;
			self::$scripts = TRUE;
			echo "<script src='" . getCustomPageURL('script', 't=' . $name) . "'></script>";
		}

		static function getLastModified($files) {
	   	  	$modified = array();
		  	foreach ($files as $file) {
				$modified[] = filemtime($file);
		  	}
		  	rsort($modified);
		  	return $modified[0];
		}
	
		static function printZenpagePageTitleLink() {
			global $_zp_current_zenpage_page;
			$link = $_zp_current_zenpage_page->getTitleLink();
			self::printCustomPageId($link);
		}
	
		static function printCustomPageId($link) {
			echo "<div style='display: none;' id='internal-page-titlelink'>$link</div>";
		}

		static function import($class, $folder=NULL) {
			$folder = isset($folder) ? $folder . '/' : '';
			require_once(SERVERPATH . '/themes/' . basename(dirname(dirname(__FILE__))) . "/classes/$folder$class.php");
		}

		static function render($file) {
			include(SERVERPATH . '/themes/' . basename(dirname(dirname(__FILE__))) . "/$file");
		}


		static function crop($text, $length, $tags, $ellipsis='') {
			$text = strip_tags($text); 
			$text = preg_replace('/(\'|"|\.|=|;|\!|\|?|,)*$/', '', $text);
			if ( strlen($text) > $length ) :
				$text = substr($text, 0, 200);
				$text .= " $ellipsis";
			endif;
			return $text;
		}
	}
?>
