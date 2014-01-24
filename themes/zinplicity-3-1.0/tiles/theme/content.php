<?php 
	global $_zp_themeroot; 
	$tiledir = Utils::getTileDirWebPath();
?>
<div>
	<div id="page-body">
		<div id="page-desc" class="Theme">
			<div id="theme-name">Zinplicity Serie, Vol. III - Zun: beyond the box</div>
			<div>A few notes about this theme. Previous themes can also be downloaded <a href="#nosupport">here</a>.</div>
		</div>
		<div id="page-content" class="Theme">
			<div class="section first">
				<div class="title">Overview</div>
				<div class="par">
					Time ravel is an awful thing and <em>S</em> becomes <em>Z</em> and <em>M</em> becomes <em>N</em>. We just grow old.
					<em>Beyond the box</em> is thus the third issue of the Zinplicity serie. 
				</div>
				<div class="par">
					As the previous theme, this one is licensed under the 
					<a href="http://www.perlfoundation.org/artistic_license_2_0">Artistic License 2.0</a> terms.
				</div>
				<div class="par">
					This theme creation has been driven by three main über-requirements that could be summarized in a single word: <em>compactness</em>.
					I wanted it to be:
					<ul>
						<li>as compact as possible - visually wise</li>
						<li>user-friendly - minimize user input</li>
						<li>lightweight - spare the user bandwidth</li>
					</ul>
				</div>
				<div class="par">
					<em>Beyond the box</em> scores over 90 with both <a href="http://code.google.com/intl/fr/speed/page-speed/">PageSpeed</a> 
					and <a href="http://developer.yahoo.com/yslow/">YSlow</a> using the small site ruleset.
				</div>
				<div class="par" id="download">
					<a href="http://gdodinet.free.fr/upload/zinplicity-3-1.0.tar.gz">
						Download <em>Beyond the box</em>
						<img src="<?= $_zp_themeroot ?>/resources/images/download.png" />
					</a>
				</div>
			</div>
			<div class="section">
				<div class="title">Main features</div>
				<div class="par">
					<ul>
						<li>Template-based theme</li>
						<li>Merged Gallery, Album and Image pages</li>
						<li>Merged Search and Archive pages</li>
						<li>Ajax candy for the mass with history support</li>
						<li>Easy menu and look-and-feel customization</li>
					</ul>
				</div>
			</div>
			<div class="section">
				<div class="title">Compatibility</div>
				<div class="par">
					This theme should be compatible with all zenphoto versions from 1.2.6 up to the latest one, however I only run it against 
					the 1.2.6 version tailored for free.fr and the 1.2.9 released version. Please note, however, that the theme has not been tested 
					with mod_rewrite enabled.
				</div>
				<div class="par">
					This theme has also been tested (not so thoroughly, though) against a wide variety of browsers under both Linux (Ubuntu) and Windows (XP).
					No issue has been found so far. Known compatible browsers are:
				</div>
				<div class="par" id="compatibility">
				<?php 
					$browsers = array(
						'ie' => array('7; 8', NULL), 
						'safari' => array('4.0', NULL), 
						'firefox' => array('3.6', '3.6'), 
						'chrome' => array('4.1' ,'5.0'), 
						'opera' => array('10.5', '10.1'),
						'chromium' => array(NULL,'6.0'), 						
						'konqueror' => array(NULL, '4.3'), 
						'epiphany' => array(NULL, '2.28'),
						'midori' => array(NULL, '0.1.9'));
					$r1 = '<td>&nbsp;</td>'; 
					$r2 = "<td><img title='$b' width='16' height='16' src='$_zp_themeroot/resources/images/compat/windows.png'/></td>"; 
					$r3 = "<td><img title='$b' width='16' height='16' src='$_zp_themeroot/resources/images/compat/linux.png'/></td>"; 
					foreach ( $browsers as $b => $v):
						$r1 .= "<td><img title='$b' width='24' height='24' src='$_zp_themeroot/resources/images/compat/$b.png'/></td>"; 
						$v1 = $v[0] ? $v[0] : "&nbsp;"; $v2 = $v[1] ? $v[1] : "&nbsp;"; 
						$cls1 = ($v[0] ? "" : " na"); $cls2 = ($v[1] ? "" : " na");
						$r2 .= "<td class='version$cls1'>$v1</td>";
						$r3 .= "<td class='version$cls2'>$v2</td>";
					endforeach;
					echo "<table style='width: 100%;'><tr>$r1</tr><tr>$r2</tr><tr>$r3</tr></table>";
				?>
				</div>
			</div>
			<div class="section">
				<div class="title">Configuration</div>
				<div class="par">
					This theme purposely exposes very few options - just the bare mininum. If you want to customize it, you will have to rely 
					on your own VIM skills.
				</div> 
				<div class="par">
					Please also note that the following general options are statically overriden 
					(see the file <span class="path">&lt;themeroot&gt;/options-override.php</span>): 
					<ul>
						<li>Albums per page (value: 3)</li>
						<li>Images per page (value: 8)</li>
						<li>Articles per page (value: 3)</li>
						<li>Slideshow mode (value: jQuery)</li>
						<li>Slideshow effect (value: slideY)</li>
						<li>Slideshow width (value: 330)</li>
						<li>Allow upscale (value: true)</li>
						<li>Custom index page (value: gallery)</li>
					</ul>
					Any other value may cause weird layouting and behaviour. So alter <a href="#nosupport">at your own risk</a>.
				</div>
			</div>
			<div class="section">
				<div class="title">Customization</div>
				<div class="par">
					I don't feel like writing a lot of text that nobody will read, so instead i'll just give some pointers for the interested readers. 
					Those may also want to check the source for further information.  
					<div class="subsection">
						<div class="title">&gt; Customize the menus</div>
						<div class="par">
							Menu items are defined in <span class="path">&lt;themeroot&gt;/custom/menus/menu.php</span>. By default two menus are defined 
							(<span class="code">Menu::main</span> and <span class="code">Menu::secondary</span>) but you can instantiate a new menu 
							and insert it wherever required in <span class="path">template.php</span>
						</div>
					</div>
					<div class="subsection">
						<div class="title">&gt; Customize the banner</div>
						<div class="par">
							Simply create a banner.png image file into the <span class="path">&lt;themeroot&gt;/custom/images</span> folder. 
							This file should have a dimension of 358x103px. If such a file is not found, the gallery title will be displayed.
						</div>
					</div>
					<div class="subsection">
						<div class="title">&gt; Add a new static page, myPage</div>
						<div class="par">	
							<ul>
								<li>Create a folder <em>myPage</em> under <span class="path">&lt;themeroot&gt;/tiles</span></li>
								<li>Create a file content.php in that folder</li>
								<li>Create a new file <span class='path'>myPage.php</span> in <span class="path">&lt;themeroot&gt;</span></li>
								<li>Invoke the template engine from that file</li>
								<li>See, for example, <span class="path">album.php</span></li>
							</ul>
						</div>
					</div>
					<div class="subsection">
						<div class="title">&gt; Style a static page, myPage </div>
						<div class="par">
							Just create a css file named <span class="path">myPage.css</span> in the myPage folder. Css rules will be merged automagically.
						</div>
					</div>
					<div class="subsection">
						<div class="title">&gt; Add client-side behaviour to a static page</div>
						<div class="par">
							<ul>
								<li>Create a js file <span class="path">myPage.js</span> in the myPage folder</li>
								<li>
									Override the class <span class="code">Zen.theme.Page</span> with a new method myPage. 
									This method will be invoked automatically on page render
								</li>
								<li>See, for example, <span class="path">album.js</span></li>
							</ul>
						</div>
					</div>
					<div class="subsection">
						<div class="title">&gt; Add client-side behaviour to a Zenpage page</div>
						<div class="par">	
							Edit the file named <span class="path">extensions.js</span> - located under 
							<span class="path">&lt;themeroot&gt;/custom/scripts</span> - and equip the object
							<span class="code">Zen.theme.instance.extensions</span> of a new function. 
							The function name must match the zenpage page titlelink (lowercase) and will then be 
							invoked automatically on page render.
							
						</div>
					</div>
					<div class="subsection">
						<div class="title">&gt; Ajax-candify a page</div>
						<div class="par">	
							If you know what <a href="#nosupport">you're doing</a>, you can easily add Ajax candy: the method 
							<span class="code">loadPage</span> in <span class="code">Zen.theme.Page</span> allows to load a page fragment 
							(a concrete tile content) in the <span class="code">#content</span> DOM element 
							(please refer to the file <span class="path">&lt;themeroot&gt;/resources/scripts/theme.js</span>). 
						</div>
						<div class="par">	
							Additionally you can enable history state with JQuery BBQ (already set up). 
							If you don't know what this is all about, you probably don't need it.
						</div>
					</div>
				</div>
			</div>
			<div id="old-themes" class="section">
				<div class="title">Previous themes</div>
				<div class="par">
					Previous themes are still available for download. Please note that i still offer 
					<a name="nosupport">no support</a> for any of the themes i provide.
				</div>
				<div class="par wrapper">
					<div class="old-theme">
						<a href='http://gdodinet.free.fr/upload/zinenaboxpacity-1.0.tar.gz'>
							<img src="<?= $tiledir ?>/theme/images/simplicity_2.jpg" width="70" height="70"/>
						</a>
						<div class='desc'>
							<a href='http://gdodinet.free.fr/upload/zinenaboxpacity-1.0.tar.gz'>Simplicity Serie Vol. II, Zinenaboxpacity</a>. 
							This theme is visually appealing to me. However it is a bandwidth hog, and thus not really suitable for the rather 
							poor free.fr servers.
						</div>
					</div>
					<div class="old-theme">
						<a href='http://gdodinet.free.fr/upload/simplicity.zip'>
							<img src="<?= $tiledir ?>/theme/images/simplicity_1.jpg" width="70" height="70"/>
						</a>
						<div class='desc'>
							<a href='http://gdodinet.free.fr/upload/simplicity.zip'>Simplicity Serie Vol. I, Grey simplicity</a>. 
							This theme is the naked simplicity: almost non existent navigation and pretty poor contextualization -
							purposely.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</div>
