<?php if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<?php printHeadTitle(); ?>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/styles/styles.css" type="text/css" />
	<?php printRSSHeaderLink('Gallery','Gallery RSS'); ?>
	
</head>

<body>
	<?php zp_apply_filter('theme_body_open'); ?>


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
		<a href="<?php echo getGalleryIndexURL();?>"><?php echo getGalleryTitle();?></a>
		</span>
		<?php if ( $sd ) { ?>
			<span class="linkit">		
				<a href="<?php echo getGalleryIndexURL();?>?p=archive">Archives</a>
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
			<?php while (next_image()): ?>
			<div class="image">
				<div class="imagethumb">
					<a href="<?php echo getImageURL(); ?>">
						<?php printImageThumb(getImageTitle()); ?>
						
					</a>
				</div>
			</div>
			<?php endwhile; ?>
			<div class="clear"></div>
		</div>
		<div id="tools">
			<?php if (hasPrevPage()) { ?>
			<a href="<?php echo getPrevPageURL(); ?>"><span class="prev"></span></a>
			<?php } else { ?>
				<span class="prev-disabled"></span>
			<?php } ?>	

			<?php if (hasNextPage()) { ?>
			<a href="<?php echo getNextPageURL(); ?>"><span class="next"></span></a>
			<?php } else { ?>
				<span class="next-disabled"></span>		
			<?php } ?>
		</div>
		
		<?php  } else { ?>

	<div id="padbox">
		<div class="imageit newsbody" style="color: #ddd;text-align: justify; text-jutify: newspaper; margin-top: 10px; padding: 40px 60px 40px 60px;">
			<div style="text-align:center; font-size: 15px; color: #666; font-weight: bold;padding: 20px;">
				<?php if ( $sd ) { ?>
				<p>How unlucky you are! Your search were unfruitful</p>
				<p><a href="<?php echo getGalleryIndexURL();?>?p=archive"><img class="rabbit" src="<?php echo $_zp_themeroot ?>/images/rabbit-sigh.png" /></a></p>
				<p>The rabbit's advice: refine your search you should</p>
				<?php } else { ?>
				<p>Do you believe it? The rabbit needs a date</p>
				<p><a href="<?php echo getGalleryIndexURL();?>?p=archive"><img class="rabbit" src="<?php echo $_zp_themeroot ?>/images/rabbit-woops.png" /></a></p>
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

<div id="credit"><?php printRSSLink('Gallery', '', 'Gallery RSS', ' | ', false); ?> <a href="<?php echo getPageURL('credits'); ?>">Credits</a> | Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album">zenphoto</a></div>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
