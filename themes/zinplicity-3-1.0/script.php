<?php	
	//ob_start('ob_gzhandler');

	if ( !defined('CACHE_LENGTH') ) define('CACHE_LENGTH', 31356000); 

	require_once('classes/Utils.php');
	//require_once('lib/JSMin.php');
	
	header('Content-Type: text/javascript');
	header('Cache-Control: max-age=' . CACHE_LENGTH);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time() + CACHE_LENGTH) . ' GMT'); 
	
	$tile = $_REQUEST['t'] ? $_REQUEST['t'] : 'none';

	$theme = basename(dirname(__FILE__));
	$folder = SERVERPATH . "/themes/$theme/resources/scripts/";

	$files = array(
		"$folder/lib/jquery-1.4.2.min.js",
		"$folder/lib/jquery.bbq-1.2.1.min.js",
		"$folder/zen.js",
		"$folder/theme.js"
	);	

	if ( getOption('simplicity3_use_fancybox') ):
		$files[] = "$folder/lib/fancybox/jquery.fancybox-1.3.1.pack.js";
	endif;

	if ( function_exists('printSlideShowJS') ):
		$files[] = SERVERPATH . '/' . ZENFOLDER . '/' . PLUGIN_FOLDER . '/slideshow/jquery.cycle.all.js';
	endif;

	$a = Utils::getTileResources('js', "custom/scripts");
	$files = array_merge($files, array_values($a));
	
	$lastModified = Utils::getLastModified(array_merge($files, array(__FILE__)));

	if ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $lastModified ) {
	 	header("{$_SERVER['SERVER_PROTOCOL']} 304 Not Modified");
		exit;
	}

	$scripts = '';

	foreach ( $files as $file ) :
		$scripts .= "/* $file */";
		$scripts .= file_get_contents($file);
	endforeach;

	//we barely gain a few kb. not worth the deal
	//$scripts = JSMin::minify($scripts);

	header('Content-Length: ' . strlen($scripts));
    header("Last-Modified: $lastModified");

	echo $scripts;

	$fullView = getOption('protect_full_image') == 'Unprotected';
?>

Zen.theme.root = "<?= $_zp_themeroot ?>";

var page = Zen.theme.instance;

$(window).load(function() {
	page.init("<?= $tile ?>", {
		loader: "<div class='loading'><img src='" + Zen.theme.root + "/resources/images/loader.gif' /></div>",
		useFancybox: <?= getOption('simplicity3_use_fancybox') && $fullView ? "true" : "false" ?>
	});
});	


