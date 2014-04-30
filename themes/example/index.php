<?php

// force UTF-8 Ø

if (!defined('WEBPATH')) die();

?>
<!DOCTYPE html>

<html>
<head>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot ?>/zen.css" type="text/css" />
	<?php zp_apply_filter('theme_head'); ?>
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
<?php zp_apply_filter('theme_body_open'); ?>

<div id="main">
		<div id="gallerytitle">
			<h2><?php printHomeLink('', ' | '); echo getGalleryTitle();?></h2>
			<?php	if (getOption('Allow_search')) {  printSearchForm(); } ?>
		</div>

		<hr />
		<?php printPageListWithNav("« ".gettext('prev'), gettext('next')." »"); ?>

		<div id="albums">
			<?php while (next_album()): ?>

 			<div class="album">
					<div class="albumthumb">
							<a href="<?php echo htmlspecialchars(getAlbumURL());?>" title="<?php echo getAnnotatedAlbumTitle();?>">
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
		<?php printPageListWithNav("« ".gettext('prev'), gettext('next')." »"); ?>
		<?php if (function_exists('printLanguageSelector')) { printLanguageSelector(); } ?>
		<div id="credit">
		<?php
		if (function_exists('printUserLogin_out')) {
			printUserLogin_out('', ' | ', true);
		}
		?>
		<?php printRSSLink('Gallery','','RSS', ' | '); ?> 
		<?php printCustomPageURL(gettext("Archive View"),"archive"); ?> |
		<?php	if (function_exists('printContactForm')) { printCustomPageURL(gettext('Contact us'), 'contact', '', '', ' | '); } ?>
		<?php if (!zp_loggedin() && function_exists('printRegistrationForm')) printCustomPageURL(gettext('Register for this site'), 'register', '', '', ' | ');	?>
		<?php printZenphotoLink(); ?>
		</div>
</div>

<?php
zp_apply_filter('theme_body_close');
?>
</body>
</html>
