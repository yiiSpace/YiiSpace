<?php
// @see https://github.com/schmunk42/yii2-giiant/blob/master/docs/20-batches.md

//$crudNs = '\project\modules\crud'; // 给的示例就是这个路径
$crudNs = '\modules\crud';

return [
    'class' => 'schmunk42\giiant\commands\BatchController',
    'overwrite' => true,
    'modelNamespace' => $crudNs . '\models',
    'modelQueryNamespace' => $crudNs . '\models\query',
    'crudControllerNamespace' => $crudNs . '\controllers',
    'crudSearchModelNamespace' => $crudNs . '\models\search',
    'crudViewPath' => '@project/modules/crud/views',
    'crudPathPrefix' => '/crud/',
    'crudTidyOutput' => true,
    'crudActionButtonColumnPosition' => 'right', //left by default
    'crudProviders' => [
        \schmunk42\giiant\generators\crud\providers\core\OptsProvider::className()
    ],
//    'tablePrefix' => 'app_',
    'tables' => [
//        'app_profile',
    ]
];