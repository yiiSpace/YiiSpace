<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-13
 * Time: 下午2:21
 */

namespace year\widgets;

use yii\web\AssetBundle ;

class FormDialogAsset extends AssetBundle{

    public $sourcePath = '@year/widgets/assets/formDialog';
    public $js = [
        'formDialog.js',
    ];
    public $depends = [
        'yii\jui\DialogAsset',

    ];

} 