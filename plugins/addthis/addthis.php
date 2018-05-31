<?php
/**
 * Plugin to add the social sharing and analytics tools from http://www.addthis.com.
 * Place printAddThis() in your theme where you want it to appear.
 * @author oswebcreations.com (gjr)
 * @package plugins
 */

$plugin_is_filter = 13|THEME_PLUGIN;
$plugin_description = gettext("Plugin to add the social sharing and analytics tools from http://www.addthis.com.");
$plugin_author = 'oswebcreations.com (gjr)';
$plugin_version = '1.4.4';
$option_interface = 'addthisOptions';

zp_register_filter('theme_head', 'addthisJS');

/**
 * Plugin option handling class
 */
class addthisOptions
{

    function addthisOptions()
    {
        setOptionDefault('addthis_style', 'Style1');
        setOptionDefault('addthis_profileID', '');
        setOptionDefault('addthis_ga', '');
    }

    function getOptionsSupported()
    {
        return array(
        gettext('Profile ID') => array('key' => 'addthis_profileID', 'type' => OPTION_TYPE_TEXTBOX,
                                        'desc' => gettext("Enter your addthis profile ID in order to utilize the analytics feature. See addthis.com for more info.  Simply leave blank to not use this feature.")),
        gettext('Google Analytics ID') => array('key' => 'addthis_ga', 'type' => OPTION_TYPE_TEXTBOX,
                                        'desc' => gettext("Enter your Google Analytics ID to integrate analytics into your GA account.  Simply leave blank to not use this feature.")),
        gettext('Style') =>array('key' => 'addthis_style', 'type' => OPTION_TYPE_RADIO,
                                        'buttons' => array(
                                            '<img src="'.WEBPATH.'/plugins/addthis/style1.jpg" alt="Style1" />' => 'Style1',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style2.jpg" alt="Style2" />' => 'Style2',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style3.jpg" alt="Style3" />' => 'Style3',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style4.jpg" alt="Style4" />' => 'Style4',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style5.jpg" alt="Style5" />' => 'Style5',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style6.jpg" alt="Style6" />' => 'Style6',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style7.jpg" alt="Style7" />' => 'Style7',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style8.jpg" alt="Style8" />' => 'Style8',
                                            '<img src="'.WEBPATH.'/plugins/addthis/style9.jpg" alt="Style9" />' => 'Style9'
                                            
                                        ),
                                        'desc' => gettext('Select your preferred style. This selected style will be used when calling the function in your theme.  You can also override this setting directly by entering the style in the function parameter (Style1 - Style9).'))
        
        );
    }
}

function addthisJS()
{
    if ((getOption('addthis_profileID')) != '') { ?>
    <script type="text/javascript">
        var addthis_config = {
            <?php if (getOption('addthis_ga') != '') { ?>
            data_ga_property: '<?php echo getOption('addthis_ga'); ?>',
            data_ga_social : true,
            <?php } ?>
            pubid: '<?php echo getOption('addthis_profileID'); ?>'  
        }
    </script>
    <?php } ?>
    <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js<?php if ((getOption('addthis_profileID')) != '') {
        echo '#pubid='.getOption('addthis_profileID');
} ?>"></script>
    <?php if (getOption('addthis_ga') != '') { ?>
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo getOption('addthis_ga'); ?>']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
    <?php }
}

/**
 * Prints addthis social sharing tools based upon style selection in options.
 * You can override the style by entering the style in the function call parameter directly in the theme.
*/
function printAddThis($style = '')
{
    if ($style == '') {
        $style = getOption('addthis_style');
    }
    if ($style == '') {
        $style = 'Style1';
    }
    switch ($style) {
        case 'Style1':
            echo
            '<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
			<a class="addthis_button_compact"></a>
			<a class="addthis_counter addthis_bubble_style"></a>
		</div>';
            break;
        case 'Style2':
            echo
            '<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
			<a class="addthis_button_compact"></a>
			<a class="addthis_counter addthis_bubble_style"></a>
		</div>';
            break;
        case 'Style3':
            echo
            '<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_tweet"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_counter addthis_pill_style"></a>
		</div>';
            break;
        case 'Style4':
            echo
            '<div class="addthis_toolbox addthis_default_style ">
			<a href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-4f01d84f22aedb84" class="addthis_button_compact">Share</a>
			<span class="addthis_separator">|</span>
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
		</div>';
            break;
        case 'Style5':
            echo
            '<div class="addthis_toolbox addthis_default_style ">
			<a href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-4f01d84f22aedb84" class="addthis_button_compact">Share</a>
		</div>';
            break;
        case 'Style6':
            echo
            '<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_counter"></a>
		</div>';
            break;
        case 'Style7':
            echo
            '<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_counter addthis_pill_style"></a>
		</div>';
            break;
        case 'Style8':
            echo
            '<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>';
            break;
        case 'Style9':
            echo
            '<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300"><img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a>';
            break;
        default:
            echo
            '<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
			<a class="addthis_button_preferred_1"></a>
			<a class="addthis_button_preferred_2"></a>
			<a class="addthis_button_preferred_3"></a>
			<a class="addthis_button_preferred_4"></a>
			<a class="addthis_button_compact"></a>
			<a class="addthis_counter addthis_bubble_style"></a>
		</div>';
    }
} ?>
