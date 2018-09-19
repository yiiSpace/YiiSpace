<?php

namespace my\test\common\models;

use Yii;
use \my\test\common\models\base\User as BaseUser;

/**
 * This is the model class for table "user".
 */
class User extends BaseUser
{

    public function fields()
    {
        /*
        $fields = parent::fields();

        return $fields ;
        */

        return [
          'id'=>'id',
            'username'=>'username',
            'email'=>'email',
        ];
    }
}
