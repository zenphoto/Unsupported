<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<?php if ( getOption('simplicity2_enable_cf') ): ?>
		<!-- enable chrome frame only if available. do not check for install -->
	    <meta http-equiv="X-UA-Compatible" content="chrome=1">
		<?php else: ?>
	    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">
		<?php endif; ?>

		<?php 
			define('DEPLOY', 1); //change value to disable scripts merging
			//define('PACK', 0); //packing scripts is not functional yet (buggy)

			//setlocale: this shouldn't be necessary
			//this should be taken care of by setThemeDomain
			//obviously we're doing something wrong here
			$locale = ThemeUtil::getUserLocale();
			$encoding = "iso-8859-1"; //"utf-8"
			setlocale(LC_ALL, $locale.'.'.$encoding, $locale);

			setThemeDomain("zinenaboxpacity");

			$siteName = 'Fading Away'; 
			$themeName = '[Zinenaboxpacity]';

			require_once('resources/utils/merge.php');
			require_once("theme_functions.php");
			require_once("TileSet.php");

			$tileSet = TileSet::get();
			if ( !isset($tileSet) ) :
				$tileSet = TileSet::init(null, null);
			endif;
		?>

		<title><?= $tileSet->getTitle() ?></title>

		<?php if ( getOption('simplicity2_enable_fancybox') ) : ?>
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/scripts/fancybox/jquery.fancybox-1.2.6.css" media="screen" />
		<?php else: ?>
		<style>#image-full-preview-container a { cursor: default; }</style>
		<?php endif; ?>
		<link rel="stylesheet" type="text/css" media="all" href="<?= $_zp_themeroot ?>/resources/scripts/selectbox/css/jquery.selectbox.css" />
		<link rel="stylesheet" type="text/css" media="all" 
			  href="<?= $_zp_themeroot ?>/resources/scripts/checkbox/jquery.safari-checkbox-1.3.0b1.css" />

		<link type="text/css" href="<?= $_zp_themeroot ?>/resources/css/layout.css" rel="stylesheet" media="screen" />
		<link type="text/css" href="<?= $_zp_themeroot ?>/resources/css/style.css" rel="stylesheet" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/.css" media="screen" />

		<link rel="stylesheet" type="text/css" href='<?= getCustomPageURL("colors") ?>' media="screen" />

		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/contact.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/overrides.css" media="screen" />
		<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/ie.css" media="screen" />
		<![endif]-->
		<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" href="<?= $_zp_themeroot ?>/resources/css/ie7.css" media="screen" />
		<![endif]-->		

		<title><?php $tileSet->process('title') ?></title>
		
		<script>
			<?php 
				//initialize a few shared options
				echo "var zin = { }; ";
				echo "var DEFAULT_SEARCH_TEXT = '" . DEFAULT_SEARCH_TEXT . "'; \n";
				echo "zin.themeroot = '" . $_zp_themeroot . "'; ";
				echo "zin.enableMousewheel = " . (getOption('simplicity2_enable_mousewheel') ? "true" : "false") . ";"; 
				echo "zin.enableKeyNavigation = " . (getOption('simplicity2_enable_key_nav') ? "true" : "false") . ";";
				echo "zin.mousewheelControlsImages = " . (getOption('simplicity2_mousewheel_image') ? "true" : "false") . ";";
				echo "zin.contactIsModal = " . (getOption('simplicity2_contact_is_modal') ? "true" : "false") . ";";
			?>
		</script>

		<?php zenJavascript(); ?>

		<?php ThemeUtil::printScriptLinks(); ?>
		
		<?php PersonalityUtil::setupPersonality(); ?>
	
	</head>
	<body>
		<?php if ( getOption('simplicity2_use_page_loader') ) : ?>
		<div id="body-loader"><?= getOption('simplicity2_no_js_text') ?></div>
		<?php endif; ?>

<style>

