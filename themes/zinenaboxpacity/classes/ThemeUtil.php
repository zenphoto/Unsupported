<?php
	class ThemeUtil {
		static $script = "";

		static function exists($relativePath) {
			$file = SERVERPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/" . $relativePath;
			$e = file_exists($file);
			return $e;
		}

		static function getUserIP() {
			return sanitize($_SERVER['REMOTE_ADDR'], 3);
		}

		static function getAgent($browser) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
			return strstr($agent, $browser);
		}

		static function clean($str, $useTags=TRUE, $length=NULL, $esc=TRUE) {
			$before = $useTags ? "<p>" : "";
			$replacement = $useTags ? "</p></p>" : "";
			$after = $useTags ? "</p>" : "";

			$str = $before . str_replace("\r\n", $replacement, $str) . $after;
			$str = $before . str_replace("\n", $replacement, $str) . $after;									
		
			if ( $esc ) $str = str_replace("'", "\'", $str);

			if ( !$useTags ) {
				$str = strip_tags($str);
			}
		
			if ( isset($length) && strlen($str) > $length + 2 ) {
				return substr($str, 0, $length - 1) . ' ...' ;
			}

			return $str;
		}

		static function getFullTitle($title) {
			global $siteName, $themeName;
			return $siteName . ': ' . $title . ' - ' . $themeName;
		}


		static function getLink($url, $text, $title=NULL, $class=NULL, $id=NULL) {
			return "<a href=\"" . htmlspecialchars($url) . "\"" .
					(($title) ? " title=\"" . html_encode($title) . "\"" : "") .
					(($class) ? " class=\"$class\"" : "") .
					(($id) ? " id=\"$id\"" : "") . ">" .
					$text . "</a>";
		}

		static function getScriptFilenames() {
			global $_zp_themeroot;		
			$g = array(
					$_zp_themeroot . "/resources/scripts/jquery.mousewheel-3.0.2.min.js",
					$_zp_themeroot . "/resources/scripts/jquery.timed-event.js",
					$_zp_themeroot . "/resources/scripts/jquery.qtip-1.0.0-rc3.min.js",
					$_zp_themeroot . "/resources/scripts/selectbox/jquery.selectbox-0.6.1.js",
					$_zp_themeroot . "/resources/scripts/checkbox/jquery.checkbox.min-1.3.0b1.js",
					WEBPATH . '/' . ZENFOLDER . '/js/jqueryui/jquery.ui.zenphoto.js',
					$_zp_themeroot . "/resources/scripts/jquery.simplemodal-1.3.4.js",
					$_zp_themeroot . "/resources/scripts/overrides.js",
					$_zp_themeroot . "/resources/scripts/init.js");

			$fb = array(
					$_zp_themeroot . "/resources/scripts/fancybox/jquery.fancybox-1.2.6.pack.js"
			);
		
			if ( getOption('simplicity2_enable_fancybox') ) :
				$scripts = array_merge($fb, $g);
			else:
				$scripts = $g;
			endif;

			return $scripts;
		}

		static function printScriptLinks() {
			$scripts = self::getScriptFilenames();
			global $_zp_themeroot;
			if ( DEPLOY != 1 ) {
				foreach ( $scripts as $script ) {
					$link = $script;
					echo "<script type='text/javascript' src='$link'></script>";
				}		
			}
			else {
				$url = "?p=scripts&version=" . combine_getTimestamp(self::getScriptFilenames());
				echo "<script type='text/javascript' src='$url'></script>";
			}
		}	

		static function printStyleSheetLink($relativePath, $id=NULL, $force=false) {
			$valid = self::exists($relativePath);
			$id = isset($id) ? "id='$id'" : "";
			if ( $valid ) {
				$css = WEBPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/" . $relativePath;
				echo "<link rel='stylesheet' type='text/css' href='$css' media='screen' $id/>";
			}
			else if ( $force ) {
				echo "<link rel='stylesheet' type='text/css' media='screen' $id/>";
			}
		}
		
		static function getSuffixedNumber($num) {
			$the_num = (string) $num;
			$last_digit = substr($the_num, -1, 1);
			switch($last_digit) {
				case "1":
					$the_num.="st";
					break;
				case "2":
					$the_num.="nd";
					break;
				case "3":
					$the_num.="rd";
					break;
				default:
					$the_num.="th";
			}
			return $the_num;
		}

		static function getUserLocale() {
			$langs = array();

			if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
				$langs = preg_split('/,/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			}

			foreach ($langs as $lang) {
				$locales = self::getSupportedLocales();
				foreach ( $locales as $full => $short ) {
					if (strpos(trim($lang), $short) === 0) {
						return $full;
					}
				}
			}

			return "en_US";
		}

		private static function getSupportedLocales() {
			$theme = $theme = basename(dirname(dirname(__FILE__)));
			$root = SERVERPATH . "/themes/$theme/locale";
			$curdir = getcwd();
			chdir($root);
			$filelist = safe_glob('*');
			$list = array();
			foreach($filelist as $file) {
				if ( is_dir($file) && $file != '.' && $file != '..' ) {
					$list[$file] = substr($file, 0, 2);
				}
			}
			chdir($curdir);
			return $list;
		}
	}
?>
