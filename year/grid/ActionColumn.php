<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-13
 * Time: 上午10:12
 */

namespace year\grid;

use Yii ;
use yii\helpers\Html ;

class ActionColumn extends \yii\grid\ActionColumn{



    /**
     * Initializes the default button rendering callbacks
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                    'class' => 'iframe-dialog-action',
                ]);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                    'class' => 'iframe-dialog-action',
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ]);
            };
        }
    }

} 