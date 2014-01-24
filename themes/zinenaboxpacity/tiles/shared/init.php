<?php
$init = <<<INIT
$(window).load(function() {
	var content = $("#content");
	var nav = $("#album-nav");
	var filler = $("#page-filler");
	var extra = $("#extra");

	if ( filler && filler.offset() ) {
		filler.height(extra.offset().top - filler.offset().top - 1);
	}

	content.height(extra.offset().top - content.offset().top - 1);
	nav.height(extra.offset().top - nav.offset().top - 1);
});
INIT;
echo $init;
?>

