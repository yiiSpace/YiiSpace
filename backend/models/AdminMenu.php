<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/21
 * Time: 16:18
 */

namespace backend\models;


use kartik\tree\models\Tree;
use kartik\tree\TreeView;

class AdminMenu extends \kartik\tree\models\Tree
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_admin_menu';
    }

    /**
     * TODO 暂时开启
     *
     * Override isDisabled method if you need as shown in the
     * example below. You can override similarly other methods
     * like isActive, isMovable etc.
     */
    public function isDisabled()
    {
        return false;

        if (\Yii::$app->user->id !== 'admin') {
            return true;
        }
        return parent::isDisabled();
    }

    public function beforeValidate()
    {
        if (empty($this->icon_type)) {
            $this->icon_type = TreeView::ICON_CSS;
        }

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function rules()
    {
        $parentRules = parent::rules();
         $parentRules[] = [
          ['url'],'safe'
        ];
        //  print_r($parentRules);
        //die(__METHOD__);
        return $parentRules ;
    }
}