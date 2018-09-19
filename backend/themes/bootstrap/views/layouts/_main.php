<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

Yii::$container->set(\yii\web\JqueryAsset::className(),[
    'jsOptions'=>[
        'position'=>\yii\web\View::POS_HEAD,
    ]
]);

$jqueryAsset = \yii\web\JqueryAsset::register($this);
/*
$jqueryAsset->jsOptions = [
    'position'=>\yii\web\View::POS_END,
];
*/

$appAsset = \year\ui\CharismaAsset::register($this);
$appAssetUrl = $appAsset->baseUrl ;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!--
            ===
            This comment should NOT be removed.

            Charisma v2.0.0

            Copyright 2012-2014 Muhammad Usman
            Licensed under the Apache License v2.0
            http://www.apache.org/licenses/LICENSE-2.0

            http://usman.it
            http://twitter.com/halalit_usman
            ===
        -->
        <meta charset="utf-8">

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
        <meta name="author" content="Muhammad Usman">

        <!-- The styles todo 暂时禁用换服功能
        <link id="bs-css" href="<?= $appAssetUrl ?>/css/bootstrap-cerulean.min.css" rel="stylesheet">
         -->
        <link  href="<?= $appAssetUrl ?>/css/bootstrap-cerulean.min.css" rel="stylesheet">

        <link href="<?= $appAssetUrl ?>/css/charisma-app.css" rel="stylesheet">
        <link href='<?= $appAssetUrl ?>/bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
        <link href='<?= $appAssetUrl ?>/bower_components/chosen/chosen.min.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/jquery.noty.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/noty_theme_default.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/elfinder.min.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/elfinder.theme.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/jquery.iphone.toggle.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/uploadify.css' rel='stylesheet'>
        <link href='<?= $appAssetUrl ?>/css/animate.min.css' rel='stylesheet'>

        <!-- jQuery
        <script src="bower_components/jquery/jquery.min.js"></script>
    -->

        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- The fav icon -->
        <link rel="shortcut icon" href="<?= $appAssetUrl ?>/img/favicon.ico">

        <?php $this->head() ?>
    </head>
    <body>

    <?php $this->beginBody() ?>


    <?= $content ?>

    <?php $this->endBody() ?>

    <!-- external javascript -->

    <script src="<?= $appAssetUrl ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- library for cookie management -->
    <script src="<?= $appAssetUrl ?>/js/jquery.cookie.js"></script>
    <!-- calender plugin -->
    <script src='<?= $appAssetUrl ?>/bower_components/moment/min/moment.min.js'></script>
    <script src='<?= $appAssetUrl ?>/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
    <!-- data table plugin -->
    <script src='<?= $appAssetUrl ?>/js/jquery.dataTables.min.js'></script>

    <!-- select or dropdown enhancer -->
    <script src="<?= $appAssetUrl ?>/bower_components/chosen/chosen.jquery.min.js"></script>
    <!-- plugin for gallery image view -->
    <script src="<?= $appAssetUrl ?>/bower_components/colorbox/jquery.colorbox-min.js"></script>
    <!-- notification plugin -->
    <script src="<?= $appAssetUrl ?>/js/jquery.noty.js"></script>
    <!-- library for making tables responsive -->
    <script src="<?= $appAssetUrl ?>/bower_components/responsive-tables/responsive-tables.js"></script>
    <!-- tour plugin -->
    <script src="<?= $appAssetUrl ?>/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
    <!-- star rating plugin -->
    <script src="<?= $appAssetUrl ?>/js/jquery.raty.min.js"></script>
    <!-- for iOS style toggle switch -->
    <script src="<?= $appAssetUrl ?>/js/jquery.iphone.toggle.js"></script>
    <!-- autogrowing textarea plugin -->
    <script src="<?= $appAssetUrl ?>/js/jquery.autogrow-textarea.js"></script>
    <!-- multiple file upload plugin -->
    <script src="<?= $appAssetUrl ?>/js/jquery.uploadify-3.1.min.js"></script>
    <!-- history.js for cross-browser state change on ajax -->
    <script src="<?= $appAssetUrl ?>/js/jquery.history.js"></script>
    <!-- application script for Charisma demo -->
    <script src="<?= $appAssetUrl ?>/js/charisma.js"></script>

    </body>
    </html>
<?php $this->endPage() ?>