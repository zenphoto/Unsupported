<div id="header">
    <h3 style="float:left; padding-left: 32px;">
        <a href="<?php echo getGalleryIndexURL(false); ?>"><img src="<?php echo $_zp_themeroot; ?>/images/banner.png"/></a>
    </h3>
    <h3 style="float:right; padding-top: 22px;">
        <?php if (getOption('Allow_search')) {  
        $album_list = array($_zp_current_album->name);
        printSearchForm(NULL, 'search', NULL, '   ', $_zp_themeroot . '/images/filter.png', NULL, $album_list);
        } ?>
    </h2>
</div>