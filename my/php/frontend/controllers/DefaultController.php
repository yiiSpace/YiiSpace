<?php

namespace my\php\frontend\controllers;

use my\php\common\annotations\AnnotationsDemo;
use my\php\common\features\PhpTokenDemo;
use my\php\common\features\TraitsDemo;
use my\php\common\reflections\BetterReflectionDemo;
use year\db\DynamicActiveRecord;
use year\migration\GeneratorTrait;
use yii\base\NotSupportedException;
use yii\web\Controller;

// 临时用下哈
use \yii\db\Connection;
use yii\di\Instance;

/**
 * Default controller for the `php` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     *
     * 错误出现：“Headers already sent”
     * Try not to echo anything. In general don’t echo in controllers.
     *
     * Since Yii 2.0.14 you cannot echo in a controller. A response must be returned:
     *
     * You may also call `exit` at the end of your method to prevent further processing or wrap your code with ob_start() and ob_get_clean(),
     * if you're not able to avoid echo.
     *
     */
    public function actionIndex()
    {

        ob_start();

        TraitsDemo::run();

        $content = ob_get_clean();


        return $this->render('index', [
            'content' => $content,
        ]);
    }

    use GeneratorTrait;

    public function actionMigrate()
    {

        // todo : 原作者是在beforAction中 实例化db的  $
        $this->db = Instance::ensure($this->db, Connection::class);
        $generator = $this->getGenerator();
        dump($generator);
        exit(0);
    }

    public function actionAnnotation()
    {
        ob_start();
        AnnotationsDemo::run();
        return ob_get_clean();
    }

    public function actionPhpToken()
    {
        PhpTokenDemo::run();
        PhpTokenDemo::getClasses();
        exit(0);
    }

    public function actionReflection()
    {
        dump(BetterReflectionDemo::run(__FILE__));
        BetterReflectionDemo::classInfo(__CLASS__);
        exit(0);
    }

    public function actionAnnotation2()
    {
        // @see https://github.com/nette/reflection
        throw new NotSupportedException();
    }

    /**
     *
     *
     * Dynamically generate classes at runtime in php?
     *
     * While it's okay in PHP to use variable names to call functions or create objects,
     * it's not okay to define functions and classes in a similar manner : docstore.mik.ua/orelly/webprog/pcook/ch07_13.htm
     *
     * @see https://stackoverflow.com/questions/1203625/dynamically-generate-classes-at-runtime-in-php
     *
     * @return string
     */

    public function actionDynamicGenClass()
    {
        $clsName =  'CLS_'.substr(md5(rand()), 0, 10); //generate a random name
//        $parentClassName = __CLASS__ ;
//        $parentClassName = static::class;
        $parentClassName = DynamicActiveRecord::class;
//        $parentClassName = 'DefaultController' ;
        // 这是heredoc 用法 等价双引号字符串；另有一个newdoc用法 等价单引号  <<<'EOT' 就是在标示符上加单引号 尾部那个不加
        // heredoc 语法 在7.3之后宽松了许多 允许尾部有空格 作为数组元素时可以后面跟其他字符串！
        $code  = <<<MY_CLASS
class $clsName extends $parentClassName {
       static public function parentClassName() {  return "{$parentClassName}"; }
  };  
MY_CLASS;
        eval($code);

        ob_start();
        dump($code) ;
          $obj = new $clsName() ;
//          echo   $obj->parentClassName() ;
          echo   $clsName::parentClassName() ;
        dump($obj) ;

         $this->genClassFile();
        $content = ob_get_clean() ;

        return $this->renderContent($content);
    }

    /**
     * @return void
     *
     * 关于spl_autoload_register  可以看看Yii类源码 底部就有注册脚本
     * 可以重写__autoload() 但这个方法只能有一次机会 spl中的那个可以多次调用
     */
    protected function genClassFile()
    {
        $__autoload =  function ($class)
        {
            // yii中的使用的是 include     关于和require的区别可以看看php手册 还有孪生对require_once
            require \Yii::getAlias('@runtime'). '/classes/' . $class . '.php';

        };
//        $my_autoload =  function($class) { ... };
// OR
// $my_autoload = array('MyClass', 'my_autoload')

//        \Yii::registerAutoloader($__autoload, true);
        // 内部是有个队列的 最后一个参数就是表示往前加还是排到队列尾部
        spl_autoload_register($__autoload,true,false) ;


        $class = 'App';
        $code = "<?php class $class {
    public function run() {
        echo '$class<br>';  
    }
    " . '
    public function __call($name,$args) {
        $args=implode(",",$args);
        echo "$name ($args)<br>";
    }
}';

        file_put_contents(\Yii::getAlias('@runtime')."/classes/{$class}.php", $code);

        $a = new $class();
        $a->run();
    }
}