<?php

/* ------------------------------------------------- */
/* start CIMI theme functions
/* ------------------------------------------------- */

/* 
	<?php include ('theme-functions.php'); ?>
*/

function getAlbumDescAlt() { 
	  if(!in_context(ZP_ALBUM)) return false;
	  global $_zp_current_album;
	  return str_replace("\n", " ", $_zp_current_album->getDesc());
	}
	
function printAlbumDescAlt($editable=false) { 
	  global $_zp_current_album;
	  if ($editable && zp_loggedin()) {
	    echo "<div id=\"albumDescEditable\" style=\"display: block;\">" . truncate_string(getAlbumDescAlt(),120) . "</div>\n";
	    echo "<script>initEditableDesc('albumDescEditable');</script>";
	  } else {
	    echo  truncate_string(getAlbumDescAlt(),110);  
	  }
	}
	
function printDefaultSizedImageAlt($alt, $class=NULL, $id=NULL) { 
	echo "<img style=\"filter: alpha(opacity=0); -moz-opacity: 0; -khtml-opacity: 0; opacity: 0;\" onload=\"opacity('fadein', 0, 100, 500)\" id=\"fadein\" src=\"" . getDefaultSizedImage() . "\" alt=\"$alt\"" .
		" width=\"" . getDefaultWidth() . "\" height=\"" . getDefaultHeight() . "\"" .
		(($class) ? " class=\"$class\"" : "") . 
		(($id) ? " id=\"$id\"" : "") . " />";
	} 
	
function printCommentAuthorEmail($title=NULL, $class=NULL, $id=NULL) {
	  echo "<a href=\"mailto:" . getCommentAuthorEmail() . "\"" . 
	  (($title) ? " title=\"$title\"" : "") .
	  (($class) ? " class=\"$class\"" : "") . 
	  (($id) ? " id=\"$id\"" : "") . ">" .
	  getCommentAuthorName() . "</a>";
	}
	
function printPageListWithNavAlt($prevtext, $nexttext, $nextprev=true, $class=NULL, $id="pagelist") {
	  echo "<div" . (($id) ? " id=\"$id\"" : "") . " class=\"$class\">";
	  $total = getTotalPages();
	  $current = getCurrentPage();
	  
	  echo "\n<ul class=\"$class\"><li>[</li>";
	    
	    for ($i=1; $i <= $total; $i++) {
	      echo "\n  <li" . (($i == $current) ? " class=\"current\"" : "") . ">";
	      printLink(getPageURL($i), $i, "Page $i" . (($i == $current) ? " (Current Page)" : ""));
	      echo "</li>";
	    } 
		 echo "\n<li>]</li>";
		 if ($nextprev) {
	      echo "\n  <li class=\"prev\">"; 
	        printPrevPageLink($prevtext, "Previous Page");
	      echo "</li>";
	    }
	    echo "\n<li></li>";
	    if ($nextprev) {
	      echo "\n  <li class=\"next\">"; 
	        printNextPageLink($nexttext, "Next Page");
	      echo "</li>"; 
	    }
	 echo "\n</ul>";
  echo "\n</div>\n";
}

/* ------------------------------------------------- */
/* end CIMI theme functions
/* ------------------------------------------------- */

?>