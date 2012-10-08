<?php

/**
 * PHP Class to handle TrackBacks (send/ping, receive, retreive, detect, seed, etc...)
 *
 * Provides trackback functionality to comments. Tracksbacks are available for images and albums
 * as well as for Zenpage news articles and pages.
 * Trackback pings currently only available for news articles and pages.
 * 
 * BETA STATUS Known bug: Currently does not work with sites in subdomains!
 *
 * ==============================================================================
 *
 * @version $Id: trackback_cls.php,v 1.2 2004/12/11 18:54:32 Ran Exp $
 * @copyright Copyright (c) 2004 Ran Aroussi (http://www.blogish.org)
 * @author Ran Aroussi <ran@blogish.org> - adpated and modified for Zenphoto 1.2.6 by Malte Müller (acrylian) and Stephen Billard (sbillard) 
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 * @version 1.2.7
 * @package plugins
 * ==============================================================================
 */
$plugin_is_filter = 5;
$plugin_description = gettext("Provides trackback functionality to comments. Tracksbacks are available for images and albums as well as Zenpage news articles and pages. Trackback pings currently available only for news articles and pages. CAUTION: BETA STATUS. BETA STATUS Known bug: Does not work with sites in subdomains!");
$plugin_author = "Malte Müller (acrylian) and Stephen Billard (sbillard) based on Ran Aroussi's trackback class";
$plugin_version = '1.2.9'; 
$option_interface = new trackbackOptions();

// check for filter needed because on root trackback.php it is not available and needed!
if (getOption('zp_plugin_zenpage') AND function_exists("zp_register_filter")) {
	zp_register_filter('publish_article_utilities', 'printTrackbackPingCheckbox');
	zp_register_filter('publish_page_utilities', 'printTrackbackPingCheckbox');
	zp_register_filter('new_article', 'sendTrackBackPing');
	zp_register_filter('update_article', 'sendTrackBackPing');
	zp_register_filter('new_page', 'sendTrackBackPing');
	zp_register_filter('update_page', 'sendTrackBackPing');
}

/**
 * Option class for trackbacks
 *
 */
class trackbackOptions {

	function trackbackOptions() {
		setOptionDefault('trackback_news', 1);
		setOptionDefault('trackback_pages', 1);
		setOptionDefault('trackback_images', 1);
		setOptionDefault('trackback_albums', 1);
	}
	/**
	 * Standard option interface
	 *
	 * @return array
	 */
	function getOptionsSupported() {
		$checkboxes = array(gettext('Albums') => 'trackback_albums', gettext('Images') => 'trackback_images');
		if (getOption('zp_plugin_zenpage')) {
			$checkboxes = array_merge($checkboxes, array(gettext('Pages') => 'trackback_pages', gettext('News') => 'trackback_news'));
		}
		return array(	gettext('Allow trackbacks on') => array('key' => 'trackback_allowed', 'type' => OPTION_TYPE_CHECKBOX_ARRAY,
										'checkboxes' => $checkboxes,
									'desc' => gettext('Trackbacks will be allowed on the checked pages.'))
		);
	}
}

/**
 * Trackback - The main class
 */
class Trackback {
	var $blog_name = ''; // Default blog name used throughout the class (ie. BLOGish)
	var $author = ''; // Default author name used throughout the class (ie. Ran Aroussi)
	var $encoding = ''; // Default encoding used throughout the class (ie. UTF-8)
	var $id = ''; // Retreives and holds $_GET['id'] (if not empty)
	var $url = ''; // Retreives and holds $_POST['url'] (if not empty)
	var $title = ''; // Retreives and holds $_POST['title'] (if not empty)
	var $excerpt = ''; // Retreives and holds $_POST['excerpt'] (if not empty)
	var $type; // type of the item to track back ("images" etc)

