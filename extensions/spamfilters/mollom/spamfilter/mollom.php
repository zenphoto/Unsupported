<?php
/**
 * This is a Mollom based SPAM filter. 
 * It uses the Mollom service to check spam
 * 
 * Note: Mollom requres PHP version 5!
 * 
 * @author Bart Braem
 * @version 1.0.0
 * @package plugins	 
 */
 
 require_once(dirname(dirname(dirname(__FILE__))).'/class-mollom.php');
 
/**
 * This implements the standard SpamFilter class for the Simple spam filter.
 *
 */
class SpamFilter  {

	/**
	 * The SpamFilter class instantiation function.
	 *
	 * @return SpamFilter
	 */
	function SpamFilter() {
		setOptionDefault('public_key', '');
		setOptionDefault('private_key', '');
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
									gettext('Public Key') => array('key' => 'public_key', 'type' => 0, 'desc' => gettext('Mollom public key')),
									gettext('Private Key') => array('key' => 'private_key', 'type' => 0, 'desc' => gettext('Mollom private key'))
									);
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
	function filterMessage($author, $email, $website, $body, $imageLink, $ip) {
		// set keys
		Mollom::setPublicKey(getOption('public_key'));
		Mollom::setPrivateKey(getOption('private_key'));
	
		$servers = Mollom::getServerList();
		Mollom::setServerList($servers);
	
		// get feedback
		try
		{
			$feedback = Mollom::checkContent(null, null, $body, $author, $website, $email);
		}
		catch (Exception $e)
		{
			// mark comment for moderation, Mollom is acting strange
		}
		// process feedback
		if(in_array($feedback['spam'], array('unsure', 'unknow')))
		{
		    $result = 1;
		}
		elseif ($feedback['spam'] == 'ham') $result = 2;
		elseif ($feedback['spam'] == 'spam') $result = 0;
		
		return $result;
	}

}

?>
