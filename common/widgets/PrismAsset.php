<?php
 
namespace common\widgets;

use yii\web\AssetBundle;

/**
 * This asset bundle provides the prismjs asset files .
 * @see https://prismjs.com/#examples
 *
 * @author qing <yiqing_95@qq.com>
 * @since 0.0.1
 * 
 * 关于如何使用AssetBundle 以及如何替换官方配置 参考
 * https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/guide/2.0/en/assets-setup
 * 
 * https://www.yiiframework.com/doc/guide/2.0/en/structure-assets
 */
class PrismAsset extends AssetBundle
{
    public $sourcePath = null ; // '@npm/xxx';

    public $cdnBaseUrl = 'https://unpkg.com/prismjs' ;

    public $version = '1.29.0' ;

    public function getCDNUrl()
    {
        return $this->cdnBaseUrl.'@'.$this->version ;
    }

    public $css = [
        // 'themes/prism.css',
        'themes/prism.min.css',
    ];
    public $js = [
        'prism.js',
    ];
    public $depends = [
        
    ];
    public function init()
    {
        parent::init();
        
    
    }
    protected function handleAssetFiles()
    {
        foreach ($this->js as $i => $js) {
            if (is_array($js)) {
                // $file = array_shift($js);
                // if (Url::isRelative($file)) {
                //     $js = ArrayHelper::merge($this->jsOptions, $js);
                //     array_unshift($js, $converter->convert($file, $this->basePath));
                //     $this->js[$i] = $js;
                // }
            // } elseif (Url::isRelative($js)) {
            } elseif ( $js !== null) {
                // $this->js[$i] = $converter->convert($js, $this->basePath);
                $this->js[$i] = 
                $this->getCDNUrl().'/'.$js;
            }
        }
        foreach ($this->css as $i => $css) {
            if (is_array($css)) {
                // 暂时不可能哦 ；
                // $file = array_shift($css);
                // if (Url::isRelative($file)) {
                //     $css = ArrayHelper::merge($this->cssOptions, $css);
                //     array_unshift($css, $converter->convert($file, $this->basePath));
                //     $this->css[$i] = $css;
                // }
            // } elseif (Url::isRelative($css)) {
            } elseif ( $css !== null) {
                // $this->css[$i] = $converter->convert($css, $this->basePath);
                $this->css[$i] = 
                $this->getCDNUrl().'/'.$css;

            }
        }
    }
    public function registerAssetFiles($view)
    {
        // 做一些前置动作 
        parent::registerAssetFiles($view) ;
    }

    public function publish($am)
    {
         // 做一些前置动作 
        $this->handleAssetFiles();

        parent::publish($am) ;
    }
}
