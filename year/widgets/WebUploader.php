<?php
/**
 * User: yiqing
 * Date: 2014/12/1
 * Time: 21:00
 */

namespace year\widgets;

use Yii;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

/**
 * @see https://github.com/2amigos/yii2-file-input-widget/blob/master/FileInput.php
 *
 * Class WebUploader
 * @package year\widgets
 */
class WebUploader extends InputWidget
{


    /**
     * @var bool
     */
    public $init = true ;
    /**
     * @var string
     */
    public $var = 'uploader ';
    /**
     * upload file to URL
     * @var string
     * @example
     * http://xxxxx/upload.php
     * ['article/upload']
     * ['upload']
     */
    public $server;

    /**
     * enable csrf verify
     * @var bool
     */
    public $csrf = true;

    /**
     * 是否渲染Input
     *
     * @var bool
     */
    public $renderInput = true;

    /**
     * @var array
     */
    protected $defaultJsOptions = [

    ];
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
    public $jsOptions = [

    ];

    /**
     * http://fex.baidu.com/webuploader/document.html
     */
    public $clientEvents = [

    ];

    /**
     * @var array
     */
    public $assetConfig = [];

    /**
     * @var string
     */
    public $assetBaseUrl = '';
    /**
     * Initializes the widget.
     */
    public function init()
    {
        //init var
        if (empty($this->server)) {
            $this->server = \yii\helpers\Url::to([Yii::$app->controller->action->id]);
        }
        if (empty($this->id)) {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        $this->options['id'] = $this->id;
        if (empty($this->name)) {
            $this->name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->id;
        }

        //register js css
        $assets = WebUploaderAsset::register($this->view);
        $this->assetBaseUrl  = $assets->baseUrl;
        if($this->init == true){
            //init options
            $this->initOptions($assets);
        }
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if($this->renderInput){
          return  $this->renderInput() ;
        }
        if($this->init){
            $this->registerScripts();
        }

    }

    /**
     * init Uploadify options
     * @param [] $assets
     * @return void
     */
    private function initOptions($assets)
    {
        $baseUrl =  $this->assetBaseUrl  = $assets->baseUrl;

        $this->jsOptions['server'] = $this->server;
        $this->jsOptions['swf'] = $baseUrl . '/Uploader.swf';

        // csrf options
        if ($this->csrf) {
            $this->initCsrfOption($this->jsOptions);
        }

        /**
         * JsExpression convert
         *
         * foreach ($this->jsOptions as $key => $val) {
         * if (in_array($key, $this->events) && !($val instanceof JsExpression)) {
         * $this->jsOptions[$key] = new JsExpression($val);
         * }
         * }
         * */
    }

    /**
     * webUploader csrf options
     *
     * @param type $jsOptions
     * @return void
     */
    private function initCsrfOption(&$jsOptions)
    {
        $session = Yii::$app->session;
        $session->open();
        $sessionIdName = $session->getName();
        $sessionIdValue = $session->getId();

        $request = Yii::$app->request;
        $csrfName = $request->csrfParam;
        $csrfValue = $request->getCsrfToken();
        $session->set($csrfName, $csrfValue);

        $jsOptions['formData'] = [
            $sessionIdName => $sessionIdValue,
            $csrfName => $csrfValue,
        ];
    }

    /**
     * render file input tag
     * @return string
     */
    private function renderInput()
    {
        if ($this->hasModel()) {
            $field = Html::activeFileInput($this->model, $this->attribute, $this->options);
        } else {
            $field = Html::fileInput($this->name, $this->value, $this->options);
        }
        return $field ;
    }

    /**
     * register script
     */
    private function registerScripts()
    {

        $jsonOptions = Json::encode($this->jsOptions);
        $script = <<<JS_INIT

        var {$this->var} = WebUploader.create({$jsonOptions});

JS_INIT;

        $this->view->registerJs($script, View::POS_READY);


        if (!empty($this->clientEvents)) {
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = ";{$this->var}.on('$event', $handler);";
            }
            $this->view->registerJs(implode("\n", $js));
        }
    }

}
