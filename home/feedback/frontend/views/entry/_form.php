<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model home\feedback\common\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
$actionId = Yii::$app->controller->action->id;
?>

<?php \year\widgets\CssBlock::begin() ?>
    <style>
        _div.required input:after {
            content: "*";
            background-color: yellow;
            color: red;
            font-weight: bold;
        }

        _div.required > label:after {
            content: " *";
            color: red;
        }

        table.borderless td, table.borderless th {
            border: none !important;
        }

        .form-group {
            margin-bottom: 5px;
        }
    </style>
<?php \year\widgets\CssBlock::end() ?>


    <div class="feedback-form">

<?php if ($actionId == '2director'): ?>
    <div class="" style="padding: 1px 3px 8px 3px ; margin-top: -40px">
    <?php else: ?>
    <div class="" style="padding: 1px 3px 8px 3px ; margin-top: -10px">
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'fieldConfig' => [
        //  'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'template' => " {beginWrapper}\n{input} \n{error}\n{endWrapper}",
        // 'template' => "{label}\n{input}\n{error}",
        //   'template' => "{label} <div class=\"row\"><div class=\"col-sm-6\">{input} {error}</div></div>",
        // 'inputTemplate' => '<div class="input-group">{input}</div>  ',
        'inputOptions' => [
            'class' => 'form-control input-sm',
        ]
    ],
]); ?>

<?php //  $form->field($model, 'cate_id')->textInput() ?>

<?php if ($actionId != '2director'): ?>
    <?= $form->field($model, 'type_id', [
        'template' => "{label} <div class=\"row\"><div class=\"col-sx-8\">{input} {error}</div></div>",
        // 'inputTemplate' => '{input}',
    ])->inline()
        ->radioList(\home\feedback\common\models\Feedback::getTypeOptions([\home\feedback\common\models\Feedback::TYPE_TO_DIRECTOR]), [

        ])
        ->label(false)
        ->hint(false) ?>
<?php else: ?>
    <?= $form->field($model, 'type_id')->hiddenInput([
        'value' => \home\feedback\common\models\Feedback::TYPE_TO_DIRECTOR,
    ])->label(false)->hint(false) ?>
<?php endif; ?>

<?php \year\widgets\CssBlock::begin() ?>
    <style>

    </style>
<?php \year\widgets\CssBlock::end() ?>
    <table class="table borderless ">
        <thead>
        <tr>
            <th style="width: 50%"></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <?= $form->field($model, 'username', [
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('username'),
                    ]
                ])->textInput(['maxlength' => true]) ?>
            </td>
            <td>
                <?= $form->field($model, 'id_card', [
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('id_card'),
                    ]
                ])->textInput(['maxlength' => true]) ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= $form->field($model, 'tel', [
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('tel'),
                    ]
                ])->textInput(['maxlength' => true]) ?>
            </td>
            <td>
                <?= $form->field($model, 'contact_address', [
                    //  'template' => "{label} <div class=\"row\"><div class=\"col-sm-7\">{input} \n{error}  </div></div>"

                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('contact_address'),
                    ]
                ])->textInput(['maxlength' => true]) ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="width: 75%">
                    <?= $form->field($model, 'subject', [
                        'inputOptions' => [
                            'placeholder' => $model->getAttributeLabel('subject'),
                        ],
                        // 'template' => '{label} <div class="row"><div class="col-sm-7">{input}{error} </div></div>'

                    ])->textInput(['maxlength' => true]) ?>
                </div>

            </td>
        </tr>

        <tr>
            <td colspan="2">

                <?= $form->field($model, 'body', [
                    // 'template' => '{label} <div class="row"><div class="col-sm-7">{input}{error} </div></div>'
                    'inputOptions' => [
                        'placeholder' => $model->getAttributeLabel('body'),
                    ],
                ])->textarea(['rows' => 6]) ?>

            </td>
        </tr

        <tr>
            <td>

                <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
                     'captchaAction' => '/site/captcha',
                    // 'captchaAction' => ['captcha'],
                    //'template' => '<div class="row"><div class="col-xs--6">{input}</div> <div class="col-xs--3">{image}</div></div>',
                    // 'template' => '{input} {image}',
                    'options' => [
                        'class' => 'form-control input-sm pull-left',
                        'style' => 'width:60%;margin-top:10px',
                        'placeholder' => $model->getAttributeLabel('verifyCode'),
                    ]
                ]) ?>

            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <?= Html::submitButton($model->isNewRecord ? '提交' : '更新',
                                [
                                    // 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                                    'class' => 'btn btn-primary'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="hidden">
        <?= $form->field($model, 'reply_department')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'reply_at')->textInput() ?>

        <?= $form->field($model, 'reply_content')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'admin_updated_by')->textInput() ?>

        <?= $form->field($model, 'status')->textInput() ?>
    </div>


<?php ActiveForm::end(); ?>

    </div>


    </div>

<?php \year\widgets\JsBlock::begin() ?>
    <script>
        $(function () {
            /*
             setTimeout(function () {
             configIFrame() ;
             },100);
             */
                configIFrame();

        });
        function configIFrame() {

            // var containerIFrame = window.parent.document.getElementById("blockrandom") ;
            // var scrollingVal =   window.parent.document.getElementById("blockrandom").scrolling;
            // alert(scrollingVal);
            // containerIFrame.scrolling = 'auto' ;
            // alert(containerIFrame.src) ;

            // var iframes = parent.document.getElementsByTagName("iframe");
            var iframes = /* parent.getElementsByTagName("iframe") ||*/ parent.document.getElementsByTagName('iframe');

            if(iframes != undefined && iframes.length >= 1 ){
                // alert(iframes.length) ;

                for (var i = 0; i < iframes.length; i++) {
                    // alert(iframes[i].id);
                    // iframes[i].scrolling = 'auto' ;
                    // iframes[i].frameborder = 0 ;
                    // iframes[i].height = '700px' ;
                    // alert('hi');     height: 500px;

                }
                if(iframes[1]){
                    iframes[1].scrolling = 'auto';
                    iframes[1].frameborder = 0;
                    iframes[1].height = '680px';
                }

            }

        }
    </script>
<?php \year\widgets\JsBlock::end() ?>