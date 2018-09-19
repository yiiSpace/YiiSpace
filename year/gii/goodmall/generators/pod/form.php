<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\module\Generator */

?>
<div class="module-form">

 <?php echo getenv("GOPATH") ?>

<?php
    
    echo $form->field($generator, 'podsPath');
    echo $form->field($generator, 'podID');
?>
</div>
