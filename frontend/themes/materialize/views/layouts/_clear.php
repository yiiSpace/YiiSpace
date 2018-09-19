<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */
//\webmaxx\materialize\MaterializeAsset::register($this) ;

/**
 * NOTE  这个地方由于原始插件指定的资源路径有误 materialize bower源下载下来没有dist目录  所有手动更正 在composer中bower-asset处指定并在此修改
 */
\Yii::$container->set(\webmaxx\materialize\MaterializeAsset::className(),
    ['sourcePath' => '@year/patch/vendor/materialize']);

\Yii::$container->set(\webmaxx\materialize\MaterializePluginAsset::className(),
    ['sourcePath' => '@year/patch/vendor/materialize']);
\webmaxx\materialize\MaterializePluginAsset::register($this);

\frontend\themes\materialize\assets\AppAsset::register($this);

// AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
