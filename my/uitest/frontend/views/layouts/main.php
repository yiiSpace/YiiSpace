<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */


\year\uikit\UIkitAsset::register($this);
\my\uitest\frontend\assets\AppUiKit::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--    TODO 这里目前有bug-->
    <?php  echo Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="tm-background">
    <?php $this->beginBody() ?>

    <nav class="tm-navbar uk-navbar uk-navbar-attached">
        <div class="uk-container uk-container-center">

            <a href="../index.html" class="uk-navbar-brand uk-hidden-small"><img width="90" height="30" alt="UIkit" title="UIkit" src="images/logo_uikit.svg" class="uk-margin uk-margin-remove"></a>

            <ul class="uk-navbar-nav uk-hidden-small">
                <li><a href="documentation_get-started.html">Get Started</a></li>
                <li class="uk-active"><a href="core.html">Core</a></li>
                <li><a href="components.html">Components</a></li>
                <li><a href="customizer.html">Customizer</a></li>
                <li><a href="../showcase/index.html">Showcase</a></li>
            </ul>

            <a data-uk-offcanvas="" class="uk-navbar-toggle uk-visible-small" href="#tm-offcanvas"></a>

            <div class="uk-navbar-brand uk-navbar-center uk-visible-small"><img width="90" height="30" alt="UIkit" title="UIkit" src="images/logo_uikit.svg"></div>

        </div>
    </nav>

    <div class="tm-middle">

        <?= $content ?>

    </div>

    <div class="tm-footer">
        <div class="uk-container uk-container-center uk-text-center">

            <ul class="uk-subnav uk-subnav-line uk-flex-center">
                <li><a href="http://github.com/uikit/uikit">GitHub</a></li>
                <li><a href="http://github.com/uikit/uikit/issues">Issues</a></li>
                <li><a href="http://github.com/uikit/uikit/blob/master/CHANGELOG.md">Changelog</a></li>
                <li><a href="https://twitter.com/getuikit">Twitter</a></li>
            </ul>

            <div class="uk-panel">
                <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
                <p class="pull-right"><?= Yii::powered() ?></p>

            </div>

        </div>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
