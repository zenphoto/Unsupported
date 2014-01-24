<?php
	if ( !function_exists('printCommentForm') ) return;

	require_once("theme_functions.php");

	$context = $_REQUEST['c'];

	switch ( $context ) {
		case 'news': 
			if ( !isset($_REQUEST['title']) ) return;
			set_context(ZP_ZENPAGE_NEWS_ARTICLE);
			$_zp_current_zenpage_news = new ZenpageNews($_REQUEST['title']);
			break;
		default:
			//not implemented
			return;
	}

	$result = CommentOverride::handleComment();
	

	if ( $result == COMMENT_SUCCESS ) {
		echo "<div id='add-comment-result' class='success'>" ;			
		echo "<div class='comment-result'>" . 
			 "<p>" . gettext('Your comment has been succesfully submitted') . "</p>" .
			 "</div>";
		echo "</div>";
		return;
	}

	if ( $result == 2 ) {
		echo "<div id='add-comment-result' class='warning'>" ;			
		echo "<div class='comment-result'>" . gettext('Your comment has been succesfully posted') . "</div>";
		echo "</div>";
		return;
	}

	echo "<div id='add-comment-result' class='error'>" ;			
	echo "<div class='comment-result'>";
	switch ($result) {
		case -10: 
			echo gettext('You must supply the street field'); 
			break;
		case -11: 
			echo gettext('You must supply the city field'); 
			break;
		case -12: 
			echo gettext('You must supply the state field'); 
			break;
		case -13: 
			echo gettext('You must supply the country field');
			break;
		case -14: 
			echo gettext('You must supply the postal code field'); 
			break;
		case  -1: 
			echo gettext("You must supply an e-mail address.");
			break;
		case  -2: 
			echo gettext("You must enter your name.");
			break;
		case  -3: 
			echo gettext("You must supply an WEB page URL.");
			break;
		case  -4: 
			echo gettext("Captcha verification failed.");
			break;
		case  -5: 
			echo gettext("You must enter something in the comment text.");
			break;
		case   1: 
			echo gettext("Your comment failed the SPAM filter check.");
			break;
		default: 
			echo sprintf(gettext('An undefined error (error-%d) has occured.'), $_zp_comment_error);
			break;
	}
	echo "</div>";

	$captchaCode=generateCaptcha($img);
		
	echo "<div id='captcha_updater' code='$captchaCode' img='$img' />";

	echo "</div>";

	
?>
