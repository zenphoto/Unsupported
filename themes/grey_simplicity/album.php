<?php 
if (!defined('WEBPATH')) die(); 
$firstPageImages = normalizeColumns('2', '6');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?> | <?php echo getAlbumTitle();?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
    <script type="text/javascript" src="<?= $_zp_themeroot ?>/highslide/highslide.js"></script>
	<?php zenJavascript(); ?>
	<script type="text/javascript" src="<?php echo $_zp_themeroot; ?>/fancybox/jquery.fancybox-1.2.6.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $_zp_themeroot; ?>/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
</head>

<body>
<?php printAdminToolbox(); ?>

<?php 
	function isStepAlbum($album) {
		$arr = $album->getTags(); 
		return in_array('Steps', $arr);
	}
?>

<div id="main">
	<div id="sd-wrapper">
	<div id="gallerytitle">
		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL(false);?>"><?php echo getGalleryTitle();?></a>
		</span>
		<span class="linkit"><a href="<?php echo getGalleryIndexURL(true);?>">Gallery</a></span>
		<?php if ( $_zp_current_album->getParent() != null ) { ?> <?php printParentBreadcrumb('<span class="linkit">', '', '</span>'); ?> </span><?php } ?>
		<span class="albumtitle"><span><?php echo $_zp_current_album->get('title');?></span></span>
		</h2>
	</div>
    
    <div id="padbox">
		
		<div class="palelinks" style="margin-bottom: 20px; margin-top: 6px; padding: 17px; font-weight: bold;">
		<?php printAlbumDesc(true); ?>
		<?php /* if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('Slideshow')); */ ?>
		</div>

  		<div id="albums">
			<?php while (next_album()): ?>
			<div style="float:left">
        		<div class="thumb">
					<a href="<?php echo getAlbumLinkURL();?>" title="View album: <?php echo getAlbumTitle();?>">
					<?php printAlbumThumbImage(getAlbumTitle()); ?>
					</a>
					<div class="data">
						<?php if(getAlbumTitle()) echo '<div class="c"><h4 class="box title">'.getAlbumTitle().'</h4></div>'; ?>	
					</div>
       			 </div>
			</div>
			<?php endwhile; ?>
		</div>
    	
   		<?php if ( $_PAGE == 'GALLERY' || count($_zp_current_album->getSubAlbums()) == 0 ) { ?>
		<?php if ( !isStepAlbum($_zp_current_album) ) { ?>
    	<div id="images">
			<?php while (next_image(false, $firstPageImages)): ?>
			<div class="image">
				<div class="imagethumb">
					<!--
					<a href="<?=getFullImageURL();?>" class="highslide" onclick="return expand(this, '<?= $_zp_current_image->getAlbum()->name ?>', '<?= $_zp_current_image->getFileName() ?>');" title="<?=getImageTitle();?>">
					-->
					<a href="<?php echo getImageLinkURL(); ?>">
						<?php printImageThumb(getImageTitle()); ?>
						
					</a>
				</div>
			</div>
			<?php endwhile; ?>
			<div style="clear:both;"/>
		</div>
		<div id="images-nav"><?php printPageListWithNav("&laquo; prev", "next &raquo;"); ?></div>
		<?php } else { ?>
		<?php while (next_image(false, $firstPageImages)): ?>		
		<div id="image-steps" class="stepimage imageit" style="margin-bottom: 25px;">
			<a class="group" rel="group"  href="<?php echo getFullImageURL();?>" title="<?php echo getImageTitle();?>"> <?php printCustomSizedImage('', 600); ?></a> 
		</div>
		<?php endwhile ?>
		<?php } ?>
		<? } ?>
        
	</div>
	</div>
</div>

<div id="credit"><?php printRSSLink('Album', '', 'Album RSS', '', false); ?> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=archive');?>">Archives</a> | <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<script type="text/javascript">
$(function() {
	$('.stepimage a').fancybox({ 'hideOnContentClick': true, imageScale: true, showCloseButton: false });
});
</script>
</body>
</html>
