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
/* @var $generator year\gii\goodmall\generators\api\Generator */

$modelName =  end( explode('.', $generator->modelType) ) ;
$controllerType = $generator->controllerType ;

$route = $generator->podId.'/'.\yii\helpers\Inflector::camel2id($modelName,'-');
$route4list = $generator->podId.'/'.\yii\helpers\Inflector::camel2id(
    \yii\helpers\Inflector::pluralize($modelName)
    ,'-');

?>

/***                      ## 主要是用来拷贝代码的 文件会删掉的！                      ***/

<?= $modelName ?>Ctrl :=  <?= $controllerType ?>{ }  // TODO 自己注入interactor

r.GET("/<?= $route ?>", <?= $modelName ?>Ctrl.Get)
r.GET("/<?= $route ?>/count", <?= $modelName ?>Ctrl.Count)
r.POST("/<?= $route ?>", <?= $modelName ?>Ctrl.Create)
r.PUT("/<?= $route ?>", <?= $modelName ?>Ctrl.Update)
r.GET("/<?= $route4list ?>", <?= $modelName ?>Ctrl.Query)
r.DELETE("<?= $route?>", <?= $modelName ?>Ctrl.Delete)