</style>
		<div id="wrap-all" <?= getOption('simplicity2_use_page_loader') ? "style='visible: hidden;'" : "" ?>>
			
			<?php if ( getOption('simplicity2_enable_persona_chooser') ): ?>
			<div id="personality-switch" style="display:none;">
				<div class="title opa40">PERSONALITY</div>
				<div id="persona-qtip" style="display:none;">
					<?php PersonalityUtil::printPersonalities(); ?>
				</div>
				<div id="persona-workaround-non-xml-response" style="display:none"></div>
			</div>	
			<?php endif; ?>
			<script>var disablePersonalityChooser = <?= getOption('simplicity2_enable_persona_chooser') ? "false" : "true" ?></script> 

			<?php if ( getOption('simplicity2_print_album_list') ) : ?>
			<div id="album-menu-box" style="z-index: -5" class="opa40">
				<?php AlbumMenuOverride::printAlbumMenuJump(); ?>
			</div>	
			<?php endif; ?>

			<div id="bottom-border-2"></div>
			<div id="top-spacer" class="opa40"></div>
			<div id="bottom-border-3"></div>

			<div id="container" class="box-shadow">

				<div id="additional-links" class="opa20">		
					<?php include('tiles/additional-links.php'); ?>
				</div>
				<div id="header">
					<div id="theme-id" class="opa40">
						<div class="left opa60">
							<?= getOption('simplicity2_print_theme_id') ? "Simplicity Serie, Vol. II - Zinenaboxpacity" : "&nbsp;" ?>
						</div>
						<?php if ( getOption('simplicity2_allow_search') ) : ?>
						<div class="right">
							<span class="tab search opa40">
								<form>	
									<input name="words" value="<?= DEFAULT_SEARCH_TEXT ?>" id="search_input" size="10" type="text"/>
									<?php if ( getOption('simplicity2_contextual_search') && in_context(ZP_ALBUM) ): ?>								
									<input name="inalbums" value="<?= $_zp_current_album->name ?>" type="hidden" />
									<?php endif; ?>
									<input name="p" value="search" type="hidden" />
									<input type="submit" id="search_submit" value="go" />
								</form>
							</span>
						</div>
						<?php endif; ?>
						<div class="clear"></div>
					</div>
					<div id="banner" class="opa60 shadow">	
						<div class="right" id="gallery-title">
							<?php 
								if ( getOption('simplicity2_print_gallery_title') ) : 
									$star = is_null(getOption('simplicity2_gallery_subtitle')) ? "" : "<span id='header-star'>*</span>";
							
									$title = getGalleryTitle();

									if ( getOption('simplicity2_print_home_menu_item') ) echo $title . $star;
									else echo "<a href='". getGalleryIndexUrl(false) . "'>$title</a> " . $star;
								endif;
							?>
						</div>
					</div>
					<div id="tabs" class="opa60">
						<?php include("tiles/menu.php"); ?>
					</div>
				</div>

				<div id="wrapper">
				
					<div id="navigation">
						<?php $tileSet->process('left'); ?>
					</div>
			
					<div id="content">
						<?php 
						 $tileSet->process('content'); 
						?>
					</div>

					<div class="clear"/>

					<div id="wrapper-mask" class="opa60"></div>
				</div>
			
				<div id="extra" class="opa40">
					<?= getOption('simplicity2_extra_text') ?>
				</div>
		
				<div id="footer" class="opa80">
					<div><?= gettext('Powered by') ?> <a href="http://www.zenphoto.org">zenPhoto</a></div>
					<?php 
						$sub = getOption('simplicity2_gallery_subtitle');
						if ( !is_null($sub) ) :
							echo "<div id='footer-subtitle'>* $sub</div>";
						endif;
					?>
				
					<div></div>
				</div>
			</div>
		
			<div id="left-border"></div>
			<div id="right-border"></div>
			<div id="top-border"></div>
			<div id="bottom-border"></div>

			<div id="left-border-2"></div>

			<!-- todo: extract classes -->
			<div id="bottom-border-4" 
				 style="position: fixed; left: 10px; right: 10px; bottom: 10px; height: 8px; background-color: #999;" class="opa40">
			</div>
			<div id="left-border-4" 
				 style="position: fixed; left: 10px; top: 10px; bottom: 10px; width: 8px; background-color: #999;" class="opa40">
			</div>
		
			<div id="right-border-2" ></div>

		</div>
	</body>
	<?php $tileSet->printScript(); ?> 
	<script>
		$('#body-loader').text("<?= str_replace('"', '\\"', getOption('simplicity2_page_loader_message')) ?>");
		<?= ThemeUtil::$script ?>
		<?php $tileSet->process('init-script'); ?>
		$(window).load(function() {
			<?php if ( getOption('simplicity2_print_album_list') ) : ?>
			$("#album-menu-box select").selectbox({listboxMaxSize: 50});
			$("#album-menu-box").css('z-index', '10002');	
			if ( $.browser.msie ) {
				var style = $.browser.version < 8 ? 'top: -7px; height: 200px; z-index: 10002;' : 'height: 200px; z-index: 10002;';
				$("#album-menu-box").attr('style', style);
			}
			<?php endif; ?>

			<?php if ( getOption('simplicity2_use_page_loader') ): ?>
			$('#body-loader').fadeOut(600);
			$('#wrap-all').fadeIn(600, function() {
				$('#personality-switch').css('display', 'block');
				//messing with body overflow seems to 
				//bother IE8 in compat mode
				//$('body').css('overflow-y', 'auto');
			});
			<?php else: ?>
			$('#personality-switch').css('display', 'block');
			<?php endif; ?>
		});
	</script>
</html>
