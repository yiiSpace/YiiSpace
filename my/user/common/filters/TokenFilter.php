<?php
namespace my\user\common\filters;


use Yii;
use yii\base\ActionFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * @property Controller $owner
 */
class TokenFilter extends ActionFilter
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->request->get('token') === null) {
            throw new ForbiddenHttpException(Yii::t('errors', 'Invalid authentication token.'));
        }
        return true;
    }
}