<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model my\devtools\common\models\ApiProvider */
/* @var $form ActiveForm */
?>

<?php
$tableSchema = \my\devtools\common\models\ApiProvider::getTableSchema($model->tableName);

$requiredParams = $optionalParams = [];
 foreach ($tableSchema->columns as $column){
     echo $column->name ;
        if($column->allowNull || !empty($column->defaultValue)){
            $optionalParams[$column->name] = empty($column->defaultValue)?
            \my\devtools\common\models\ApiProvider::getPhpTypeZeroValue($column->phpType):
                $column->defaultValue
            ;
        }   else{
            $requiredParams[$column->name] = $column->name;
        }
 }
/*
print_r([
   $requiredParams,
    $optionalParams,
])
*/;
?>

<code>
    /**
    * Create <?= $model->getModelName() ."\n" ?>
	*
    <?php foreach ($tableSchema->columns as $column): ?>
        * @param <?= "{$column->phpType} \${$column->name}  {$column->comment}\n" ?>
    <?php endforeach; ?>
    *
    * @return array
    */
    public function actionCreate(
    <?php foreach ($requiredParams as $param): ?>
      <?= "\${$param}"  ?>,
    <?php endforeach; ?>
    <?php foreach ($optionalParams as $param=>$defaultVal): ?>
        <?= '$'.$param  .'= ' . $defaultVal ?>,
    <?php endforeach; ?>
    )
    {
         /**  @var $user User|\my\user\common\models\User  */
         $user = \Yii::$app->user->identity;

		$params = func_get_args() ;
        $model = new  <?= $model->getModelName() ."()" ?>;
        /**
         * below is for sigle item assignment !
    <?php foreach ($requiredParams+$optionalParams as $param=>$__): ?>
        <?= " \$model->{$param} = \${$param} ; \n " ?>
    <?php endforeach; ?>
        */
        $model->load($params,'');
        if($model->save()){
            return true ;
        }

        return $model ;
    }

</code>
