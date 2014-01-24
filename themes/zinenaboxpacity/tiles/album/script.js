var AlbumPage = function() {

	this.highlightTitle = true;
	this.lastThumbSelection = null;

	var scroller = $("#scroller");
	var rightScroll = $("#right-scroll");
	var leftScroll = $("#left-scroll");
	var previewContainer = $("#image-full-preview-container");
	var content = $("#content");
	var albumNavigation = $("#album-nav");
	var navigationDiv = $("#navigation");
	var navHeight = navigationDiv.height();
	var imageWrapper = $("#image-wrapper");
	var nextPageEl = $("#image-nav-next").parent();
	var prevPageEl = $("#image-nav-prev").parent();
	var wrapperMask = $("#wrapper-mask");
	var filler = $("#page-filler")
	var initialFillerHeight = filler.height();
	var contentFiller = $('#content-filler');

	var replaceImageThumb = function() {
		try {
			var title = this.attr('title');
			var width = parseInt(this.attr('width'));
			var height = parseInt(this.attr('height'));
			var index = parseInt(this.attr('index'));
			var object_id = this.attr('object_id');
			var url = this.attr('url');
			var previewUrl = this.attr('previewUrl');
			var location = this.attr('location');
			var index = this.attr('index');

			var rating = parseInt(this.attr('rating'));

			//console.log(title + ' '  + rating + ' ' + object_id);

			rating = typeof rating == 'undefined' || rating == NaN ? 0 : rating;
			var description = this.find('description').text();
		
			var img = $("#img-" + index);
			img.attr('src', location);
			flipClasses(img.parent(), "opa20", "opa60");

			images[index] = {
				title: title,
				description: description,
				location: previewUrl,
				url: url,
				width: width,
				height: height, 
				rating: rating,	
				object_id: object_id
			};
		}
		catch ( e ) { 
			console.error(e); 
		}
	};

	var replaceAlbumThumb = function() {
		var title = this.attr('title');
		var index = this.attr('index');
		var location = this.attr('location');
		var url = this.attr('url');
		var description = this.find('description').text();

		var img = $("#subalbum-" + index + " img");
		var descEl = $("#subalbum-" + index).next();
		descEl.html(title);
		img.attr('src', location);
		img.css('visibility', 'visible');
		$("#subalbum-" + index + " a").attr('href', url);
		flipClasses($("#subalbum-" + index).parent(), "opa20", "opa60");
		$("#subalbum-" + index).removeClass("opa20");
		$("#subalbum-description-" + index).removeClass("opa20");
	};

	this.handlePageNavigation = function handlePageNavigation(opt) {
		var selectionIndex = opt.selectionIndex;
		if ( selectionIndex === 'first' ) {
			selectionIndex = 0; 
		}
		wrapperMask.height(content.height());
		wrapperMask.css('display', 'block');
		wrapperMask.css('top', content.offset().top);

		$.ajax({ 
			url: opt.url, 
			//dataType: 'xml',
			success: function(xml){
				try {
					$('#workaround-non-xml-comment-crap').html(xml);
					var coll = $('#workaround-non-xml-comment-crap').find('div.thumb');
					var currentIndex = 0;
					var thumbCount = coll.size()
					if ( selectionIndex === 'last' ) {
						selectionIndex = thumbCount - 1;
					}
					coll.each(function(idx) { 
						if ( isAlbumPage ) {
							//console.log(idx);
							replaceAlbumThumb.call($(this));
						}							
						else {
							replaceImageThumb.call($(this));
						}
						currentIndex = idx;
					});

					maxImageIndex = currentIndex;
					if ( isAlbumPage ) {
						for ( var u = currentIndex + 1; u < albumsPerPage; u++ ) {
							var img = $("#subalbum-" + u + " img");
							img.parent().removeAttr('href');
							img.attr('src', BLANK_IMAGE);
							$("#subalbum-description-" + u).addClass("opa20");
							$("#subalbum-description-" + u).html("&nbsp;");
							flipClasses($("#subalbum-" + u), "opa60", "opa20");
						}
					}				
					else {
						images.length = currentIndex + 1;
						for ( var u = currentIndex + 1; u < imagesPerPage; u++ ) {
							var img = $("#img-" + u);
							img.parent().removeAttr('href');
							img.attr('src', BLANK_IMAGE);
							flipClasses(img.parent(), "opa60", "opa20");
						}
					}

					var navEl = $('#workaround-non-xml-comment-crap').find('#thumbs-navigation:first');
					var prevUrl = navEl.attr('prev');
					var nextUrl = navEl.attr('next');

					hasPrevPage = prevUrl && prevUrl.trim() != '';
					hasNextPage = nextUrl && nextUrl.trim() != '';

					prevPageEl.attr('href', prevUrl);
					nextPageEl.attr('href', nextUrl);

					prevPageEl.css('display', !hasPrevPage  ? 'none' : 'block');
					nextPageEl.css('display', !hasNextPage ? 'none' : 'block');

					var navBar = $('#workaround-non-xml-comment-crap').find('#bar').html();
					albumNavigation.html(navBar);

					wrapperMask.css('display', 'none');
					$(".nav-cell a").click(navbarListener); 

					$("#img-" + selectionIndex).trigger('click');

					updateSizes();

					if ( opt.onSuccess ) {
						opt.onSuccess(xml);
					}

					preload();
				}
				catch ( e ) {
					console.erro('unable to handle page navigation ' + (e.message || e));
					wrapperMask.css('display', 'none');
				}
			},
			error: function(req, error) {
				console.log('unable to handle page navigation ' + error);
				wrapperMask.css('display', 'none');
				//TODO: should we warn user?
			}
		});
	};

	this.navigation = {
		go: function jump(url) {
			this.handlePageNavigation({
				url: url + '&f=' + 'xml',
				selectionIndex: 'first'
			});
		}.createDelegate(this), 
		nextPage: function nextPage() {
			if ( hasNextPage === true ) {
				this.handlePageNavigation({
					url: nextPageEl.attr('href') + '&f=' + 'xml',
					selectionIndex: 'first'
				});
			} 
			return false;
		}.createDelegate(this),
		prevPage: function prevPage() {
			if ( hasPrevPage === true ) {
				this.handlePageNavigation({
					url: prevPageEl.attr('href') + '&f=' + 'xml',
					selectionIndex: 'last'
				});
			}			
			return false;
		}.createDelegate(this),
		nextImage: function nextImage() {
			var currentIndex = this.lastThumbSelection.attr('index');
			if ( currentIndex == maxImageIndex ) {
				if ( hasNextPage === true ) { 
					nextPageEl.trigger("click"); 
				}
				return;
			}
			$("#img-" + (parseInt(currentIndex) + 1)).trigger("click");
		}.createDelegate(this),
		prevImage: function prevImage() {
			var currentIndex = this.lastThumbSelection.attr('index');
			if ( currentIndex == 0 ) {
				if ( hasPrevPage === true ) {
					prevPageEl.trigger("click");
				}
				return;
			}
			$("#img-" + (parseInt(currentIndex) - 1)).trigger("click");
		}.createDelegate(this)
	}

	this.init = function() {

		registerListeners.call(this);

		if ( AlbumPage.skipInitialSelection !== true && images.length > 0 ) {
			if ( initialImageThumbSelection > 0 ) {
				$(".image-thumb img[index=" + initialImageThumbSelection + "]").trigger("click");
			}
			else {
				$(".image-thumb img:first").trigger("click");
			}
		}

		if ( !hasPrevPage ) {
			prevPageEl.css('display', 'none');
		}
		if ( !hasNextPage ) {
			nextPageEl.css('display', 'none');
		}

		updateSizes();
		
		preload();

		return this;
	};

	var updateSizes = function() {
		var contentHeight = content.height(); 
		var height = navHeight > contentHeight ? navHeight : contentHeight;

		content.height(height);
		albumNavigation.height(height);

		if ( !isAlbumPage && nextPageEl.css('display') == 'none' ) filler.addClass('last');
		else filler.removeClass('last');

		filler.height(height + content.offset().top - filler.offset().top);
		
		if ( contentFiller && contentFiller.offset() ) {
			if ( contentFiller.offset().top < $("#extra").offset().top - 4 ) {
				contentFiller.css('display', 'block');
				contentFiller.height(
					height + 
					content.offset().top - 
					contentFiller.offset().top - 
					($('#image-description').css('display') == 'block' && $.browser.mozilla ? 1 : 0)); //weird enough, there's a one pixel offset when image has description
			}
			else {
				contentFiller.css('display', 'none');
			}
		}

		var c = $('#image-thumb-container');
		if ( !isAlbumPage && $('.image-thumb:last').offset() ) {
			c.height($('.image-thumb:last').offset().top + 105 - $('.image-thumb:first').offset().top);
		}

		$("#page-filler").height(
			$('#content').height() + 
			$('#content').offset().top - 		
			$("#page-filler").offset().top);

		$(zin.ALBUM_PAGE).trigger("updatesizes");
		
	}.createDelegate(this);

	var updateSelection = function(el) {
		if ( this.lastThumbSelection ) {
			if ( this.lastThumbSelection.attr('src') == BLANK_IMAGE ) {
				this.lastThumbSelection.parent().removeClass("opa100");
			}
			else {
				flipClasses(this.lastThumbSelection.parent(), "opa100", "opa60");
			}
		}
		
		flipClasses(el.parent(), "opa60", "opa100");
		this.lastThumbSelection = el;

		var index = el.attr('index');
		
		var canScrollNext = index < maxImageIndex || hasNextPage;
		var canScrollPrev = index > 0 || hasPrevPage;
		flipClasses($("#scroller #left-scroll"), canScrollPrev  ? "opa20" : "opa100", canScrollPrev ? "opa100" : "opa20");
		flipClasses($("#scroller #right-scroll"), canScrollNext ? "opa20" : "opa100", canScrollNext ? "opa100" : "opa20");

	}.createDelegate(this);

	var onThumbClick = function(event) {
		var target = $(event.target);
		var index = target.attr('index');
		
		if ( target.attr('src') == BLANK_IMAGE ) {
			updateSizes();
			return;
		}

		updateSelection(target);

		var image = images[index];
		
		if ( !image ) return;

		var title = image.title; 	
		var fullImageUrl = image.url;

		var description = image.description;
		var hasDescription = description && description.trim().length > 0;
		var previewUrl = image.location;
		var width = image.width;
		var height = image.height;
	
		var pre = function pre() {
			previewContainer.html('<a href="' + fullImageUrl + '"><img width="' + width + '" height="' + height + '" src="' + previewUrl + '"/></a>');
			previewContainer.height(height + 20);
			previewContainer.width(width + 20);
			if ( enableFancybox ) {
				$("#image-full-preview-container a").fancybox({ 'hideOnContentClick': true, imageScale: true, showCloseButton: false });		
			}
			else {
				$("#image-full-preview-container a").click(function() { return false; });
			}

			$("#image-title-placeholder").html(title);
		
			var descriptionEl = $("#image-description");
			descriptionEl.html(description);
			descriptionEl.css('display', !hasDescription ? 'none' : 'block');
	
			$("#rating-wrapper").css('display', 'block');
			var rating = parseInt(image.rating);
			if ( rating == NaN || rating < 1 ) {
				$("#rating-wrapper form :radio.star").rating('drain');
			}
			else {
				$("#rating-wrapper form :radio.star").rating('select', image.rating - 1);
			}

			imageWrapper.css('display', 'block');
		
			scroller.css('display', 'block');
			scroller.width(width + 20);
			rightScroll.css('margin-left', width - 64);
		
			content.height(previewContainer.height() + descriptionEl.height() +  scroller.height() + $("#image-title-placeholder").parent().height() + 46);
		};
		
		var post = function post() {
			updateSizes();
			fixFancyZIndex();
		};
		
		pre();
		post();
		
		/*
		$('#image-wrap-scroll').fadeOut('slow', function() { 
			pre();
			post();
			$('#image-wrap-scroll').fadeIn('slow', post);
		});
		*/

	}.createDelegate(this);

	var navbarListener = function(event) {
		this.navigation.go($(event.target).attr('href'));
		return false;
	}.createDelegate(this);

	var thumbContainerMousewheelListener = function(event, delta) {
		if ( zin.mousewheelControlsImages ) {
			if ( delta > 0 ) {
				this.navigation.prevImage();
				return false;
			}			

			if ( delta < 0 ) {
				this.navigation.nextImage();
				return false;
			}
		}
		else {
			if ( hasPrevPage && delta > 0 ) {
				this.navigation.prevPage();
				return false;
			}			

			if ( hasNextPage && delta < 0 ) {
				this.navigation.nextPage();
				return false;
			}		
		}		
	}.createDelegate(this);

	var preload = function preload() {
		if ( !isAlbumPage ) {
			for ( var u = 0; u < images.length; u++ ) {
				$('#preloader').append("<img src='" + images[u].location + "'/>");
			}
		}
	};

	var registerListeners = function() {
		var fn = function(el) {
			var highlightPreview = function(c1, c2) {
				flipClasses(previewContainer, c1, c2);
				flipClasses(scroller, c1, c2);	
			};
			el.mouseover(highlightPreview.createDelegate(this, ["opa60", "opa100"]));
			el.mouseout(highlightPreview.createDelegate(this, ["opa100", "opa60"]));
		}

		fn(previewContainer);
		fn(scroller);

		$(".nav-cell a").click(navbarListener);

		$(".image-thumb img").click(onThumbClick);

		leftScroll.click(this.navigation.prevImage);
		rightScroll.click(this.navigation.nextImage);
		nextPageEl.click(this.navigation.nextPage);
		prevPageEl.click(this.navigation.prevPage);		
		
		if ( zin.enableMousewheel !== false )  {
			//$('#subalbum-thumb-container').timedBind("mousewheel", {delay: 0, buffer: 500}, thumbContainerMousewheelListener);
			//$('#image-thumb-container').timedBind("mousewheel", {delay: 0, buffer: 500}, thumbContainerMousewheelListener);
			$('#subalbum-thumb-container').mousewheel(thumbContainerMousewheelListener);
			$('#image-thumb-container').mousewheel(thumbContainerMousewheelListener);
		}

		$("#wrapper-mask").mousewheel(function() { return false; });

		$("#image-wrap-scroll").mouseover(function() {
			if ( this.highlightTitle === true ) {
				flipClasses($("#image-title"), "opa80", "opa100");
			}
		}.createDelegate(this));

		$("#image-wrap-scroll").mouseout(function() {
			if ( this.highlightTitle === true ) {
				flipClasses($("#image-title"), "opa100", "opa80");
			}
		}.createDelegate(this));
		
		if ( zin.enableKeyNavigation !== false ) {
			$(document.documentElement).keyup(function(event) {
				switch ( event.keyCode ) {
					case 37: //left key
						this.navigation.prevImage(); 
						return false;
					case 38: //up key
						if ( enableUpDownKeys ) {
							this.navigation.prevPage(); 
							return false;
						}
					case 39: //right key
						this.navigation.nextImage();
						return false;
					case 40: //down key
						if ( enableUpDownKeys ) {
							this.navigation.nextPage(); 
							return false;
						}
				}			
				return true;
			}.createDelegate(this));
		}

	}.createDelegate(this);

};

$(window).load(function() {
	zin.ALBUM_PAGE = new AlbumPage().init();
});
