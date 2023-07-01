<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/7
 * Time: 8:53
 */

namespace common\widgets;

use year\widgets\PageletBlock;
use yii\base\ViewEvent;
use yii\base\Widget;
use yii\base\WidgetEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use Yii ;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

use yii\web\View ;

/**
 * 替换原先gii生成的view 视图默认信息
 */
class ViewInfo extends Widget{

   /** */

    protected $controllerViewFiles = [];

    public function init()
    {
        parent::init();
        $controller = Yii::$app->controller ;
        $controllerClass = get_class($controller) ;
        $action = $controller->action;

        $module = $controller->module ;

        // $cssClass = Inflector::camel2id(StringHelper::basename($controller::class)) ;
        $cssClass = strtr(  $action->getUniqueId() ,'/','_');

        // echo $cssClass ,'<br>';

        $viewDefaltContent = <<<EOF
        <div class="{$cssClass}">
        
            <h1> {$action->uniqueId} </h1>
            <p>
                This is the view content for action "{$action->id}".
                The action belongs to the controller "{$controllerClass}"
                in the " {$module->id} " module.
            </p>
            <p>
                You may customize this page by editing the following file:<br>
                <code><?= __FILE__ ?></code>
            </p>
         
        </div>
EOF;

         
        $view = $this->getView();

        $widget = $this ;
        // EVENT_BEFORE_RENDER|EVENT_AFTER_RENDER|EVENT_END_PAGE
        $view->on(View::EVENT_AFTER_RENDER,function(ViewEvent $event)use($widget,$viewDefaltContent,$view){
           if(count($widget->controllerViewFiles) >0) return ;
           
            // sleep(1) ;
            // echo $event->viewFile ,'<br/>';
            array_push($widget->controllerViewFiles, $event->viewFile ) ;
            // echo count($widget->controllerViewFiles) ;
            // echo '___'.microtime() ;

            // $viewDefaltContent = strtr($viewDefaltContent,'__FILE__',$event->viewFile ) ;
            
            $pageletBlock = PageletBlock::widget([
                'content'=>$viewDefaltContent . $event->viewFile,
                'targetId'=>$widget->getDomId(),
            ]);
            $view->on(View::EVENT_END_BODY,function($event)use($pageletBlock ){
                echo $pageletBlock ;
            });

             
        });

        $this->on(static::EVENT_AFTER_RUN,function(WidgetEvent $event)use($widget){
            
            // echo __CLASS__ .time() ;
            // // 用微秒 可以看出到底先渲染的哪个
            // echo __CLASS__ .microtime() ;
            // echo count($widget->controllerViewFiles) ;
        });
      

    }
    public function getDomId()
    {
        return  'viewinfo'.md5(__CLASS__).$this->getId() ;
    }
    
    public function run()
    {
        // dump(Yii::$app->controller)  ;
        // echo count($this->controllerViewFiles) ;
        // return 'hi' .join(',', $this->controllerViewFiles) ;
        $id = $this->getDomId() ;
        return "<div id='{$id}'> ViewInfo not working!!!</div>";
    }
}