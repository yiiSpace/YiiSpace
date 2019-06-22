<?php

namespace my\dci\backend\controllers;

use my\dci\backend\contexts\TransferMoney;
use my\dci\models\Account;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Default controller for the `dci` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
       $source = new Account([
           'name'=>'yiqing',
           'balance'=>1000 ,
       ]);
        $dest  = new Account([
            'name'=>'Kanokon',
            'balance'=>1000 ,
        ]);

        $transferMoney = new TransferMoney($source,$dest,100);
        $transferMoney->execute() ;

        VarDumper::dump([
           'source'=>$source->toArray() ,
           'dest'=>$dest->toArray() ,
        ]);
    }
}
