<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace year\api\rest;

use year\api\service\CrudServiceInterface;
use year\api\service\ServiceInterface;
use year\api\service\ServiceExecutor;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecordInterface;
use yii\web\NotFoundHttpException;

/**
 * Action is the base class for action classes that implement RESTful API.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Action extends \yii\base\Action
{
    /**
     * @var string class name of the service which will be handled by this action.
     * The service class must implement [[CrudServiceInterface]].
     * This property must be set.
     */
    public $serviceClass;
    /**
     * @var callable a PHP callable that will be called to return the model corresponding
     * to the specified primary key value. If not set, [[findModel()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($id, $action) {
     *     // $id is the primary key value. If composite primary key, the key values
     *     // will be separated by comma.
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return the model found, or throw an exception if not found.
     */
    public $findModel;
    /**
     * @var callable a PHP callable that will be called when running an action to determine
     * if the current user has the permission to execute the action. If not set, the access
     * check will not be performed. The signature of the callable should be as follows,
     *
     * ```php
     * function ($action, $model = null) {
     *     // $model is the requested model instance.
     *     // If null, it means no specific model (e.g. IndexAction)
     * }
     * ```
     */
    public $checkAccess;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->serviceClass === null) {
            throw new InvalidConfigException(get_class($this) . '::$serviceClass must be set.');
        }
        // TODO: 检测类是否实现了特定接口 拥有 crud的功能
    }

    /**
     * @return ServiceExecutor
     */
    protected function getServiceExecutor()
    {
        $serviceExecutor = new ServiceExecutor();
        $serviceExecutor->setServiceClass( $this->serviceClass ) ;
        return $serviceExecutor ;
    }

    /**
     * Returns the data model based on the primary key given.
     * If the data model is not found, a 404 HTTP exception will be raised.
     * @param string $id the ID of the model to be loaded. If the model has a composite primary key,
     * the ID must be a string of the primary key values separated by commas.
     * The order of the primary key values should follow that returned by the `primaryKey()` method
     * of the model.
     * @return ActiveRecordInterface the model found
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if ($this->findModel !== null) {
            return call_user_func($this->findModel, $id, $this);
        }
        /*
        $keys = $modelClass::primaryKey();
        if (count($keys) > 1) {
            $values = explode(',', $id);
            if (count($keys) === count($values)) {
                $model = $modelClass::findOne(array_combine($keys, $values));
            }
        } elseif ($id !== null) {
            $model = $modelClass::findOne($id);
        }
        */
        $model = $this->getServiceExecutor()
            ->invoke('get',['id'=>$id]) ;

        if (isset($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException("Object not found: $id");
        }
    }
}
