<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/2/9
 * Time: 6:26
 */

namespace year\widgets;


use year\base\AssetBundle;

class IFrameUploadAsset extends AssetBundle{
    public $sourcePath = '@year/widgets/assets/iframe-upload';
    public $js = [
        'iframeUpload.js',
    ];
}