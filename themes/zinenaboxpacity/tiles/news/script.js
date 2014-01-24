var NewsPage = function() {
	var lastSelectedNews = null;
	var lastUrlLoaded = null;

	var content = $("#content");
	var navbar = $("#album-nav");
	var originalNavbarHeight = navbar.height();
	var wrapperMask = $("#wrapper-mask");
	var navigationDiv = $("#navigation");
	var navHeight = navigationDiv.height();
	var extra = $("#extra");
	var filler = $("#page-filler");
	var originalFillerHeight = filler.height();

	var newsWrapperEl = $("#news-wrappers");

	var contentPlaceholder = $("#news-content-placeholder");
	var titlePlaceholder = $("#image-title-placeholder");
	var datePlaceholder = $("#news-date-placeholder");
	var categoriesPlaceholder = $("#news-categories-placeholder");
	
	var loading = false;
	
	var restoreFillerHeight = function() {
		filler.height(originalFillerHeight);
		navbar.height(filler.offset().top - navbar.offset().top + originalFillerHeight);
		navHeight = navigationDiv.height();
	};
	
	var updateSizes = function() {
		restoreFillerHeight();

		//var cHeight = contentPlaceholder.height();
		var cHeight = $('#page-body').height();
		content.height(cHeight + contentPlaceholder.offset().top - content.offset().top);

		var contentHeight = content.height();
		var height = navHeight > contentHeight ? navHeight : contentHeight;

		content.height(height);
		navbar.height(height);
		filler.height(originalFillerHeight);
		filler.height(extra.offset().top - filler.offset().top - 5);
	};

	var getSuffixedNumber = function getSuffixedNumber(n) {
		var num = String(n);
		var lastDigit = num.substring(num.length - 1);
		switch(lastDigit) {
			case "1":
				num += "st";
				break;
			case "2":
				num += "nd";
				break;
			case "3":
				num += "rd";
				break;
			default:
				num += "th";
		}
		return num;
	};

	var createDateBlock = function createDateBlock(obj) {
		return  "<span>" + obj.year + " " + obj.month + ", the " + getSuffixedNumber(obj.day) + "</span>";
	};

	var updateSelection = function updateSelection(el) {
		if ( lastSelectedNews ) {
			flipClasses(lastSelectedNews, "opa80", "opa40");
		}
		
		flipClasses(el, "opa40", "opa80");
		lastSelectedNews = el;
	};

	var onPreviewClick = function onPreviewClick() {
		if ( lastSelectedNews && lastSelectedNews.attr('index') == $(this).attr('index') ) {
			return;
		}

		var index = $(this).attr('index');

		var title = news[index].title;
		var contentText = news[index].content;
		var newsDate = news[index].date;
		var categories = news[index].categories;
		var commentson = news[index].commentson;
		var commentCount = news[index].commentCount;

		categories = categories && categories.trim() != '' ?  "<span> In: " + categories + "</span>" : "";

		contentPlaceholder.html(contentText);
		titlePlaceholder.html(title);
		datePlaceholder.html(createDateBlock(newsDate));
		categoriesPlaceholder.html(categories);

		updateSizes();

		updateSelection($(this));

		var commentAllowed = commentson || (commentCount > 0);

		$('#news-comments').css('display', commentAllowed ? 'block' : 'none'); 
		$('#loaded-comments').html('');

		hideComments();

		if ( commentAllowed ) {
			$('#news-comment-count .count').text(commentCount);
			var plural = commentCount > 1;
			$('#news-comment-count .plural').css('display', plural ? 'inline' : 'none');
			$('#news-comment-count .singular').css('display', plural ? 'none' : 'inline');
			$("#news-comment-control").click(hideShowComments);
		}
		else {
			$('#commentform').unbind(postComment);
			$("#news-comment-control").unbind('click', hideShowComments);
		}
	};
	
	var postComment = function postComment() {
		var url = zin.postCommentUrl + 
				  (zin.fetchNewsCommentUrl.indexOf('?') > 0 ? '&' : '?') + 
				  "c=news&title=" + lastSelectedNews.attr('titleLink');
		var data = $("#commentform").serialize();
		$.post(url, data, function(r, textStatus) {
			//captcha el: #commentform label[for=code] img
			var d = $("<div>" + r + "</div>");
			var result = d.find('#add-comment-result').html();
			var success = !d.find('#add-comment-result').hasClass('error');
			var captcha = d.find('#captcha_updater');
			var code = captcha.attr('code');
			var img = captcha.attr('img');
		
			zin.createModalBox((success ? zin.messages.success : zin.messages.error), result, "comment-error-popup", { maxWidth: 380 });

			if ( success ) {
				clearForm($("#commentform"));
				$("#add-comment-header").trigger('click');
			}
						
			$("#commentform td label[for=code] img").attr('src', img);
			$("#commentform input[name=code_h]").attr('value', code);
		});
	};

	var hideShowComments = function hideShowComments() {
		if ( !lastSelectedNews ) return;

		var open = $("#news-comment-control").attr('open');

		if ( open ) hideComments();
		else showComments();
	}

	var showComments = function showComments() {
		$("#news-comment-control img.control").attr('src', zin.themeroot + "/resources/images/arrow_down.png");
		$("#news-comment-control").attr('open', 1);

		if ( $('#loaded-comments').html() == '' ) {
			$('#loaded-comments').html('<div class="loader">Loading comments...</div>');

			$('#loaded-comments').css('display', 'block');

			$.ajax({
				url: zin.fetchNewsCommentUrl,
				data: {
					title: lastSelectedNews.attr('titleLink'),
					c: 1
				},
				success: function(data) {
					$('#loaded-comments').css('visible', 'false');

					$('#loaded-comments').html(data);

					$('#loaded-comments .commenttext').addClass('opa40');
					$('.date-wrapper').addClass('opa40');
					$('.date-wrapper div').addClass('opa60');
					$('#commentform').submit(function() { postComment(); return false; });
				
					updateSizes();	

					$('#loaded-comments').css('visible', 'true');			
				},
				error: function(r, e) {
					//we definitively should warn user
					$('#loaded-comments').html('');
				}
			});
		}
		else {
			$('#loaded-comments').css('visible', 'false');
			$('#loaded-comments').css('display', 'block');
			updateSizes();	
			$('#loaded-comments').css('visible', 'true');
		}
	}

	var hideComments = function hideComments() {
		$("#news-comment-control img.control").attr('src', zin.themeroot + "/resources/images/arrow_left.png");
		$("#news-comment-control").removeAttr('open');

		$('#loaded-comments').css('display', 'none');

		updateSizes();
	}

	var createNewsItem = function createNewsItem(el) {
		var dt = el.find('.date');
		var d = {day: dt.attr('day'), month: dt.attr('month'), year: dt.attr('year') };
		var n = {
			title: el.attr('title'),
			date: d,
			categories: el.find('.categories').text(),
			content: el.find('.content'),
			previewTitle: el.attr('previewTitle'),
			preview:  el.find('.preview').text(),
			commentson: el.attr('commentson') == "true",
			commentCount: parseInt(el.attr('commentCount')),
			titleLink: el.attr('titleLink')
		};
		news.push(n);
		var idx = news.length - 1;
		var style = '';
		if ( $.browser.opera ) {
			style = " style='margin-left: 1px;'";
		}
		return [
			'<div id="news-' + idx + '" index="' + idx + '" class="news-preview-wrapper opa40" titleLink="' + n.titleLink + '"' + style + '>\n',
			'	<div class="news-preview">\n',
			'		<div class="news-preview-title">\n',
			'			<span>' + n.previewTitle + '</span>\n',
			'		</div>\n',
			'		<div class="news-preview-content">\n',
			'			' + n.preview + '\n',
			'		</div>\n',
			'	</div>\n', 
			'</div>\n'
		].join('');
	};

	var handlePageNavigation = function handlePageNavigation(opt) {
		var selectionIndex = opt.selectionIndex;
		if ( selectionIndex === 'first' ) {
			selectionIndex = 0; 
		}
		if ( opt.url == lastUrlLoaded ) {
			if ( zin.enableMousewheel !== false )  {
				newsWrapperEl.timedBind("mousewheel", {delay: 0, buffer: 500}, function(event, delta) {
					onScrollButtonClick((delta > 0 ? $("#news-nav-prev") : $("#news-nav-next")).parent());
					return false;
				});
			}
			return;
		}
		lastUrlLoaded = opt.url;
		wrapperMask.height(content.height());
		wrapperMask.css('display', 'block');
		wrapperMask.css('top', content.offset().top);
		loading = true;
		$.ajax({ 
			url: opt.url, 
			success: function(xml){
				$('#workaround-non-xml-comment-crap').html(xml);
				lastSelectedNews = null;
				var coll = $('#workaround-non-xml-comment-crap').find('.news');
				var previewReplacement = "";
				
				news.length = 0;

				coll.each(function(idx) {
					previewReplacement += createNewsItem($(this));
				});
				newsWrapperEl.html(previewReplacement);

				var bar = $('#workaround-non-xml-comment-crap').find('#navigation').find('#bar');
				var nav = bar.html();
				navbar.html(nav);

				var prevNext = $('#workaround-non-xml-comment-crap').find('#navigation').find('#nav')	
				var prev = prevNext.find('.prev');
				var next = prevNext.find('.next');

				var currentPrev = $("#news-nav-prev");
				var currentNext = $("#news-nav-next");

				currentPrev.replaceWith(prev.html());
				currentNext.replaceWith(next.html());

				registerListeners();
			 	
				$(".news-preview-wrapper:first").trigger('click');

				wrapperMask.css('display', 'none');

				loading = false;
			},
			error: function(req, error)  {
				wrapperMask.css('display', 'none');
				loading = false;
			}
		});
	};

	this.navigation = {
		go: function(url, selectionIndex) {
			handlePageNavigation({
				url: url + '&f=xml',
				selectionIndex: selectionIndex || 'first'
			})		
		}
	};

	var onNavbarClick = function(event) {
		this.navigation.go($(event.target).attr('href'));
		return false;
	}.createDelegate(this);

	var onScrollButtonClick = function(el) {
		if ( el ) {
			this.navigation.go(el.attr('href'));
		}
	}.createDelegate(this); 

	var registerListeners = function registerListeners() {
		if ( zin.enableMousewheel !== false )  {		
			newsWrapperEl.unbind('mousewheel');
		}
		$("#wrapper-mask").unbind('mousewheel');

		$(".news-preview-wrapper").click(onPreviewClick);
		$(".nav-cell a").click(onNavbarClick);

		$('.news-nav-scroll').parent().click(function() {
			onScrollButtonClick($(this));
			return false;
		});
		
		if ( zin.enableMousewheel !== false )  {
			newsWrapperEl.timedBind("mousewheel", {delay: 0, buffer: 500}, function(event, delta) {
				onScrollButtonClick((delta > 0 ? $("#news-nav-prev") : $("#news-nav-next")).parent());
				return false;
			});
		}

	}.createDelegate(this);
	
	this.init = function() {
		registerListeners();

		$("body").mousewheel(function() { return loading !== true; });

		$(".news-preview-wrapper").each(function(idx) {
			if ( idx == initialSelection ) {
				$(this).trigger('click');
			}
		});	
		if ( !lastSelectedNews ) {
			$(".news-preview-wrapper:first").trigger('click');
		}
	};

	this.updateSizes = updateSizes;
};

$(window).load(function() {
	$.currentPage = new NewsPage();	
	$.currentPage.init();
});
