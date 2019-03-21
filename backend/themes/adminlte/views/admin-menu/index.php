<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-menu-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Admin Menu'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    use kartik\tree\TreeView;

    /*
    $treePartDirAlias = '@treePartDirAlias';
    Yii::setAlias($treePartDirAlias,__DIR__);
    */
    $treePartDirAlias = \year\helpers\Web::getRelativeAlias(__DIR__,'@backend');

    echo \kartik\tree\TreeView::widget([
        'query' => \backend\models\AdminMenu::find()->addOrderBy('root, lft'),
       // 'nodeView'=>$treePartDirAlias.'/tree-view/_form',
        'nodeAddlViews' => [
            // \kartik\tree\Module::VIEW_PART_2 => $treePartDirAlias.'/_treePart2'
            \kartik\tree\Module::VIEW_PART_2 => $treePartDirAlias.'/_treePart2',

        ],
        'headingOptions' => ['label' => 'Categories'],
        'rootOptions' => ['label' => '<span class="text-primary">Root</span>'],
        'fontAwesome' => false,
        'isAdmin' => true,
        'displayValue' => 1,
        'iconEditSettings' => [
            'show' => 'list',
            'listData' => [
                'folder-close' => 'Folder',
                'file' => 'File',
                'tag' => 'Tag',
            ],
        ],
        'softDelete' => true,
        'cacheSettings' => ['enableCache' => true],

    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'root',
            'lft',
            'rgt',
            'lvl',
            // 'name',
            // 'icon',
            // 'icon_type',
            // 'active',
            // 'selected',
            // 'disabled',
            // 'readonly',
            // 'visible',
            // 'collapsed',
            // 'movable_u',
            // 'movable_d',
            // 'movable_l',
            // 'movable_r',
            // 'removable',
            // 'removable_all',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
