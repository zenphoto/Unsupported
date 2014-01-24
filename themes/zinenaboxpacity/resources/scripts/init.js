$.support = $.support || { };
$.support.boxModel = $.model;
				
$.extend(zin, { 
	createModalBox: function(title, text, containerId, cls, options) {
		$.modal(
			zin.getModalBoxHtml(title, text, containerId, cls), $.extend({
				closeHTML:"",
				overlayCss:{
					backgroundColor: "#131313", 
					opacity: .6
				},
				overlayClose:true
			}, options || { }));

		$("#" + containerId).draggable();
	},
	getModalBoxHtml: function(title, text, containerId, cls) {
		return '<div class="dbx-container box-shadow' + (cls ? (' ' + cls) : '') + '" id="' + containerId + '">' +	
			'	<div class="dbx-modal-content">' +
			'		<div class="dbx-modal-title">' + title + '</div>' +
			'		<div class="close" style="display: block !important;"><a href="#" class="simplemodal-close">x</a></div>' +
			'		<div class="dbx-modal-data">' +
						text +
			'			<div class="buttons">' +
			'				<div class="generic-button dbx-close simplemodal-close">Close</div>' +
			'			</div>' +
			'		</div>' +
			'	</div>' +
			'</div>';
	}
});

var PageInstaller = function() {
	var setUpPersonalityChooser = function setUpPersonalityChooser() {
		if ( disablePersonalityChooser === true ) return;
		var qtip = $('#personality-switch div.title');
		qtip.qtip({
			content: $("#persona-qtip").html(),
		 	position: {
	  			corner: {
	     			target: 'bottomLeft',
	     			tooltip: 'topLeft'
	  			}
   			},
			api: {
				onRender: function() {
					var lastInsert = null;
					this.elements.content.find('a').click(function() { 
						var url = $(this).attr('href');	
						var persona = $(this).attr('persona');		
						$.ajax({ 
							url: url, 
							success: function(xml){
								var wa = $('#persona-workaround-non-xml-response');
								wa.html(xml);
								var s = $('#persona-workaround-non-xml-response').find('style');
								$('#persona').attr('href', s.attr('src'));
								s.removeAttr('src');
								if ( lastInsert ) {
									lastInsert.remove();
								}
								$('head').append(s);
								var icons = wa.find('#icons')[0].attributes;
								var names = { };
								for ( var u = 0, l= icons.length; u < l; u++ ) {
									if ( icons[u].name != 'id' ) names[icons[u].name] = 1;
								}
								$("#personality-switch").trigger('setpersona', [persona, names]);
							}
						});
						qtip.qtip("hide");
						return false;
					});
			  	}
			},
			show: {
				solo: true,
				ready: false,
				when: {
					event: 'click'
				},
				effect: { 
					type:'slide',
					length: 400
				}
			},
		 	hide: {
				fixed: true,
				when: { 
					event: 'unfocus' 
				},
				effect: { 
					type:'slide',
					length: 400
				}
			},
		 	style: {
				width: 158,
				marginTop: 0,
				padding: '2px 6px',
				border: {
	     			width: 0
	  			},
				name: 'light',
				classes: { tooltip: 'persona-tooltip' }
		 	}
		});
	};

	var installPrimitives = function installPrimitives() {
		window.BLANK_IMAGE = zin.themeroot + "/resources/images/c.gif";
		window.emptyFn = function() { };

		if ( typeof window.console == 'undefined' ) {
			window.console = { log: emptyFn, trace: emptyFn, debug: emptyFn, info: emptyFn, warn: emptyFn, error: emptyFn, fatal: emptyFn };
		}
	};

	var fixStyles = function fixStyles() {
		//fix css on a per browser basis
		if ( $.browser.opera ) {
			//opera [10.x] doesn't play well? weird but seems to work this way 
			//test with windows
			$(".news-preview-wrapper").css('margin-left', '1px !important');

			$(".tab.search form").css('margin-right', '0px');
			$(".tab.search form").css('padding-right', '0px');
			$(".tab.search form #search_submit").css('margin-top', '-1px');
			$(".tab.search form #search_submit").css('padding-right', '11px');
			$(".tab.search form #search_submit").css('padding-left', '10px');

			//$("#page-filler").css('margin-left', '41px');
			$("#theme-id").css('margin-left', '4px');
		}

		if ( $.browser.mozilla ) {
			$('.tab.search form #search_input ').css('padding', '5px 10px 6px 10px');
			$('.tab.search form').css('margin-top', '-2px');
		}
	};

	var setUpContactLink = function setUpContactLink() {
		if ( zin.contactIsModal ) {
			$("#contact-link").click(function() {
				var src = "index.php?p=contact&fo=true";
				var html = '<iframe id="contact-frame" border="0" frameborder="0" scrolling="no" bgcolor="transparent" src="' + src + '" style="background-color: transparent; height:350px; width: 403px; border:0; overflow: hidden !important;">';
				zin.createModalBox("Contact", html, "contact-box", "opa80");
				return false;
			});
		}
	};

	var setUpSearchBox = function setUpSearchBox() {
		var input = $('#search_input'), defaultText = DEFAULT_SEARCH_TEXT;
		input.blur(function() {
			if ( !input.val() || input.val().trim() == '' ) {
				input.attr('value',  defaultText);
			}
		});

		input.focus(function() {
			if ( input.val() == defaultText ) {
				input.val('');
			}
		});
	};

	this.init = function() {
		installPrimitives();
		fixStyles();
		setUpPersonalityChooser();
		setUpSearchBox();
		setUpContactLink();
	};
};

$(window).load(function() {
	zin.ROOT = new PageInstaller();
	zin.ROOT.init(); 
});

