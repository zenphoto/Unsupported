<?php 

/*******************************************************************************
 * random.php: return random image
 *******************************************************************************
 * URL Parameters:
 *   num	- number of images
 *   width	- width of random image.
 *   height	- height of random image.
 *   class	- css class for random image.
 *   album	- album to get the random image, default is root.
 *
 *******************************************************************************
 */

define('OFFSET_PATH', true);
require_once("template-functions.php");

isset($_REQUEST['num']) ? $num = $_REQUEST['num'] : $num = 0;
isset($_REQUEST['width']) ? $width = $_REQUEST['width'] : $width = 50;
isset($_REQUEST['height']) ? $height = $_REQUEST['height'] : $height = 50;
isset($_REQUEST['class']) ? $class = $_REQUEST['class'] : $class = '';
isset($_REQUEST['album']) ? $album = $_REQUEST['album'] : $album = '';


header ('Content-Type: text/html; charset=' . getOption('charset'));

while ($num > 0) {
	if ($album == '') {
		$randomImage = getRandomImages();
	} else {
		$randomImage = getRandomImagesAlbum($album);
	}
		
	$randomImageURL = getURL($randomImage);
	echo '<a href="' . getMainSiteURL() . $randomImageURL . '" title="View image: ' . $randomImage->getTitle() . '" class="' . $class . '">' .
		'<img src="' . getMainSiteURL() . $randomImage->getCustomImage(null, $width, $height, null, null, null, null) .
		'" width="' . $width . '" height="' . $height . '" alt="'.$randomImage->getTitle().'"';
	echo "/></a>\n";
	$num--;
}


?>
