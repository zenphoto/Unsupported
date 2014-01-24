Function.prototype.createDelegate = function(obj, args, appendArgs){
    var method = this;
    return function() {
        var callArgs = args || arguments;
        if(appendArgs === true){
            callArgs = Array.prototype.slice.call(arguments, 0);
            callArgs = callArgs.concat(args);
        }else if(typeof appendArgs == "number"){
            callArgs = Array.prototype.slice.call(arguments, 0); // copy arguments first
            var applyArgs = [appendArgs, 0].concat(args); // create method call params
            Array.prototype.splice.apply(callArgs, applyArgs); // splice them in
        }
        return method.apply(obj || window, callArgs);
    };
};
Function.prototype.defer = function(millis, obj, args, appendArgs){
	var fn = this.createDelegate(obj, args, appendArgs);
	if(millis){
	    return setTimeout(fn, millis);
	}
	fn();
	return 0;
};

Function.prototype.createSequence = function(fcn, scope) {
    var method = this;
    return !Ext.isFunction(fcn) ?
        this :
        function(){
            var retval = method.apply(this || window, arguments);
            fcn.apply(scope || this || window, arguments);
            return retval;
        };
};


String.prototype.urlencode = function urlencode() {
	return escape(this).replace(/\+/g,'%2B').replace(/%20/g, '+').replace(/\*/g, '%2A').replace(/\//g, '%2F').replace(/@/g, '%40');
};

String.prototype.trim = function() {
	return this.replace(/\s+$/, '').replace(/\s+$/, '');
}

var flipClasses = function flipClasses(el, c1, c2) {
	el.removeClass(c1);
	el.addClass(c2);
};

var fixFancyZIndex = function() {	
	//adapted from http://commonmanrants.blogspot.com/2008/11/fancybox-jquery-and-z-index.html

	var zmax = 0 ;
   
   	var buildZMax = function() {
	 	$('*').each(function() {
	   		var cur = parseInt($(this).css('zIndex'));
	   		zmax = cur > zmax ? cur : zmax;
		});
   	}

	var updateFancy = function(el) {
		zmax = zmax + 1 ;
   		el.css("z-index", zmax);

	}
   	
	var goFancy = function() {

   		$("div#fancy_overlay").each(function() {
	 		updateFancy($(this));
   		});

   		$("div#fancy_outer").each(function() {
	 		updateFancy($(this));
   		});
	};

 	buildZMax();

	goFancy();
};

var clearForm = function clearForm(elem) {
    $(elem).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });

};

