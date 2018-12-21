<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use \yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var my\content\common\models\Article $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="article-form">

    <?php $form = ActiveForm::begin([
            'id' => 'Article',
            'layout' => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-danger',
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-2',
                    #'offset' => 'col-sm-offset-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>


            <!-- attribute cate_id -->
            <?PHP // $form->field($model, 'cate_id')->textInput() ?>
            <?= $form->field($model, 'cate_id')
                ->dropDownList(\my\content\common\models\ArticleCategory::getCategoryTreeOptions(), []) ?>

            <!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


            <!-- attribute content -->
            <?php // $form->field($model, 'content')->textarea(['rows' => 6]) ?>
            <?php

            use vova07\imperavi\Widget;

            echo $form->field($model, 'content')->widget(Widget::className(), [
                'settings' => [
                    'uploadImageFields' => [
                            'album'=>'#album',
                            'name' => "test123"],
                    'callbacks' => [
                        'upload' => [
                            'beforeSend' => new \yii\web\JsExpression(' function ( xhr)
{
   alert( "My upload started!3333" );
             return false;
}'),
                        ]
                    ],
                    'imageData' => [
                        // https://imperavi.com/redactor/examples/images-and-files/additional-upload-data/
                        'elements' => '#album'
                    ],
                    'lang' => 'en',
                    'minHeight' => 200,
                    'plugins' => [
                        // 'clips',
//                        'fullscreen',

                    ],
                    'uploadStartCallback' => new \yii\web\JsExpression(' function ( e , formData )
{
   alert( "My upload started!" );
    // e.preventDefault();
       console.log(formData);    
       formData["someKey"] = "someValue" ;  
       console.log(this.uploadImageFields) ;
             return false;
}'),
                    // for image manager
                    'imageUpload' => Url::to(['default/image-upload']),
                    'imageDelete' => Url::to(['/default/file-delete']),
                    'imageManagerJson' => Url::to(['/default/images-get']),
                    'imageManagerUrl' => Url::to(['/content/photo/editor-selection']),
                    'imageAlbumUrl' => Url::to(['/content/album/api-list']),
                    // 'iframeUrl' => 'http://www.baidu.com', //  Url::to(['/default/images-get']),
                    'iframeUrl' => Url::to(['/default/images-get']),
                ],
                'plugins' => [
//                    'my-image-man' => \my\content\bundles\MyImageManagerAsset::className(),
                    'imagemanager' => \my\content\bundles\MyImageManagerAsset::className(),
//                    'iframe' => \my\content\bundles\MyImageManagerAsset::className(),
                ],

            ]);
            ?>

            <!-- attribute display_order -->
            <?= $form->field($model, 'display_order')->textInput() ?>

            <!-- attribute view_count -->
            <?= $form->field($model, 'view_count')->textInput() ?>

            <!-- attribute status -->
            <?= $form->field($model, 'status')->textInput() ?>

            <!-- attribute intro -->
            <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>

            <!-- attribute rep_thumb -->
            <?= $form->field($model, 'rep_thumb')->textInput(['maxlength' => true]) ?>


        </p>
        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('seo'); ?>
        <p>

            <!--SEO 相关属性-->
            <?= $form->field($model, 'seoTitle')->textInput(); ?>
            <?= $form->field($model, 'seoKeywords')->textInput(); ?>
            <?= $form->field($model, 'seoDescription')->textarea(); ?>
        </p>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => Yii::t('models', 'Article'),
                        'content' => $this->blocks['main'],
                        'active' => true,
                    ],
                    [
                        'label' => Yii::t('models', 'SEO'),
                        'content' => $this->blocks['seo'],
                    ],
                ]
            ]
        );
        ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