	/**
	 * Class Constructor
	 *
	 * @return
	 */
	function Trackback() {
		$this->gallery_name = getOption("gallery_title");
		$this->encoding = getOption('charset');

		// Gather $_POST information
		if (isset($_REQUEST['id'])) { // get the id
			$this->id = sanitize_numeric($_REQUEST['id']);
		}
		if (isset($_REQUEST['type'])) { // get the type e.g. "images", "albums", "news" or "pages" (this is from our trackback url so $_GET only).
			$this->type = sanitize($_REQUEST['type']);
		}
		if (isset($_REQUEST['url'])) {
			$this->url = sanitize(urldecode($_REQUEST['url']));
			if (!empty($this->url) && substr($this->url, 0, 7) != "http://") {
				$this->url = "http://" . $this->url;
			}
		}
		if (isset($_REQUEST['title'])) {
			$this->title = sanitize(urldecode($_REQUEST['title']));
		}
		if (isset($_REQUEST['excerpt'])) {
			$this->excerpt = trim(sanitize(urldecode($_REQUEST['excerpt'])));
			$this->excerpt = truncate_string($this->excerpt,255,"(...)");
		}
		if (isset($_REQUEST['blog_name'])) {
			$this->blog_name = sanitize(urldecode($_REQUEST['blog_name']));
		}
	}

	/**
	 * Sends a trackback ping to a specified trackback URL.
	 * allowing clients to auto-discover the TrackBack Ping URL.
	 *
	 * <code><?php
	 * include('trackback_cls.php');
	 * $trackback = new Trackback('BLOGish', 'Ran Aroussi', 'UTF-8');
	 * if ($trackback->ping('http://tracked-blog.com', 'http://your-url.com', 'Your entry title')) {
	 * 	echo "Trackback sent successfully...";
	 * } else {
	 * 	echo "Error sending trackback....";
	 * }
	 * ?></code>
	 *
	 * @param string $tb
	 * @param string $url
	 * @param string $title
	 * @param string $excerpt
	 * @return boolean
	 */
	function ping($tb, $url, $title = "", $excerpt = "") {
		$response = "";
		$reason = "";
		// Set default values
		if (empty($title)) {
			$title = gettext("Trackbacking your entry...");
		}
		if (empty($excerpt)) {
			$excerpt = gettext("I found your entry interessting so I've added a Trackback to it on my weblog.");
		}
		// Parse the target
		$target = parse_url($tb);

		if ((isset($target["query"])) && ($target["query"] != "")) {
			$target["query"] = "?" . $target["query"];
		} else {
			$target["query"] = "";
		}

		if ((isset($target["port"]) && !is_numeric($target["port"])) || (!isset($target["port"]))) {
			$target["port"] = 80;
		}
		// Open the socket
		$tb_sock = fsockopen($target["host"], $target["port"]);
		// Something didn't work out, return
		if (!is_resource($tb_sock)) {
			return sprintf(gettext("Can't connect to: %s."),$tb);
			exit;
		}
		// Put together the things we want to send
		$tb_send = "url=" . rawurlencode($url) . "&title=" . rawurlencode($title) . "&blog_name=" . rawurlencode($this->gallery_name) . "&excerpt=" . rawurlencode($excerpt);
		// Send the trackback
		fputs($tb_sock, "POST " . $target["path"] . $target["query"] . " HTTP/1.1\r\n");
		fputs($tb_sock, "Host: " . $target["host"] . "\r\n");
		fputs($tb_sock, "Content-type: application/x-www-form-urlencoded\r\n");
		fputs($tb_sock, "Content-length: " . strlen($tb_send) . "\r\n");
		fputs($tb_sock, "Connection: close\r\n\r\n");
		fputs($tb_sock, $tb_send);
		// Gather result
		while (!feof($tb_sock)) {
			$response .= fgets($tb_sock, 128);
		}
		// Close socket
		fclose($tb_sock);
		// send result
		return $response;
	}

