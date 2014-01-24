<?php
	class MenuItem {

		private $text;	
		private $url;
		private $id;
		private $tile;
		private $area;
		private $initialSelection;
		private $external;	

		function MenuItem($text, $url, $id, $area=NULL, $external=FALSE) {
			$this->text = $text;
			$this->tile = $url['tile'];
			$this->url = $url['href'];
			$this->area = $area;
			$this->id = $id;
			$this->initialSelection = $initialSelection;
			$this->external = $external ? "true" : "false";
		}

		function getHtml($cls) {
			if ( !$this->areaMatch() ):
				return '<span id="' . $this->id . '" class="menu-item' . ($this->initialSelection ? ' selected ' : ' ') . $cls . '">' . 
					   '<a external="' . $this->external . '" href="' . $this->url . '" tile="' . $this->tile . '" class="link">' . $this->text . '</a>'. 
					   '</span>';
			endif;
			return '<span id="' . $this->id . '" class="menu-item selected' . ($this->initialSelection ? ' selected' : '') . $cls . '">' . 
				   '<a external="' . $this->external . '" href="' . $this->url . '"  tile="' . $this->tile . '" class="link">' . $this->text . '</a>' . 
				   '</span>';
		}

		protected function areaMatch() {
			return $this->area == AREA;
		}
	}

	class PageItem extends MenuItem {
		private $pageName;
		
		function PageItem($text, $id, $pageName=NULL) {
			if ( function_exists('getPageLinkURL') ) {
				parent::MenuItem($text, array('tile' => "page", 'href'=> getPageLinkURL($pageName)), $id);
				$this->pageName = $pageName;
			}
		}

		protected function areaMatch() {
			return in_context(ZP_ZENPAGE_PAGE) && getPageTitleLink() == $this->pageName;
		}

		function getHTML($cls) {
			if ( function_exists('getPageLinkURL') ) return parent::getHTML($cls);
			else return '';
		}
	}

	class Menu {
		private static $menus;
 
		private $name;
		private $id;		

		private $items = array();
		
		function Menu($name, $id) {
			$this->name = $name;
			$this->id = $id;
		}

		function register($item) {
			$this->items[] = $item;
		}

		function getName() {
			return $this->name;
		}

		function write() {
			$menu = "<div id='" . $this->id . "'>";
			$shadow = '<div id="top-menu-bar-shadow" class="opa40">';

			$total = count($this->items);
			for ( $u = 0; $u < $total; $u++ ):
				$item = $this->items[$u];
				$cls = '';
				if ( $u == 0 ) $cls = ' first';
				if ( $u == $total - 1 ) $cls = ' last';
				$menu .= $item->getHtml($cls);

			endfor;

			$shadow .= '</div>';
			$menu .= '</div>';

			echo $menu;
		}

		static function get($name, $id) {
			if ( is_null(self::$menus) ) {
				self::$menus = array();
			}

			if ( is_null(self::$menus[$name]) ) {
				$m = new Menu($name, $id);
				self::$menus[$name] = $m;
			}

			return self::$menus[$name];
		}

		static function secondary() {
			return self::get('secondary', 'secondary-menu-bar');
		}

		static function main() {
			return self::get('main', 'top-menu-bar');
		}
	}
?>
