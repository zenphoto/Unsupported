<?php global $_zp_themeroot; ?>
<div id="content-top-filler" class="opa20">
	&nbsp;
</div>

<div id="image-title" class="opa60 shadow">
	<div id="image-title-placeholder" class="right">
		Simplicity Serie Vol. II, Zinenaboxpacity	
	</div>
	<div class="left">
		<img src="<?= $_zp_themeroot ?>/resources/images/brush.png" width="64" height="64"/>
	</div>
	<div class="text left">
		&nbsp;
	</div>
	<div class="clear"></div>
</div>

<style>
.section pre {
	font-family: Courier New, Courier, monospace;
	line-height: 1.5em;
	border: 1px #999 solid;
	padding: 6px;
	background-color: transparent;
	background-color: rgba(255, 255, 255, .15);
}
.section {
	margin-bottom: 16px;
}
.section .content {
	margin-left: 10px;
	margin-top: 6px;
}
.section .title {
	font-size: 12px;
	border-bottom: 1px #777 dotted;
}
.subsection .title {
	border-width: 0;
	font-style: italic;
	margin-bottom: 6px;
}
#page-body {
	margin-top: 24px;
	padding-left: 1px;
	padding-right: 10px; 
	text-align:justify;
}
a.anchor {
	color: #000;
}
.ubertitle {
	margin-bottom: 12px;
	font-weight: bold;
	font-size: 13px;
	margin-top: 32px;
}
.ubertitle.first {
	margin-top: 0;
}
.subsection .title.level3 {
	font-style: normal;
}
#compat-table {
	border-collapse: collapse;
	cell-margin: 0;
	width: 100%;
	background-color: transparent;
	background-color: rgba(255, 255, 255, .15);
}
#compat-table, #compat-table td {
	border: 1px #666 solid;
}
#compat-table td {
	padding: 4px;
}
#compat-table ul {
	margin: 0;
	padding: 0;
	list-style-type: none;
}
#compat-table ul li {
	padding-bottom: 5px;
}
.red {
	color: #8b2f0d;
	font-weight: bold;
}
.green {
	color: green;
	font-weight: bold;
}
td.result.ko {
	width: 135px;
}
</style>

