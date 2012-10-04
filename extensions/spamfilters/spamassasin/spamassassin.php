<?php
/**
 * This is plugin for Spamassassin filtering
 * 
 * @author Jerome Blion : jerome@hebergement-pro.org Website: http://www.hebergement-pro.org
 * @version 1.0.0 (2007-11-06)
 * @package plugins	 
 */

// TODO : Implement socket connexion

/**
 * This implements the standard SpamFilter class for the spamassassin spam filter.
 *
 */
class SpamFilter {
	var $spamassassin_host;		// Spamassassin server
	var $spamassassin_ctype;	// Connexion type
	var $spamassassin_port;		// Port of spamassassin
	var $spamassassin_socket;	// Socket of Spamassassin
	var $spamassassin_user;		// USer to use on Spamassassin box
	var $server_name;		// This webserver
	var $admin_email;		// e-Mail of the admin

	var $received_1;		// first line of "Received: headers
	var $received_2;		// Second line of "Received: headers 
	var $conn;			// Network connexion to Spamassassin
	var $date;			// Date (RFC compliant)

	/**
	 * The SpamFilter class instantiation function.
	 *
	 * @return SpamFilter
	 */
	function SpamFilter() {	// constructor
	
		// setup default options

		setOptionDefault('Forgiving', 0);
		setOptionDefault('SpamAssassin_host', 'localhost');
		setOptionDefault('SpamAssassin_ctype', 'tcp');
		setOptionDefault('SpamAssassin_port', '');
		setOptionDefault('SpamAssassin_socket', '');
		setOptionDefault('SpamAssassin_user', '');
		
		/* Spamassassin variables */
		$this->spamassassin_host	= getOption('SpamAssassin_host');
		$this->spamassassin_ctype	= getOption('SpamAssassin_ctype');
		if($this->spamassassin_ctype == 'tcp') {
			$this->spamassassin_port = getOption('SpamAssassin_port');
		}
		else {
			$this->spamassassin_socket = getOption('SpamAssassin_socket');
		}
		$this->spamassassin_user = getOption('SpamAssassin_user');
	
		/* Internal variables I need to fetch to use them in the class */	
		$this->server_name = php_uname('n');
		$admin_emails = getAdminEmail();
		if (count($admin_emails) > 0) {
			$this->admin_email = $admin_emails[0];
		}

	}

	/**
	 * The admin options interface
	 * called from admin Options tab
	 *  returns an array of the option names the theme supports
	 *  the array is indexed by the option name. The value for each option is an array:
	 *          'type' => 0 says for admin to use a standard textbox for the option
	 *          'type' => 1 says for admin to use a standard checkbox for the option
	 *          'type' => 2 will cause admin to call handleOption to generate the HTML for the option
	 *          'desc' => text to be displayed for the option description.
	 *
	 * @return array
	 */
	function getOptionsSupported() {
		return array(
			gettext('Forgiving') => array('key' => 'Forgiving', 'type' => '1' , 'desc' => gettext('Mark suspected SPAM for moderation rather than as SPAM')),
			gettext('SpamAssassin host') => array('key' => 'SpamAssassin_host', 'type' => '0' , 'desc' => gettext('SpamAssassin server')),
			gettext('SpamAssassin ctype') => array('key' => 'SpamAssassin_ctype', 'type' => '2' , 'desc' => gettext('Connection type')),
			gettext('SpamAssassin port') => array('key' => 'SpamAssassin_port', 'type' => '0' , 'desc' => gettext('TCP port of SpamAssassin')),
			gettext('SpamAssassin socket') => array('key' => 'SpamAssassin_socket', 'type' => '0' , 'desc' => gettext('Socket of SpamAssassin')),
			gettext('SpamAssassin user') => array('key' => 'SpamAssassin_user', 'type' => '0' , 'desc' => gettext('User to use on SpamAssassin box'))
		);
	}
	
 	/**
 	 * Handles custom formatting of options for Admin
 	 *
 	 * @param string $option the option name of the option to be processed
 	 * @param mixed $currentValue the current value of the option (the "before" value)
 	 */
	function handleOption($option, $currentValue) {
		if ($option == 'SpamAssassin_ctype') {
			echo '<select id="connectiontype" name="' . $option . '"' . " DISABLED>\n";
			echo '<option value="tcp"';
			if ($currentValue == 'tcp') { 
				echo ' selected="selected"'; 
			}
			echo ">tcp</option>\n";
			echo '<option value="socket" disabled';
			if ($currentValue == 'socket') { 
				echo ' selected="selected"'; 
			}
			echo ">socket (unimplemented)</option>\n";
			echo "</select>\n";
		}
	}