	/**
	 * Produces XML response for trackbackers with ok/error message.
	 *
	 * <code><?php
	 * // Set page header to XML
	 * header('Content-Type: text/xml'); // MUST be the 1st line
	 * //
	 * // Instantiate the class
	 * //
	 * include('trackback_cls.php');
	 * $trackback = new Trackback('BLOGish', 'Ran Aroussi', 'UTF-8');
	 * //
	 * // Get trackback information
	 * //
	 * $tb_id = $trackback->post_id; // The id of the item being trackbacked
	 * $tb_url = $trackback->url; // The URL from which we got the trackback
	 * $tb_title = $trackback->title; // Subject/title send by trackback
	 * $tb_expert = $trackback->expert; // Short text send by trackback
	 * //
	 * // Do whatever to log the trackback (save in DB, flatfile, etc...)
	 * //
	 * if (TRACKBACK_LOGGED_SUCCESSFULLY) {
	 * 	// Logged successfully...
	 * 	echo $trackback->receive(true);
	 * } else {
	 * 	// Something went wrong...
	 * 	echo $trackback->receive(false, 'Explain why you return error');
	 * }
	 * ?></code>
	 *
	 * @param boolean $success
	 * @param string $err_response
	 * @return boolean
	 */
	function receive($success = false, $err_response = "") {
		// Default error response in case of problems...
		if (!$success && empty($err_response)) {
			$err_response = gettext("An error occured while trying to log your trackback...");
		}
		// Start response to trackbacker...
		$return = '<?xml version="1.0" encoding="' . $this->encoding . '"?>' . "\n";
		$return .= "<response> \n";
		// Send back response...
		if ($success) {
			// Trackback received successfully...
			$return .= "	<error>0</error> \n";
		} else {
			// Something went wrong...
			$return .= "	<error>1</error> \n";
			$return .= "	<message>" . $this->xml_safe($err_response) . "</message>\n";
		}
		// End response to trackbacker...
		$return .= "</response>";

		return $return;
	}


	/**
	 * Produces embedded RDF representing metadata about the entry,
	 * allowing clients to auto-discover the TrackBack Ping URL.
	 *
	 * NOTE: DATE should be string in RFC822 Format - Use RFC822_from_datetime().
	 *
	 * <code><?php
	 * include('trackback_cls.php');
	 * $trackback = new Trackback('BLOGish', 'Ran Aroussi', 'UTF-8');
	 *
	 * echo $trackback->rdf_autodiscover(string DATE, string TITLE, string EXPERT, string PERMALINK, string TRACKBACK [, string AUTHOR]);
	 * ?></code>
	 *
	 * @param string $RFC822_date
	 * @param string $title
	 * @param string $excerpt
	 * @param string $permalink
	 * @param string $trackback
	 * @param string $author
	 * @return string
	 */
	function rdf_autodiscover($RFC822_date, $title, $excerpt, $permalink, $trackback, $author = "")	{
		if (!$author) {
			$author = $this->author;
		}
		$return = "<!-- \n";
		$return .= "<rdf:RDF xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" \n";
		$return .= "	xmlns:dc=\"http://purl.org/dc/elements/1.1/\" \n";
		$return .= "	xmlns:trackback=\"http://madskills.com/public/xml/rss/module/trackback/\"> \n";
		$return .= "<rdf:Description \n";
		$return .= "	rdf:about=\"" . $this->xml_safe($permalink) . "\" \n";
		$return .= "	dc:identifier=\"" . $this->xml_safe($permalink) . "\" \n";
		$return .= "	dc:title=\"" . $this->xml_safe($title) . "\" \n";
		$return .= "	trackback:ping=\"" . $this->xml_safe($trackback) . "\" />\n";
		$return .= "</rdf:RDF> \n";
		$return .= "-->  \n";

		return $return;
	}

