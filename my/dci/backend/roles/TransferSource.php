<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/6/22
 * Time: 13:09
 */

namespace my\dci\backend\roles;


use my\dci\models\Account;
use yii\base\Behavior;

/**
 * Class TransferSource
 * @package my\dci\backend\roles
 */
class TransferSource extends Behavior
{

    /**
     * @param Account $destination
     * @param float $amount
     */
    public function transferTo(  $destination  , $amount=0.0  )
    {
	 // source.SetBalance(source.Balance() - amount)
     //	destination.SetBalance(destination.Balance() + amount)

        /** @var Account $dataModel */
        $dataModel = $this->owner ;
        $dataModel->balance = $dataModel->balance - $amount ;
        $destination->balance = $destination->balance + $amount ;

    }
}