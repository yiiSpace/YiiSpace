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

echo \yii\helpers\Html::errorSummary($generator) ;

echo $form->field($generator, 'srcDir');


echo $form->field($generator, 'tableName');
echo $form->field($generator, 'tablePrefix');

echo $form->field($generator, 'generateTest')->checkbox();


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
<p>
<h4>  关于测试  参考 </h4>
    <ul>
    <li>
        <a href=" https://www.cnblogs.com/tugenhua0707/p/8419534.html" target="_blank">
            学习测试框架Mocha
        </a>
    </li>
    <li>
        <a href="https://nodejs.org/api/assert.html" target="_blank">node api assert</a>
    </li>
        <li>
        <a href="https://eggjs.org/zh-cn/core/unittest.html" target="_blank">
            eggjs test
        </a>
    </li>
        <li>
        <a href="https://github.com/power-assert-js/power-assert" target="_blank">
            power-assert
        </a>
    </li>
</ul>


</p>

<?php \yii\bootstrap\Alert::end(); ?>
