/**
 * Created by yiqing on 2017/3/14.
 */

/*

 jQuery pub/sub plugin by Peter Higgins (dante@dojotoolkit.org)

 Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.

 Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
 http://dojofoundation.org/license for more information.

 */

;
(function(d) {

    // the topic/subscription hash
    var cache = {};

    d.publish = function( /* String */ topic, /* Array? */ args) {
        // summary:
        //		Publish some data on a named topic.
        // topic: String
        //		The channel to publish on
        // args: Array?
        //		The data to publish. Each array item is converted into an ordered
        //		arguments on the subscribed functions.
        //
        // example:
        //		Publish stuff on '/some/topic'. Anything subscribed will be called
        //		with a function signature like: function(a,b,c){ ... }
        //
        //	|		$.publish("/some/topic", ["a","b","c"]);
        cache[topic] && d.each(cache[topic], function() {
            this.apply(d, args || []);
        });
    };

    d.subscribe = function( /* String */ topic, /* Function */ callback) {
        // summary:
        //		Register a callback on a named topic.
        // topic: String
        //		The channel to subscribe to
        // callback: Function
        //		The handler event. Anytime something is $.publish'ed on a
        //		subscribed channel, the callback will be called with the
        //		published array as ordered arguments.
        //
        // returns: Array
        //		A handle which can be used to unsubscribe this particular subscription.
        //
        // example:
        //	|	$.subscribe("/some/topic", function(a, b, c){ /* handle data */ });
        //
        if (!cache[topic]) {
            cache[topic] = [];
        }
        cache[topic].push(callback);
        return [topic, callback]; // Array
    };

    d.unsubscribe = function( /* Array */ handle) {
        // summary:
        //		Disconnect a subscribed function for a topic.
        // handle: Array
        //		The return value from a $.subscribe call.
        // example:
        //	|	var handle = $.subscribe("/something", function(){});
        //	|	$.unsubscribe(handle);
        var t = handle[0];
        cache[t] && d.each(cache[t], function(idx) {
            if (this == handle[1]) {
                cache[t].splice(idx, 1);
            }
        });
    };

})(jQuery);



//Copyright (c) 2010 Nicholas C. Zakas. All rights reserved.
//MIT License
//http://jsperf.com/peter-higgins-pubsub-vs-tiny-pubsub/6
var CustomEvent = new Class({
    constructor: function() {
        this._listeners = {};
    },
    addListener: function(type, listener) {
        if (typeof this._listeners[type] === "undefined") {
            this._listeners[type] = [];
        }
        this._listeners[type].push(listener);
    },
    fire: function(event) {
        if (typeof event === "string") {
            event = {type: event};
        }
        if (!event.target) {
            event.target = this;
        }
        if (!event.type) {  //falsy
            throw new Error("Event object missing 'type' property.");
        }

        if (this._listeners[event.type] instanceof Array) {
            var listeners = this._listeners[event.type];
            for (var i = 0, len = listeners.length; i < len; i++) {
                listeners[i].call(this, event);
            }
        }
    },
    removeListener: function(type, listener) {
        if (this._listeners[type] instanceof Array) {
            var listeners = this._listeners[type];
            for (var i = 0, len = listeners.length; i < len; i++) {
                if (listeners[i] === listener) {
                    listeners.splice(i, 1);
                    break;
                }
            }
        }
    },
    hasListeners: function(type) {
        if (this._listeners[type] instanceof Array) {
            return (this._listeners[type].length > 0);
        } else {
            return false;
        }
    },
    getListeners:function(type) {
        if (this._listeners[type] instanceof Array) {
            return this._listeners[type];
        }
    }
});


(function($) {

    var o = $({});

    $.sub = function() {
        o.on.apply(o, arguments);
    };

    $.unsub = function() {
        o.off.apply(o, arguments);
    };

    $.pub = function() {
        o.trigger.apply(o, arguments);
    };

}(jQuery));


