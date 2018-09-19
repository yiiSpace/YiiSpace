<?php
/**
 * User: yiqing
 * Date: 14-7-31
 * Time: 下午4:28
 */

namespace year\user\widgets;

//\Yii::$container->set('\year\base\Widget',['cacheTime'=>1000]);

use year\user\models\User;

class LatestUsers extends BaseWidget{


    public $limit = 10 ;

    public function run()
    {
        $query = User::find() ;
        $query->limit($this->limit)
            ->orderBy('id DESC');
        $users = $query->all();
       return   $this->render('latestUsers',['users'=>$users]);
    }
} 