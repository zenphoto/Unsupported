<?php
//TODO push those global variables under zin namespace
echo "var isAlbumPage = " . (AlbumUtil::isAlbumPage() ? "true" : "false") . ";\n" .
	 "var maxImageIndex = " . AlbumUtil::getMaxImageIndex() . 
	 ", hasNextPage = " . (hasNextPage() ? "true" : "false") . 
	 ", hasPrevPage = " . (hasPrevPage() ? "true" : "false") . 
	 ", albumsPerPage = " . getOption('albums_per_page') .
	 ", imagesPerPage = " . getOption('images_per_page') .
	 ", enableFancybox = " . (getOption('simplicity2_enable_fancybox') ? 'true' : 'false' ) .
	 ", enableUpDownKeys = " . (getOption('simplicity2_nav_enable_updown') ? 'true' : 'false') .
     ";\n";
?>

