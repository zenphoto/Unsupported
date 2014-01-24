<?php
	class SearchUtil {
		static function printAllDates($class='archive', $yearid='year', $monthid='month', $order='asc') {
			global $_zp_current_search;
			if (!empty($class)){ $class = "class=\"$class\""; }
			if (!empty($yearid)){ $yearid = "class=\"$yearid\""; }
			if (!empty($monthid)){ $monthid = "class=\"$monthid\""; }
			$datecount = getAllDates($order);
			$lastyear = "";

			echo "\n<ul $class>\n";

			$nr = 0;
			$years = array();
			while (list($key, $val) = each($datecount)) {
				$nr++;
				if ($key == '0000-00-01') {
					$year = "no date";
					$month = "";
				} else {
					$d = strftime('%Y-%m', strtotime($key));
					$index = substr($d, 5);
					$dt = strftime('%Y-%B', strtotime($key));
					$year = substr($dt, 0, 4);
					$month = substr($dt, 5);
				}

				if ($lastyear != $year) {
					$lastyear = $year;
					echo "<li id='year-$year' $yearid year='$year'><p>$year</p></li>";
					$years[$year] = array();
				}
			
				$years[$year][$month] = array($index, $val);
			}

			echo "</ul>";
		
			return $years;
		}

		static function getArchiveMonthLink($year, $month, $monthIndex, $count, $tag='a') {
			global $_zp_current_search;
			if (is_object($_zp_current_search)) {
				$albumlist = $_zp_current_search->album_list;
			} 
			else {
				$albumlist = NULL;
			}

			return "<$tag href='".htmlspecialchars(getSearchURl('', "$year-$monthIndex", 0, 0, $albumlist))."&f=xml' rel='nofollow'>$month ($count)</$tag>";
		}
	
		static function getSearchQuery() {
			$input = $_GET['words'];
			$words = getSearchWords();
			$date = $_GET['date'];

			if ( isset($date) ):
				$words = strftime('%B %Y', strtotime("$date-01"));
			elseif ( !isset($input) || $input == '' || $input == DEFAULT_SEARCH_TEXT ):
				$words = '&lt; ' . gettext('No search criteria') . '&gt;';
				//$words = '&lt; ' . 'No search criteria' . '&gt;';
				return $words;
			endif;

			if ( isset($words) && strlen($words) > 25 ) :
				$words = substr($words, 0, 23) . " ... ";
			endif;

			return $words;
		}
	}
?>
