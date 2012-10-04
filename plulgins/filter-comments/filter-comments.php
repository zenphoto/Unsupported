<?php
/**
 * Processes a new comment posting, sending the post to all who have previously commented.
 * NB: this is an example filter. It does not, for instance, check to see if a previous poster is also
 * an admin receiving email notifications anyway. 
 * 
 * @package plugins
 */
$plugin_is_filter = 5;
$plugin_description = gettext("Email all posters when a new comment is made on an item.");
$plugin_author = "Stephen Billard (sbillard)";
$plugin_version = '1.3.0'; 

zp_register_filter('comment_post', 'emailReply');
zp_register_filter('comment_approve', 'emailApproval');

/**
 * Filters a new comment post and sends email replies to previous posters
 * @param object $comment the comment
 * @param object $owner the element commented upon.
 */
function emailReply($comment, $owner) {
	$gallery = new Gallery();
	if ($comment->getInModeration() || $comment->getPrivate()) {
		return $comment;  // we are not going to e-mail unless the comment has passed.
	}
	$oldcomments = $owner->comments;
	$emails = array();
	foreach ($oldcomments as $oldcomment) {
		$name = $oldcomment['name'];
		$emails[$name] = $oldcomment['email'];
	}
	$emails = array_unique($emails);
	switch ($comment->getType()) {
		case "albums":
			$url = "album=" . urlencode($owner->name);
			$action = sprintf(gettext('A reply has been posted on album "%1$s".'), $owner->name);
			break;
		case "news":
			$url = "p=".ZENPAGE_NEWS."&title=" . urlencode($owner->getTitlelink());
			$action = sprintf(gettext('A reply has been posted on article "%1$s".'), $owner->getTitlelink());
			break;
		case "pages":
			$url = "p=".ZENPAGE_PAGES."&title=" . urlencode($owner->getTitlelink());
			$action = sprintf(gettext('A reply has been posted on page "%1$s".'), $owner->getTitlelink());
			break;
		default: // all image types
			$url = "album=" . urlencode($owner->album->name) . "&image=" . urlencode($owner->filename);
			$action = sprintf(gettext('A reply has been posted on "%1$s" the album "%2$s".'), $owner->getTitle(), $owner->getAlbumName());
	}

	if ($comment->getAnon()) {
		$email = $name = '<'.gettext("Anonymous").'>';
	} else {
		$name = $comment->getname();
		$email = $comment->getEmail();
	}
	$message = $action . "\n\n" . 
							sprintf(gettext('Author: %1$s'."\n".'Email: %2$s'."\n".'Website: %3$s'."\n".'Comment:'."\n\n".'%4$s'),$name, $email, $comment->getWebsite(), $comment->getComment()) . "\n\n" .
							sprintf(gettext('You can view all comments about this item here:'."\n".'%1$s'), 'http://' . $_SERVER['SERVER_NAME'] . WEBPATH . '/index.php?'.$url) . "\n\n";
	$on = gettext('Reply posted');
	zp_mail("[" . $gallery->getTitle() . "] $on", $message, $emails);
	return $comment;
}

function emailApproval($comment) {
	$owner = NULL;
	switch ($comment->getType()) {
		case 'albums':
			$sql = 'SELECT `folder` FROM '.prefix('albums').' WHERE `id`='.$comment->getOwnerID();
			$row = query_single_row($sql);
			if (is_array($row)) {
				$owner = new Album(New Gallery(), $row['folder']);
			}
			break;
		case 'images':
			$sql = 'SELECT `albumid`, `filename` FROM '.prefix('images').' WHERE `id`='.$comment->getOwnerID();
			$imagerow = query_single_row($sql);
			if (is_array($imagerow)) {
				$sql = 'SELECT `folder` FROM '.prefix('albums').' WHERE `id`='.$imagerow['albumid'];
				$row = query_single_row($sql);
				if (is_array($row)) {
					$album = new Album(New Gallery(), $row['folder']);
					$owner = newImage($album, $imagerow['filename']);
				}
			}
			break;
		case 'news':
			$sql = 'SELECT `titlelink` FROM '.prefix('zenpage_news').' WHERE `id`='.$comment->getOwnerID();
			$row = query_single_row($sql);
			if (is_array($row)) {
				$owner = new ZenpageNews($row['titlelink']);
			}
			break;
		case 'pages':
			$sql = 'SELECT `titlelink` FROM '.prefix('zenpage_pages').' WHERE `id`='.$comment->getOwnerID();
			$row = query_single_row($sql);
			if (is_array($row)) {
				$owner = new ZenpagePage($row['titlelink']);
			}
			break;
	}
	if (!is_null($owner)) {
		$owner->getComments();
		emailReply($comment, $owner);
	}
	return $comment;
}
?>