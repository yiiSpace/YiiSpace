<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/6/22
 * Time: 12:57
 */

namespace my\dci\backend\contexts;


use my\dci\backend\roles\TransferSource;
use my\dci\models\Account;

class TransferMoney
{
    /** @var Account|TransferSource  */
    protected $source ;

    protected $destination ;
    protected $amount ;

    /**
     * 注入所需要的数据对象  内部实现角色绑定
     *
     * TransferMoney constructor.
     * @param Account $source
     * @param Account $destination
     * @param float $amount
     */
    public function __construct($source, $destination, $amount = 0.0)
    {

        // 绑定行为  让对象充当角色
        $source->attachBehavior('transferSource',[
           'class'=>TransferSource::className(),
        ]);
        $this->source = $source ;


        $this->destination = $destination ;


        $this->amount = $amount ;

    }

    /**
     * context trigger
     */
    public function execute()
    {
        $this->source->transferTo($this->destination,$this->amount) ;
    }

}