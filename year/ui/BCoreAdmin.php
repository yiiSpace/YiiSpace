<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-10
 * Time: 下午7:10
 */

namespace year\ui;

use yii\base\ViewContextInterface;
use yii\helpers\Html;

class BCoreAdmin
{


    /**
     * @var ViewContextInterface
     */
    protected static $viewContext = null;

    /**
     * @param ViewContextInterface $context
     */
    public static function setViewContext(ViewContextInterface $context = null)
    {
        static::$viewContext = $context;
    }

    /**
     * @return ViewContextInterface
     */
    public static function getViewContext()
    {
        if (null == static::$context) {
            static::$viewContext = \Yii::$app->controller;
        }
        return static::$viewContext;
    }


    /**
     * @var array
     */
    protected static $globalStyles = [];
    /**
     * @var array
     */
    protected static $pageStyles = [];
    /**
     * @var array
     */
    protected static $globalScripts = [];
    /**
     * @var array
     */
    protected static $pageScripts = [];

    /**\
     * @var string
     */
    protected static $assetBaseUrl = '';

    /**
     * @param ViewContextInterface $viewContext
     * @return AssetBundle
     */
    public static function registerAsset($viewContext = null)
    {
        if (empty($viewContext)) {
            $viewContext = static::getViewContext();
        }
        $asset = BCoreAdminAsset::register($viewContext);
        static::$assetBaseUrl = $asset->baseUrl;
        // die($asset->baseUrl.__METHOD__);
        return $asset;
    }


    /**
     * @param string|array| $globalStyle
     */
    public static function addGlobalStyles($globalStyle = '')
    {
        $styles = [];
        if (func_num_args() > 1) {
            $styles = func_get_args();
        } else {
            if (is_string($globalStyle)) {
                $styles[] = $globalStyle;
            } elseif (is_array($globalStyle)) {
                $styles = $globalStyle;
            }
        }

        static::$globalStyles = array_merge(static::$globalStyles, $styles);
        //array_push(static::$globalStyles,$styles);
    }

    /**
     * @param string|array $pageStyle
     * @throws \InvalidArgumentException
     */
    public static function addPageStyles($pageStyle = '')
    {
        $styles = [];
        if (func_num_args() > 1) {
            $styles = func_get_args();
        } else {
            if (is_string($pageStyle)) {
                $styles[] = $pageStyle;
            } elseif (is_array($pageStyle)) {
                $styles = $pageStyle;
            } else {
                throw new \InvalidArgumentException('pageStyle should be a string or array !');
            }
        }

        static::$pageStyles = array_merge(static::$pageStyles, $styles);
    }

    /**
     * @param string|array $globalScript
     */
    public static function addGlobalScripts($globalScript = '')
    {
        $scripts = [];
        if (func_num_args() > 1) {
            $scripts = func_get_args();
        } else {
            if (is_string($globalScript)) {
                $scripts[] = $globalScript;
            } elseif (is_array($globalScript)) {
                $scripts = $globalScript;
            }
        }

        // TODO 用ArrayHelper::merge 做数组合并 | static::$globalScripts += $scripts ;
        static::$globalScripts = array_merge(static::$globalScripts, $scripts);

    }

    /**
     * TODO 用ArrayHelper::merge 做数组合并
     * @param string|array $pageScript
     */
    public static function addPageScripts($pageScript = '')
    {
        $scripts = [];
        if (func_num_args() > 1) {
            $scripts = func_get_args();
        } else {
            if (is_string($pageScript)) {
                $scripts[] = $pageScript;
            } elseif (is_array($pageScript)) {
                $scripts = $pageScript;
            }
        }

        // static::$pageScripts += $scripts ;
        static::$pageScripts = array_merge(static::$pageScripts, $scripts);
        // array_push(static::$pageScripts,$scripts);

    }

    /**
     *
     */
    public static function registerGlobalStyles()
    {
        static::renderCssFiles(static::$globalStyles);
    }

    /**
     *
     */
    public static function registerPageStyles()
    {
        // die(__METHOD__);
        static::renderCssFiles(static::$pageStyles);

    }

    protected static function renderCssFiles($styles = [])
    {
        // die(static::$assetBaseUrl . __METHOD__);
        $files = [];
        $options = [];
        $options['rel'] = 'stylesheet';
        foreach ($styles as $style) {
            $options['href'] = static::$assetBaseUrl . '/' . ltrim($style, '/');
            $files[] = Html::tag('link', '', $options);
        }
        echo empty($files) ? '' : implode("\n", $files);
    }

    /**
     *
     */
    public static function registerGlobalScripts()
    {
        static::renderScripts(static::$globalScripts);
    }


    /**
     *
     */
    public static function registerPageScripts()
    {
         // print_r(self::$pageScripts) ;
        static::renderScripts(static::$pageScripts);

    }

    /**
     * @param array $scripts
     */
    protected static function renderScripts($scripts = [])
    {
        $files = [];
        $scriptOption = [];
        foreach ($scripts as $script) {
            $scriptOption['src'] = static::$assetBaseUrl . '/' . ltrim($script, '/');
            $files[] = Html::tag('script', '', $scriptOption);
        }
        echo empty($files) ? '' : implode("\n", $files);
    }

} 