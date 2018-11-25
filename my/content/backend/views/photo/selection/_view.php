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

<a href="<?= $model->getUrl() ?>" class="thumbnail">
    <img src="<?= $model->getUrl() ?>" alt="...">
</a>
<p>
    <a href="<?= Url::to(['photo/view','id'=>$model->primaryKey]) ?>" class="view">
        <?= $model->title  ?>
    </a>
    <a href="<?= Url::to(['photo/as-album-cover','id'=>$model->primaryKey]) ?>" class="ajax">
        设置为封面
    </a>
</p>