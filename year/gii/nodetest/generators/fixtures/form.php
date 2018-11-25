<?php

use schmunk42\giiant\generators\model\Generator;
use schmunk42\giiant\helpers\SaveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator \year\gii\migration\generators\migration\Generator */

/*
 * JS for listbox "Saved Form"
 * on chenging listbox, form fill with selected saved forma data
 * currently work with input text, input checkbox and select form fields
 */

//$this->registerJs(SaveForm::getSavedFormsJs($generator->getName()), yii\web\View::POS_END);
//$this->registerJs(SaveForm::jsFillForm(), yii\web\View::POS_END);

$onSelection = <<<JS
            function(data) {
               $("input[name*='srcDir']").val(data) ;
               alert('路径选择成功啦:'+data) ;
            }
JS;

echo \year\gii\migration\widgets\PathSelector::widget([
    'onSelection'=>$onSelection,
]);
?>
<?php
\yii\bootstrap\Alert::begin([
     'options' => [
          'class' => 'alert-warning',
     ],
]);?>

最好只用来浏览 如果用来生成 可以使用命令行程序

<?php \yii\bootstrap\Alert::end(); ?>

<?php

echo \yii\helpers\Html::errorSummary($generator) ;

echo $form->field($generator, 'srcDir');


echo $form->field($generator, 'tableName');
echo $form->field($generator, 'tablePrefix');

echo $form->field($generator, 'generateMigration')->checkbox();


//echo $form->field($generator, 'db');
/** @var \backend\components\DbMan $dbMan */
$dbMan = Yii::$app->get('dbMan') ;
$dbIds = array_map(function($item){
    return 'db_'.$item ; // FIXME 这里有个约定！  db_xxx
} , $dbMan->getDatabases()) ;
$dbList = ['db'=>'db','db2'=>'db2'] + array_combine($dbIds,$dbMan->getDatabases());
echo $form->field($generator, 'db')->dropDownList($dbList,[]);

?>

<?php
\yii\bootstrap\Alert::begin([
    'options' => [
        'class' => 'alert-warning',
    ],
]);?>

GII 生成的文件 原则上文件名是固定的 但迁移文件名 里面含有随机因素 这里最好自己生一个 然后拷贝代码过去

<?php \yii\bootstrap\Alert::end(); ?>
