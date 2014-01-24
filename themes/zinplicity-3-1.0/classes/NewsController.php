<?php
	class NewsController {
		function NewsController() {
			zenpage_load_news();
			$this->setCurrentNewsPage();
		}

		function prepare() {
			global $_zp_current_zenpage_news;

			if ( !isset($_zp_current_zenpage_news) ) next_news();

			$links = "<table id='news-link' cellspacing='10'><tr>";

			$links .= $this->getNewsBlock($this->getNextPrevNews('prev'));
			$links .= $this->getNewsBlock($_zp_current_zenpage_news, TRUE);
			$links .= $this->getNewsBlock($this->getNextPrevNews('next'));

			$links .= "</tr></table>";

			return $links;
		}

		function printNewsPageListWithNav($next='next &raquo;', $prev='&laquo; prev', $nextprev=true, $class='pagelist') {
			global $_zp_zenpage_total_pages;
			$total = ceil(getTotalArticles() / getOption("zenpage_articles_per_page"));
			$current = getCurrentNewsPage(); 
			echo "<ul class=\"$class\">";
			if($nextprev) {
				echo "<li class=\"prev\">"; $this->printPrevNewsPageLink($prev); echo "</li>";
			}
			$j=max(1, min($current-3, $total-6));
			if ($j != 1) {
				echo "\n <li>";
				echo "<a href=\"".getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().max($j-4,1)."\">...</a>";
				echo '</li>';
			}
			for ($i=$j; $i <= min($total, $j+6); $i++) {
				if($i == $current) {
					echo "<li class='current'><a>".$i."</a></li>\n";
				} else {
					echo "<li><a href='".getNewsBaseURL().getNewsCategoryPathNav().
								getNewsArchivePathNav().getNewsPagePath().$i."' title='".gettext("Page")." ".$i."'>".$i."</a></li>\n";
				}
			}
			if ($i <= $total) {
				echo "\n <li>";
				echo "<a href=\"".getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().min($j+10,$total)."\">...</a>";
				echo '</li>';
			}

			if($nextprev ) {
				if ( $current < $total) {
					echo "<li class='next'>"; printNextNewsPageLink($next); echo "</li>";
				}
				else {
					echo "<li class='next'><a>$next</a></li>";
				}
			}
			echo "</ul>";
		}

		function getRss() {
			if ( function_exists('getZenpageRSSHeaderLink') ):
				global $_zp_themeroot;
				$img = "<img src='$_zp_themeroot/resources/images/rss.png' height='20' width='20' />";
				$href = WEBPATH . "/rss-news.php"; 
				$link = getZenpageRSSHeaderLink('News');
				return "<div id='rss' class='news'>$link<a href='$href'>$img</a></div>";
			endif;
			return '';
		}

		private function printPrevNewsPageLink($prev='&laquo; prev',$class='disabledlink') {
			$page = getCurrentNewsPage();
			$prevUrl = $this->getPrevNewsPageURL();
			if($prevUrl) {
				echo "<a href='".$prevUrl."' title='".gettext("Prev page")." ".($page - 1)."' >".$prev."</a>\n";
			} else {
				echo "<span class=\"$class\"><a>".$prev."</a></span>\n";
			}
		}

		private function getPrevNewsPageURL() {
			$page = getCurrentNewsPage();
			if($page != 1) {
				return getNewsBaseURL().getNewsCategoryPathNav().getNewsArchivePathNav().getNewsPagePath().($page - 1);
			} 
			else {
				return false;
			}
		}

		private function getNextPrevNews($option='') {
			global $_zp_current_zenpage_news, $_zp_loggedin;

			if(!getOption("zenpage_combinews")) {
				$current = 0;
				if(!empty($option)) {
					$all_articles = getNewsArticles("","");
					$count = 0;
					foreach($all_articles as $article) {
						$newsobj = new ZenpageNews($article['titlelink']);
						$count++;
						$news[$count] = $newsobj;
						if($newsobj->getTitleLink() == $_zp_current_zenpage_news->getTitlelink()){
							$current = $count;
						}
					}
					switch($option) {
						case "prev":
							$prev = $current - 1;
							if($prev > 0) {
								return $news[$prev];
							}
							break;
						case "next":
							$next = $current + 1;
							if($next <= $count){
								return $news[$next];
							}
							break;
					}
				}
			} 
			return NULL;
		}
		
		private function setCurrentNewsPage() {
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

		private function getNewsBlock($newsobj, $current=FALSE) {
			$cls = $current ? 'current' : 'link';
			if ( !isset($newsobj) ) :
				return "<td class='empty'>" . 
					   "<div class='info'>" . 
					   "<div class='title'>" . 
					   "&nbsp;" . 	
				  	   "</div>" . 
					   "<div class='date'>&nbsp;</div>" . 
					   "</div>" . 
					   "</td>";
			else: 
				$link = $newsobj->getTitleLink();
				return "<td class='$cls'>" . 
					   "<div class='info'>" . 
					   "<div class='title'>" . 
					   "<a href='" . getNewsURL($newsobj->getTitlelink()) . "' link='$link'>". $newsobj->getTitle() . "</a>" . 	
				  	   "</div>" . 
					   "<div class='date'>" . date('Y M, \t\h\e jS', strtotime($newsobj->getDateTime())) . "</div>" . 
					   "</div>" . 
					   "</td>";
			endif;
		}
	}
?>
