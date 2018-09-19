<?php
/**
 * User: yiqing
 * Date: 2014/10/12
 * Time: 21:34
 */

namespace year\editor;

use yii\helpers\Html;
use yii\helpers\Inflector;
use Yii;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

class XHEditor extends InputWidget
{
    /**
     *
     * @var array
     */
    public $clientOptions = [];
    /**
     * ID of Textarea where editor will be placed
     *
     * @var string
     */
    protected $id;

    public function init()
    {
        parent::init();


        $this->id = $this->options['id'];


        //  $this->view->registerJs($script);
    }

    public function run()
    {
        XHEditorAssets::register($this->view);
        $this->registerScripts();

        if ($this->hasModel()) {
            $textarea = Html::activeTextArea($this->model, $this->attribute, $this->options);
        } else {
            $textarea = Html::textArea($this->name, $this->value, $this->options);
        }
        // die($textarea);
        echo $textarea;
    }

    public function registerScripts()
    {
        $xhOptions =  Json::encode($this->clientOptions,JSON_FORCE_OBJECT);

        $varName = Inflector::classify('editor' . $this->id);

        $script = "var {$varName} = $('#{$this->id}').Xheditor({$xhOptions}); ";
        $this->view->registerJs($script);
    }
}