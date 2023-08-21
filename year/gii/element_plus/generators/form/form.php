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
    'onSelection' => $onSelection,
]);

?>


<?php

echo \yii\helpers\Html::errorSummary($generator);

echo $form->field($generator, 'srcDir');



/// echo $form->field($generator, 'generateLabelsFromComments')->checkbox();

//echo $form->field($generator, 'db');
/** @var \backend\components\DbMan $dbMan */
$dbMan = Yii::$app->get('dbMan');
$dbIds = array_map(function ($item) {
    return \backend\components\DbMan::DB_ID_PREFIX . $item; //
}, $dbMan->getDatabases());

$dbList = ['db' => 'db', 'db2' => 'db2'] + array_combine($dbIds, $dbMan->getDatabases());

echo $form->field($generator, 'db')->dropDownList($dbList, [
    //'class'=>'db-list'
    'data' => [
//        'table-prefix' => $generator->getTablePrefix(),
        'action' => \yii\helpers\Url::to([
            'default/action',
            'id' => Yii::$app->request->get('id'), // get the generator id from request
            'name' => 'TableNames'])
    ]
]);


echo $form->field($generator, 'tableName');
echo $form->field($generator, 'tablePrefix');

?>


<?php \year\widgets\pubsub\JTinyPubSubAsset::register($this); ?>
<?php \year\layui\LayerAsset::register($this) ?>
<?php \year\widgets\JsBlock::begin() ?>
    <script>

        jQuery(function ($) {
            var ajaxRequest;

            var $modal = $('#preview-modal');

            // you should see the gii.js file for some insight
            // NOTE: 需要参考gii.js  DefaultController
            $('select[name="Generator[db]"]').on('change', function () {
                // alert('db-changed');

                var $this = $(this);


                var $tableName = $('#generator-tablename');
                var tableNameListId = $tableName.attr('list');
                // alert($tableNameListId);
                var $tableNameList = $('#'+tableNameListId);

                var db = $this.val();


                // request to `default/action`(`year\gii\form\generators\form\Generator::actionTableNames()`)
                ajaxRequest = $.ajax({
                    type: 'POST',
                    cache: false,
                    url: $this.data('action'),
                    data: $this.closest('form').serializeArray(),
                    success: function (response) {
                        // $tableName.val(response).blur();
                        $tableNameList.empty() ;

                        $.each(response,function (index,value){
                            $tableNameList.append("<option>"+value+"<option>");
                        });

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $modal.find('.modal-body').html('<div class="error">' + XMLHttpRequest.responseText + '</div>');
                        console.error( XMLHttpRequest.responseText ) ;
                    }
                });
                // alert("done!");

            });
        });

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
                $.publish(topic, payload);
                //PubSub.publish(topic, payload);
            }

            function sub(topic, handler) {
                $.subscribe(topic, handler);
                //PubSub.subscribe(topic, handler);
            }

            function unsub(topic, handler) {
                $.unsubscribe(topic, handler)
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
            $("input[name*='srcDir']").val(data.data);
            layer.alert('选择成功(from layer-dailog)！' + data.data);
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