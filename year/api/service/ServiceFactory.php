<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/9
 * Time: 12:49
 */

namespace year\api\service;


class ServiceFactory
{

    /**
     * @param string $serviceClass
     * @return CrudServiceInterface|mixed
     */
    public static function createCrudService($serviceClass )
    {
        $serviceProxy = new ServiceProxy() ;
        $serviceProxy->setTarget($serviceClass)  ;
        return $serviceProxy ;
    }

}