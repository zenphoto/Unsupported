var ArchivePage = function() {
	var onMonthClick = function(url, month) {	
		try {
			zin.ALBUM_PAGE.handlePageNavigation({
				url: url,
				selectionIndex: 'first',
				onSuccess: function() {
					var totalImages = $('#thumbs-navigation').attr('totalImages');
					$('#album-count').html(totalImages);
					$('#current-month-placeholder').html(month);
				}
			});
		}
		catch ( e ) {
			console.error(e);
		}
		finally {
			return false;
		}
	};

	var initCarousel = function() {
		$('#archive-carousel').jCarouselLite({
			visible: 3,
			circular: false,
			mouseWheel: false,
			speed: 600,
			btnPrev: "#archive-wrapper .prev",
			btnNext: "#archive-wrapper .next"
		});
		$('#archive-carousel ul.archive li.year').addClass('box-shadow');
		$('#archive-carousel ul.archive li.year').addClass("opa80");
		$('#archive-wrapper .prev').addClass('disabled');
	
	};
	
	var initMenu = function() {
		$('.year').each(function() {
			var year = $(this).attr('year');
			var qtip = $(this);
			$(this).qtip({
				content: $("#year-detail-wrapper-" + year).html(),
			 	position: {
		  			corner: {
		     			target: 'bottomLeft',
		     			tooltip: 'topLeft'
		  			}
	   			},
				api: {
					onRender: function() {
						this.elements.content.find('a').click(function() { 
							var url = $(this).attr('href');							
							onMonthClick(url, $(this).parent().attr('text')); 
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
					effect: 'slide'
				},
			 	hide: {
					fixed: true,
					when: { 
						event: 'unfocus' 
					},
					effect: 'slide'
				},
			 	style: {
					opacity: .5,
					padding: '5px 15px',
					border: {
		     			width: 4,
		     			radius: 1
		  			},
					name: 'light'
			 	}
			});
	   });
	};

	this.init = function init() {
		zin.ALBUM_PAGE.highlightTitle = false;
	
		//account for image-wrap-scroll margin-top
		$("#content-filler").height($("#content-filler").height() + ($.browser.mozilla ? 19 : 22));
		
		initCarousel();
		initMenu();		
	};
}

AlbumPage.skipInitialSelection = true;

$(window).load(function() {
	new ArchivePage().init();	
});
