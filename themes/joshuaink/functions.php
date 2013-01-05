<?php
################################################################################
# JoshuaInk Theme Options
################################################################################

// Use this to set whether you want to use AJAX effects or not.
define ('USE_AJAX', true);

// This sets the default width of the thumbnail.  Affects index.php & album.php.
// If you edit this, you WILL need to edit the CSS file as well.
define ('THM_WIDTH', 200);

// This sets the default height of the thumbnail. Affects index.php & album.php.
// If you edit this, you WILL need to edit the CSS file as well.
define ('THM_HEIGHT', 140);

// This sets the maximum width of the image. Affects image.php.
// If you edit this, you MAY need to edit the CSS file as well (depending on
//   the dimensions you choose).
define ('IMG_MAX_WIDTH', 600); // If > 600px, edit line 107 in CSS file.

// This sets the maximum height of the image. Affects image.php.
// If you edit this, you MAY need to edit the CSS file as well (depending on
//   the dimensions you choose).
define ('IMG_MAX_HEIGHT', 480);

// This sets whether or not you want to display your gallery with pages.
define ('PAGINATED', false);   // default is false

################################################################################
# DO NOT EDIT BELOW THIS LINE
################################################################################
define ('JI_VERSION', '1.2');

if(!PAGINATED) {
   $_zp_conf_vars['albums_per_page'] = 10000;
   $_zp_conf_vars['images_per_page'] = 10000;
}

function ji_ver() {
   return "JoshuaInk Theme " . JI_VERSION;
}

function ji_show_thumb() {
   /*
   	$cw - crop width
   	$ch - crop height
   	$iw - image width
   	$ih - image height
   */
			
	$iw = $cw = THM_WIDTH;
	$ih = $ch = THM_HEIGHT;
?>
<li>
	<a href="<?php echo getAlbumLinkURL(); ?>"
		title="<?php echo getAlbumTitle(); ?>"><img
		src="<?php echo getCustomAlbumThumb(null, $iw, $ih, $cw, $ch); ?>"
		alt="<?php echo getAlbumTitle(); ?>"
		width="<?php echo $iw; ?>" height="<?php echo $ih; ?>" />
		<span><?php
			echo getNumImages().' images';
			if (getAlbumDesc() == '') {
			   echo '<br /><br />[' . getAlbumTitle() . ']';
			} else {
				echo '<br /><br />' . getAlbumDesc();
			} ?></span></a>
</li>
<?php
}

?>
