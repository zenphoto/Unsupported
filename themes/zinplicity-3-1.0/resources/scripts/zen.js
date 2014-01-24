$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

$.ajaxSetup ({  cache: false  }); 

String.prototype.startsWith = function(str) {
	return this.match("^" + str) == str;
}

String.prototype.trim = function(str) {
	return this.replace(/^\s+/g,'').replace(/\s+$/g,'');
}

/* borrowed from Ext + a few modifications */
var Zen = {
	idSeed: 1000,
	isIE: $.browser.msie,
	emptyFn: function() { },
	ns: function(){
        var o, d;
        Zen.each(arguments, function(v) {
            d = v.split(".");
            o = window[d[0]] = window[d[0]] || {};
            Zen.each(d.slice(1), function(v2){
                o = o[v2] = o[v2] || {};
            });
        });
        return o;
	},
	override: function(origclass, overrides){
        if(overrides){
            var p = origclass.prototype;
            Zen.apply(p, overrides);
            if(Zen.isIE && overrides.hasOwnProperty('toString')){
                p.toString = overrides.toString;
            }
        }
    },
	apply: function(o, c, defaults){
		if(defaults){
		    Zen.apply(o, defaults);
		}
		if(o && c && typeof c == 'object') {
		    for(var p in c){
		        o[p] = c[p];
		    }
		}
		return o;
	},
	each: function(array, fn, scope){
        if(Zen.isEmpty(array, true)){
            return;
        }
        if(!Zen.isIterable(array) || Zen.isPrimitive(array)){
            array = [array];
        }
        for(var i = 0, len = array.length; i < len; i++){
            if(fn.call(scope || array[i], array[i], i, array) === false){
                return i;
            };
        }
    }, 
	isIterable: function(v){
        if(Zen.isArray(v) || v.callee){
            return true;
        }
        if(/NodeList|HTMLCollection/.test(toString.call(v))){
            return true;
        }
        return ((typeof v.nextNode != 'undefined' || v.item) && Zen.isNumber(v.length));
    },
	isEmpty : function(v, allowBlank){
        return v === null || v === undefined || ((Zen.isArray(v) && !v.length)) || (!allowBlank ? v === '' : false);
    },
    isArray : function(v){
        return !!v && Object.prototype.toString.call(v) === '[object Array]';
    },
    isDate : function(v){
        return !!v && Object.prototype.toString.call(v) === '[object Date]';
    },
    isObject : function(v){
        return !!v && Object.prototype.toString.call(v) === '[object Object]';
    },
    isPrimitive : function(v){
        return Zen.isString(v) || Zen.isNumber(v) || Zen.isBoolean(v);
    },
	isFunction : function(v){
        return !!v && Object.prototype.toString.call(v) === '[object Function]';
    },
    isNumber : function(v){
        return typeof v === 'number' && isFinite(v);
    },
    isString : function(v){
        return typeof v === 'string';
    },
    isBoolean : function(v){
        return typeof v === 'boolean';
    },
    isElement : function(v) {
        return v ? !!v.tagName : false;
    },
    isDefined : function(v){
        return typeof v !== 'undefined';
    },
	id: function() {
		return "zen-" + (++Zen.idSeed);
	}
};

Zen.apply(Function.prototype, {
    createInterceptor : function(fcn, scope){
        var method = this;
        return !Zen.isFunction(fcn) ?
                this :
                function() {
                    var me = this,
                        args = arguments;
                    fcn.target = me;
                    fcn.method = method;
                    return (fcn.apply(scope || me || window, args) !== false) ?
                            method.apply(me || window, args) :
                            null;
                };
    },
    createCallback : function(/*args...*/){
        var args = arguments,
            method = this;
        return function() {
            return method.apply(window, args);
        };
    },
    createDelegate : function(obj, args, appendArgs){
        var method = this;
        return function() {
            var callArgs = args || arguments;
            if (appendArgs === true){
                callArgs = Array.prototype.slice.call(arguments, 0);
                callArgs = callArgs.concat(args);
            }else if (Zen.isNumber(appendArgs)){
                callArgs = Array.prototype.slice.call(arguments, 0);
                var applyArgs = [appendArgs, 0].concat(args); 
                Array.prototype.splice.apply(callArgs, applyArgs);
            }
            return method.apply(obj || window, callArgs);
        };
    },
    defer : function(millis, obj, args, appendArgs){
        var fn = this.createDelegate(obj, args, appendArgs);
        if(millis > 0){
            return setTimeout(fn, millis);
        }
        fn();
        return 0;
    }
});

Zen.ns('Zen.theme');

