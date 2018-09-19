<?php
/**
 * User: yiqing
 * Date: 14-9-13
 * Time: 下午7:05
 */
use yii\helpers\Url ;
?>

<a href="<?= Url::to(['photo/index','album_id'=>$model->primaryKey]) ?>" class="thumbnail">
    <img src="<?= $model->getCoverUrl() ?>" alt="...">
</a>
<p>
    <?= $model->name  ?>
</p>