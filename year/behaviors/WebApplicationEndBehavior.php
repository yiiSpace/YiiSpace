<?php
/**
 * User: yiqing
 * Date: 14-9-3
 * Time: 下午10:20
 */

namespace year\behaviors;


use Yii ;
use yii\base\Module ;
use yii\base\Application;
use yii\base\BootstrapInterface;

// used by WebApplicationEndBehavior class
use yii\base\Behavior;
use yii\base\Event;

class WebApplicationEndBehavior extends Behavior implements BootstrapInterface
{
    /**
     * @var string
     */
    public $eventId = 'changeModulePaths';


    /**
     * 主题化模块， 改特性与@year/base/Theme 类搭配使用！
     *
     * 如果不用此扩展,在module的目录下 手动添加：
     *   ~~~
     *     public function init()
            {
            parent::init();
            \Yii::$app->view->theme->pathMap[your_module_name.'/views'] = [your_module_name.'/themes/'.\Yii::$app->view->theme->active.'/views'];
            // custom initialization code goes here
            }
     *    ~~~
     *
     * @var bool
     */
    public $themedModule = true ;

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->attachBehavior($this->eventId, new WebApplicationEndBehavior());

    }


    // Web application end's name.
    private $_endName;

    // Getter.
    // Allows to get the current -end's name
    // this way: Yii::app()->endName;
    public function getEndName()
    {
        return $this->_endName;
    }

    // Run application's end.
    public function runEnd($name)
    {
        $this->_endName = $name;

        // Attach the changeModulePaths event handler
        // and raise it.
        Yii::$app->on($this->eventId, [$this, 'changeModulePaths']);
        //  $this->onModuleCreate = array($this, 'changeModulePaths');
        $this->owner->trigger($this->eventId, new Event(array('sender' => $this->owner)));

        $this->owner->run(); // Run application.
    }


    // This event should be raised when Application
    // or Module instances are being initialized.
    /**
     * @param Event $event
     */
    public function onModuleCreate($event)
    {
        $this->owner->trigger($this->eventId, $event);
    }

    // onModuleCreate event handler.
    // A sender must have controllerPath and viewPath properties.
    /**
     * @param Event|Module $eventOrModule
     */
    public  function changeModulePaths( $eventOrModule)
    {
        /** @var   Application|Module $app   */
        $appOrModule = null ;
        if($eventOrModule instanceof Event){
            $appOrModule = $eventOrModule->sender ;
        }else{
            $appOrModule = $eventOrModule ;
        }


        // custom initialization code goes here
        $appEnd = Yii::$app->getEndName() ;
        $appOrModule->controllerNamespace = str_replace('\controllers', sprintf('\controllers\%s',$appEnd),$appOrModule->controllerNamespace);

        // 可以考虑在这里实现模块内theme特性

        $appOrModule->viewPath .= DIRECTORY_SEPARATOR.$this->_endName;
        if($this->themedModule === true && !($appOrModule instanceof Application)){
            $moduleAlias = '@Theme'.$appOrModule->id ;
            Yii::setAlias($moduleAlias,$appOrModule->getBasePath());
            // $moduleAlias = $appOrModule->id ;
            \Yii::$app->view->theme->pathMap[$moduleAlias.'/views'] = [$moduleAlias.'/themes/'.\Yii::$app->view->theme->active.'/views'];
             // die(Yii::getAlias($moduleAlias));
        }

    }
}