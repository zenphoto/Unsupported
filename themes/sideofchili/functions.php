<?php

//Prints total number of Images in Zenphoto
function printTotalImages() {
$photosArray = query_single_row("SELECT count(*) FROM ".prefix('images')); 
$photosNumber = array_shift($photosArray); 
echo ($photosNumber);
}

//Printer the total number of comments in Zenphoto
function printTotalComments(){
$commentsArray = query_single_row("SELECT count(*) FROM ".prefix('comments')." WHERE inmoderation = 0"); 
$commentsNumber = array_shift($commentsArray); 
echo ($commentsNumber);
}

//Prints EXIF Information
function getEXIF() {
$er = new phpExifRW("../" . getFullImageURL());
$er->processFile();
$er->showImageInfo();
}
  
//Album Navigation


//Header Function -  Displays Header
function zp_header() {?>

<?php }

//Footer Function - Displays Footer.
function zp_footer() { ?>
<div id="credit"><?php
	if (zp_loggedin()) {
	printUserLogin_out($before='', $after='| ', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLinkHTML(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin | ');
	}
?><?php printZenphotoLink(); ?> <?php printVersion();?></a> |  Using "Side Of Chili Theme" by: <a href="http://www.chilifrei.net" title="How Do You Like Your Chili?">ChiliFrei64</a></div>
<?php }

//Prints pagenav if more than 1 page exists
function show_pagenav() {
		if (getTotalPages()!= 1) {?>
			<div id="pagenav">	
				<?php printPageListWithNav("« prev", "next »"); ?>
			</div> <?php } else if (getTotalPages() == 1) {?>
			<div id="pagenav"></div>
			<?php };
		}

//Sidebar Function - Displays Sidebar
function zp_side_bar() {?>
	<div id="sidebar">
		<?php 
		
//-------------If you are in the Image Page

	if (in_context(ZP_IMAGE)) {?>
				<div class="imgnav">
					<?php if (hasPrevImage()) { ?>
					<div class="imgprevious"><a href="<?php echo getPrevImageURL();?>" title="Previous Image"><img src="<?php echo getPrevImageThumb();?>" /><br /><small>&laquo; prev  |</small></a></div>
					<?php } if (hasNextImage()) { ?>
					<div class="imgnext"><a href="<?php echo getNextImageURL();?>" title="Next Image"><img src="<?php echo getNextImageThumb();?>" /><br /><small>| next &raquo;</small></a></div>
					<?php } ?>
				</div> 
		<div id="sbinfo">
			<b>Album Name:</b> <?php printAlbumTitle(true);?><br />
			<b>Number of Photos:</b> <?php echo getNumImages();?><br />
			<b>Album Date:</b> <?php printAlbumDate($before="Date: ", $format="%F"); ?><br />
			<b>Album Description:</b> <?php printAlbumDesc(true);?><br />
			<b>Image Name:</b> <?php echo getImageTitle();?><br />
			<b>Image Description:</b> <?php printImageDesc(true); ?><br />
		</div>
			<?php
			
//--------------- If you are in the Album Page 

	} else if  (in_context(ZP_ALBUM)) {?>
		<b>Album Name:</b> <?php printAlbumTitle(true);?><br />
		<b>Number of Pictures:</b> <?php echo getNumImages();?><br />
		<b>Album Date:</b> <?php printAlbumDate($before="Date: ", $format="%F"); ?><br /> 
		<b>Album Description:</b> <?php printAlbumDesc(true);?><br />		
<?php

//--------------- If you are in the Index Page

	} else if (in_context(ZP_INDEX)) {?>
<?php }?>

</div>
<?php }
//End Sidebar
?>