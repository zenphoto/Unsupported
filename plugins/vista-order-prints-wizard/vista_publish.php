<?php 
/**

  * Vista Order prints wizard for Zenphoto 0.1
  * - by ChiliFrei64 (2008)
  *
  * Inspired by XP Publishing wizard for ZenPhoto 0.3
  * Copyright (C) 2006 Niels Leenheer
  * AND
  * The XP Publishing wizard from
  * Gallery and Coppermine
  * - Copyright (C) 2003-2006 Coppermine Dev Team
  * - Copyright Gregory Demar
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
  *
  * Updated Niels Leenheer script on 1/13/2007 by ChiliFrei64 to 
  * support new Zenphoto installations 1.1.3 and greater and modified
  * for Windows Vista Order Prints wizard.
  *
  */
  
require_once("zp-core/template-functions.php"); 
require_once("zp-core/admin-functions.php");
$cmd = empty($_GET['cmd']) ? '' : $_GET['cmd'];
$xp = new xpPublish();

if ($cmd == 'publish') {
	$xp->logout();
	$xp->handleCmd('login');
	exit;
}

$xp->authorize();

if (!zp_loggedin() && $cmd && $cmd != 'regedit') $cmd = 'login';
if (isset($_POST['user'])) $cmd = 'process_login';

$xp->handleCmd($cmd);




class xpPublish {

	/* Wizard buttons */
	var $buttonsEnableBack = false;
	var $buttonsEnableNext = false;
	var $buttonsLastServerSidePage = false;

	/* Default actions */
	var $onBack = 'window.external.FinalBack();';
	var $onNext = 'window.external.FinalNext();';
	var $onCancel = '';

	function xpPublish() {
	}
	
	function handleCmd($cmd) {
		switch ($cmd) {
			case 'regedit':
				$this->send_reg_file();
				break;
			case 'login':
				$this->form_login(); 
				break;
			case 'process_login':
				$this->process_login();
				break;
			case 'album':
				$this->form_album();
				break;
			case 'finish':
				$this->form_finish();
				break;
			case 'upload':
				$this->form_upload();
				break;
			default:
				$this->explaination();
				break;
		}
	}
	
	function explaination() {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>zenphoto xp publishing wizard</title>
	<link rel="stylesheet" href="zp-core/admin.css" type="text/css" />
	<script type="text/javascript" src="zp-core/admin.js"></script>
</head>
<body>	
<p><img src="zp-core/images/zen-logo.gif" title="Zen Photo" /></p>
  <div id="loginform">
    <p><strong>To use the XP Publishing Wizard you first need to register it with Windows.</strong></p>
	<p>Download the file below and open it.<br />This will add the ZenPhoto XP Publishing Wizard to your copy of Windows XP.</p>
	<p><a href='<?php echo basename(__FILE__); ?>?cmd=regedit'>Download zenphoto.reg</a></p>
  </div>  	
</body>
</html>
<?php
	}
	
	function show_debug($cmd = '') {
		$this->header();

		echo "<p>Command: " . $cmd . "</p>";
		echo "<p>Logged in: " . zp_loggedin() . "</p>";

		$this->buttonsLastServerSidePage = true;
		$this->footer();
	}
	
	function form_upload() {
		if ($_FILES['userpicture']['tmp_name'] != '' &&
			$_FILES['userpicture']['tmp_name'] == 0) {
			
			$folder = strip($_GET['folder']);
        	$uploaddir = SERVERPATH . '/albums/' . $folder;
            $tmp_name = $_FILES['userpicture']['tmp_name'];
            $name = $_FILES['userpicture']['name'];

            if (is_image($name)) {
				$uploadfile = $uploaddir . '/' . $name;
				move_uploaded_file($tmp_name, $uploadfile);
				@chmod($uploadfile, 0777);
            }
		}
	}
	
