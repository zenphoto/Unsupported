<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>

<!DOCTYPE html>

<html>
<head>
  <title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?> | <?php echo getImageTitle();?></title>
  <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
  <link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/killer_bee.css" type="text/css" />
  <?php zp_apply_filter('theme_head'); ?>
  <script language="Javascript" type="text/javascript" src="<?php echo $_zp_themeroot ?>/killer_bee.js"></script>
</head>

<body onload="IB_preload('<?php echo $_zp_themeroot ?>/images/logo-on.gif')">
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
  
  <div id="title">
    <h1>
	  <a href="<?php echo getGalleryIndexURL();?>" title="Gallery Index"><?php echo getGalleryTitle();?></a> | <a href="<?php echo getAlbumLinkURL();?>" title="Gallery Index"></a><?php printParentBreadcrumb("",""," | "); ?><?php printAlbumBreadcrumb();?> | <?php printImageTitle(true); ?>
	</h1>
    <a href="<?php echo getGalleryIndexURL();?>" onmouseout="IB_restore()" onmouseover="IB_swap('logo','','<?php echo $_zp_themeroot ?>/images/logo-on.gif',1)"  title="Home">
	  <img src="<?php echo $_zp_themeroot ?>/images/logo-off.gif" alt="Home" id="logo" width="25" height="25" border="0" />
	</a>
  </div><!--#title-->
  <hr />

  <div id="imgcontent">
    <div id="imgnav">
	  <?php if (hasPrevImage()) { ?>
		<a href="<?php echo getPrevImageURL();?>" title="Previous Image">&laquo; prev</a> |
	  <?php } else { ?>
	    <span class="current">&laquo; prev</span> |
	  <?php if (hasNextImage()) echo ""; } if (hasNextImage()) { ?>
	    <a href="<?php echo getNextImageURL();?>" title="Next Image">next &raquo;</a>
	  <?php } else { ?>
	    <span class="current">next &raquo;</span>
	  <?php } ?>
    </div><!--#imgnav-->

    <div class="image">
      <a href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>">
        <?php printCustomSizedImage(getImageTitle(), null, 470); ?>
	  </a>
	  <div id="imageDescEditable">
        <?php printImageDesc(true); ?>
      </div><!--imageDescEditable-->
    </div><!--.image-->
  </div><!--#imgcontent-->

<div id="comments" style="clear: both; padding-top: 10px;">
		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>

</div><!--#comments-->
</div><!--#main-->
<div id="footer">
</div><!--.footer-->

<div class="footnote">
  Powered by
  <a href="http://zenphoto.org/" onmouseout="IB_restore()" onmouseover="IB_swap('zp_button','','<?php echo $_zp_themeroot ?>/images/zp_button-on.gif',1)"  title="zenphoto.org">
	<img src="<?php echo $_zp_themeroot ?>/images/zp_button-off.gif" alt="ZenPhoto" id="zp_button" width="78" height="13" />
  </a>
  <br />

  template by
  <a href="http://imagebaker.com/">ImageBaker</a>
  licensed under a
  <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/2.5/">Creative Commons License</a>
  <br />

  checked for valid
  <a href="http://validator.w3.org/check?uri=referer">XHTML</a>
  and
  <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a>
</div><!--.footnote-->

<?php
	printAdminToolbox();
	zp_apply_filter('theme_body_close');
?>

</body>
</html>
