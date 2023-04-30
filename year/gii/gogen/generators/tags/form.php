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
               console.log(data);
            }
JS;

echo \year\gii\common\widgets\PathSelector::widget([
    'onSelection'=>$onSelection,
]);

?>


<?php
$generatorId = Yii::$app->request->get('id');

echo \yii\helpers\Html::errorSummary($generator) ;


echo $form->field($generator, 'srcDir');

echo $form->field($generator,'struct')->dropDownList([],['data'=>[
        'key'=>'struct'
]]);


echo $form->field($generator, 'tableName');
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

        var TOPIC_FILE_CHOOSE = 'file.choose';


        msgBus.sub(TOPIC_FILE_CHOOSE, function (event, data) {
             // console.log(arguments);
            console.log(data);
            $("input[name*='srcDir']").val(data.data) ;
            layer.alert('选择成功！'+data.data)
            
            var url = '<?= \yii\helpers\Url::to(['default/action/','id'=>$generatorId,'name'=>'hi'
            ,'path'=>'_path',
                ]) ?>';
                url = url.replace('_path',encodeURIComponent(data.data)) ;
            var data = {
              // "path": encodeURIComponent( data.data )
              // "path":  data.data
            };


            $.ajax({
                url: url,
                data: data,
                success: function(data,status,xhr){
                    console.log(data);
                    // var $struts =  $("select[name$=strut]");
                    // $struts.empty();
                    // if(data.structs){
                    //     alert('hiii');
                    // }


                },
                dataType: "json"
            });
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