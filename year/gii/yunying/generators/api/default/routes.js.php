<?php
/**
 * This is the template for generating a CRUD controller class file.
 *
 * User: yiqing
 * Date: 2018/4/19
 * Time: 7:22
 */
?>
<?php
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator year\gii\yunying\generators\api\Generator */

$modelName =  end( explode('.', $generator->modelType) ) ;

$route = $generator->podId.'/'.\yii\helpers\Inflector::camel2id($modelName,'-');
$route4list = $generator->podId.'/'.\yii\helpers\Inflector::camel2id(
    \yii\helpers\Inflector::pluralize($modelName)
    ,'-');

?>

/***                      ## 主要是用来拷贝代码的 文件会删掉的！                      ***/


