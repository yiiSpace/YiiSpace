<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/6/12
 * Time: 10:33
 */

namespace year\widgets;


use yii\web\AssetBundle;

/**
 * @see https://github.com/jmblog/color-themes-for-google-code-prettify
 *
 * Class GoogleCodePrettifyTheme
 * @package year\widgets
 */
class GoogleCodePrettifyTheme extends AssetBundle
{


    const  THEME_GITHUB = 'github';

    const  THEME_HEMISU_DARK = 'hemisu-dark';
    const  THEME_HEMISU_LIGHT = 'hemisu-light';

    const  THEME_TOMORROW = 'tomorrow';
    const  THEME_TOMORROW_NIGHT = 'tomorrow-night';
    const  THEME_TOMORROW_NIGHT_BLUE = 'tomorrow-night-blue';
    const  THEME_TOMORROW_NIGHT_BRIGHT = 'tomorrow-night-bright';
    const  THEME_TOMORROW_NIGHT_EIGHTIES = 'tomorrow-night-eighties';

    const  THEME_TRANQUIL_HEART = 'tranquil-heart';

    const  THEME_VIBRANT_INK = 'vibrant-ink';


    /**
     * get all available themes
     *
     * @return array
     */
    public static function getAllThemes()
    {
        return [
            self::THEME_GITHUB,

            self::THEME_HEMISU_DARK,
            self::THEME_HEMISU_LIGHT,

            self::THEME_TOMORROW,
            self::THEME_TOMORROW_NIGHT,
            self::THEME_TOMORROW_NIGHT_BLUE,
            self::THEME_TOMORROW_NIGHT_BRIGHT,
            self::THEME_TOMORROW_NIGHT_EIGHTIES,

            self::THEME_TRANQUIL_HEART,

            self::THEME_VIBRANT_INK,
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
        if (in_array($themeName, static::getAllThemes())) {

            $bundle->css = [
                $themeName . '.css',
            ];

        } else {
            // throw an exception OR apply the default theme
        }
        return $bundle;
    }

    /**
     * @var string
     */
    public $sourcePath = '@year/widgets/assets/google-code-prettify-themes/css/themes';


    public $css = [

    ];


}