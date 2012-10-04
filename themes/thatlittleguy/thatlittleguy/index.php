<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>

	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>

</head>

<body>

<div id="main">

	<?php printAdminToolbox(); ?>

	<div id="gallerytitle">
		<h2><?php echo getGalleryTitle(); ?></h2>
	</div>
	
	<?php printPageListWithNav("« prev", "next »"); ?>
	
	<div id="albums">
		
		<?php 
		//begin album generation /////////////
		while (next_album()): ?>
		<div class="album">
			<div class="albumtitle">
				<h3><a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
				</div>
			
			<div id="album_box">
			<div id="album_position">
			<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
			<?php printAlbumThumbImage(getAlbumTitle()); ?>
			</a>
			</div>
			</div>
			
			
			
			<div class="albumdesc">
        <!--
        <small><? printAlbumDate("Date Taken: "); ?></small>
        -->
				
				
				
				<p><?php printAlbumDesc(); ?></p>
			</div>
			<p style="margin:0px;padding:0px;clear: both; ">&nbsp;</p>
		</div>
		<?php
		//end album generation ////////////////
		endwhile; ?>
	
	</div>
	
	<?php printPageListWithNav("« prev", "next »"); ?>
	
	

</div>

<div id="credit"><?php
	if (zp_loggedin()) {
	printUserLogin_out($before='', $after='|', $showLoginForm=NULL, $logouttext=NULL, $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin');
	}
?>Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
