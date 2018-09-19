<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/12
 * Time: 9:23
 */

namespace year\widgets;


use yii\web\AssetBundle;

/**
 * @see https://github.com/google/code-prettify
 *
 * Class PrettifyAsset
 * @package year\widgets
 */
class PrettifyAsset extends AssetBundle
{

    const  THEME_DEFAULT = 'default';

    const  THEME_SUNBURST = 'sunburst';
    const  THEME_DOXY = 'doxy';
    const  THEME_SONS_OF_OBSIDIAN = 'sons-of-obsidian';
    const  THEME_DESERT = 'desert';

    /**
     * get all available themes
     *
     * @return array
     */
    public static function getAllThemes()
    {
        return [
            self::THEME_DESERT,
            self::THEME_DOXY,
            self::THEME_SONS_OF_OBSIDIAN,
            self::THEME_SUNBURST,
        ];
    }

    /**
     * return a random theme name
     *
     * @return mixed
     */
    public static function getRandomTheme()
    {
        $themes = static::getAllThemes();
        $idx = array_rand($themes);
        return $themes[$idx];
    }

    /**
     * 应用某个特定的皮肤：
     *
     * @param string $themeName
     * @return AssetBundle
     * @throws \yii\base\InvalidConfigException
     */
    public static function applyTheme($themeName)
    {
        $bundle = \Yii::$app->assetManager->getBundle(self::className());
        if (in_array($themeName, [self::THEME_DESERT, self::THEME_DOXY, self::THEME_SONS_OF_OBSIDIAN, self::THEME_SUNBURST])) {

            $bundle->css = [
                'styles/' . $themeName . '.css',
            ];

        } else {
            // throw an exception OR apply the default theme
        }
        return $bundle;
    }

    /**
     * @param  string $colorThemName
     * @param  \yii\web\View|null $view
     * @throws \yii\base\InvalidConfigException
     */
    public static function applyColorTheme($colorThemName, $view = null)
    {
        $colorThemeBundleAsset = GoogleCodePrettifyTheme::applyTheme($colorThemName);
        // 注册资源包
        $colorThemeBundleAsset->register(
            $view == null ? \Yii::$app->view : $view
        );
        // 由于css 间互相干扰 所以还要清除掉当前注册的css
        $asset = \Yii::$app->assetManager->getBundle(static::className());
        $asset->css = [];  // 清除注google-code-prettify自带的css
        /*
        if(!in_array(GoogleCodePrettifyTheme::className(),$asset->depends)){
           // 推入到依赖中去
        }
        */
    }

    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/google-code-prettify';

    /**
     * @var array
     */
    public $depends = [

    ];

    /**
     * @var array
     */
    public $jsOptions = [
        //  'position' => View::POS_END,
    ];

    public $css = [
        'prettify.css'
    ];

    /**
     *
     */
    public function init()
    {
        if (YII_DEBUG) {


        } else {
            /*
            $this->js = [
                'xxx.min.js',
            ];
            */
        }

        $this->js = [
            'prettify.js',
        ];

        parent::init();
    }
}