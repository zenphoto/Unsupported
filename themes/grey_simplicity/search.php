<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title><?php printGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	<?php zenJavascript(); ?>
</head>

<body>
<?php printAdminToolbox(); ?>

<div id="main">
	<?php 
	if ($_REQUEST['date']) {
	  $sd = true;
	  if (($total = getNumImages() + getNumAlbums()) > 0) {	
		$searchwords = getSearchDate();		   
	  }
	}
	?>
	<div id="sd-wrapper">	
	<div id="gallerytitle" style="margin-bottom: 30px;">
   		<h2>
		<span class="linkit">
		<a href="<?php echo getGalleryIndexURL(false);?>"><?php echo getGalleryTitle();?></a>
		</span>
		<?php if ( $sd ) { ?>
			<span class="linkit">		
				<a href="<?php echo getGalleryIndexURL(false);?>?p=archive">Archives</a>
			</span>
			<span class="albumtitle"><span><?php echo getSearchDate(); ?> </span></span>
		<?php } else {?>
			<span class="albumtitle"><span>Archives</span></span>
		<?php } ?>
		</h2>
	</div>
    
    <div id="padbox">
	
		<?php if ( isset($searchwords) ) { ?>

		<div id="images">
			<?php while (next_image(false, $firstPageImages)): ?>
			<div class="image">
				<div class="imagethumb">
					<a href="<?php echo getImageLinkURL(); ?>">
						<?php printImageThumb(getImageTitle()); ?>
						
					</a>
				</div>
			</div>
			<?php endwhile; ?>
			<div style="clear:both;"/>
		</div>
		<?php
			echo '<div id="images-nav" style="margin-bottom: 10px;">' ;
			printPageListWithNav("&laquo; prev","next &raquo;") ;
			echo "</div>";
		  } else {
		?>

	<div id="padbox">
		<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-jutify: newspaper; margin-top: 10px; padding: 40px 60px 40px 60px;">
			<div style="text-align:center; font-size: 15px; color: #666; font-weight: bold;padding: 20px;">
				<?php if ( $sd ) { ?>
				<p>How unlucky you are! Your search were unfruitful</p>
				<p><a href="<?php echo getGalleryIndexURL(false);?>?p=archive"><img class="rabbit" src="<?= $_zp_themeroot ?>/images/rabbit-sigh.png"/></a></p>
				<p>The rabbit's advice: refine your search you should</p>
				<?php } else { ?>
				<p>Do you believe it? The rabbit needs a date</p>
				<p><a href="<?php echo getGalleryIndexURL(false);?>?p=archive"><img class="rabbit" src="<?= $_zp_themeroot ?>/images/rabbit-woops.png"/></a></p>
				<p>The rabbit says: you cannot trick me, dear</p>
				<?php } ?>
			</div>
	  	</div>
	</div>

		<?php 
			}    	
	    ?> 

	</div>
	</div>
</div>

<div id="credit"><?php printRSSLink('Gallery', '', 'Gallery RSS', ' | ', false); ?> <a href="<?php echo rewrite_path(urlencode(ZENPAGE_NEWS), '/index.php?p=pages&title=credits');?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

</body>
</html>
