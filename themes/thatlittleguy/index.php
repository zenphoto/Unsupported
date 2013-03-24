<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">

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

<div id="credit">
<?php
	if (!zp_loggedin()) {
	printUserLogin_out($before='', $after=' | ', $showLoginForm=false, $logouttext="Logout", $show_user=NULL);
	} else {
		printLink(WEBPATH . '/' . ZENFOLDER .'/admin.php', 'Admin'); echo " | ";
	}
?><?php printZenphotoLink(); ?></div>

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

</body>
</html>
