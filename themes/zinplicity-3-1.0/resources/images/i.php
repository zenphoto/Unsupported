<?php
ob_start('ob_gzhandler');

$i = $_GET['i'];
$ext = substr(strrchr($i, "."), 1);

header("Content-type: image/$ext");
header("Last-Modified:  Sat, 26 Jul 2007 05:00:00 GMT");
header( 'Expires: Sat, 26 Jul 2017 05:00:00 GMT');

if ( strpos($i, '/') === 0 ) :
	$file = dirname(dirname(dirname(__FILE__))) . $i;
else:
	$file = dirname(__FILE__) . '/' . $i;
endif;

echo file_get_contents($file);

?> 
