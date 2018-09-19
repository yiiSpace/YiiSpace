<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<?= "  <?php " ?>   \year\charisma\Box::begin([
                'options'=>[
                      'class'=>'col-md-12'
                ],
            'headerTitle'=>'<i class="glyphicon glyphicon-search"></i> '.Html::encode($this->title),
            'headerIcons'=>[
                  '<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>',
             ]
        ]) ?>


        <div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

            <?= "<?php " ?>$form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options'=>[
            'class'=>'', // form-inline
            ],
            ]); ?>

            <?php
            $count = 0;
            $col = 3 ;
            $attributeCount = count($generator->getColumnNames()) ;

            foreach ($generator->getColumnNames() as $attribute) {
                ++$count ;
                if($count == 1){
                    // first row
                    echo '<div class="row">'," \n\n ";
                }

                if ( $count <= $attributeCount /*  $count < 6  */) {
                    echo  '<div class="col-xs-4"> '," \n\n ";

                    echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";

                    echo '</div>' ," \n\n ";

                } else {
                    echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
                }

                if(($count % $col) == 0){
                    echo '</div>'," \n\n ";
                    if($count !== count($generator->getColumnNames())){
                        echo '<div class="row">'," \n\n ";
                    }
                }
                //  last count
                if($count == $attributeCount){

                    echo '</div>'," \n\n ";
                }

            }
            ?>
            <div class="form-group row">
<!--                pull-right-->
                <div  class="col-xs-offset-10">
                    <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
                    <?= "<?= " ?>Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default']) ?>
                </div>
            </div>

            <?= "<?php " ?>ActiveForm::end(); ?>


</div>

<?= "   <?php " ?>  \year\charisma\Box::end() ?>