	/**
	 * Search text for links, and searches links for trackback URLs.
	 *
	 * SEEMS NOT TO WORK WITH SUBDOMAINS?
	 *
	 * <code><?php
	 *
	 * include('trackback_cls.php');
	 * $trackback = new Trackback('BLOGish', 'Ran Aroussi', 'UTF-8');
	 *
	 * if ($tb_array = $trackback->auto_discovery(string TEXT)) {
	 * 	// Found trackbacks in TEXT. Looping...
	 * 	foreach($tb_array as $tb_key => $tb_url) {
	 * 	// Attempt to ping each one...
	 * 		if ($trackback->ping($tb_url, string URL, [string TITLE], [string EXPERT])) {
	 * 			// Successful ping...
	 * 			echo "Trackback sent to <i>$tb_url</i>...\n";
	 * 		} else {
	 * 			// Error pinging...
	 * 			echo "Trackback to <i>$tb_url</i> failed....\n";
	 * 		}
	 * 	}
	 * } else {
	 * 	// No trackbacks in TEXT...
	 * 	echo "No trackbacks were auto-discover...\n"
	 * }
	 * ?></code>
	 *
	 * @param string $text
	 * @return array Trackback URLs.
	 */
	function auto_discovery($text)	{
		// Get a list of UNIQUE links from text...
		// ---------------------------------------
		// RegExp to look for (0=>link, 4=>host in 'replace')
		$reg_exp = "/(http)+(s)?:(\\/\\/)((\\w|\\.)+)(\\/)?(\\S+)?/i";
		// Make sure each link ends with [space]
		$text = preg_replace("#www.#i", "http://www.", $text);
		$text = preg_replace("#http://http://#i", "http://", $text);
		$text = preg_replace("#\"#", " \"", $text);
		$text = preg_replace("#'#", " '", $text);
		$text = preg_replace("#>#", " >", $text);
		// Create an array with unique links
		$uri_array = array();
		if (preg_match_all($reg_exp, strip_tags($text, "<a>"), $array, PREG_PATTERN_ORDER)) {
			foreach($array[0] as $key => $link) {
				foreach((array(",", ".", ":", ";")) as $t_key => $t_value) {
					$link = trim($link, $t_value);
				}
				$uri_array[] = ($link);
			}
			$uri_array = array_unique($uri_array);
		}
		// Get the trackback URIs from those links...
		// ------------------------------------------
		// Loop through the URIs array and extract RDF segments
		$rdf_array = array(); // <- holds list of RDF segments
		foreach($uri_array as $key => $link) {
			if ($link_content =  file_get_contents($link)) {
				preg_match_all('/(<rdf:RDF.*?<\/rdf:RDF>)/sm', $link_content, $link_rdf, PREG_SET_ORDER);
				for ($i = 0; $i < count($link_rdf); $i++) {
					if (preg_match('|dc:identifier="' . preg_quote($link) . '"|ms', $link_rdf[$i][1])) {
						$rdf_array[] = trim($link_rdf[$i][1]);
					}
				}
			}
		}
		// Loop through the RDFs array and extract trackback URIs
		$tb_array = array(); // <- holds list of trackback URIs
		if (!empty($rdf_array)) {
			for ($i = 0; $i < count($rdf_array); $i++) {
				if (preg_match('/trackback:ping="([^"]+)"/', $rdf_array[$i], $array)) {
					$tb_array[] = trim($array[1]);
				}
			}
		}
		// Return Trackbacks
		return $tb_array;
	}

	/**
	 * Other Useful functions used in this class
	 */

	/**
	 * Converts MySQL datetime to a standart RFC 822 date format
	 *
	 * @param string $datetime
	 * @return string RFC 822 date
	 */
	function RFC822_from_datetime($datetime) {
		$timestamp = mktime(
		substr($datetime, 8, 2), substr($datetime, 10, 2), substr($datetime, 12, 2),
		substr($datetime, 4, 2), substr($datetime, 6, 2), substr($datetime, 0, 4)
		);
		return date("r", $timestamp);
	}

	/**
	 * Converts a string into an XML-safe string (replaces &, <, >, " and ')
	 *
	 * @param string $string
	 * @return string
	 */
	function xml_safe($string) {
		return htmlspecialchars($string, ENT_QUOTES);
	}

