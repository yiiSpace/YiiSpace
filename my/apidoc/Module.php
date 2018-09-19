<?php

namespace my\apidoc;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'my\apidoc\controllers';

    /**
     * @var string  默认的所有本模块内的控制权都采用的布局
     */
    public $layout = 'main' ;

    /**
     * API 基URL
     *
     * @var string
     */
    public $apiBaseUrl = '' ;

    /**
     * used to transform the api short Description
     *
     *  function($shortDesc){
     *      return ' ' ;
     * }
     * @var \Closure
     */
    public $apiShortDescriptionTransformer ;

    public $servicePaths = [

    ];

    public function init()
    {
        parent::init();

        // custom initialization code goes here

    }

    public function afterAction($action, $result)
    {
        $result =  parent::afterAction($action, $result);

        if(is_callable($this->apiShortDescriptionTransformer)){
            $result =  call_user_func($this->apiShortDescriptionTransformer,$result);
        }

        return $result ;
    }

}
