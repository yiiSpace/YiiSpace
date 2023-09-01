<?php
namespace my\dev\backend;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\Html;
use yii\helpers\IpHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\rest\UrlRule;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\View;

class Module extends \yii\base\Module implements BootstrapInterface
{

    public $defaultRoute = 'module' ;

    public $controllerNamespace = 'my\dev\backend\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

     /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        // die(__METHOD__);
        // // delay attaching event handler to the view component after it is fully configured
        // $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
        //     $app->getResponse()->on(Response::EVENT_AFTER_PREPARE, [$this, 'setDebugHeaders']);
        // });
        // $app->on(Application::EVENT_BEFORE_ACTION, function () use ($app) {
        //     $app->getView()->on(View::EVENT_END_BODY, [$this, 'renderToolbar']);
        // });

        // 可访问路径： yiispace.com:7086/index.php?r=dev/user
        // 如果不走rest风格url 也可以： yiispace.com:7086/index.php?r=dev/user/view&id=1
        // action | view | create | update |delete | options
        // FIXME: 感觉没啥作用？ 
       
        $app->getUrlManager()->addRules([
            // [
            //     'class' => $this->urlRuleClass,
            //     'route' => $this->getUniqueId(),
            //     'pattern' => $this->getUniqueId(),
            //     'normalizer' => false,
            //     'suffix' => false
            // ],
            // [
            //     'class' => UrlRule::class,
                
            //     'controller' => ['user']
            // ],
           
            
        ], false);
    }
}