	function form_finish() {
		if ($_POST['albumselect'] == '' && empty($_POST['folder']))
			return $this->form_publish('Please enter the name of the new album');
		
		if ($_POST['albumselect'] == '' && $_POST['folder'] != '') {
			$folder = strip($_POST['folder']);
        	$uploaddir = SERVERPATH . '/albums/' . $folder;
        
			if (!is_dir($uploaddir)) {
          		mkdir ($uploaddir, 0777);
        	}
        	
			@chmod($uploaddir,0777);

			$gallery = new Gallery();
        	$album = new Album($gallery, $folder);
	        $title = strip($_POST['albumtitle']);

	        if (!empty($title)) {
				$album->setTitle($title);
        	}
		} else {
			$folder = strip($_POST['albumselect']);
		}
		
		$this->header();

		echo '<h2>Just a moment...</h2>';

		$this->buttonsEnableBack = true;
		$this->buttonsEnableNext = true;
		$this->buttonsLastServerSidePage = true;
		$this->footer('startUpload("' . utf8::encode_javascript($folder) . '"); ');
	}
	
	function form_album($message = '') {
      global $gallery;	
	  $gallery = new Gallery();

      $albumlist = array();
      genAlbumList($albumlist);


		$this->header();

		echo '<script language="javascript" type="text/javascript">';
		echo 'window.totalinputs = 5;';
		echo "\n\n";
        echo 'var albumArray = new Array (';
          $separator = '';
          foreach($albumlist as $key => $value) {
            echo $separator . "'" . addslashes($key) . "'";
            $separator = ", ";
          } 
		echo ');';
		echo "\n\n";
		echo '</script>';


		echo '<h2>Select the album you want to use</h2>';
		if ($message != '') echo "<p>" . htmlspecialchars($message) . "</p>";
	
		echo '<form method="post" id="select" action="' . FULLWEBPATH . '/' . basename(__FILE__) . '?cmd=finish">';
        echo '<input type="hidden" name="folder" value="" />';

        echo '<div id="albumselect">';
		echo '<select id="" name="albumselect" onChange="albumSwitch(this)">';
		echo '<option value="" selected="true">A new album...</option>';
		
              $bglevels = array('#fff','#f8f8f8','#efefef','#e8e8e8','#dfdfdf','#d8d8d8','#cfcfcf','#c8c8c8');
              $checked = "checked=\"false\"";
              foreach ($albumlist as $fullfolder => $albumtitle) {
                $singlefolder = $fullfolder;
                $saprefix = "";
                $salevel = 0;
                if ($_GET['album'] == $fullfolder) {
                  $selected = " SELECTED=\"true\" ";
                  if (!isset($_GET['new'])) { $checked = ""; }
                } else {
                  $selected = "";
                }
                // Get rid of the slashes in the subalbum, while also making a subalbum prefix for the menu.
                while (strstr($singlefolder, '/') !== false) {
                  $singlefolder = substr(strstr($singlefolder, '/'), 1);
                  $saprefix = "&nbsp; &nbsp;&raquo;&nbsp;" . $saprefix;
                  $salevel++;
                }
                echo '<option value="' . $fullfolder . '"' . ($salevel > 0 ? ' style="background-color: '.$bglevels[$salevel].'; border-bottom: 1px dotted #ccc;"' : '')
                  . "$selected>" . $saprefix . $singlefolder . "</option>\n";
              }
		
		echo '</select>';
        echo '<fieldset id="albumtext"><legend>Create a new album</legend><div>';
		echo '<label>Title:';
        echo '<input id="albumtitle" size="22" type="text" name="albumtitle" value="" onKeyUp="updateFolder(this, \'folderdisplay\', \'autogen\');" />';
		echo '</label>';
		echo '<label>Folder:';
		echo '<input id="folderdisplay" size="18" type="text" name="folderdisplay" disabled="true" onKeyUp="validateFolder(this);"/>';
        echo '<label>';
		echo '<input type="checkbox" name="autogenfolder" id="autogen" checked="true" onClick="toggleAutogen(\'folderdisplay\', \'albumtitle\', this);" />';
		echo 'Auto-generate';
		echo '</label>';
		echo '</label>';
		echo '<div id="foldererror" style="display: none;">That name is already in use</div>';
		echo '</div></fieldset></div>';
		echo '</form>';

		$this->buttonsEnableBack = true;
		$this->buttonsEnableNext = true;
		$this->onNext = 'select.folder.value = select.folderdisplay.value; select.submit();';
		$this->footer();
	}
	