	/*********************************/
	/* Method additions for Zenphoto */
	/*********************************/

	/**
	 * Sends a trackback ping (= notification) for an item to on or more external sites that have been referred to by this item's content.
	 *
	 * For admin backend filter use only.
	 *
	 * @param string $message Message text
	 * @param object $object The object of the item to send a ping for
	 * @return string
	 */
	function sendTrackbackPing($message,$object) {
		$class = get_class($object);
		$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
		$title = "";
		$text = "";
		$url = "";
		$title = $object->getTitle();
		switch($class) {
			case "ZenpageNews":
				$text = $object->getContent();
				if(getOption("mod_rewrite")) {
					$url = "http://".$host.WEBPATH."/".ZENPAGE_NEWS."/".$object->getTitlelink();
				} else {
					$url = "http://".$host.WEBPATH."/index.php?p=".ZENPAGE_NEWS."&amp;title=".$object->getTitlelink();
				}
				break;
			case "ZenpagePage":
				$text = $object->getContent();
				if(getOption("mod_rewrite")) {
					$url = "http://".$host.WEBPATH."/".ZENPAGE_PAGES."/".$object->getTitlelink();
				} else {
					$url = "http://".$host.WEBPATH."/index.php?p=".ZENPAGE_PAGES."&amp;title=".$object->getTitlelink();
				}
				break;
			case "Album":
				$text = $object->getDesc();
				if(getOption("mod_rewrite")) {
					$url = "http://".$host.WEBPATH."/".$object->getFolder();
				} else {
					$url = "http://".$host.WEBPATH."/index.php?album=".$object->getFolder();
				}
				break;
			case "_Image":
				$text = $object->getDesc();
				if(getOption("mod_rewrite")) {
					$url = "http://".$host.WEBPATH."/".$object->getAlbumName()."/".getFileName().getOption("mod_rewrite_suffix");
				} else {
					$url = "http://".$host.WEBPATH."/index.php?album=".$object->getAlbumName()."&amp;image=".getFileName();
				}
				break;
		}
		$url = urlencode($url);
		$excerpt = truncate_string($text,255,"(...)");
		$array = $this->auto_discovery($text); // debugging
		echo "Array with trackback URLs: <pre>"; print_r($array); echo "</pre>"; // debugging
		$message = '';
		if ($tb_array = $this->auto_discovery($text)) {
			// Found trackbacks in TEXT. Looping...
			foreach($tb_array as $tb_key => $tb_url) {
				// Attempt to ping each one...
				$response = parsePingResponse($this->ping($tb_url,$url,$title,$excerpt));
				if (empty($response)) {
					// Successful ping...
					$message .= "<p class='messagebox'>".sprintf(gettext("Trackback send to <em>%s</em>."),$tb_url)."</p>\n";
				} else {
					// Error pinging...
					$message .= "<p class='errorbox'>".sprintf(gettext('Trackback to <em>%1$s</em> failed...%2$s'),$tb_url, $response)."</p>\n";
				}
			}
		} else {
			// No trackbacks in TEXT...
			$message = "<p  class='errorbox'>".gettext("No trackbacks were auto-discovered...")."</p>\n";
			$message.= "<br />".urldecode($url); // debug only
		}
		return $message;
	}
	
	// theme methods

	/**
	 * Returns the trackback url for the current item object.
	 *
	 * For theme usage.
	 *
	 * @param object $object The object of the item to get the trackback url to
	 * @return string
	 */
	function getTrackbackURL($object="") {
		global $_zp_current_zenpage_news, $_zp_current_zenpage_page, $_zp_current_album, $_zp_current_image;
		if(is_object($object)) {
			$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
			$class = strtolower(get_class($object));
			switch($class) {
				case "zenpagenews":
					$type = "news";
					break;
				case "zenpagepage":
					$type = "pages";
					break;
				case "album":
					$type = "albums";
					break;
				case "_image":
					$type = "images";
					break;
			}
			$trackbackURL = "http://".$host.WEBPATH."/trackback.php?id=".$object->get('id')."&type=".$type; // the & gets escaped later by the RDF function!
			return $trackbackURL;
		}
	}

