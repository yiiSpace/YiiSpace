<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/4/19
 * Time: 19:30
 */

namespace my\test\backend\controllers;


use Casbin\Enforcer;
use CasbinAdapter\Yii\Casbin;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class CasbinController
 * @package my\test\backend\controllers
 */
class CasbinController extends Controller
{

    /**
     * @see https://github.com/jk2K/yii-casbin-demo
     *
     * @return string
     * @throws ForbiddenHttpException
     * @throws \Casbin\Exceptions\CasbinException
     */
    public function actionIndex()
    {
        /** @var Casbin|Enforcer $casbin */
        $casbin = \Yii::$app->casbin;


        $enforcer = $casbin->enforcer();
// give user "alice1" the "read" permission for "data1" resource
        $enforcer->addPermissionForUser('alice1', 'data1', 'read');
// give role "group_admin" the "read" permission for "data1" resource
        $enforcer->addPermissionForUser('group_admin', 'data1', 'read');
// assigning role to user
   // TODO 此行加上后就出错！
        //    $enforcer->addRoleForUser('alice', 'group_admin');

        $enforcer->addPermissionForUser('alice', 'data1', 'read');
        $sub = 'alice'; // the user that wants to access a resource.
        $obj = 'data1'; // the resource that is going to be accessed.
        $act = 'read'; // the operation that the user performs on the resource.

        if (true === $casbin->enforce($sub, $obj, $act)) {
            // permit alice to read data1
            return $this->renderContent('OK');
        } else {
            // deny the request, show an error
            throw  new ForbiddenHttpException('casbin forbidden!');
        }
    }

}