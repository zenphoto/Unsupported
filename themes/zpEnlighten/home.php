<?php if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('2', '5'); 
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printZDRoundedCornerJS(); ?>
</head>
<body>

<div id="main" class="home">

		<?php include("header.php"); ?>
<div id="content">

	<div id="breadcrumb">
<h2><strong><?php echo gettext('Index'); ?></strong></h2>
</div>

	<div id="content-left">
	<!-- div class="gallerydesc"><?php /* printGalleryDesc(true); */ ?></div -->
    <h3 class="searchheader">Latest sins</h3>
    <div id="albums" style="margin-left: 4px;">
    <?php 
        $latestImages = Utils::getLatestImages();
        $u = 0;
        foreach ( $latestImages as $i ) : $u++;?>
        <div class="album" <?php if ( $u%2 == 0 ) { echo 'style="margin-left: 8px;"'; } ?> > 
            <div class="thumb">
                <?php
                $thumb = $i->getCustomImage(NULL, 255, 75, 255, 75, NULL, NULL, false, false);
                $link = $i->getImageLink();
                $date = strftime("%d %B %Y", strtotime($i->get('date')));
                echo "<a href='$link'><img src='$thumb' width='255' height='75'/></a>" ;
                ?>
            </div>
            <div class="albumdesc">
                <?php 
                    $_zp_current_album = $i->getAlbum(); 
                ?>
                <h3><span style="color: #999;">Album:</span> <a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
                <h3 class="date"><?= $date; ?></h3>
            </div>
        </div>
        <?php endforeach ?>
        <?php 
            $_zp_current_album = NULL;
        ?>
    </div>
    <br style="clear:both;" /><br />
    <h3 class="searchheader" >Latest words</h3>
    <?php 
    $ln = getLatestNews(1);
  
    foreach ( $ln as $n) : 
        $_zp_current_zenpage_news = new ZenpageNews($n['titlelink']);
    
    ?>
    
    
    <div class="newsarticlewrapper"><div class="newsarticle" style="border-width: 0;"> 
    <h3><?php printNewsTitleLink(); ?></h3>
        <div class="newsarticlecredit"><span class="newsarticlecredit-left"><?php printNewsDate();?> | <?php echo gettext("Comments:"); ?> <?php echo getCommentCount(); ?></span>
<?php
if(is_GalleryNewsType()) {
	if(!is_NewsType("album")) {
		echo " | ".gettext("Album:")."<a href='".getNewsAlbumURL()."' title='".getBareNewsAlbumTitle()."'> ".getNewsAlbumTitle()."</a>";
	} else {
		echo "<br />";
	}
} else {
	echo ' | '; printNewsCategories(", ",gettext("Categories: "),"newscategories");
}
?>
</div>
    <?php printNewsContent(); ?>
    <p><?php printNewsReadMoreLink(); ?></p>
    <?php printCodeblock(1); ?>
    <br style="clear:both; " />
    </div>	
    </div>
    <?php endforeach; ?>
    
	<br style="clear:both;" />
	

	</div><!-- content left-->
	
	
	
	<div id="sidebar">
		<?php include("sidebar.php"); ?>
	</div><!-- sidebar -->



	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php printAdminToolbox(); ?>
</body>
</html>