	/**
	 * Prints the RDF trackback url information for external clients to autodiscover.
	 * This code is invisible and within comments on the theme page.
	 *
	 * For theme usage.
	 *
	 */
	function printTrackbackRDF() {
		global $_zp_current_zenpage_news, $_zp_current_zenpage_page, $_zp_current_album, $_zp_current_image;
		// check if Zenpage is there...
		if (getOption('zp_plugin_zenpage')) {
			if(is_NewsArticle()) {
				$trackback = $this->getTrackbackURL($_zp_current_zenpage_news);
				$title = getNewsTitle();
				$permalink = $this->getPermalinkURL($_zp_current_zenpage_news,$host);
			}
			if(is_Pages()) {
				$trackback = $this->getTrackbackURL($_zp_current_zenpage_page);
				$title = getPageTitle();
				$permalink = $this->getPermalinkURL($_zp_current_zenpage_page);
			}
		}
		if(in_context(ZP_ALBUM)) {
			$trackback = $this->getTrackbackURL($_zp_current_album);
			$title = getAlbumTitle();
			$permalink = $this->getPermalinkURL($_zp_current_album);
		}
		if(in_context(ZP_IMAGE)) {
			$trackback = $this->getTrackbackURL($_zp_current_image);
			$title = getImageTitle();
			$permalink = $this->getPermalinkURL($_zp_current_image);
		}
		echo $this->rdf_autodiscover("", $title,"",$permalink,$trackback,"");
	}
	
	
	/**
	 * Gets the permalink url of the item that should be trackbacked 
	 * as we can't use template functions on trackback.php
	 *
	 * @param object $object Object of the item
	 * @return string
	 */
	function getPermalinkURL($object) {
		$host = "http://".htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
		$class = get_class($object);
		// Workaround because the ZENPAGE_NEWS and ZENPAGE_PAGES constants are not setup (strangely only on my live server...)
		if (getOption('zp_plugin_zenpage')) {
			$zenpage_pages = getOption("zenpage_pages_page");
			$zenpage_news = getOption("zenpage_news_page");
		}
		switch($class) {
			case "ZenpageNews":
				// the & is escaped by the rdf function later
				return $host.rewrite_path($zenpage_news."/".$object->getTitlelink(), $host."/index.php?p=".$zenpage_news."&title=".$object->getTitlelink()); 
				break;
			case "ZenpagePage":
				return $host.rewrite_path($zenpage_pages."/".$object->getTitlelink(), $host."/index.php?p=".$zenpage_pages."&title=".$object->getTitlelink());
				break;
			case "Album":
				return  $host.getAlbumLinkURL($object);
				break;
			case "_Image":
				return  $host.rewrite_path($object->getAlbumName()."/".$object->getFilename(), $host."/index.php?album=".urlencode($object->getAlbumName())."&image=".$object->getFilename());
				break;
		}
	}

