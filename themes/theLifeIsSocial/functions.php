<?php

function getFormattedMainSiteName($pref = '', $suf = '') {
	if (getMainSiteName() != '') {
		return $pref . getMainSiteName() . $suf;
	} else {
		return '';
	}
}

function getGalleryTitleHeader() {
	return '<h1>' . getGalleryTitle() . '</h1>';
}

function getGalleryLogo() {

}

function printThemeMenu() {
	echo '<ul class="menu main">';
	if (getMainSiteName() != '') {
		echo '<li><a href="' . getMainSiteURL() . '" title="' . getMainSiteName() . '">' . getMainSiteName() . '</a></li>';
	}
	echo '<li><a href="' . getGalleryIndexURL() . '" title="' . getGalleryTitle() . '">' . getGalleryTitle() . '</a></li>';
	if (function_exists('printNewsIndexURL')) {
		echo '<li><a href="' . getNewsIndexURL() . '" title="' . gettext('News') . '">' . gettext('News') . '</a></li>';
	}
	if (function_exists("printPageMenu")) {
		printPageMenu("list-top", "", "menu-active", "", "", '', 0, false, '');
	}
	echo '<li><a href="' . getCustomPageURL('archive') . '">' . gettext('Archives') . '</a></li>';
	echo '</ul>';
}

function printThemeFooter() {
	echo '<ul class="menu footer">';
	if (function_exists('printRegistrationForm') OR function_exists('printUserLogin_out')) {
		if (zp_loggedin() AND function_exists('printUserLogin_out')) {
			echo '<li>';
			printUserLogin_out();
			echo '</li>';
		} else {
			echo '<li><a href="' . getCustomPageURL('login') . '">';
			if (function_exists('printRegistrationForm')) {
				echo gettext('Register');
			}
			if (function_exists('printRegistrationForm') AND function_exists('printUserLogin_out')) {
				echo ' / ';
			}
			if (function_exists('printUserLogin_out')) {
				echo gettext('Login');
			}
			echo '</a></li>';
		}
	}
	if (function_exists('printContactForm')) {
		echo '<li><a href="' . getCustomPageURL('contact') . '">' . gettext('Contact') . '</a></li>';
	}
	echo '</ul>';
}

function getParentBreadcrumbTLS($before = '', $after = '') {
	global $_zp_current_album, $_zp_last_album;

	$parents = getParentAlbums();
	$n = count($parents);

	if ($n > 0) {
		foreach ($parents as $parent) {
			$url = rewrite_path("/" . pathurlencode($parent->name) . "/", "/index.php?album=" . urlencode($parent->name));
			echo $before;
			echo '<li><a href="' . htmlspecialchars($url) . '" class="activ">' . html_encode($parent->getTitle()) . '</a></li>';
			echo $after;
		}
	}
}

function getParentHeaderTitle($before = '', $after = '') {
	global $_zp_current_album, $_zp_last_album;
	$tmp = '';

	$parents = getParentAlbums();
	$n = count($parents);

	if ($n > 0) {
		foreach ($parents as $parent) {
			$tmp .= $before . $parent->getTitle() . $after;
		}
	}

	return $tmp;
}

/**
 * Displays a list of all news in zenphoto
 *
 */
function newsListDisplay() {
	while (next_news()) {
		?>
		<div class="newslist_article">
			<div class="newslist_title">
				<span class="italic date_news"><?php printNewsDate(); ?></span>
				<h4><?php printNewsURL(); ?></h4>
				<div class="newslist_detail">
					<div class="italic newslist_type">
						<?php
						$cat = getNewsCategories();
						if (!empty($cat)) {
							printNewsCategories(", ", gettext("Categories: "), "newslist_categories");
						}
						?>
					</div>
				</div>
			</div>
			<div class="newslist_content">
				<?php printCodeblock(1); ?>
				<?php printNewsContent(); ?>
				<?php printCodeblock(2); ?>
				<?php if (getNewsReadMore()) { ?>
					<p class="italic newslist_readmore">
						<?php
						$readmore = getNewsReadMore($readmore);
						if (!empty($readmore)) {
							$newsurl = getNewsURL();
							echo "<a href='" . $newsurl . "' title=\"" . getBareNewsTitle() . "\">" . html_encode($readmore) . "</a>";
						}
						?>
					</p>
				<?php } ?>
			</div>
		</div>
		<?php
	}
}
?>