<?php
/**
 * User: yiqing
 * Date: 14-7-31
 * Time: 下午4:17
 */

namespace year\base;

use Yii;
use yii\base\Widget as YiiBaseWidget;

/**
 * Class Widget
 * @package year\base
 */
class Widget extends YiiBaseWidget
{

    /**
     * 支持松散theme 有则用没有则用原来路径
     * @var bool
     */
    public $relaxTheme = true ;

    /**
     * for the method getViewPath
     *
     * @var bool
     */
    protected  $applyTheme = true ;

    /**
     * 注意yii2 可以集中配置某个类的实例化属性
     *  \Yii::createObject()  这个归功于di了
     * 类似yii1的 widgetFactory的配置
     * 如：
     *     \Yii::$container->set('yii\widgets\LinkPager', ['maxButtonCount' => 5]);
     * @var int
     */
    public $cacheTime;

    /**
     * theme-able the widget
     *
     * @return string
     */
    public function getViewPath()
    {
        $viewPath = parent::getViewPath();
        if ($this->applyTheme == true &&  Yii::$app->view->theme !== null) {
            $theme = Yii::$app->view->theme;
            if ($theme instanceof \year\base\Theme) {
                $themeName = $theme->active;
                $candidateDir = $viewPath . DIRECTORY_SEPARATOR . $themeName;
                if (is_dir($candidateDir)) {
                    $viewPath = $candidateDir;
                }
            }
            /*
             * borrow from yupe
             *
            $class = get_class($this);
            $obj = new ReflectionClass($class);
            $string = explode(Yii::app()->modulePath . DIRECTORY_SEPARATOR, $obj->getFileName(), 2);
            if (isset($string[1])) {
                $string = explode(DIRECTORY_SEPARATOR, $string[1], 2);
                $themeView = Yii::app()->themeManager->basePath . '/' .
                    Yii::app()->theme->name . '/' . 'views' . '/' .
                    $string[0] . '/' . 'widgets' . '/' . $class;
            }*/
        }
        return $viewPath;

    }

    public function render($view, $params = [])
    {
        if($this->relaxTheme == true){
            // check if view file exists?
            $viewFile = $this->getViewPath().DIRECTORY_SEPARATOR.$view ;
           if( is_file($viewFile)
            || is_file($viewFile.'.'.$this->getView()->defaultExtension)
               || is_file($viewFile.'.php')
           ){
              // return parent::render($view,$params);
           }else{
               // 设置下不要使用theme了 上面检测文件以及不存在了！
               $this->applyTheme = false ;
           }

        }
        return parent::render($view,$params);
    }
}