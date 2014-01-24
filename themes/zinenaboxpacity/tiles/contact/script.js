//fix hard-coded inline styles
var ContactPage = function() {
	
	this.init = function init() {
		$('#page-body').find('p').each(function() {
			if ( $(this).css('color') == 'red' ) {
				$(this).addClass('contact-form-errors').addClass('opa60');
			}
		});
	}

};

$(window).load(function() {
	new ContactPage().init();
});
