<?php
use yii\widgets\DetailView;
use yii\bootstrap\Tabs ;

$asset = year\user\UserAsset::register($this);

?>

<?php $this->beginContent('@year/user/views/layouts/space.php') ?>

<div class="content">
    hi  <?= __FILE__ ?>

    <div>

<?php $this->endContent() ?>