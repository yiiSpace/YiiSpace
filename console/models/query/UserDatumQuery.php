<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\my\test\common\models\UserDatum]].
 *
 * @see \my\test\common\models\UserDatum
 */
class UserDatumQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \my\test\common\models\UserDatum[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \my\test\common\models\UserDatum|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
