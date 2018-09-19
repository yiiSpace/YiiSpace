<?php
/**
 * User: yiqing
 * Date: 14-9-13
 * Time: 下午7:05
 */
use yii\helpers\Url ;

/**
 * @var yii\web\View $this
 * @var my\content\common\models\Photo $model
 */
?>

<a href="<?= Url::to(['photo/view','id'=>$model->primaryKey]) ?>" class="thumbnail">
    <img src="<?= $model->getUrl() ?>" alt="...">
</a>
<p>
    <?= $model->title  ?>
</p>