	function prepareHeaders() {
		$this->date=date('r');
		$from_ip = ($_SERVER['REMOTE_ADDR'] != getenv('SERVER_ADDR')) ? $_SERVER['REMOTE_ADDR'] : getenv('HTTP_X_FORWARDED_FOR');
		$from_name = gethostbyaddr($from_ip);
		if($from_name == $from_ip ) {
			$this->received_1 = "[$from_ip]";
			$this->received_2 = "($received_1)";
		}
		else {
			$this->received_1 = $from_name;
			$this->received_2 = "($from_name [$from_ip])";
		}
	}

	function comment2Mail($name,$email,$website,$comment) {
		if (ini_get('magic_quotes_gpc') == 1) $comment = stripslashes($comment);

		$message = "From: \"$name\" <$email>\n".
			 	"To: ".$this->admin_email."\n".
			 	"Date: ".$this->date."\n".
			 	"Content-type: text/plain\n".
			 	"Received: from ".$this->received_1." ".$this->received_2." (uid ".getmyuid().")\n".
			 	"	by ".$this->server_name." with Zenphoto; ".$this->date."\n".
			 	"Message-ID: <zenphoto-".md5(time())."@".$this->server_name.">\n".
			 	"Subject: Zenphoto\n\n".
			 	wordwrap($comment." - ".$website."\r\n",76);

		return $message;
	}

	function prepareRequest($message) {
		$request = "CHECK SPAMC/3.1\n".
			 	"User: ".$this->spamassassin_user."\n".
			 	"Content-length: ".strlen($message)."\n\r\n".
			 	$message;

		return $request;
	}

	function connectMe() {
		// TODO : Manage errors a better way
		//	: Manage socket connexion
		$this->conn = @fsockopen($this->spamassassin_host, $this->spamassassin_port, $errno, $errmsg);
		if ($this->conn) {
			return true;
		}
		else {
			return false;
		}
	}
	function disconnectMe() {
		fclose($this->conn);
		return true;
	}

	function sendRequest($request) {
		$out = '';
		if(fwrite($this->conn, $request, strlen($request)) === false) return true;      // something happened...
		
		while(!feof($this->conn)) {
			/*
			 * Here is an answer of spamd:
			 *
			 * SPAMD/1.1 0 EX_OK
			 * Spam: True ; 5.7 / 5.0
			 *
			 * As the answer is short enough, the buffer is short...
			 */

			$out.=fgets($this->conn,64); // add ."\n"; for debug purposes
		}
		return $out;
	}

	function parseAnswer($output) {
		if(preg_match('/Spam: True/', $output) > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * The function for processing a message to see if it might be SPAM
   *       returns:
   *         0 if the message is SPAM
   *         1 if the message might be SPAM (it will be marked for moderation)
   *         2 if the message is not SPAM
	 *
	 * @param string $author Author field from the posting
	 * @param string $email Email field from the posting
	 * @param string $website Website field from the posting
	 * @param string $body The text of the comment
	 * @param string $imageLink A link to the album/image on which the post was made
	 * @param string $ip the IP address of the comment poster
	 * 
	 * @return int
	 */
	function filterMessage($author, $email, $website, $comment, $image_name, $ip) {
		$this->prepareHeaders();
		$forgedMail = $this->comment2Mail($author, $email, $website, $comment);
		$request = $this->prepareRequest ($forgedMail);

		$isConnected = $this->connectMe();
		$isSpam = true;
		if ($isConnected) {
			$output = $this->sendRequest($request);
			$isSpam = $this->parseAnswer($output);

			$this->disconnectMe();
		}

		/* 
		 * It's a little bit confusing here
		 * I'm looking for a spam while Zenphoto core is looking for a good message !
		 * So, I need to answer to : "Is it a good message?"
		 */

		if ($isSpam === true) {
			if (getOption('Forgiving') == 1) {
				// Comment has been detected as spam and has to be moderated
				return 1;
			}
			else {
				// Comment has been detected as spam and will be dropped
				// If there is any code injection that tries to modify the Forgiving variable,
				// it will go to trash :-)
				return 0;
			}
		}
		else {
			// Comment is good and do not need to be moderated
			return 2; 
		}
	}
}
?>
