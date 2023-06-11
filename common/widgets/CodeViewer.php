<?php

/**
 * User: yiqing
 */

namespace common\widgets;

use year\base\Widget;

class CodeViewer extends Widget
{
    /**
     * 获取方法源码
     *
     * <code>
     * $reflection = new ReflectionMethod(new Example(), 'method');
     * $reflection = new ReflectionMethod(Example::class, 'method');
     * $reflection = new ReflectionMethod('Example::method');
     * </code>
     *
     * @param string|object $objectOrMethod Classname, object
     * (instance of the class) that contains the method or class name and
     * method name delimited by ::.
     * @param string|null $method Name of the method if the first argument is a
     * classname or an object.
     * @throws ReflectionException if the class or method does not exist.
     */
    public static function GetMethodCode($objectOrMethod, $method = null)
    {
        $func = new \ReflectionMethod ($objectOrMethod, $method);
        //        return $rm->__toString() ;
        //
        //
        //        if (!empty($class))
        //            $func = new ReflectionMethod($class, $method);
        //        else
        //            $func = new ReflectionFunction($method);

        $f = $func->getFileName();
        $start_line = $func->getStartLine() - 1;
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;

        //        $source = file($f);
        //        $source = implode('', array_slice($source, 0, count($source)));

        $source = file_get_contents($f);
        $source = preg_split("/" . PHP_EOL . "/", $source);

        $body = '';
        for ($i = $start_line; $i < $end_line; $i++) {
            $body .= "{$source[$i]}\n";
        }

        return $body;
    }

    /**
     * Undocumented function
     *
     * @param \ReflectionClass $ref
     * @return void
     */
    public function getSource(\ReflectionClass $ref)
    {
        $path = $ref->getFileName(); #获取脚本文件文件名
        $file = file($path); #file()方法获取文件内容，并将内容保存在一个数组中，数组每个元素保存一行内容
        $start = $ref->getStartLine(); #获取类在脚本中的第一行行号
        $end = $ref->getEndLine(); #获取类在脚本中最后一行的行号
        $source = implode(array_slice($file, $start - 1, $end - $start + 1)); #拼装类源码
        // var_dump($source);
        return $source;
    }
    /**
     * Undocumented variable
     *
     * @var string
     */
    public $code = '';

    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        $this->registerClientScript();

        // Yii2 中run方法echo 或者return一个string 效果等同了！参考Widget::widget 方法的实现即知
        return $this->render('code-viewer', [
            'code' => $this->code,
        ]);
    }

    public function registerClientScript()
    {

        $view = $this->view;
        // $asset = MiniCartAsset::register($view);
        // $options = empty($this->clientOptions) ? '' : Json::encode($this->clientOptions);
        //  jQuery('{$this->targetItemSelector}').shoping({$options});
        $js = <<<INIT_JS



INIT_JS;

        $js = '';
        // $view->registerJs($js);
    }

}
