<?php global $_zp_themeroot; ?>
<link type="application/rss+xml" rel="alternate" href="<?php echo m9GetRSS('gallery'); ?>" title="<?php echo html_encode(getMainSiteName()); ?> + RSS" />
<link type="text/css" rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/reset.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" />
<?php zp_apply_filter('theme_head'); ?>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="doc-type" content="Web Page" />
<meta name="doc-class" content="Published" />
<meta name="doc-rights" content="Copywritten Work" />
<meta name="doc-publisher" content="<?php echo html_encode(getMainSiteName()); ?>" />
<meta name="author" content="<?php echo html_encode(getMainSiteName()); ?>" />
<meta name="designer" content="<?php echo html_encode(getMainSiteName()); ?>" />
<meta name="copyright" content="<?php echo html_encode(getMainSiteName()); ?>" />
<meta name="generator" content="Zenphoto <?php printVersion(); ?>" />
<meta name="robots" content="index, follow" />
<meta name="language" content="en" />