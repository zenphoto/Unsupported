<?php
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
	<head>
		<?php include_once('header.php'); ?>
		<meta name="keywords" content="<?php echo html_encode(getFormattedMainSiteName('', ', ').getGalleryTitle()); ?>" />
		<meta name="description" content="<?php echo html_encode(getGalleryDesc()); ?>" />
		<title>
			<?php
			echo strip_tags(getFormattedMainSiteName('', ' / ').getGalleryTitle() . ' / ');
			if( function_exists( 'printRegistrationForm' ) ) {
				echo strip_tags( gettext( 'Register' ) );
			}
			?>
		</title>
	</head>
	<body id="gallery-index">
	<?php zp_apply_filter('theme_body_open'); ?>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<?php echo getGalleryLogo(); ?>
				</div>
				<div id="gallery_title">
					<?php echo getGalleryTitleHeader(); ?>
				</div>
				<?php printSearchForm(); ?>
			</div>
			<div id="menu">
				<?php printThemeMenu(); ?>
			</div>
			<div id="breadcrumb">
				<ul>
				<?php
					getFormattedMainSiteName('<li class="page">', '</li><li class="chevron"> > </li>');
					echo '<li><a href="' . getGalleryIndexURL() . '" class="activ">' . getBareGalleryTitle() . '</a></li>';
					echo '<li class="chevron"><a> &gt; </a></li>';
					echo '<li><a>';
					if( function_exists( 'printRegistrationForm' ) ) {
						echo html_encode( gettext( 'Register' ) );
					}
					if( function_exists( 'printRegistrationForm' ) AND function_exists( 'printUserLogin_out' ) ) {
						echo ' / ';
					}
					if( function_exists( 'printUserLogin_out' ) ) {
						echo html_encode( gettext( 'Login' ) );
					}
					echo '</a></li>';
				?>
				</ul>
			</div>
			<div id="content">
				<div id="logReg">
					<?php
					if( function_exists( 'printRegistrationForm' ) AND function_exists( 'printUserLogin_out' ) ) {
						$class = 'deux';
					} else {
						$class = 'un';
					}
					if( function_exists( 'printRegistrationForm' ) ) {
						echo '<div id="register" class="' . $class . '">';
						printRegistrationForm();
						echo '</div>';
					}
					if( function_exists( 'printUserLogin_out' ) ) {
						echo '<div id="login" class="' . $class . '">';
						printUserLogin_out();
						echo '</div>';
					}
					?>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div id="footer">
					<?php include_once('footer.php'); ?>
			</div>
		</div>
		<?php include_once('analytics.php'); ?>
		<?php zp_apply_filter('theme_body_close'); ?>
	</body>
</html>

