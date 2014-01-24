<?php 
	
	class PersonalityUtil {
		static $_request_persona = null;

		static function getPersonality() {
			$persona = $_COOKIE["persona"];

			if ( $persona == '__void__' ) return null;

			if ( isset($persona) && is_dir(SERVERPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/personality/" . $persona) ) {
				return $persona;
			}

			$persona = getOption('simplicity2_personality');

			if ( $persona != '__random__' ) {
				return $persona;
			}

			if ( isset(self::$_request_persona) ) return self::$_request_persona;

			$personas = self::getPersonalities();
			self::$_request_persona = array_rand($personas);

			return self::$_request_persona;
		}

		static function setupPersonality() {
			$persona = self::getPersonality();

			if ( !isset($persona) || trim($persona) == '' ) return;

			ThemeUtil::printStyleSheetLink("personality/$persona/styles.css", "persona", true);
	
			$validBanner = ThemeUtil::exists("/personality/" . $persona . "/banner.png");
			$validFooter = ThemeUtil::exists("/personality/" . $persona . "/footer.png");
			echo "<!-- setting up persona: $persona : $validFooter ; $validBanner -->";
			if ( $validFooter || $validBanner ) {
				echo "<style>\n";
				if ( $validBanner ) {
					$banner = WEBPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/personality/" . $persona . "/banner.png";
					echo "#banner {	\n" .
						 "	background: transparent url($banner) no-repeat 0 -10px; \n" .
						 "} \n";
				}
				if ( $validFooter ) {
					$footer = WEBPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/personality/" . $persona . "/footer.png";
				 	echo "#footer {	\n" .
						 "	background: transparent url($footer) no-repeat 0 -10px; \n" .
						 "} \n" ;
				}
				echo "</style> \n";
			}
		}

		static function getPersonaIconURL($icon, $default) {
			$persona = self::getPersonality();
			if ( !isset($persona) || trim($persona) == '' ) return $default;
	
			$f = "/themes/" . basename(dirname(dirname(__FILE__))) . "/personality/$persona/icons/$icon.png";
			$i = SERVERPATH . $f;
			if ( file_exists($i) ) {
				return WEBPATH . $f;
			}

			return $default;
		}

		static function printPersonalities() {
			$personalities = self::getPersonalities();
			echo "<ul>";	
			echo "<li><span style='padding: 0 5px; margin-right: 5px;" . 
					 "background-color: #fff; border: 1px #666 dotted;'>&nbsp;</span><a persona='__void__' href='" . getCustomPageURL('switch-persona') . 
					 "&persona=__void__'>Great void</a></li>";
			foreach ( $personalities as $persona => $a ) {
				$name = $a['name'];
				$dominant = $a['dominant'];		
				echo "<li><span style='padding: 0 5px; margin-right: 5px;" . 
					 "background-color: $dominant; border: 1px #666 dotted;'>&nbsp;</span><a persona='$persona' href='" . getCustomPageURL('switch-persona') . 
					 "&persona=$persona'>$name</a></li>";
			}
			echo "</ul>";
		}

		static function getPersonalities() {
			$theme = $theme = basename(dirname(dirname(__FILE__)));
			$root = SERVERPATH . "/themes/$theme/personality";
			$curdir = getcwd();
			chdir($root);
			$filelist = safe_glob('*');
			$list = array();
			foreach($filelist as $file) {
				if ( is_dir($file) && $file != '.' && $file != '..' ) {
					$internal = filesystemToInternal($file);
				
					//ignore __random__ and __void__ folders: it is a 'reserved' word
					//ignore _template folder: we donot want to consider it
					if ( $internal == '__random__' || $internal == '_template' || $internal == '__void__' ) continue;

					//properties file is mandatory
					if ( !file_exists("$root/$file/persona.properties") ) continue;
					$props = new Properties();
					$props->load(file_get_contents("$root/$file/persona.properties"));
					$name = $props->getProperty('name');

					//name is mandatory
					if ( !isset($name) ) continue;

					$dominant = $props->getProperty('dominant', '#fff');
					$disabled = $props->getProperty('disabled');

					//if persona marked as disabled, ignore it
					if ( $disabled != 'true' ) { 
						$list[$internal] = array('name' => $name, 'dominant' => $dominant);
					}
				}
			}
			chdir($curdir);
			return $list;
		}

		static function getPersonaIconList($persona) {
			$list = array();

			if ( !isset($persona) || trim($persona) == '' ) return $list;

			$theme = $theme = basename(dirname(dirname(__FILE__)));
			$root = SERVERPATH . "/themes/$theme/personality/$persona/icons";
			$curdir = getcwd();
			chdir($root);
			$filelist = safe_glob('*.png');

			foreach($filelist as $file) {
				$internal = filesystemToInternal($file);		
				$list[] = $internal;
			}

			chdir($curdir);
			return $list;
		}

		static function printPersonalityIconSwitcher($icon, $target=NULL) {
			global $_zp_themeroot;
			if ( !isset($target) ) $target = $icon . "-icon";

			echo "<script>".
				 "$(window).load(function() { " .
				 "	$('#personality-switch').bind('setpersona', function(event, p, icons) { " .
				 "		if ( icons['home'] ) { " .
				 "			$('#$target').attr('src', '$_zp_themeroot/personality/' + p + '/icons/$icon.png'); " .
				 "		} " .
				 "	}); " .
				 "}); " .
				 "</script>";
		}

		static function includePersonalityFile($file) {
			$persona = getPersonality();
			if ( !isset($persona) || trim($persona) == '' ) return;

			$m = SERVERPATH . "/themes/" . basename(dirname(dirname(__FILE__))) . "/personality/$persona/$file";
			if ( file_exists($m) ) {
				include($m);
			}
		}
	}
?>