	function form_login($message = '') {
		$this->header();

		echo '<h2>Enter your username and password</h2>';
		if ($message != '') echo "<p>" . htmlspecialchars($message) . "</p>";
		
		echo '<form method="post" id="login" action="' . FULLWEBPATH . '/' . basename(__FILE__) . '?cmd=album">';
		echo '<label>Username:';
        echo '<input type="text" id="user" name="user" value="" maxlength="25" />';
		echo '</label>';
		echo '<label>Password:';
        echo '<input type="password" id="pass" name="pass" value="" maxlength="25" />';
		echo '</label>';
		echo '</form>';
		
		$this->buttonsEnableBack = true;
		$this->buttonsEnableNext = true;
		$this->onNext = 'login.submit();';
		$this->footer();
	}
	
	function process_login() {
 		if (isset($_POST['user']) && isset($_POST['pass'])) {
			$user = $_POST['user'];
			$pass = $_POST['pass'];

            $check_auth = md5($user . $pass);
                if ($user == getOption('adminuser') && $check_auth == getOption("adminpass")) {
                    setcookie("zenphoto_wizard", md5($user . $check_auth), time()+5184000, $cookiepath);
                    $_zp_loggedin = true;
                } else {
                setcookie("zenphoto_wizard", "", time()-368000, $cookiepath);
						}
                } 
		if ($_zp_loggedin) {
			$this->form_album();
		} else {
			$this->form_login('The username or password you entered are not correct');
				}
	}
	
	function logout() {
		setcookie("zenphoto_wizard", "");
	}
	
	function authorize() {
		global $_zp_loggedin;

		if (isset($_COOKIE['zenphoto_wizard'])) {
  			$saved_auth = $_COOKIE['zenphoto_wizard'];
  			$check_auth = md5(getOption("adminuser").getOption("adminpass"));
  			if ($saved_auth == $check_auth) {
    			$_zp_loggedin = true;
  			} else {
				setcookie("zenphoto_wizard", "");
  			}
		}
	}
	
	function header() {
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
		echo '<html dir="ltr">';
		echo '<head>';
		echo '<title>' . htmlspecialchars(getOption('gallery_Title')) . '</title>';
		//echo '<meta http-equiv="Content-Type" content="text/html; charset=' . getOption('charset') . '" />';
		echo '<style type="text/css">';
?>

	body {
		background: threedface url(<?php echo FULLWEBPATH; ?>/zp-core/images/zen-logo.gif) right bottom no-repeat;
	}
	
	body, td, select, input {
		font-family: Tahoma, Verdana, Arial, Helvetica, sans-serif;
		font-size: 8pt;
	}
	
	h2 {
		font-size: 9pt;
	}
	
	fieldset {
		padding: 12pt 12pt 0;
	}
	
	fieldset div {
		padding: 12pt 0 0;
	}
	
	label {
		display: block;
		position: relative;
		height: 24pt;		
	}
	label input#user,
	label input#pass,
	label input#albumtitle,
	label input#folderdisplay {
		position: absolute;
		left: 15%;
		width: 60%;
		top: -4pt;
		padding: 2pt;
		height: 17pt;
	}
	label input#folderdisplay {
		width: 30%;
	}
	
	label label {
		position: absolute;
		width: 30%;
		left: 47%;
		top: -2pt;
		display: inline;
	}
	label label input {
		margin: 0 2pt 0 0;
	}
	#foldererror {
		font-weight: bold;
		color: red;
		margin: -4pt 0 0 0;
		padding: 0 0 12pt 15%;
	}

