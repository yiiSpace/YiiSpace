<?php
/**
 * User: yiqing
 * Date: 14-7-31
 * Time: 下午4:50
 */

namespace year\base;

use Yii ;
use yii\base\Theme as YiiBaseTheme;

use yii\helpers\FileHelper;

/**
 * 搭配使用的类有：@year/base/WebApplicationEndBehavior , @year/base/Widget
 *
 * @see https://github.com/sheillendra/yii2-theme
 *
 * Class Theme
 * @package year\base
 */
class Theme extends YiiBaseTheme{
    /**
     * give a name for this theme
     * widget will use it to determine the view location !
     * @var string
     */
    public $name = 'bootstrap';

    public $active;

    /**
     * Initializes the theme.
     * @throws InvalidConfigException if [[basePath]] is not set.
     */
    public function init() {
        parent::init();
        if ($this->baseUrl === null) {
            $this->baseUrl = '@web/themes/' . $this->active;
        }
        $this->baseUrl = rtrim(\Yii::getAlias($this->baseUrl), '/');
        if ($this->basePath === null) {
            $this->basePath = '@webroot/themes/' . $this->active;
        }
        $this->basePath = Yii::getAlias($this->basePath);
        if (empty($this->pathMap)) {
            $this->pathMap = [Yii::$app->getBasePath() => [$this->basePath]];
        }
    }

    /**
     * Converts a file to a themed file if possible.
     * If there is no corresponding themed file, the original file will be returned.
     * @param string $path the file to be themed
     * @return string the themed file, or the original file if the themed version is not available.
     */
    public function applyTo($path) {
        $path = FileHelper::normalizePath($path);
        foreach ($this->pathMap as $from => $tos) {

            $from = FileHelper::normalizePath(Yii::getAlias($from)) . DIRECTORY_SEPARATOR;

            if (strpos($path, $from) === 0) {


                $n = strlen($from);
                foreach ((array) $tos as $to) {
                    $to = FileHelper::normalizePath(Yii::getAlias($to)) . DIRECTORY_SEPARATOR;
                    $file = $to . substr($path, $n);
                   // print_r($file);
                    if (is_file($file)) {

                        return $file;
                    }
                }
            }
        }
        return $path;
    }
} 