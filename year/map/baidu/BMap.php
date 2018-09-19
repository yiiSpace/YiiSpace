<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/27
 * Time: 14:17
 */

namespace year\map\baidu;


use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\web\View;

class BMap extends Widget
{

    /**
     * js version
     *
     * @var string
     */
    public $v = '2.0';
    /**
     * access key
     *
     * @var string
     */
    public $ak = '';

    /**
     * position where js file will be registered
     *
     * @var int
     */
    public $jsPos = View::POS_END;


    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        // this key can be configured global in assetManager.bundles section of the  main config file !
        if (empty($this->ak)) {

            throw new InvalidConfigException('must specify the access key for using this widget !');
        }

        // 注册转换工具
        BMapAsset::register($this->view) ;
    }

    /**
     *
     */
    public function run()
    {

        $query = \http_build_query([
            'v' => $this->v,
            'ak' => $this->ak,
        ]);
        $jsSrc = '//api.map.baidu.com/api?' . $query;
        $this->view->registerJsFile($jsSrc, ['position' => $this->jsPos]);
        $this->view->registerJsFile('//api.map.baidu.com/library/SearchInfoWindow/1.5/src/SearchInfoWindow_min.js', ['position' => $this->jsPos]);
    }

    public static function buildUrl($ak, $version = 2.0, $options = [])
    {
        $baseOpt = [
            'v' => $version,
            'ak' => $ak,
        ];

        $queryArr = empty($options)
            ? $baseOpt
            : array_merge($baseOpt, $options);

        $query = \http_build_query($queryArr);
        $jsSrc = '//api.map.baidu.com/api?' . $query;
        return $jsSrc;
    }
}