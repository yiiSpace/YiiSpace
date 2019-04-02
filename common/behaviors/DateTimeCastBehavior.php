<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2019/3/16
 * Time: 23:12
 */

namespace common\behaviors;


use yii\base\Behavior;
use yii\base\Event;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * 拷贝这个到宿主类去 可以添加智能提示
 *
 * @method string getLogicalName($physicalAttrName) Get Logical Attribute Name for dbAttribute
 * @method []string getLogicalAttributeLabels(string $attributeLabels)
 */

/**
 * Class DateTimeCastBehavior
 *
 * @see https://github.com/mdmsoft/yii2-format-converter/blob/master/DateConverter.php
 *
 * 使用例子 特别适合于ui上面有日期的形式
 *
 *
 *
 * ~~~php
 *  public function behaviors()
 * {
 *  return ArrayHelper::merge(
 *      parent::behaviors(),
 *     [
 *          # custom behaviors
 *         [
 *          'class' => DateTimeCastBehavior::className(),
 *          'attributesMapping' => [
 *              'uiCreatedAt'=>'created_at' ,
 *          ],
 *       ],
 *    ]
 *   );
 * }
 *
 * public function rules()
 * {
 *  return ArrayHelper::merge(
 *      parent::rules(),
 *      [
 *           # custom validation rules
 *          ['uiCreatedAt' , 'safe'],
 *      ]
 *      );
 * }
 *
 * public function attributeLabels()
 * {
 *      $attributeLabels = parent::attributeLabels() ;
 *
 *      $attributeLabels['uiCreatedAt'] = '填报时间2';
 *
 *      return $attributeLabels ;
 * }
 *
 *~~~
 *
 * @package common\behaviors
 *
 * TODO  提供格式转换配置
 * - uiFormat  ==> 'Y-m-t'
 * - 暴露Closure 可以自定义转换器
 *
 */
class DateTimeCastBehavior extends Behavior
{

    /**
     * 根据 `物理属性名` 获取对应的映射 默认规则是：
     *
     *       'user_created'=> UserCreated
     *
     * @param array $physicalAttrNames
     * @param string $prefix
     * @return array
     */
    public static function createMappingFromAttributes($physicalAttrNames = [], $prefix = '')
    {
        $mapping = [];

        foreach ($physicalAttrNames as $idx=>$physicalAttrName){
            $mapping[$prefix.Inflector::camelize($physicalAttrName)] = $physicalAttrName ;
        }

        return $mapping;
    }

    /**
     * @param $physicalAttrName
     * @return mixed
     */
    public function getLogicalName($physicalAttrName)
    {
        static $mapping;
        $mapping = array_flip($this->attributesMapping);
        return $mapping[$physicalAttrName];

    }

    /**
     * FIXMe 本来是想传递一个指针的 当初用的是5.4 好像在那一版中不允许传指针？
     *
     * @param $attributeLabels
     * @return array
     */
    public function getLogicalAttributeLabels($attributeLabels)
    {
        $labels = [];
        foreach ($this->attributesMapping as $logicAttr => $physicalAttr) {
            $labels[$logicAttr] = $attributeLabels[$physicalAttr];
        }
        return $labels;

    }

    /**
     * @var array
     */
    public $attributesMapping = [];

    /**
     *
     */
    public function init()
    {
        parent::init();

        foreach ($this->attributesMapping as $uiAttribute => $modelAttribute) {
            $this->_attributes[$uiAttribute] = null;
        }
    }

    /**
     * @var array
     */

    private $_attributes = [];


    /**
     * @param $name
     * @return bool
     */
    public function hasAttribute($name)
    {
        return array_key_exists($name, $this->_attributes); // 如果存在 Null 也算哦 注意跟底下两个的区别
        // return isset($this->_attributes[$name]) || in_array($name, $this->attributes(), true);
    }


    /*
    public function getAttribute($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }

    public function setAttribute($name, $value)
    {
        if ($this->hasAttribute($name)) {

            $this->_attributes[$name] = $value;
        } else {
            throw new InvalidArgumentException(get_class($this) . ' has no attribute named "' . $name . '".');
        }
    }
    */

    /**
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return parent::canGetProperty($name, $checkVars) || $this->hasAttribute($name);;
    }

    /**
     * @param string $name
     * @param bool $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return parent::canSetProperty($name, $checkVars) || $this->hasAttribute($name);;
    }

    /**
     *                               处理事件
     * ======================================================================================== +|
     */


    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'myBeforeValidate',
            ActiveRecord::EVENT_AFTER_FIND => 'myAfterFind',
        ];
    }

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function myBeforeValidate($event)
    {
        foreach ($this->_attributes as $attr => $val) {
            $ownerAttr = $this->attributesMapping[$attr];

            if (!empty($val)) {
                // NOTE Y-m-d 不提供时间部分 那么是按照当前时间计算给的  会变！
                // $date = date_create_from_format('Y-m-d',$this->uiStartedAt) ;
                // TODO 这里想做个性化配置 再添加独立支持 比如格式之类
                // TODO 如果不想搞太复杂 可以配置多个该类实例每个不同的格式 就可以做到了
                $date = date_create_from_format('!Y-m-d', $val);
                // 转时间格式

                if ($date) {

                    $this->owner->{$ownerAttr} = $date->getTimestamp();;
                }

            }else{
                $this->owner->{$ownerAttr}  = 0 ;
            }
        }

    }

    public function myAfterFind($event)
    {

        foreach ($this->_attributes as $attr => $val) {

            $ownerAttr = $this->attributesMapping[$attr];
            $ownerAttrVal = $this->owner->{$ownerAttr};

            if (!empty($ownerAttrVal)) {
                $this->{$attr} = date('Y-m-d', $ownerAttrVal);
            } else {
                $this->{$attr} = '';  // FIXME 通过空串 需要对应到db中的null  :  $this->started_at = new DbExpression('null');
            }
        }

    }


    /**
     * ======================================================================================== +|
     */

    /**
     *              魔术方法复写
     *   =========================================================================================  +|
     */

    /**
     * 提供读 $obj->name 支持
     *
     * {@inheritdoc}
     */
    public function __get($name)
    {
        if ($this->hasAttribute($name)) {
            return $this->_attributes[$name];
        }

        return parent::__get($name);
    }

    /**
     * 提供  $obj->name = $value 访问
     *
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        if ($this->hasAttribute($name)) {
            $this->_attributes[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     *  提供 isset($obj->someName)
     *
     * {@inheritdoc}
     */
    public function __isset($name)
    {
        if ($this->hasAttribute($name)) {
            return isset($this->_attributes[$name]);
        }

        return parent::__isset($name);
    }

    /**
     * 提供 unset($obj->name) 支持
     *
     * {@inheritdoc}
     */
    public function __unset($name)
    {
        if ($this->hasAttribute($name)) {
            unset($this->_attributes[$name]);
        } else {
            parent::__unset($name);
        }
    }

    /**
     *   =========================================================================================  +|
     */

}