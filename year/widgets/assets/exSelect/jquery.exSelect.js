/* jQuery Yii ExSelect plugin file.
    *
* @author yiqing95 <yiqing_95@qq.com>
* @license MIT
*/
;(function ($) {
    var methods,
        exSelectSettings = [];

    // logging function , can be attached to settings object for using "this.debug" setting.
    function debug(message, debug) {
        if (debug === true && window.console) {
            console.log(message);
        }
    }

    methods = {
        /**
         * exSelect set function.
         * @param options map settings for the exSelect view. Available options are as follows:
         * - url: string, the url that handle the ajax request !
         * @return object the jQuery object
         */
        init:function (options) {
            var settings = $.extend({
                parentParam:'parentId',
                url:'',
                parentId:0,
                maxLevel : 0 ,

                // one for outer usage the other for internal usage!
                editable:true,
                _editable:true,

                initNodeId:0,
                loadAncestorsUrl : '',

                selectHtmlOptions:{},
                firstOptionValue:0,
                firstOptionLabel:'please select',

                callback:function(selectedValues){},
                beforeLoadChildren:function(selectedValues){},

                debug:false
            }, options || {});

            return this.each(function () {
                var $exSelect = $(this),
                    id = $exSelect.attr('id');

                // if exists it means this is reinit
                /*
                 *  here has some bugs !
                 if(exSelectSettings[id]){
                 settings = $.extend(exSelectSettings[id],settings);
                 }
                 */
                // save this to the settings too !
                settings['self'] = $(this);
                exSelectSettings[id] = settings;

                // clear all content , this is useful for reEntry
                $exSelect.empty();

                if (settings.initNodeId !== 0) {

                    if( $.isFunction(settings.initNodeId)){
                        settings.initNodeId = settings.initNodeId();
                    }
                    var ancestors = [] , ajaxHtml ;
                    ajaxHtml   = $.ajax({
                        url: settings.loadAncestorsUrl,
                        data:{id:settings.initNodeId},
                        // dataType:'json',
                        async: false
                    }).responseText;
                    ancestors = $.parseJSON(ajaxHtml);
                    //--------------------------------------------------------\\
                    /**
                     * below we will construct a path which from the root node of the tree to the leaf node .
                     * and then save the path array in "this" jquery object !
                     * */
                    // ancestors.shift();// first is 0 ；
                    var last = ancestors.slice(-1)[0];
                    if(/*last == undefined ||*/ last != settings.initNodeId){
                        ancestors.push(settings.initNodeId); // last child
                    }
                    $exSelect.data('ancestors',ancestors);
                    debug('this ancestors for loading nodes is '+ancestors.toString(),settings.debug);
                    //---------------------------------------------------------//
                    $.fn.exSelect.loadChildren(id, null, {url:settings.url});
                } else {
                    //
                    $.fn.exSelect.loadChildren(id, null, {url:settings.url});
                }

            });
        },
        getUrl:function () {
            var sUrl = exSelectSettings[this.attr('id')].url;
            return sUrl;
        },
        getSettings:function(){
            return exSelectSettings[this.attr('id')] ;
        },
        reinit:function(){
            return methods.init.call(this,exSelectSettings[this.attr('id')]);
        }
    };

    $.fn.exSelect = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.exSelect');
            return false;
        }
    };

    /******************************************************************************\
     *** DEPRECATED METHODS
     \******************************************************************************/
    $.fn.exSelect.settings = exSelectSettings;

    /**
     * Performs an AJAX-based load of the current selected item's children
     * @param containerId string the ID of the exSelect view container
     * @param selectElement string the ID of the current select element(dom)
     * @param options map the AJAX request options (see jQuery.ajax API manual). By default,
     * the URL to be requested is the one that generates the current content of the ExSelect container div.
     */
    $.fn.exSelect.loadChildren = function (containerId, selectElement, options) {
        var settings = $.fn.exSelect.settings[containerId];
        // readonly mode
        if(settings._editable == false){
            return  ;
        }

        if (selectElement) {
            var $currentSelect = $(selectElement);
            $currentSelect.nextAll().remove();
            if($(selectElement).val() == settings.firstOptionValue){
                return ;
            }
        }

        //  max level
        var maxLevel = settings.maxLevel ;
        var currentLevel = $('.ex-select', '#'+containerId).size() ;
        if( maxLevel != 0){
            if(currentLevel >= maxLevel ){
                return ;
            }
        }

        // --------------------------------------------------------\\
        // the function callback will be called before loading the children
        // if this function return false loading will be cancelled !
        //---------------------------------------------------------//
        var beforeLoadChildren = settings.beforeLoadChildren;
        if($.isFunction(beforeLoadChildren)){
            var selectedValues = [];
            $('.ex-select', $('#' + containerId)).each(function(){
                selectedValues.push($(this).val());
            });
            var rtn =   beforeLoadChildren(selectedValues);
            if(rtn !== undefined && rtn === false){
                return;
            }
        }

        //  $('#' + id).addClass(settings.loadingClass);
        options = $.extend({
            async: false,
            type:'GET',
            dataType:'json',
            url:settings.url,
            success:function (data, status) {
                // alert(data);
                // data = $.parseJSON(data);
                if (jQuery.isEmptyObject(data)) {
                    return;
                }

                var firstOptionValue = settings.firstOptionValue ;
                var firstOptionLabel = settings.firstOptionLabel ;

                // if we have a firstOptionCallBack will get the first option setting from it
                var  firstOptionCallBack = settings.firstOptionCallBack ;
                if($.isFunction(firstOptionCallBack)){
                    var firstOptionConf =  firstOptionCallBack.apply(settings.self, [currentLevel]);
                    if( firstOptionConf != undefined &&  !$.isEmptyObject(firstOptionConf)){
                        var returnType = jQuery.type(firstOptionConf);
                        if(returnType == 'string'){
                            firstOptionLabel = firstOptionConf ;
                        }
                        // TODO we should handle the "array","object" returnType too!
                    }
                }

                var html = '<select>';
                html += '<option value="'+firstOptionValue+'">'+firstOptionLabel +'</option>';

                $.each(data, function (k, v) {
                    html += ('<option value="' + k + '">' + v + "</option>");
                });

                html += "</select>";
                var $wrapper = $("<div>").addClass('temp-wrapper');

                var $select =  $(html);
                if(!jQuery.isEmptyObject(settings.selectHtmlOptions)){
                    $.each(settings.selectHtmlOptions,function(k,v){
                        $select.attr(k,v);
                    });
                }
                $select.addClass('ex-select');

                $wrapper.append($select);

                if (selectElement) {
                    $currentSelect.after($wrapper);
                } else {
                    $('#' + containerId).append($wrapper)
                }
                $wrapper.find('select').change(function () {

                    var params = {};
                    params[settings.parentParam] = $(this).val() ;
                    $.fn.exSelect.loadChildren(containerId, this, { url:settings.url, data:params });

                    var cb = settings.callback ;
                    if($.isFunction(cb)){
                        var selectedValues = [];
                        $('.ex-select', $('#' + containerId)).each(function(){
                            selectedValues.push($(this).val());
                        });
                        cb(selectedValues);
                        debug('the selected values is :'+selectedValues.toString(),settings.debug);
                    }
                }).unwrap('.temp-wrapper');

                // after load children set the init value if  there have ancestors param
                var ancestors = $("#"+containerId).data('ancestors');
                if(ancestors != undefined){
                    if(ancestors.length > 0){
                        var firstParent = ancestors.shift();
                        $select.val(firstParent);

                        $("#"+containerId).data('ancestors',ancestors);

                        if( ancestors.length != 0 ){
                            $select.trigger('change'); // $select.change();
                        }else{
                            if(settings.editable == false){
                                // the last node has loaded ,set the internal flag
                                $.fn.exSelect.settings[containerId]._editable = false;
                            }
                        }
                        if(settings.editable == false){
                            $select.prop('disabled', true);
                        }
                    }
                }

                /*
                 $('select', $child).on('change',function(){
                 alert('yee');
                 });*/
                //  $('#' + id).removeClass(settings.loadingClass);
            },
            error:function (XHR, textStatus, errorThrown) {
                var ret, err;
                //  $('#' + id).removeClass(settings.loadingClass);
                if (XHR.readyState === 0 || XHR.status === 0) {
                    return;
                }
                switch (textStatus) {
                    case 'timeout':
                        err = 'The request timed out!';
                        break;
                    case 'parsererror':
                        err = 'Parser error!';
                        break;
                    case 'error':
                        if (XHR.status && !/^\s*$/.test(XHR.status)) {
                            err = 'Error ' + XHR.status;
                        } else {
                            err = 'Error';
                        }
                        if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
                            err = err + ': ' + XHR.responseText;
                        }
                        break;
                }
            }
        }, options || {});

        // TODO here we should write a function to replace the $.param.querystring [from jquery-bbq plugin]
        if (options.data != undefined && options.type == 'GET') {
            options.url = $.param.querystring(options.url, options.data);
            options.data = {};
        }

        $.ajax(options);
    };
})(jQuery);