<?php		
		echo '</style>';
		echo '</head>';
		echo '<body>';
	}
	
	function footer($javascript = '') {
		echo '<div id="content"></div>';
		echo '<script language="javascript" type="text/javascript">';

		?>

	function contains(arr, key) {
		for (i=0; i<arr.length; i++) {
			if (arr[i].toLowerCase() == key.toLowerCase()) {
				return true;
			}
		}
		return false;
	}

	function albumSwitch(sel) {
		var selected = sel.options[sel.selectedIndex];
		var albumtext = document.getElementById("albumtext");
		var albumbox = document.getElementById("folderdisplay");
		var titlebox = document.getElementById("albumtitle");
		var checkbox = document.getElementById("autogen");
		
		if (selected.value == "") {
			albumtext.style.display = "block";
			albumbox.value = "";
			titlebox.value = "";
			document.getElementById("foldererror").style.display = "none";
			checkbox.checked = true;
			toggleAutogen("folderdisplay", "albumtitle", checkbox);
		} else {
			albumtext.style.display = "none";
			albumbox.value = selected.value;
			titlebox.value = selected.text;
		}
	}

	function updateFolder(nameObj, folderID, checkboxID) {
		var autogen = document.getElementById(checkboxID).checked;
		var folder = document.getElementById(folderID);
		var name = nameObj.value;
		var fname = "";
		var fnamesuffix = "";
		var count = 1;
		if (autogen && name != "") {
			fname = name;
			fname = fname.toLowerCase();
			fname = fname.replace(/[\!@#$\%\^&*()\~`\'\"]/gi, "");
			fname = fname.replace(/[^a-zA-Z0-9]/gi, "-");
			fname = fname.replace(/--*/gi, "-");
			while (contains(albumArray, fname+fnamesuffix)) {
				fnamesuffix = "-"+count;
				count++;
			}
		}
		folder.value = fname+fnamesuffix;
	}

	function validateFolder(folderObj) {
		var errorDiv = document.getElementById("foldererror");
		if (albumArray && contains(albumArray, folderObj.value)) {
			errorDiv.style.display = "block";
		} else {
			errorDiv.style.display = "none";
		}
	}

	function toggleAutogen(fieldID, nameID, checkbox) {
		var field = document.getElementById(fieldID);
		var name = document.getElementById(nameID);
		if (checkbox.checked) {
			window.folderbackup = field.value;
			field.disabled = true;
			updateFolder(name, fieldID, checkbox.id);
		} else {
			if (window.folderbackup && window.folderbackup != "")
				field.value = window.folderbackup;
			field.disabled = false;
		}
	}


		
	function startUpload(folder) {
		var xml = window.external.Property('TransferManifest');
		var files = xml.selectNodes('transfermanifest/filelist/file');

		for (i = 0; i < files.length; i++) {
			var postTag = xml.createNode(1, 'post', '');
			postTag.setAttribute('href', '<?php echo FULLWEBPATH . '/' . basename(__FILE__) . '?cmd=upload'; ?>&folder=' + folder);
			postTag.setAttribute('name', 'userpicture');

			var dataTag = xml.createNode(1, 'formdata', '');
			dataTag.setAttribute('name', 'MAX_FILE_SIZE');
			dataTag.text = '10000000';
			postTag.appendChild(dataTag);

			files.item(i).appendChild(postTag);
        }

        var uploadTag = xml.createNode(1, 'uploadinfo', '');
        uploadTag.setAttribute('friendlyname', '<?php echo utf8::encode_javascript(getOption('gallery_title')); ?>');
        var htmluiTag = xml.createNode(1, 'htmlui', '');
        htmluiTag.text = '<?php echo utf8::encode_javascript(FULLWEBPATH); ?>';
        uploadTag.appendChild(htmluiTag);

        xml.documentElement.appendChild(uploadTag);

        window.external.Property('TransferManifest')=xml;
        window.external.SetWizardButtons(true,true,true);
        content.innerHtml=xml;
        window.external.FinalNext();
	}

	function OnBack() {
		<?php echo $this->onBack; ?>
	}

	function OnNext() {
		<?php echo $this->onNext; ?>
	}

	function OnCancel() {
		<?php echo $this->onCancel; ?>
	}

	function window.onload() {
		window.external.SetWizardButtons(1,1,0);
		window.external.SetHeaderText('<?php echo utf8::encode_javascript(getOption('gallery_title')); ?>','<?php echo utf8::encode_javascript(FULLWEBPATH); ?>');
	}
	
	<?php echo $javascript; ?>
	
		<?php
		
		echo '</script></body></html>';
	}
	
	function send_reg_file() {

    	$time_stamp = time();

	    header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=zenphoto_".$time_stamp.".reg");

		$lines[] = 'Windows Registry Editor Version 5.00';
		$lines[] = '[HKEY_CURRENT_USER\Software\Microsoft\Windows\CurrentVersion\Explorer\PublishingWizard\InternetPhotoPrinting\Providers\\'. getOption('gallery_title') .']';
		$lines[] = '"displayname"="' . getGalleryTitle() . '"';
		$lines[] = '"description"="' . FULLWEBPATH . '"';
    	$lines[] = '"href"="' . FULLWEBPATH . '/' . basename(__FILE__) . '?cmd=publish"';
    	$lines[] = '"icon"="' . "http://" . $_SERVER['HTTP_HOST'] . '/favicon.ico"';
    	
		print join("\r\n", $lines);
    	print "\r\n";
    	exit;	
	}
}


?>