	/**
	 * Prints the code to auto receive and add tracksbacks from external clients
	 * for the root trackback.php file
	 *
	 */
	function printTrackbackReceiver() {
		global $_zp_gallery;
		// Set page header to XML
		header('Content-Type: text/xml'); // MUST be the 1st line
		// Get trackback information
		$tb_id = $this->id; // The id of the item being trackbacked
		$tb_type = $this->type; // The type of the item being trackbacked
		$tb_url = $this->url; // The URL from which we got the trackback.
		$tb_title = $this->title; // Subject/title send by trackback
		$tb_blogname = $this->blog_name; // Name of the blog/site that sends the trackback;

		// Following trackback spec only $tb_url is mandatory, so throw error if missing. Also if comments are not allowed at all
		if(empty($tb_url) || empty($tb_id) || empty($tb_type)) {
			echo $this->receive(false,"Trackbacks are not allowed");
			exit();
		}
		if(empty($tb_blogname)) {
			$tb_blogname = "[Trackback] ".$tb_url; // if there is no name sent, use the url as name.
		} else {
			$tb_blogname = "[Trackback] ".$tb_blogname;
		}
		$tb_excerpt = truncate_string($this->excerpt,255,"[...]"); // Short text send by trackback if too long
		$tb_excerpt = "<strong>".$tb_title."</strong><br />".$tb_excerpt; // add trackback title to trackback content to show them togehter

		// getting the item "name" so that we can setup an receiver object for postComment()
		$gallery = new Gallery(); //$_zp_gallery;
		$query = "";
		switch($tb_type) {
			case "albums":
				$query = query_single_row('SELECT `folder` FROM '.prefix('albums').' WHERE `id`="'.zp_escape_string($tb_id).'"',true);
				$object = new Album($gallery,$query['folder']);
				$allowed = commentsAllowed('comment_form_albums');
				break;
			case "images":
				$query = query_single_row('SELECT `filename`,`albumid` FROM '.prefix('images').' WHERE `id`="'.zp_escape_string($tb_id).'"',true);
				$albumid = $query['albumid'];
				$query2 = query_single_row('SELECT `folder` FROM '.prefix('albums').' WHERE `id`="'.zp_escape_string($albumid).'"',true);
				$albobject = new Album($gallery,$query2['folder']);
				$object = newImage($albobject,$query['filename']);
				$allowed = commentsAllowed('comment_form_images');
				break;
			case "pages":
				$query = query_single_row('SELECT `titlelink` FROM '.prefix('zenpage_pages').' WHERE `id`="'.zp_escape_string($tb_id).'"',true);
				$object = new ZenpagePage($query['titlelink']);
				$allowed = commentsAllowed('comment_form_pages');
				break;
			case "news":
				$query = query_single_row('SELECT `titlelink` FROM '.prefix('zenpage_news').' WHERE `id`="'.zp_escape_string($tb_id).'"',true);
				$object = new ZenpageNews($query['titlelink']);
				$allowed = commentsAllowed('comment_form_articles');
				break;
		}
		// Check if the url being sent really includes a link to us.
		$our_url = $this->getPermalinkURL($object);
		if(!$this->validateTrackbackSender($tb_url,$our_url)) {
			echo $this->receive(false,"Not a valid trackback!");
			exit();
		} 
		// I realized that we should only send one final receive(true) at the end
		// and only receive(false) inbetween if it fails a precheck. 
		if(!(getOption('zp_plugin_comment_form') && $allowed && $object->getCommentsAllowed())) {
			echo $this->receive(false, gettext("Sorry, comments are closed for this item."));
			exit();
		} 
		$sql = 'SELECT `id` FROM '.prefix('comments').' WHERE `ownerid`='.$tb_id	
																.' AND `comment`="'.zp_escape_string($tb_excerpt)
																.'" AND `website`="'.zp_escape_string($tb_url)
																.'" AND `type`="'.zp_escape_string($tb_type)
																.'" AND `name`="'.zp_escape_string($tb_blogname)
																.'"';
		$dbcheck = query_single_row($sql); 
		if($dbcheck){
			echo $this->receive(false, gettext("This trackback already exists!"));
			exit();
		} else {
			$commentobj = postComment($tb_blogname,"", $tb_url, $tb_excerpt,"","",$object,"","","",COMMENT_WEB_REQUIRED | COMMENT_SEND_EMAIL);
			if($commentobj->getInModeration()>= 0) {
				echo $this->receive(true);
			} else {
				echo $this->receive(false);
			}
		}
	}
	
	
	/** 
	 * Checks if the trackback sender really has a link to us on his page he wants to notify us about.
	 *
	 * @param string $sender_url The url the trackback sender sent
	 * @param unknown_type $our_url The url of our post the trackback refers to.
	 * @return bool
	 */
	function validateTrackbackSender($sender_url,$our_url) {
		if ($link_content =  file_get_contents($sender_url)) {
			$url_found = strstr($link_content, $our_url);
			if($url_found) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/** DOES NOT WORK....
	 * Checks if $url is external so that we can prevent sending trackback to ourselves.
	 *
	 * @param string $url The url to check
	 * @return bool
	 */
	function isExternalURL($url) {
		$host = htmlentities($_SERVER["HTTP_HOST"], ENT_QUOTES, 'UTF-8');
		$url = substr($url,7);
		$url = explode("/",$url);
		echo "<br />".$url[0];
		if($host == $url[0]) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

} // class end


// set up the trackback global object so it can be used
global $_zp_trackback;
$_zp_trackback = new Trackback();


/*********************************/
/* Some Zenphoto helper/wrapper functions */
/*********************************/

/**
 * parses the response to a trackback ping
 * Returns the error message if the ping failed or empty of successful
 *
 * @param string $response
 * @return string
 */
function parsePingResponse($response) {
	$fail = strpos($response, '<error>1</error>') !== false;
	if ($fail) {
		$i = strpos($response, '<message>');
		$j = strpos($response, '</message>');
		if ($i!==false && $j!==false) {
			$i = $i + 9;
			return substr($response, $i, $j-$i);
		}
	} else {
		return '';
	}
}

/**
 * Prints the RDF autodiscovery link for theme pages (theme usage convenience wrapper function)
 * For theme use.
 *
 */
function printTrackbackRDF() {
	global $_zp_trackback,$_zp_gallery_page;
	switch ($_zp_gallery_page) {
		case 'album.php':
			if (getOption('trackback_albums')) $_zp_trackback->printTrackbackRDF();
			break;
		case 'image.php':
			if (getOption('trackback_images')) $_zp_trackback->printTrackbackRDF();
			break;
		case ZENPAGE_PAGES.'.php':
			if (getOption('trackback_pages')) $_zp_trackback->printTrackbackRDF();
			break;
		case ZENPAGE_NEWS.'.php':
			if (getOption('trackback_news')) $_zp_trackback->printTrackbackRDF();
			break;
	}
}

/**
 * Prints the trackback url link for the current item object as a html link
 * For theme use.
 *
 * @param object $object The object of the item to get the trackback url to
 * @param string $linktext The text for the link printed
 * @return string
 */
function printTrackbackURL($object="",$linktext="Trackback URL") {
	global $_zp_trackback;
	echo "<a href=".$_zp_trackback->xml_safe($_zp_trackback->getTrackbackURL($object)).">".$linktext."</a>";
}

/**
 * Prints the checkbox for activating trackback ping sending for the backend.
 *
 * For admin backend filter use on edit pages.
 *
 */
function printTrackbackPingCheckbox() {
	?>
<p class="checkbox"><input name="trackbackping" type="checkbox"
	id="trackbackping" value="1" /> <label for="trackbackping"><?php echo gettext("Send trackback ping"); ?></label>
</p>
	<?php
}

/**
 * Sends a trackback ping to external clients if trackback urls are discovered within
 * the content part of the $object (article or pages content, image or album descriptions)
 * and returns jQuery fade out message if none are found and on error or success.
 *
 * For admin backend filter use.
 *
 * @param string $message Message text
 * @param object $object The object of the item to check for trackback urls
 * @return string
 */
function sendTrackbackPing($message,$object) {
	global $_zp_trackback;
	$jsmessage = "
	<script language='javascript' type='text/javascript'>
		jQuery(function($){
			$('.errorbox').fadeTo(5000, 1).fadeOut(1000);
			$('.messagebox').fadeTo(5000, 1).fadeOut(1000);
		});
	</script>";
	if(getCheckboxState("trackbackping")) {
		$message .= $_zp_trackback->sendTrackbackPing($message,$object);
		$message = $jsmessage.$message;
	}
	return $message;
}
?>