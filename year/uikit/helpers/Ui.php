<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/4/5
 * Time: 7:06
 */

namespace year\uikit\helpers;


use yii\helpers\Html;

class Ui extends Html{


    /**
     * @inheritdoc
     */
    public static function button($content = 'Button', $options = [])
    {
        static::addCssClasses($options, ['uk-button', 'button']);
        return parent::button($content, $options);
    }

    /**
     * Adds multiple CSS classes to the specified options.
     * If one of the CSS class is already in the options, it will not be added again.
     *
     * @param array $options the options to be modified.
     * @param array $classes the CSS classes to be added
     */
    public static function addCssClasses(&$options, $classes)
    {
        foreach ($classes as $class) {
            Html::addCssClass($options, $class);
        }
    }
}