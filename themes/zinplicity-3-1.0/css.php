<?php
	global $_zp_themeroot;

	if ( !defined('CACHE_LENGTH') ) define('CACHE_LENGTH', 31356000); 

	//ob_start('ob_gzhandler');

	require_once('theme_functions.php');
	
	header('Content-Type: text/css');
	
	$headerScroll = getOption('simplicity3_header_scroll');
	$bannerExists = file_exists(SERVERPATH . '/themes/' . basename(dirname(__FILE__)) . '/custom/images/banner.png');

	$theme = basename(dirname(__FILE__));
	$root = SERVERPATH . "/themes/$theme/resources/css";

	$css = array("$root/base.css", "$root/layout.css", "$root/menu.css", "$root/extension.css");

	if ( getOption('simplicity3_use_fancybox') ):
		$css[] = SERVERPATH . "/themes/$theme/resources/scripts/lib/fancybox/jquery.fancybox-1.3.1.css";
	endif;

	$custom = Utils::getTileResources('css', "custom/css");
	$css = array_merge($css, array_values($custom));
	$lastModified = Utils::getLastModified(array_merge($css, array(__FILE__)));

	if ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $lastModified ) {
	 	header("{$_SERVER['SERVER_PROTOCOL']} 304 Not Modified");
		return;
	}

	if ( !is_dir(SERVERPATH . '/archives') ): 
		mkdir(SERVERPATH . '/archives');
		chmod(SERVERPATH . '/archives', 755);
	endif;

	$cacheFile = SERVERPATH . '/archives/css_' . $_SERVER['SERVER_NAME'] . '_' . ($headerScroll ? 1 : 0) . '_' . ($bannerExists ? 1 : 0) . '_' . $lastModified;
	$cacheExists = file_exists($cacheFile);
	if ( $cacheExists ):
		$css = file_get_contents($cacheFile);
	else: 
		$css = Utils::mergeStyleSheets($css);	
	endif;

	header('Cache-Control: max-age=' . CACHE_LENGTH);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + CACHE_LENGTH) . ' GMT'); 
  	header('Content-Length: ' . strlen($css));
    header("Last-Modified: $lastModified");

	switch ( $headerScroll ) {
		case 'fixed':
			$css .= "#header, #main-dash, #main-scissors { position: fixed; }";
			break;
		case 'scroll':
			$css .= "#header, #main-dash, #main-scissors { position: absolute; }";
			break;
		case 'banner':
			$css .= "#header { position: absolute; } #main-dash, #main-scissors { z-index: 1; }";			
			break;
	}

	if ( $bannerExists ):
		$css .= "#header-content {" .
			 "  text-indent: -100em; ".
			 "  overflow: hidden; ".
			 "  background: url($_zp_themeroot/custom/images/banner.png) no-repeat;" .
			 "  height: 103px;".
			 "  width: 358px;".
		     "}";
	endif;

	if ( !$cacheExists ) :
		file_put_contents($cacheFile, $css);
	endif;

	echo $css;
?>
