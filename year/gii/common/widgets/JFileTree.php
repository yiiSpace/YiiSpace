<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/6/20
 * Time: 16:20
 */

namespace year\gii\common\widgets;


use yii\base\Widget;

class JFileTree extends Widget
{

    const DEFAULT_PUB_TOPIC = 'file.choose' ;

    /**
     * @var string
     */
    public $pubTopic = self::DEFAULT_PUB_TOPIC ;

    public function run()
    {
       return $this->render('file-tree',[
            'pubTopic'=>$this->pubTopic ,
       ]);
    }

}