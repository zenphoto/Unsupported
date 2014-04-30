<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();
$startTime = array_sum(explode(" ",microtime()));
?>
<!DOCTYPE html>

<html>
<head>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
	
	<script type="text/javascript">
	$(document).ready(function() {
    jQuery('a.gallery').colorbox({photo:true, rel:'gallery', slideshow:true});
    });
	</script>
	
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
	<div id="gallerytitle">
			<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo ('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?></span> <?php printAlbumTitle();?></h2>
		</div>

		( <?php printLinkHTML(getPrevAlbumURL(), "« ".gettext("Prev Album")); ?> | <?php printLinkHTML(getNextAlbumURL(), gettext("Next album")." »"); ?> )

		<hr />
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
	<?php printAlbumDesc(true); ?>
		<br />


	<?php printPageListWithNav("« ".gettext('prev'), gettext('next')." »"); ?>

	<!-- Sub-Albums -->
		<div id="albums">
			<?php while (next_album()): ?>
			<div class="album">
					<div class="albumthumb"><a href="<?php echo htmlspecialchars(getAlbumURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
						<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
						</div>
					<div class="albumtitle">
									<h3><a href="<?php echo htmlspecialchars(getAlbumURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
							<?php printAlbumTitle(); ?></a></h3> <?php printAlbumDate(); ?>
								</div>
						<div class="albumdesc"><?php printAlbumDesc(); ?></div>
				</div>
				<hr />
 		<?php endwhile; ?>
		</div>

		<br />

		<div id="images">
		<?php
		if (function_exists('flvPlaylist') && getOption('Use_flv_playlist')) {
			if (getOption('flv_playlist_option') == 'playlist') {
				flvPlaylist('playlist');
			} else {
				while (next_image()) {
					printImageTitle();
					flvPlaylist("players");
				}

			}
		} else {
			while (next_image()) { ?>
				<div class="image">
					<div class="imagethumb">
							<a class="gallery" href="<?php echo htmlspecialchars(getImageURL());?>" title="<?php echo getBareImageTitle();?>">
							<?php printImageThumb(getAnnotatedImageTitle()); ?></a>
						</div>
				</div>
		<?php
			}
		}
		?>

		<br clear="all" />
		<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
			<div class="rating"><?php if (function_exists('printRating')) printRating(); ?></div>
		</div>


 		<?php printPageListWithNav("« ".gettext('prev'), gettext('next')." »"); ?>

<!-- begin comment block -->
			<?php if (function_exists('printCommentForm')  && getCurrentPage() == 1) {
				printCommentForm();
			}
			?>
<!--  end comment block -->

		<div id="credit">
		<?php printRSSLink('Album', '', gettext('Album RSS'), ' | '); ?> 
		<?php printZenphotoLink(); ?>
		| <?php printCustomPageURL(gettext("Archive View"),"archive"); ?>
		<?php
		if (function_exists('printUserLogin_out')) {
			printUserLogin_out(" | ");
		}
		?>
		<br />
			<?php printf(gettext("%s seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
		</div>
</div>

<?php
zp_apply_filter('theme_body_close');
?>

</body>
</html>
