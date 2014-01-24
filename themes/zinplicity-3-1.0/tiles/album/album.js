Zen.override(Zen.theme.Page, {
	album: function() {

		var tile = typeof arguments[0] == 'string' ? arguments[0] : 'album';		

		var initialSelection = $('#images a img.force-selection');

		var loadImage = function(thumb) {
			if ( thumb.hasClass('force-selection') ) return false;			
		
			var i = thumb.parent().attr('sref');
		
			imageContainer.animate({opacity: 0 }, 'slow', 'linear', function() {
				$(this).attr('src', i);
				imageList.each(function() {
					$(this).removeClass('force-selection');
				});
				thumb.addClass('force-selection');
			});
		};

		var images = $('#images');
		var imageList = $('#images a img');
		var imageContainer = $('#image-container img');
		imageContainer.load(function() {
			$(this).animate({opacity: 1}, 'slow', 'linear');
		});
		images.click(function(event) {
			var target = event.target;
			if ( target.nodeName.toLowerCase() == 'img' ) {
				var thumb = $(target);
				var index = thumb.attr('index');
				$.bbq.pushState({i: index});
				return false;
			}
		});
		
		$(window).bind('hashchange', function(e)  {
			var i = e.getState('i');
			var thumb = null;

			if ( !i ) thumb = initialSelection;
			else thumb = $(imageList.get(i));
		
			if ( thumb) loadImage(thumb);

			return false;		
			
		});

		$(window).trigger('hashchange');

		if ( this.useFancybox ) {
			$("#image-container img").click(function() {
				var href = $('#images a img.force-selection').attr('ref');
				if ( href && href.trim() != '' ) {
					//$.fancybox.showActivity(); 
					$.fancybox({
						padding: 2,
						href: href,
						transitionIn: 'elastic',
						transitionOut: 'elastic',
						hideOnContentClick: true, 
						imageScale: true, 
						type: 'image',
						showCloseButton: false,
					});
				}
			});
		}
	}
});

Zen.theme.instance.rels.album = 'gallery-menu-item';
