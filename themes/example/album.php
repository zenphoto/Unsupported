<?php
if (!defined('WEBPATH')) die();
$startTime = array_sum(explode(" ",microtime()));
?>
<?php
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
header('Content-Type: text/html; charset=' . getOption('charset'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
	
	<script type="text/javascript">
	$(document).ready(function() {
    jQuery('a.gallery').colorbox({photo:true, rel:'gallery', slideshow:true});
    });
	</script>
	
</head>
<body>

<div id="main">
	<div id="gallerytitle">
			<h2><span><?php printHomeLink('', ' | '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo ('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> | <?php printParentBreadcrumb(); ?></span> <?php printAlbumTitle(true);?></h2>
		</div>

		( <?php printLink(getPrevAlbumURL(), "« ".gettext("Prev Album")); ?> | <?php printLink(getNextAlbumURL(), gettext("Next album")." »"); ?> )

		<hr />
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
	<?php printAlbumDesc(true); ?>
		<br />


	<?php printPageListWithNav("« ".gettext("prev"), gettext("next")." »"); ?>

	<!-- Sub-Albums -->
		<div id="albums">
			<?php while (next_album()): ?>
			<div class="album">
					<div class="albumthumb"><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
						<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
						</div>
					<div class="albumtitle">
									<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
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
							<a class="gallery" href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>">
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


 		<?php printPageNav("« ".gettext("prev"), "|", gettext("next")." »"); ?>

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
			<?php printf(gettext("%u seconds"), round((array_sum(explode(" ",microtime())) - $startTime),4)); ?>
		</div>
</div>

<?php printAdminToolbox(); ?>

</body>
</html>
