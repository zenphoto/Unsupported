<?php
	global $_zp_themeroot;
	include(dirname(dirname(__FILE__)) . "/shared/init.php"); 
?>

zin.fetchNewsCommentUrl = '<?= NewsUtil::getNewsIndexUrl() ?>';
zin.postCommentUrl = '<?= getCustomPageUrl("add-comment") ?>';
zin.messages = zin.messages || { } ;
$.extend(zin.messages, {
	success: '<?= gettext("Success") ?>',
	error: '<?= gettext("Error") ?>'
});
