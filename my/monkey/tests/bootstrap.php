<?php

// ensure we get report on all possible php errors
error_reporting(-1);

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);
$_SERVER['SCRIPT_NAME'] = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

define('DS', DIRECTORY_SEPARATOR);

/**
 * return the vendor dir
 *
 * @return string
 */
function VendorDir()
{
    $rootBaseName = 'yii_blog';
    $projectRootDir = substr(__DIR__, 0, strpos(__DIR__, $rootBaseName)) . $rootBaseName;
    // die($phpSpaceRootDir) ;
    $vendorDir = $projectRootDir . DS . 'vendor';
    return $vendorDir;
}

require_once(VendorDir() . '/autoload.php');
require_once(VendorDir() . '/yiisoft/yii2/Yii.php');

Yii::setAlias('@yiiunit/extensions/monkey', __DIR__);
Yii::setAlias('@monkey', dirname(__DIR__));
