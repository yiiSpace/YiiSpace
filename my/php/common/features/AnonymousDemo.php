<?php

namespace my\php\common\features;

use year\db\DynamicActiveRecord;

class AnonymousDemo
{
    public static function run()
    {
//        DynamicActiveRecord::setDbID('db');
//        DynamicActiveRecord::setTableName('some_table');
        $anotherDAR = returnDynamicActiveRecord() ;
        $anotherDARClass = get_class($anotherDAR) ;

        var_dump($anotherDARClass);
    }

}

function returnDynamicActiveRecord(){
    return new class extends DynamicActiveRecord{
    };
}