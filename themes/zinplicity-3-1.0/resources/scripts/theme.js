Zen.theme.Page = function() { 
	this.extensions = { };
	this.rels = [];
};

Zen.override(Zen.theme.Page, {	
	init: function(tile, options) {
		Zen.apply(this, options || { });

		this.elements = { 
			content: $('#content'),
			css: $('#dyn-css')
		};
		
		if ( typeof this[tile] == 'function' ) {
			this[tile].call(this);
		}

	},
	selectMenuItem: function(el) {
		$(".menu-item").each(function() {
			$(this).removeClass('selected');
		});

		el.addClass('selected');
	},
	isSelected: function(el) {
		return el.hasClass('current') || el.hasClass('selected') || el.hasClass('over');
	},
	loadPage: function(options) {
		options = options || { };		
		var effect = options.effect || "fadeIn";
		var tile = options.tile;

		var into = this.elements.content;

		var url = options.url;

		$(this).trigger('beforeload', {url: url, into: into});
		
		var params = options.params || {  };
		delete params.xr;
		params.xr = 'true';		
		var callback = function(response, status, xhr) {
			try {
			  	if (status == "error") {
					return;
			  	}
			}
			finally {
				into.html(response);
				into.delay(100)[effect]("slow");
				if ( typeof this[tile] == 'function' ) {
					this[tile].call(this, options);
				}
				(options.callback || Zen.emptyFn).call(this);
				if ( tile in this.rels ) {
					this.selectMenuItem($('#' + this.rels[tile]));
				}
				this.registerTiledOrphanLinks();
			}
		}.createDelegate(this);


		into.fadeOut("fast");
		into.html(this.loader).fadeIn("fast");

		var method = options.post === true ? 'post' : 'get';
		delete options.post;

		$[method](url, params, callback);		
	}
});

Zen.theme.instance = new Zen.theme.Page();

