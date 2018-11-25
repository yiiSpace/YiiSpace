<?php

namespace my\content\common\models;

use Yii;
use \my\content\common\models\base\Article as BaseArticle;
use yii\helpers\ArrayHelper;

use romi45\seoContent\components\SeoBehavior;

/**
 * This is the model class for table "content_article".
 */
class Article extends BaseArticle
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
                'seo' => [
                    'class' => SeoBehavior::className(),

                    // This is default values. Usually you can not specify it
                    'titleAttribute' => 'seoTitle',
                    'keywordsAttribute' => 'seoKeywords',
                    'descriptionAttribute' => 'seoDescription'
                ],
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
                [['seoTitle', 'seoKeywords', 'seoDescription'], 'safe'],
               //  [['seoTitle'], 'checkSeoTitleIsGlobalUnique'], // It recommends for title to be unique for every page. You can ignore this recommendation - just delete this rule.
                ['display_order','default','value'=>0],
                [['view_count',],'default','value'=>0],
                [['status' ,],'default','value'=>1],
            ]
        );
    }
}
