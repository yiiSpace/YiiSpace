<?php
/* @var $this \yii\web\View */
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $content string */

$this->beginContent(__DIR__.'/base.php')
?>
    <div class="container" style="margin-top: 50px">


        <?php echo $content ?>

    </div>
<?php $this->endContent() ?>