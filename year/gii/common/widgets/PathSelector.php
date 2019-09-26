<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/6/21
 * Time: 14:49
 */

namespace year\gii\common\widgets;


use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class PathSelector
 * @package year\gii\common\widgets
 *
 * @TODO 需要支持多源 并区分不同的源  比如模型目录 api目录 都需要选择功能 可以点击时携带一个key src-id|key之类 进行发出者区分
 *
 */
class PathSelector extends Widget
{

    const DEFAULT_TRIGGER_SELECTOR = '.dialog-choose-path';
    const FROM_KEY = 'from';
    /**
     * @var string
     */
    public $modalId = 'fs-modal' ;

    /**
     * @var string
     */
    public $modalTitle = '选择路径' ;


    /**
     * @deprecated
     * @var JsExpression|string
     */
    public $onSelection   ;

    /**
     * @var string Identify the event source ,you can give a unique key ,when callback|sub occur you can use this to differ them.
     */
    public $from  ;

    public $triggerSelector = self::DEFAULT_TRIGGER_SELECTOR ;


    public function init()
    {
        parent::init();
        if(empty($this->onSelection)) {
            $onSelection = <<<JS
            function(data) {
               console.log('路径选择成功啦:'+data) ;
            }
JS;
            $this->onSelection = new JsExpression(
                $onSelection
            );
             $this->onSelection = Json::htmlEncode($this->onSelection);
        }
    }

    public function run()
    {
        return $this->render('path-selector',[
            'triggerSelector'=>$this->triggerSelector,
            'from'=>empty($this->from)? 'default': $this->from ,
        ]);
    }

}