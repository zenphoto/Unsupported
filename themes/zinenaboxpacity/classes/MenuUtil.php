<?php
	class MenuUtil {
		static $area;		

		static function setArea($a) {
			self::$area = $a;
		}

		static function printMenuItem($url, $text, $zone, $cls='', $alwaysLink=false, $id=NULL) {
			$inArea = self::$area == $zone;
			$selected = $inArea ?  " selected" : "";
			$id = isset($id) ? " id='$id'" : "";
			$link = !$inArea || $alwaysLink ? "<a href='$url'$id>$text</a>" : $text;
			$cls = " " . trim($cls);
			echo "<span class='tab$selected$cls'>$link</span>";
		}

		static function printMenuPageLink($pageName, $text, $id=NULL) {
			if ( !function_exists('getPageLinkURL') ) return; 

			global $_zp_current_zenpage_page;

			$id = isset($id) ? " id='$id'" : "";
			$inArea = !is_null($_zp_current_zenpage_page) && $_zp_current_zenpage_page->getTitleLink() == $pageName;
			$selected = $inArea ? " selected" : "";
			$link = !$inArea ? ("<a href='" . getPageLinkURL($pageName) . "'$id>$text</a>") : $text;
			echo "<span class='tab$selected'>$link</span>";
		}

		static function printSecondaryLinkItem($id, $url, $text, $zone=NULL) {
			$inArea = self::$area == $zone;
			$selected = $inArea ?  " selected" : "";
			$link = !$inArea || $alwaysLink ? "<a href='$url'>$text</a>" : $text;
			echo "<span id='$id' class='text-link$selected opa80'><a href='$url'>$text</a></span>";
		}

		static function printSecondaryPageLinkItem($id, $pageName, $text) {
			if ( !function_exists('getPageLinkURL') ) return; 
			global $_zp_current_zenpage_page;
			$inArea = !is_null($_zp_current_zenpage_page) && $_zp_current_zenpage_page->getTitleLink() == $pageName;
			$selected = $inArea ? " selected" : "";
			$link = !$inArea ? ("<a href='" . getPageLinkURL($pageName) . "'>$text</a>") : $text;
			echo "<span id='$id' class='text-link$selected opa80'>$link</span>";
		}

	}
?>
