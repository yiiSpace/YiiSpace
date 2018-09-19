<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/24
 * Time: 22:23
 */

namespace year\validate;


use yii\base\Widget;

/**
 * todo 国际化可以在此 也可以在asset累里面做
 * Class JValidationEngine
 * @package year\validate
 */
class JValidationEngine extends Widget
{

    /**
     * 标准到 文件语言后缀的映射
     * @see (http://en.wikipedia.org/wiki/IETF_language_tag)
     * Yii::$app->language !
     * @var array
     */
    public static $langMap = [
        'zh-CN'=>'zh_CN'
    ];

    /**
     * @var string
     */
    public $lang = '';

    public function init()
    {
        $langFileSuffix = 'en';

       $lang = \Yii::$app->language ;
        if(isset(static::$langMap[$lang])){
            $langFileSuffix = static::$langMap[$lang] ;
        }

        $view = $this->getView();
        //TODO 这里做国际化 利用上面的两个变量做
        \Yii::$container->set(JValidationEngineAsset::className(), [
               'js' => ["js/languages/jquery.validationEngine-{$langFileSuffix}.js"]
            ]
        );
        $asset = JValidationEngineAsset::register($view);
        // $baseUrl = $asset->baseUrl ;
    }
}