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



echo \year\gii\common\widgets\PathSelector::widget([
    // 'onSelection'=>$onSelection,
]);

?>


<?php

echo \yii\helpers\Html::errorSummary($generator) ;

echo $form->field($generator, 'srcDir');

/*
$data = [2 => 'widget', 3 => 'dropDownList', 4 => 'yii2'];
echo $form->field($generator, 'tablePrefix')->widget(\kartik\select2\Select2::classname(), [
    'data' => $data,
     'options' => ['placeholder' => '请选择 ...'],
]);
*/



$tableNames = $generator->getAllTableNames();
if(!empty($tableNames)) {
    echo $form->field($generator,'tableName')
        ->dropDownList(array_combine($tableNames,$tableNames)) ;
}else{
    echo $form->field($generator, 'tableName');
}
echo $form->field($generator,'genTableName')->checkbox();
echo $form->field($generator,'handleNullColumn')->checkbox();
echo $form->field($generator,'enableServiceLayer')->checkbox();


// echo 'count: '.count($tableNames) ;
echo $form->field($generator, 'tablePrefix');

/// echo $form->field($generator, 'generateLabelsFromComments')->checkbox();

//echo $form->field($generator, 'db');
/** @var \backend\components\DbMan $dbMan */
$dbMan = Yii::$app->get('dbMan') ;
$dbIds = array_map(function($item){
    return 'db_'.$item ; // FIXME 这里有个约定！  db_xxx
} , $dbMan->getDatabases()) ;
$dbList = ['db'=>'db','db2'=>'db2'] + array_combine($dbIds,$dbMan->getDatabases());
echo $form->field($generator, 'db')->dropDownList($dbList,[]);

?>

    <div class="card bg-light mb-12"  style="margin-bottom: 15px;" >
        <div class="card-header"><h5 class="card-title">Dao 生成相关</h5></div>
        <div class="card-body">
            <h5 class="card-title"></h5>
            <?php
            echo \yii\helpers\Html::a('选择DAO路径 ', '#', [
                'id' => 'triggerDaoPath',
                'class' => 'btn btn-success dialog-choose-path',
                'data'=>[
                    'from'=>'daoPath'
                ],
            ]);
            echo $form->field($generator, 'daoDir');
            ?>
        </div>
    </div>




<?php \year\widgets\pubsub\JTinyPubSubAsset::register($this); ?>
<?php \year\layui\LayerAsset::register($this) ?>
<?php \year\widgets\JsBlock::begin() ?>
    <script>
        /**
         *
         *                   PUB-SUB
         * --------------------------------------------------------------------  +|
         *   var MY_TOPIC = 'hello';
         PubSub.subscribe(MY_TOPIC, function (msg, data) {
                console.log(msg);
                console.log(data);
            });

         PubSub.publish(MY_TOPIC, 'world');
         *
         */

        window.msgBus = window.MsgBus = function () {
            function pub(topic, payload) {
                $.publish(topic,payload);
                //PubSub.publish(topic, payload);
            }

            function sub(topic, handler) {
                 $.subscribe(topic, handler ) ;
                //PubSub.subscribe(topic, handler);
            }

            function unsub(topic, handler) {
                $.unsubscribe(topic,handler)
            }

            return {
                pub: pub,
                sub: sub,
                unsub: unsub
            };

        }();

        // FIXME 以上代码建议也封装到widget去 不要到处出现  回调机制就用

        var TOPIC_FILE_CHOOSE = 'file.choose';


        msgBus.sub(TOPIC_FILE_CHOOSE, function (event, data) {
            // console.log(arguments);
            // console.log(data);
            // $("input[name*='srcDir']").val(data) ;
            // layer.alert('选择成功！'+data);
            alert("看控制台数据是啥");
            console.log(data)
            var from = data.from ;
            if(from == 'default'){
                $("input[name*='srcDir']").val(data.data) ;
                layer.alert('选择成功！'+data.data);
            }else if(from == 'daoPath'){
                $("input[name*='daoDir']").val(data.data) ;
                layer.alert('dao目录选择成功！'+data.data);
            }
        });

        /**
         * --------------------------------------------------------------------  +|
         */

    </script>
<?php \year\widgets\JsBlock::end() ?>
<?php

//
//$onSelection = <<<JS
//            function(data) {
//               $("input[name*='srcDir']").val(data) ;
//               alert('路径选择成功啦:'+data) ;
//            }
//JS;
//// TODO 这个组件会导致布局变形的！ 还有预览对话框显示不正常
//\year\gii\common\widgets\PathSelector::widget([
//    'onSelection'=>$onSelection,
//]);

?>