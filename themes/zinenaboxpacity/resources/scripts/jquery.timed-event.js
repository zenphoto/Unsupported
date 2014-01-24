
jQuery.fn.timedBind = function(type, data, fn) {
    data = data || {};
    var defaults = {
        delay: 0,
	buffer: 0
    };
    data = jQuery.extend(defaults, data);

    if (data.delay || data.buffer) {
         data.originalHandler = fn;   
    }
    
    var encloseFunction  = function(fn) {
        return function(e) {
			fn.apply(e.target, arguments);
		};
    }; 
    

    
    this.each(function() {
        var handler = function(e) {
            if (e.data.delay) {
	        setTimeout(encloseFunction(fn), e.data.delay, e);
	    }
	    
	    if (e.data.buffer) {
	        if (e.data.lastCalled && (e.timeStamp - e.data.lastCalled < e.data.buffer)) {
		    return;
		}
		else {
		    fn.apply(this, arguments);
		    jQuery(this).bind(type, jQuery.extend(e.data, {lastCalled: new Date().getTime()}), handler);
		}
				
	    }
        };    
        jQuery(this).bind(type, data, handler);
    });
};





