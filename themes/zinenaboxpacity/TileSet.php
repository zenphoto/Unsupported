<?php
	require_once("tiles/tiles.php");
	
	class TileSet {
		static $instance;
		static $tileDefinitions;

		var $tiles;
		var $title;

		private function TileSet($title, $tiles) {
			$this->title = $title;
			
			if ( is_array($tiles) ) {
				$this->tiles = $tiles;
			}
			else {
				$this->tiles = self::$tileDefinitions[$tiles];
			}

			if ( !isset($this->tiles) ) {
				$this->tiles = array();
			}
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
			$file = str_replace('//', '/', dirname(__FILE__)) . '/' . $tile;
			if ( file_exists($file) ) {
				include($file);
			}
			else {
				echo $tile;
			}
		}

		function getTitle() {
			return ThemeUtil::getFullTitle($this->title);
		}

		function printScript() {
			$s = $this->tiles['script'];

			if ( !isset($s) ) return;
			
			if ( is_array($s) ) :
				foreach ( $s as $scr ):
					$this->printScriptLink($scr);
				endforeach;
			else:
				$this->printScriptLink($s);
			endif;
		}

		function printScriptLink($s) {
			$script = $this->getFilePath($s);
			if ( !is_null($script) ) {
				echo "<script type='text/javascript' src='$script'></script>";
			}
		}

		function getFilePath($s) {
			global $_zp_themeroot;

			$file = str_replace('//', '/', dirname(__FILE__)) . '/' . $s;
			if ( !file_exists($file) ) :
				//echo "<script>console.log('file not found: $file');</script>"; 
				return NULL; 
			endif;
			
			return $_zp_themeroot . "/" . $s;
		}
	}
?>
