<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/6/21
 * Time: 14:49
 */

namespace year\gii\yunying4java\widgets;


use yii\base\Widget;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class PathSelector
 * @package year\gii\yunying4java\widgets
 */
class PathSelector extends Widget
{
    /**
     * @var string
     */
    public $modalId = 'fs-modal' ;

    /**
     * @var string
     */
    public $modalTitle = '选择路径' ;


    /**
     * @var JsExpression|string
     */
    public $onSelection   ;


    public function init()
    {
        parent::init();
        if(empty($this->onSelection)) {
            $onSelection = <<<JS
            function(data) {
               $("input[name*='podsPath']").val(data) ;
               alert('路径选择成功啦:'+data) ;
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

        ]);
    }

}