<?php
/**
 * User: yiqing
 * Date: 2014/11/24
 * Time: 10:27
 */

namespace year\base;

use yii\base\Component;
use yii\base\Exception;

/**
 * FIXME 方法签名模拟成nodeJs中的那个
 * emit方法签名 跟nodeJs中的EventEmitter一致
 *
 * Class EventEmitter
 * @package year\base
 */
trait EventEmitter {

    public function emit($eventName,$event){
        if(!($this instanceof Component)){
            throw new Exception('an event emitter must be an instance of yii\base\Component ! ');
        }
        $this->trigger($eventName,$event);
    }
} 