<div>
	<div id="page-body">
		<div class="opa60">
			<div class="ubertitle">Download</div>
			<div class="section">
				<div class="content">
					You can read an awful lot of boring text (that may contain some precious information, though), or you can download 
					the theme <a href="#">here</a> and now. It is released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GPL v2</a> license.
				</div>
			</div>
			<div class="ubertitle first">1. Quick Presentation</div>
			<div class="section">
				<div class="title level1">1. Overview</div>
				<div class="content">
					<p>
						Previous zenphoto themes i've built never were completely generic, and reuse implied to manually modify the provided resources. 
						With Zinenaboxpacity (the theme you're currently viewing) i've tried to remain generic. As a result, quite a number of options are 
						exposed to allow customizing it. This fixed-width theme relies heavily on javascript and ajax, so if javascript is not detected it won't even load. 
						Also, while this theme targets both zenphoto and zenpage, it degrades gracefully if zenpage is not activated.
					</p>
					<p>
						Zinenaboxpacity? When you build something, anything, you have to name it - even just for the sake of naming it. This theme has a boxy 
						appeal (you can actually <em>see</em> the boxes, can't you?) and most of the elements are translucent. Hence the theme name. Other candidates,
						in no particular order, were: Ophely, Hamlet, Boxy Lady, and a few others i've forgotten.
					</p>
				</div>
			</div>

			<div class="section">
				<div class="title level1">2. Main Features</div>
				<div class="content">
					<p>
						<ul>
							<li>
								<em>Template based theme</em>
								<p>
									Homogeneous look-and-feel is garanteed thanks to a template-based layout. 
									Each static page just consists of a mere description of the various parts of the page. 
									All layout information is defined in the single template.php file. 
									A simplistic tile system has been specially crafted for this purpose 
									(see <a href="#addpage">Section 2.1.2</a>, below). <a href="http://phpti.com/">PhpTI</a> could probably have been used instead,	
									but i didn't know it at the time i wrote this theme.
								</p>
							</li>
							<li>
								<em>Ajax-based gallery</em>
								<p>
									This is just presentation sugar, but i actually like it: no page change when browsing news, images and subalbums list.
									Archive page also eats this sweet sugar. Most javascript are merged (not minified) to reduce server load a bit.
								</p>
							</li>
							<li>
								<em>I18N-ready</em>
								<p>
									I may have missed a few strings, but most of them should be translatable. 
									Translation files are provided for en and fr languages.
									Read more about theme translation <a href="http://www.zenphoto.org/2009/03/theming-tutorial/#theme-translations">here</a>..
								</p>
							</li>
							<li>
								<em>Contextual positioning</em>
								<p>
									News and images can only be viewed in their context. There's really no separate image page. Well, actually, there 
									is but it just includes the album page, which takes care of positioning the context correctly (i.e. the album page number). 
								</p>
							</li>
							<li style="margin-bottom: 8px;">
								<em>Personality-aware theme</em>
								<p>
									Theme appearance can be easily customized (the level of difficulty actually depends on your skill and knowledge) by applying a 
	 								<em>personnality</em>. Basically a personnality is: 
									<ul style="margin-bottom: 8px;">		
										<li>a css file, mainly containing colors definition</li> 
										<li>a banner.png file, used in the header</li>
										<li>a footer.png file, used (you guessed it) in the footer</li>
										<li>a set of well-known icons, used in the predefined pages</li>
										<li>a persona.properties file, that provides basic information about the personality</li>					
									</ul>
									Visitors can select their prefered personality (if the option is enabled); the information is then stored in a cookie ad vitam. (experimental feature).
								</p>
							</li>
							<li>
								<em>Image preloading</em>
								<p>Album image are preloaded to try improving user experience.</p>
							</li>
							<li>
								<em>Basic customization levers</em>
								<p>
									A lot of options are exposed to control the theme behaviour. Still, this theme deserves to belong to the <em>Simplicity Serie</em>. 
									Nota: as far as i know, zenphoto doesn't allow to categorize 3rd-party theme options, so option names have been 
									prefixed to emulate categories.
								</p>
							</li>
						</ul>
					</p>
				</div>
			</div>

			<div class="section">
				<div class="title level1">3. Compatibility</div>
				<div class="content">
					<p>
					This theme has been tested with zenphoto 1.2.6 (tailored for free.fr) and 1.2.9 (released version) against various browsers under both Linux (Ubuntu/XFCE) and Windows (XP). Results are summarized below. 
					If noticeable, it is rendered best with webkit-based browsers - but that's just subjective.
					<table id="compat-table" valign="top" border="1px">
						<thead>
							<tr>
								<td>Browser</td>
								<td>Version</td>
								<td width="85px">Platform</td>
								<td>Result</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td rowspan="2" class="green">Firefox</td>
								<td class="green"d>3.6.x</td>
								<td>Linux</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">3.6.x</td>
								<td>Windows</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td rowspan="2" class="green">Chrome</td>
								<td class="green">5.0.x</td>
								<td>Linux</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">4.1</td>
								<td>Windows</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">Safari</td>
								<td class="green">4</td>
								<td>Windows</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">Konqueror</td>
								<td class="green">4.3.2</td>
								<td>Linux</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">Midori</td>
								<td class="green">0.1.9</td>
								<td>Linux</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td rowspan="3" class="green">Opera</td>
								<td class="green">9.64</td>
								<td>Windows</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
										<li>No shadow-box</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">10.51</td>
								<td>Windows</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">10.10</td>
								<td>Linux</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
										<li>No shadow-box</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td rowspan="5" class="green">IE</td>
								<td class="green">8</td>
								<td>Windows</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
										<li>
											No shadow-box
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">8</td>
								<td>Windows (<a href="http://code.google.com/chrome/chromeframe/">Chrome frame</a>)</td>
								<td class="result ok">
									<ul>
										<li>OK</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="green">7</td>
								<td>Windows (Compat. mode)</td>
								<td class="result ok">
									<ul>
										<li>Disabled</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td style="font-weight: bold;">7</td>
								<td style="font-weight: bold;">Windows</td>
								<td class="result ok">
									<ul>
										<li style="font-weight: bold;">Not tested</li>
									</ul>
								</td>
							</tr>
							<tr class="red">
								<td>7</td>
								<td>Linux (Wine)</td>
								<td class="result ko">
									<ul>
										<li>KO</li>
										<li>No Ajax support</li>
										<li>No opacity support</li>
										<li>No shadow box</li>		
										<li>No text shadow</li>		
									</ul>
								</td>
							</tr>
							<tr class="red">
								<td>Epiphany</td>
								<td>2.28.0</td>
								<td>Linux</td>
								<td class="result ko">
									<ul>
										<li>KO</li>
										<li>Incorrect resize</li>
										<li>Blurry text shadow</li>
										<li>No shadow box</li>		
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
					</p>
				</div>
			</div>

			<div class="section">
				<div class="title level1">4. Limitations and known issues</div>
				<div class="content">
					<p>
						First, please note that this theme has not been tested with mod_rewrite on, and that the admin toolbox has not been tested at all. That being 
						said a few limitations and issues should be pointed out.
						<ul>
							<li>
								<em>Non homogeneous albums</em> (mixed albums), containing subalbums and images, are not supported: if there are subalbums, no image thumbs are displayed. 
								Thus non homogeneous albums can lead to weird side effects since the navigation bar won't reflect what is actually displayed. Ulterior version 
								may integrate mixed albums.
							</li>
							<li>
								<em>Search</em> does only account for image results. Although the interface layout is ready 
								to integrate album and news results (zp 1.2.9 feature), those are not managed yet.
							</li>
							<li>
								Very few <em>theme plugins</em> are supported. Not amongst them, the slideshow plugin as the theme emulates it (kind of).
							</li>
							<li>
								The <em>rating plugin</em> is supported in a limited way:
								<ul>
									<li>only images can be rated</li>
									<li>the "split stars" feature doesn't seem to work correctly</li>
								</ul>
							</li>
							<li>
								<em>Translation support</em> may not be complete, and, in any case, hasn't been thoroughly tested. For some reason, chains that have actually been translated and processed through poedit do not appear under their translated form.  
							</li>
							<li>
								<em>Comments</em> are only supported on news objects. Adding a new comment is not immediately reflected in the UI (The user has to refresh the page to see it).
							</li>
							<li>
								There may be some glitches on the <em>contact dialog</em> under IE7 (there are in IE7 compatibility mode - which is disabled).
							</li>
							<li>
								Coding wise, there's <em>a little redundancy</em> (this is assumed and won't be fixed) between:
								<ul>
									<li>album/content and album/fetch-thumbs</li>
									<li>search/content and search/fetch-thumbs</li>
								</ul>
							</li>
						</ul>
					</p>
				</div>
			</div>


			<div class="ubertitle">2. Rough documentation</div>
			
			<div class="section">
				<div class="title level1">1. Templating</div>
				<div class="section">
					<div class="content">
						This theme is based upon a simple templating mechanism. All layout information is held into a single template.php file. 
						This template defines a few placeholders. All is left is to create simple mappings to instruct the template how to fill 
						those placeholders. You will see in the next section how these mappings are declared.
					</div>
				</div>
				<div class="content">
					<div class="subsection">
						<div class="title level2"><a class="anchor" name="addpage">1.1 Overview</a></div>
						<div class="content" style="margin-bottom: 16px;">
							<p>
								To handle the mappings the notion of TileSet is introduced. A TileSet actually holds the concrete mappings. It is really just a map of Strings.
								The template file firsts tries to get a reference to a TileSet singleton object (line 1, below). If such an object doesn't exist, it is bluntly created (line 3). Then a placeholder is declared as shown line 4:
								<pre>
&lt;?php
    $tileSet = TileSet::get(); 
    if ( !isset($tileSet) ) :
        $tileSet = TileSet::init(null, null);
    endif;
    $tileSet->process('placeHolderLogicalName');
?&gt;</pre>
								If there's no <em>placeHolderLogicalName</em> in the tileSet's map, nothing is done. Otherwise, 
								if the value associated to <em>placeHolderLogicalName</em> refers to a file, then it is included, 
								else the value is simply outputted. 
							</p>
							<p>
								TileSets definition are held in the tiles.php file located under the $themeroot/tiles folder. It simply declares a map such as:
								<ul>
									<li>the key is the tileSet name</li>
									<li>the values are maps holding the tileSet mapping</li>
								</ul>
								Let's consider the example below.
								<pre>
&lt;?php
    $prefix = "tiles/myPage";
    $tileDefinitions = array(
        "myPage" => array(
            "left" => "$prefix/left.php", 
            "content" => "$prefix/content.php", 
            "script" => "$prefix/script.js", 
            "init-script" => "$prefix/init.php"),
        //... more tile definitions
    );
    TileSet::configure($tileDefinitions);
?&gt;</pre>
								What do we have here? We just declared a tileSet named "myPage". When the template will be processed, 
								the content of "tiles/myPage/left.php" will be injected in the placeholder named "left", and so on. 
								The script logicalName is a bit special and won't be covered here - please refer to the source (template.php and TileSet.php). 
							</p>
							<p>
								As mentionned above, this templating mechanism is quite simplistic, to say the least; so don't expect too much from it. For instance, attentive readers have already spotted that as we use a singleton TileSet object, there's no easy support for recursive templating (although it should be feasible with some hacks, it would probably be not so pretty).
						</div>
					</div>
					<div class="subsection">
						<div class="title level2"><a class="anchor" name="addpage">1.2 Add a page</a></div>
						<div class="content">
							<div class="subsection" style="margin-bottom: 12px;">			
								<div class="title level3">1.2.1 Add a static page</div>
								<div class="content">
								The basics of the template mechanism have been quickly uncovered, and now you're eager to add a new custom page of your own, aren't you? 
								Well, it is really very simple: you just need to:
								<ul> 
									<li>create a file myPage.php (this is how zenphoto works)</li> 
									<li>if relevant, declare the site area (i.e. where the user is)</li>
									<li>instantiate the appropriate TileSet</li>
									<li>include the template.php file</li>
								</ul>
								So a basic myPage.php will look like the following:
								<pre>
&lt;?php
    require_once('theme_functions.php');
    MenuUtil::setArea(THEME_MYPAGE);
    TileSet::init(
        getAlbumTitle(), 
        "myPage");
    include_once('template.php');
?&gt;</pre>  
								Of course, after that you will need to create the php files referenced in the TileSet definition. To help you get started,
								you can copy the tiles/_template folder to tiles/myPage. 
								</div>
							</div>
							<div class="subsection">			
								<div class="title level3">1.2.2 Zenpage page structure</div>
	
								<div>
									Last, it may be worth documenting a bit how zenpage pages are handled. The image below shows how this theme 
									displays a zenpage page and where the various page parts are outputted.
									<div style="margin-top: 10px;" class="opa40"><img style="width: 100%;" src="<?= $_zp_themeroot ?>/tiles/theme/images/page_structure.png"/></div>
								</div>
							</div>
							<div class="subsection">			
						<div class="title level2" style="margin-top: 12px;">2.1 Refine menus</div>
						<div class="content">
							<p >
								Menus can be easily customized without hacking the template. Two levels of menu are available: 
								<ul>
									<li>the main menu (the one with the big-oh buttons)</li>
									<li>and a more discreet one, on the upper top</li>
								</ul>
								The "Home" button can be disabled on the option page. "Gallery" and "News" buttons are always present.
							</p>
							<div class="subsection" style="margin-top: 8px;">
								<div class="title level3">2.1.1 Main menu</div>
								<p>
									New buttons are automatically appended to the main menu if a <em>menu.php</em> file is present in the <em>menus</em> folder. For instance, 
									if you want to add two new buttons, respectively linking to a static page, say myPage.php, and a zenpage page, say 
									myZpPage, your menu.php would look like the following:
									<br/><br/>
									<pre>
&lt;?php
	//link to a custom page 
	MenuUtil::printMenuItem(
	    getCustomPageURL("myPage"), 
	    gettext("Button text 1"), 
	    THEME_MYPAGE); 

	//link to a zenpage page 
	MenuUtil::printMenuPageLink(
	    "myZpPage", 
	    gettext('Button text 2'));
?&gt;</pre>
								</p>
								<p style="margin-bottom: 8px;">
									The third parameter of <em>printMenuItem</em> is optional and can be used to 
									give the visitor a hint of where he is (see also area-definitions.php, in the theme root folder).
								</p>
							</div>
							<div class="subsection">
								<div class="title level3">2.1.1 Secondary menu</div>
								<p>
									New items are automagically added in the secondary menu if a file <em>secondary.php</em>, similar
									to the previously presented menu.php, is present in the <em>menus</em> folder. If you want 
									to add a link to myPage in the upper menu just add a line in your secondary_links.php 
									file as described below:
									<pre>
&lt;?php
	//link to a custom page 
	MenuUtil::printSecondaryLinkItem(
	    'dom-element-id', 
	    getCustomPageURL("myPage"), 
	    gettext('Secondary link text'), 
	    THEME_MYPAGE); 

	//link to a zenpage page
	MenuUtil::printSecondaryPageLinkItem(
	    'dom-element-id-2',
	    "myZpPage",
	    gettext('Secondary link text 2'))
?&gt;</pre>
								</p>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>
			</div>


			<div class="section">
				<div class="title level1">2. Personalities</div>
				<div class="content">
					<p>
						Personalities are a way of tweaking the default theme appearance (identification images and color scheme).
						By default no personality is applied. You will need to explicitely activate a personality on the theme options page. 
						To add a new personality, just create a folder under <em>$themeroot/personality</em> and create the required resources as described below.
					</p>	
					<div class="subsection" style="margin-bottom: 8px;">			
						<div class="title level2">2.1 Configuration</div>					
						<p>						
							A personality will be only be recognized if a <em>persona.properties</em> file exists. 
							This file needs only to contain a <em>name</em> property, 
							which is a human-friendly string identifier of the personality. 
							Additionally two more properties are recognized: (i) <em>dominant</em>, which is a hex or rgb(a) color representation, 
							and (ii) <em>disabled</em>; if disabled is set to true, the personality will be ignored. The dominant property is only 
							used if user personality selection is enabled.
						</p>
						<p>
							This theme comes with three personalities:
							<ul>
								<li>A light and sober one, <em>Brown dust</em>, for delicate souls</li>
								<li>A greenish one, <em>Green wash</em>, for those ecologist freaks</li>
								<li>A dark one, <em>Gray stone</em>, for gloomy people</li>
							</ul>
							Personality can also be configured to be randomly chosen. Note that if visitors are allowed to choose their preferred personality, their choice
							prevails.
						</p>
					</div>
					<div class="subsection">			
						<div class="title level2">2.2 Change identification images</div>
						<div class="content">
							<p>
								Changing banner and footer image is as simple as dropping, respectively, a banner.png and a footer.png file in the personnality folder. 
								They will be detected and applied automatically. Additionnally, the gallery title can be disabled in the option page if you want
								the banner image to hold the gallery title.
							</p>
						</div>
					</div>
					<div class="subsection">			
						<div class="title level2">2.3 Alter the color scheme</div>
						<div class="content">
							<p>
								Altering the color scheme requires a little css knowledge - the bare minimum actually. If a styles.css file is present in 
								the personality folder it will used automatically. See the provided personality css files for an example.
							</p>
						</div>
					</div>
					<div class="subsection">			
						<div class="title level2">2.4 Change icons</div>
						<div class="content">
							<p>
								Personalities can also provide their own icons; if found they are automatically used. To expose custom icons, 
								a personality just needs to have a folder named <em>icons</em> containing 64x64 png images. Those images 
								must have specific names as shown below (case matters). Right now icons that can be customized are:
								<ul>
									<li>Home page icon: home.png</li>
									<li>RSS icon: rss.png</li>
									<li>Search icon: search.png</li>
									<li>Archive icon: archive.png</li>
									<li>Lock icon: lock.png</li>
									<li>Contact icon: contact.png</li>
								</ul>
								
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="section">
				<div class="title level1">3. Options</div>
				<div class="content">
					All options are documented in the Admin/Options/Theme page and should be self-explanatory.
				</div>
			</div>			

			<div class="ubertitle">3. Installation</div>
			<div class="section">
				<p>
					<ul>
						<li>Drop the theme in your themes folder, and simply set the Custom Index Page option to 'gallery' (in Options/Themes/Standard)
					(or create a custom page for your index page - see section 2.1.2)</li>
						<li>Configure the theme: there are an awful lot of opitons, but with convenient defaults - fortunately</li>
						<li>No hard recommendation, but i think this theme renders well with: 
							<ul>	
								<li>4 albums per page</li>
								<li>6 images per page</li>
								<li>4 news per page</li>
							</ul>
						</li>
					</ul>
					Nota: thumbnail size option is not taken into account (custom thumbnail size is hardcoded).		
				</p>
			</div>	

			<div class="ubertitle">4. What's Next?</div>
			<div class="section">
				<p>
					Not much, really. For you: download and install the theme, test it, stress it, <a href="<?= getCustomPageURL('contact') ?>">report</a> and fix issues you find; for me: well, nothing, i guess. 
				</p>
			</div>	
		
		</div>
	</div>	
</div>



