<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 14-4-27
 * Time: 上午11:50
 */

namespace year\widgets\fancyTreeSkins;

use yii\web\AssetBundle;

/**
 * Class BootstrapAsset
 *
 * every skin asset class represents a specified skin ?
 *
 * @package year\widgets\fancyTreeSkins
 */
class BootstrapAsset extends AssetBundle
{
    public $sourcePath = '@year/widgets/assets/fancyTree';
    public $css = [
        'skin-bootstrap/ui.fancytree.min.css',
    ];

}