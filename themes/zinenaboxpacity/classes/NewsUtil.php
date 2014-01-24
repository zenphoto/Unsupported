<?php 
	class NewsUtil {
		
		static function setCurrentNewsPage() {
			global $_zp_current_zenpage_news, $_zp_page;
			if ( isset($_zp_current_zenpage_news) ) {
				$table = prefix('zenpage_news');
				$id = $_zp_current_zenpage_news->getID();

				$query = "SELECT count(id) ct FROM $table where id >= $id AND `show`=1";
				$result = query_single_row($query);

				$count = $result['ct'];
				$pageNumber = ceil($count / max(1, getOption("zenpage_articles_per_page")));
			
				$_GET["page"] = $pageNumber;
				$_zp_page = $pageNumber;
			}
		}

		static function printNewsNavigation($nexttext, $prevtext) {
			global $_zp_zenpage_total_pages;
			$total = ceil(getTotalArticles() / getOption("zenpage_articles_per_page"));
			$current = getCurrentNewsPage();
			if($total > 1) {
			
				$j=max(1, min($current-3, $total-6));
				if ($j != 1) {
					echo '<div class="nav-cell">';
					echo "<span class='valign'>";
					echo "<a href=\"".getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().max($j-4,1)."\">...</a>";
					echo "</span></div>\n";
				}
				for ($i=$j; $i <= min($total, $j+6); $i++) {
					if($i == $current) {
						echo '<div class="nav-cell current">';
						echo "<span class='valign'>";			
						echo $i;
						echo "</span></div>\n";						
					} else {
						echo '<div class="nav-cell">';
						echo "<span class='valign'>";
						echo "<a href='" . 
							 getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().$i . 
							 "' >" . $i . "</a>";							
						echo "</span></div>\n";
					}
				}

				if ($i <= $total) {
					echo '<div class="nav-cell">';
					echo "<span class='valign'>";
					echo "<a href=\"".getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().min($j+10,$total)."\">...</a>";
					echo "</span></div>\n";
				}

				$prevUrl = self::getPrevNewsPageURL();
				if( $prevUrl ) {
					$prevnext['prev'] = "<a href='$prevUrl'>$prevtext</a>";
				}

				$nextUrl = getNextNewsPageURL();
				if( $nextUrl && $current < $total ) {
					$prevnext['next'] = "<a href='$nextUrl'>$nexttext</a>";
				}

				return $prevnext;
			}
		}

		static function getPrevNewsPageURL() {
			$page = getCurrentNewsPage();
			if($page != 1) {
				if(($page - 1) == 1) {
					return rewrite_path(urlencode(ZENPAGE_NEWS), "/index.php?p=".ZENPAGE_NEWS);
				} else {
					return getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().($page - 1);
				}
			} else {
				return false;
			}
		}
		
		static function getNewsContent($shorten) {
			$c = getNewsContent();
			$c = substr(strip_tags($c, "<p>"), 0, $shorten);
			if ( eregi("</p>$", $c) ) {
				return eregi_replace("</p>$", " ...</p>", $c);
			}
			else {
				return $c . " ...</p>";
			}
		}

		static function printNewsContent($shorten) {
			echo getNewsContent($shorten);
		}

		static function getNewsIndexUrl() {
			return rewrite_path(urlencode(ZENPAGE_NEWS), "/index.php?p=".ZENPAGE_NEWS);
		}

		static function printNewsCategories($separator='', $link=true, $print=true) {
			$text = '';
			$categories = getNewsCategories();
			$catcount = count($categories);
			if($catcount != 0) {
				if(is_NewsType("news")) {
					$count = 0;
					foreach($categories as $cat) {
						$count++;
						$catname = get_language_string($cat['cat_name']);
						if($count >= $catcount) {
							$separator = "";
						}
						else {
							$separator = ", ";
						}
						$url = getNewsCategoryURL($cat['cat_link']);
					
					 	$text .= ($link ? "<a href='$url'>" : "") . $catname . ($link ? "</a>" : "") . $separator;
					}
				}
			}

			if ( $print ) {
				echo $text;
			}

			return $text;
		}

		static function printNewsDateBlock() {
			global $_zp_current_comment;

		   	$d = $_zp_current_comment['date'];
		   	
			$x = myts_date('%m', $d);
			$mo = $x - 1;
		   	$mt = $mo * -30 + (3 - $x);

			$c = myts_date('%d', $d);
			$da = $c - ($c > 16 ? 17 : 1);
			$dc = $c > 16 ? '-100px' : '-50px';
			$dt = $da * -31;

			$ye = myts_date('%y', $d) - 6;
		   	$yt = ($ye * -50) - 1;

			echo "<div class='date-wrapper'>" .
				 "	<div class='postdate'>" .
				 "	   <div class='month' style='background-position: 0 " . $mt . "px;'>" . strftime('%b', $d) . "</div>" .
				 "	   <div class='day' style='background-position: " . $dc . " " . $dt ."px;'>" . myts_date('%d', $d) . "</div>" .
				 "	   <div class='year' style='background-position: -150px " . $yt . "px;'>" . myts_date('%Y', $d) . "</div>" .
				 "	</div>" .
				 "</div>";
		}

		static function commentsAllowed() {
			global $_zp_current_zenpage_news;

			$allowed = $_zp_current_zenpage_news->getCommentsAllowed();

			$onlyMembersCanComment = getOption('comment_form_members_only') == 1;
			$isSuperUser = zp_loggedin(ADMIN_RIGHTS | POST_COMMENT_RIGHTS);

			$aggregate = $allowed && (!$onlyMembersCanComment || $isSuperUser);

			return $aggregate;
		}


		/* doesnot really belong to NewsUtil */
		static function printPageLastChangeDate() {
			global $_zp_current_zenpage_page;
			$d = $_zp_current_zenpage_page->getLastchange();
			if ( !empty($d) ) {		
				printPageLastChangeDate();
			}
			else {
				printPageDate();
			}
		}
	}
?>
