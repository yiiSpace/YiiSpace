<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/23
 * Time: 10:22
 */

namespace year\widgets;


use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;

class JFileApi    extends InputWidget {

    /**
     * upload file to URL
     * @var string
     */
    public $url;



    /**
     * 是否渲染Tag
     * @var bool
     */
    public $renderTag = true;

    /**
     * uploadify js options
     * @var array
     * @example
     * [
     * 'height' => 30,
     * 'width' => 120,
     * 'swf' => '/uploadify/uploadify.swf',
     * 'uploader' => '/uploadify/uploadify.php',
     * ]
     * @see http://www.uploadify.com/documentation/
     */
    public $jsOptions = [];

    /**
     * @var []
     */
    public $events = [
       'onComplete','onPreview',
    ];

    /**
     * Initializes the widget.
     */
    public function init() {

        //init var
        if (empty($this->url)) {
            $this->url = \yii\helpers\Url::to('');
        }
        if (empty($this->id)) {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        $this->options['id'] = $this->id;
        if (empty($this->name)) {
            $this->name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->id;
        }

        //register js css
        $asset = JFileApiAsset::register($this->view);
        $globalJs = <<<JS
        window.FileAPI = { staticPath: '{$asset->baseUrl}' };
JS;
      $this->view->registerJs($globalJs,View::POS_HEAD) ;

        static $registered ;
        if(empty($registered)){
            // 注册插件
            $this->render('file-api/js-multiple',[]);
            // 置注册标记为真
            $registered = true ;
        }

        //============================================================================================ begin \\
        //init options
         $this->initOptions($asset);

        if(!isset($this->jsOptions['sessionName'])){
            $this->jsOptions['sessionName'] = \app\helpers\Web::getSessionNameIdPair()[0] ;
        }
        if(!isset($this->jsOptions['sessionId'])){
            $this->jsOptions['sessionId'] = \app\helpers\Web::getSessionNameIdPair()[1] ;
        }

        if(!isset($this->jsOptions['onComplete'])){
            $this->jsOptions['onComplete'] = new JsExpression('
            function (err, xhr){
                                    /* ... */
                                    if( !err ){
                                        var result = xhr.responseText;
                                        // ...
                                        console.log(result);
                                    }
                                }
            ');
        }

        if(!isset($this->jsOptions['ele'])){
            $this->jsOptions['ele'] = new JsExpression("
                  document.getElementById('{$this->id}')
            ");
        }

        /*
        if(!isset($this->jsOptions['url'])){
            $this->jsOptions['url'] = $this->url ;
        }
        */
        $this->jsOptions['url'] = isset($this->jsOptions['url']) ? $this->jsOptions['url'] : $this->url ;

        if(empty($this->jsOptions['url'])){
            // 当前控制器！
           $this->jsOptions['url'] = Url::to(['']);
           // throw new InvalidConfigException('you must specify the url for using this widget !');
        }
        //============================================================================================   end //


        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run() {
        $this->registerScripts();
        if ($this->renderTag === true) {
            echo $this->renderTag();
        }

    }


    /**
     * render file input tag
     * @return string
     */
    private function renderTag() {
        return Html::fileInput($this->name, null, $this->options);
    }

    /**
     * register script
     */
    private function registerScripts() {
        $jsOptions = Json::encode($this->jsOptions);

        /**
         *   var obj1 = new YiiFileApi({
                ele : document.getElementById('choose') , // element to listen

                sessionName : '<?= \app\helpers\Web::getSessionNameIdPair()[0] ?>' ,
                sessionId : '<?= \app\helpers\Web::getSessionNameIdPair()[1] ?>' ,
                onPreview : function(err,img){
                window.images.appendChild(img);
                }

                , url : '<?= \yii\helpers\Url::to() ?>'
                // postFileName : '',
                // postData : '',  // post data when upload the image together to the server end
                , onComplete : function(){}  // when the upload completed ,this callback function will be called !
                }) ;
         */

        $script = <<<EOF
    new YiiFileApi({$jsOptions});
EOF;

        $this->view->registerJs($script, View::POS_END);
    }


    /**
     * ================================================================================ begin \\
     */

    /**
     * init  options
     * @return void
     */
    protected function initOptions() {

        /**
         * JsExpression convert
         */
        foreach ($this->jsOptions as $key => $val) {
            if (in_array($key, $this->events) && !($val instanceof JsExpression)) {
                $this->jsOptions[$key] = new JsExpression($val);
            }
        }
        return $this ;
    }

    /**
     * csrf options
     *
     * @param type $jsOptions
     * @return void
     */
    private function initCsrfOption(&$jsOptions) {
        $request = Yii::$app->request;
        $csrfName = $request->csrfParam;
        $csrfValue = $request->csrfToken;

        $session = Yii::$app->session;
        $session->open();
        $sessionIdName = $session->getName();
        $sessionIdValue = $session->getId();
        $jsOptions['formData'] = [
            $sessionIdName => $sessionIdValue,
            $csrfName => $csrfValue,
        ];
    }
    /**
     * ================================================================================ end //
     */
}