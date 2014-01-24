<?php
	class TileSet {
		private static $instance;
		private static $tileDefinitions;

		private $name;
		private $tiles;
		private $title;
		
		private function TileSet($title, $tiles) {
			$this->title = $title;
			
			if ( is_array($tiles) ) {
				$this->tiles = $tiles;
			}
			else {
				$this->name = $tiles;
				$this->tiles = self::$tileDefinitions[$tiles];
			}

			if ( !isset($this->tiles) ) {
				$this->tiles = self::$tileDefinitions["default"];
				if ( !isset($this->tiles) ) {
					$this->tiles = array();
				}
				else {
					$this->tiles = $this->harmonize($this->tiles, $tiles);
				}
			}
		}
		
		function getName() {
			return $this->name;
		}

		static function printDefault($title, $tileName, $area=NULL) {
			$root = SERVERPATH . '/themes/' . basename(dirname(dirname(__FILE__)));
			require_once("$root/theme_functions.php");
			//MenuUtil::setArea($area);
			TileSet::init("Home", "news");
			include_once("$root/template.php");
		}

		private function harmonize($arr, $n) {
			foreach ( $arr as $k => $v ) {
				if ( is_string($v) ) {
					$arr[$k] = str_replace("%tile", $n, $v);
				}
				else if ( is_array($v) ) {
					$arr[$k] = $this->harmonize($v, $n);					
				}
			}
			return $arr;
		}

		static function configure($obj) {
			self::$tileDefinitions = $obj;
		}

		static function init($title, $tiles) {
			if ( !isset(self::$instance) ) {
				self::$instance = new TileSet($title, $tiles);
			}
			return self::$instance;
		}

		static function get() {
			return self::$instance;
		}

		function process($tileName) {
			$tile = $this->tiles[$tileName];
			if ( !isset($tile) ) return;
			$file = str_replace('//', '/', dirname(dirname(__FILE__))) . '/' . $tile;
			if ( file_exists($file) ) {
				include($file);
			}
			else {
				echo $tile;
			}
		}

		function getRawTile($tileName) {
			return $this->tiles[$tileName];
		}

		function includeStyleSheets($asLink=TRUE) {
			global $_zp_themeroot;
			$css = $this->tiles['css'];
			if ( !isset($css) || !is_array($css) ) return;
			foreach ( $css as $c ):
				$file = str_replace('//', '/', dirname(dirname(__FILE__))) . '/' . $c;
				if ( isset($c) && file_exists($file) ):
					if ( $asLink ):
						echo "		<link rel='stylesheet' type='text/css' href='$_zp_themeroot/$c' media='screen' />\n";
					else:
						$content = file_get_contents($file);
						$content = str_replace("url(/", "url($_zp_themeroot/", $content);
						echo $content;
					endif;
				endif; 
			endforeach;
		}

		function getTitle() {
			return $this->title;
		}

	}
?>
