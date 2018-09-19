<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/7
 * Time: 15:52
 */

namespace year\behaviors;


use year\base\Theme;
use yii\base\Action;
use yii\base\Behavior;
use yii\base\Module;

/**
 * @see http://www.yiiframework.com/doc-2.0/guide-output-theming.html
 *
 * Class Themable
 * @package year\behaviors
 */
class Themable extends Behavior
{

    public function events()
    {
        return [
            Module::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    /**
     * @param ActionEvent $event
     * @return boolean
     * @throws MethodNotAllowedHttpException when the request method is not allowed.
     */
    public function beforeAction($event)
    {
        $action = $event->action;
        $this->configureTheme($action);
        return $event->isValid;
    }

    /**
     * @param Action $action
     */
    protected function configureTheme(Action $action)
    {
        // get the current theme object
        $theme = \Yii::$app->view->theme;
        if ($theme instanceof Theme) {
            $activeThemeName = $theme->active;
            $parentModule = $action->controller->module;
            $moduleBasePath = $parentModule->getBasePath() ;
            // check if the themes dir under the current module exists ?
            if(is_dir($moduleBasePath. DIRECTORY_SEPARATOR .'themes')){
                $moduleAlias = '@ThemeModule' . $parentModule->id;
                \Yii::setAlias($moduleAlias, $parentModule->getBasePath());
                \Yii::$app->view->theme->pathMap[$moduleAlias . '/views'] = [$moduleAlias . '/themes/' . $activeThemeName . '/views'];
            }
        }
    }
}