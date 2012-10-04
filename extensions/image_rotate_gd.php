<?php
/**
 * Substitute for GD imagerotate
 *
 * @author Stephen Billard (sbillard)
 * @package plugins
 */

$plugin_description = gettext("Enable this plugin if your GD installation does not support image rotation.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.2.9'; 
$plugin_is_filter = 9;

/**
 * Substitute for GD imagerotate
 *
 * @param image $imgSrc
 * @param int $angle
 * @param int $bgd_colour
 * @return image
 */
function imagerotate($imgSrc, $angle, $bgd_colour) {
	// ensuring we got really RightAngle (if not we choose the closest one)
	$angle = min( ( (int)(($angle+45) / 90) * 90), 270 );

	// no need to fight
	if ($angle == 0)
	return ($imgSrc);

	// dimenstion of source image
	$srcX = imagesx($imgSrc);
	$srcY = imagesy($imgSrc);

	switch ($angle) {
		case 90:
			$imgDest = imagecreatetruecolor($srcY, $srcX);
			for ($x=0; $x<$srcX; $x++)
			for ($y=0; $y<$srcY; $y++)
			imagecopy($imgDest, $imgSrc, $srcY-$y-1, $x, $x, $y, 1, 1);
			break;

		case 180:
			$imgDest = imageflip($imgSrc, IMAGE_FLIP_BOTH);
			break;

		case 270:
			$imgDest = imagecreatetruecolor($srcY, $srcX);
			for ($x=0; $x<$srcX; $x++)
			for ($y=0; $y<$srcY; $y++)
			imagecopy($imgDest, $imgSrc, $y, $srcX-$x-1, $x, $y, 1, 1);
			break;
	}

	return ($imgDest);
}
?>