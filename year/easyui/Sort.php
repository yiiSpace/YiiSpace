<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/24
 * Time: 23:23
 */

namespace year\easyui;

use Yii ;
use yii\web\Request;

/**
 * easyUi 排序部分 url片段的规则如： sort=username%2Cauth_key&order=desc%2Casc
 *
 * Class Sort
 * @package year\easyui
 */
class Sort extends \yii\data\Sort{

    /**
     * 默认允许多重排序
     *
     * @var bool
     */
    public $enableMultiSort = true ;

    /**
     * @var string
     */
    public $orderParam = 'order';
    /**
     * FIXME 鸭蛋的 竟然是私有属性 害的还需要在声明一遍！
     *
     * @var array the currently requested sort order as computed by [[getAttributeOrders]].
     */
    private $_attributeOrders;
    /**
     * Returns the currently requested sort information.
     * @param boolean $recalculate whether to recalculate the sort directions
     * @return array sort directions indexed by attribute names.
     * Sort direction can be either `SORT_ASC` for ascending order or
     * `SORT_DESC` for descending order.
     */
    public function getAttributeOrders($recalculate = false)
    {
        if ($this->_attributeOrders === null || $recalculate) {
            $this->_attributeOrders = [];
            if (($params = $this->params) === null) {
                $request = Yii::$app->getRequest();
                $params = $request instanceof Request ? $request->getQueryParams() : [];
               // print_r($request->getQueryParams());
            }
           /*
            print_r([
               'sort'=>$params[$this->sortParam],
                'order'=>$params[$this->orderParam],
            ]);
           */
            if (isset($params[$this->sortParam]) && is_scalar($params[$this->sortParam])) {

                $attributes = explode($this->separator, $params[$this->sortParam]);
                $orders = explode($this->separator,$params[$this->orderParam]);

                /*
                print_r([
                   'attributes'=>$attributes,
                    'orders'=>$orders ,
                ]);
                die(__METHOD__);
                */
                foreach ($attributes as $idx => $attribute) {
                    $descending = false;
                    $order = $orders[$idx];
                    if($order == 'desc'){
                        $descending = true ;
                    }

                    /**
                     * TODO 暂时忽略掉 全部可以排序  ; attributes 的赋值在ActiveDataProvider中是很诡异的：
                     * 参考： ActiveDataProvider::setSort 方法内部的实现吧！
                     *
                    if (isset($this->attributes[$attribute])) {
                        $this->_attributeOrders[$attribute] = $descending ? SORT_DESC : SORT_ASC;
                        if (!$this->enableMultiSort) {
                            return $this->_attributeOrders;
                        }
                    }

                    // 这段代码 可能导致 不存在的属性 出现在排序配置中 容易出bug ！！
                    $this->_attributeOrders[$attribute] = $descending ? SORT_DESC : SORT_ASC;
                    if (!$this->enableMultiSort) {
                        return $this->_attributeOrders;
                    }
                    **/

                    if (isset($this->attributes[$attribute])) {
                        $this->_attributeOrders[$attribute] = $descending ? SORT_DESC : SORT_ASC;
                        if (!$this->enableMultiSort) {
                            return $this->_attributeOrders;
                        }
                    }
                }
            }

            if (empty($this->_attributeOrders) && is_array($this->defaultOrder)) {
                $this->_attributeOrders = $this->defaultOrder;
            }
        }
        return $this->_attributeOrders;
    }
}