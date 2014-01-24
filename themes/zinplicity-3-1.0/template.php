<?php 
	//ob_start('ob_gzhandler');

	$tileSet = TileSet::get();
	if ( !isset($tileSet) ):
		$tileSet = TileSet::init(null, null);
	endif;

	if ( $_REQUEST['xr'] == 'true' ) {
		//process ajax request and exit
		$tileSet->process('content');
		return;
	}

	if ( Utils::exists('custom/menus/menus.php') ) require_once('custom/menus/menus.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?= $tileSet->getTitle() ?></title>

		<link rel="stylesheet" type="text/css" href="<?= getCustomPageURL('css') ?>" media="screen" />

		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/ie7.css" media="screen" />
		<![endif]-->

		<noscript>
			<style>
				#album-slideshow-link {
					display: none;
				}
				#slideshowpage {
					display: none;
				}
			</style>
		</noscript>

	</head>

	<body>

		<div id="wrap">
			
			<!-- just some pointless decoration -->
			<div id="main-dash">&nbsp;</div>
			<div id="main-scissors"><img src='<?= $_zp_themeroot ?>/resources/images/scissors.png' /></div>
			<div id="main-sun">&nbsp;</div>
			
			<!-- banner and menus -->
			<div id="header">
				<?= Menu::secondary()->write() ?>
				<div id="header-content"><?= getGalleryTitle() ?></div>
				<?= Menu::main()->write() ?>
			</div>

			<!-- page content -->
			<div id="content"><?php $tileSet->process('content'); ?></div>

			<!-- footer as in... "page footer" ? -->
			<div id="footer" class="header-footer">
				<div id="footer-content">powered by <a href="http://zenphoto.org">zenphoto</a></div>
			</div>
		</div>
	</body>
	
	<?php Utils::printScripts($tileSet->getName()); ?>

</html>


