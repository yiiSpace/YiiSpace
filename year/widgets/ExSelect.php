<?php
/**
 * User: yiqing
 * Date: 14-9-16
 * Time: 下午7:32
 */

namespace year\widgets;

use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\web\JsExpression;
use yii\web\View;

/**
 * TODO 目前该插件依赖了一个bbq插件 是yii1.x默认导入的
 * TODO 实际功能只是拼接url跟queryString 有空需要写个方法替换掉那个插件即可
 * TODO   严重bug： 当下拉列表只有一列时没有发生change方法 回调没有被执行呢！！！
 *
 * ------------------------------------------------------
 * 隐藏域可能出现的问题：
 * Whenever you change the value of a hidden field using script,
 * it wont fire any event. But you can manually trigger the event if you are using jQuery.
 * 用js变化隐藏域字段的value值是不会触发任何事件的，如果你使用的是jquery可以手动触发！
 * $("#hid").val("2").change();  或者： $('#hidden_input').val('new_value').trigger('change');
 * ------------------------------------------------------
 *
 * Class ExSelect
 * @package year\widgets
 */
class ExSelect extends Widget
{


    public $parentParam = 'parentId';

    /**
     * @var int
     */
    public $jsPluginPos = View::POS_END;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var string
     */
    public $container;

    /**
     * @var string
     */
    public $url;

    /**
     * @var int
     * this is the top root id
     */
    public $parentId = 0;

    /**
     * @var int
     * used to recover the last scenario when selection happened .
     */
    public $initNodeId = 0;

    /**
     * @var string
     * when the initNodeId has some value
     * will use the url to load all its ancestors
     */
    public $loadAncestorsUrl;

    /**
     * @var int
     * the max level should be loaded
     * non-zero value is required , 0 means infinite
     */
    public $maxLevel = 0;

    /**
     * @var bool
     */
    public $debug = false;

    /**
     * @var array
     */
    public $selectHtmlOptions = [];

    /**
     * @var string|\yii\web\JsExpression
     */
    public $callback = 'function(selectedValues){}';

    /**
     * @var string|\yii\web\JsExpression
     */
    public $beforeLoadChildren = 'function(selectedValues){}';


    /**
     * @var int
     */
    public $firstOptionValue = 0;
    /**
     * @var string
     * eg: 'please select &nabla;';
     */
    public $firstOptionLabel = '请选择  &darr;';

    /**
     * TODO 第一个选项回调函数 可以根据level 等环境返回不同的label
     *
     * @var string|\yii\web\JsExpression
     */
    public $firstOptionCallBack = 'function(level){}';

    /**
     * @var string
     * notice: multi instance in the save view!
     *
     */
    public $apiVar = 'exSelect';

    /**
     * TODO 是不是允许编辑
     * @var bool
     */
    public $editable = true;

    public function run()
    {
        \year\widgets\ExSelectAsset::register($this->getView());

        // $this->registerPlugin();

        if (empty($this->container)) return;

        $this->options = array(
            'parentParam' => $this->parentParam,

            'maxLevel' => $this->maxLevel,
            'url' => $this->url,
            'parentId' => $this->parentId,
            'initNodeId' => empty($this->initNodeId)? 0 : $this->initNodeId,
            'loadAncestorsUrl' => $this->loadAncestorsUrl,

            'editable' => $this->editable,

            'selectHtmlOptions' => $this->selectHtmlOptions,
            'firstOptionValue' => $this->firstOptionValue,
            'firstOptionLabel' => $this->firstOptionLabel,
            'firstOptionCallBack' => $this->firstOptionCallBack,

            'callback' => $this->callback,
            'beforeLoadChildren' => $this->beforeLoadChildren,
            'debug' => $this->debug,
        );

        // check some condition
        if(!empty($this->options['initNodeId'])){
            if(empty($this->loadAncestorsUrl)){
                throw new InvalidParamException('you must specify the loadAncestorsUrl for the initNodeId property ');
            }
        }

        //> encode it for initializing the current jquery  plugin
        $options = \yii\helpers\Json::encode($this->options);

        //>  the js code for setup
        /**
         * $("#exSelect").exSelect({
         * parentId:0,
         * url:'<?php echo $this->createUrl('4ics2');?>',
         * selectHtmlOptions:{"style":"float:left;margin:0 10px 0 0;","name":"node[]"}
         * })
         */
        $jsCode = <<<SETUP
           {$this->apiVar} = jQuery('{$this->container}').exSelect({$options});
SETUP;

        //> register jsCode
        $view = $this->getView();
        $view->registerJs("var {$this->apiVar};", View::POS_HEAD, __CLASS__ . 'api-var#' . $this->apiVar);
        $view->registerJs($jsCode, View::POS_READY, __CLASS__ . '#' . $this->getId());


    }

    /**
     * @deprecated
     */
    protected function registerPlugin()
    {
        $jsPlugin = <<<EOD
/**
     * jQuery Yii ExSelect plugin file.
     *
     * @author yiqing95 <yiqing_95@qq.com>
     * @license MIT
     */
    (function ($) {
        var methods,
                exSelectSettings = [];

        // logging
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
                    var \$exSelect = $(this),
                         id = \$exSelect.attr('id');

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
                    \$exSelect.empty();
                      if (settings.initNodeId !== 0) {

                        if( $.isFunction(settings.initNodeId)){
                          settings.initNodeId = settings.initNodeId();
                        }

                        var ancestors , ajaxHtml ;
                         ajaxHtml   = $.ajax({
                            url: settings.loadAncestorsUrl,
                            data:{id:settings.initNodeId},
                            // dataType:'json',
                            async: false
                        }).responseText;
                        ancestors = $.parseJSON(ajaxHtml);
                        // ancestors.shift();// first is 0 ；
                        // ancestors.push(settings.initNodeId); // last child
                        // alert(""+ancestors)
                        \$exSelect.data('ancestors',ancestors);
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
                var \$currentSelect = $(selectElement);
                \$currentSelect.nextAll().remove();
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
                    var \$wrapper = $("<div>").addClass('temp-wrapper');

                    var \$select =  $(html);
                    if(!jQuery.isEmptyObject(settings.selectHtmlOptions)){
                        $.each(settings.selectHtmlOptions,function(k,v){
                           \$select.attr(k,v);
                        });
                    }
                    \$select.addClass('ex-select');

                    \$wrapper.append(\$select);

                    if (selectElement) {
                        \$currentSelect.after(\$wrapper);
                    } else {
                        $('#' + containerId).append(\$wrapper)
                    }
                    \$wrapper.find('select').change(function () {

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

                   // after load children set the init value if if there have ancestors param
                   var ancestors = $("#"+containerId).data('ancestors');
                    if(ancestors != undefined){
                        if(ancestors.length > 0){
                            var firstParent = ancestors.shift();
                            \$select.val(firstParent);

                             $("#"+containerId).data('ancestors',ancestors);

                             if( ancestors.length != 0 ){
                                  \$select.trigger('change');//\$select.change();
                             }else{
                               if(settings.editable == false){
                                   // the last node has loaded ,set the internal flag
                                   $.fn.exSelect.settings[containerId]._editable = false;
                               }
                             }
                              if(settings.editable == false){
                                 \$select.prop('disabled', true);
                              }
                        }
                    }

                    /*
                    $('select', \$child).on('change',function(){
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
EOD;

        $view = $this->getView();
        $view->registerJs($jsPlugin, \yii\web\View::POS_END, __CLASS__);
    }
} 