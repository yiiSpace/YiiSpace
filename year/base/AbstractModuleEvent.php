<?php
/**
 * User: yiqing
 * Date: 2014/11/24
 * Time: 10:42
 */

namespace year\base;

/**
 * 模块事件 是本模块内可能发生的所有事件
 *
 * 为模块内事件的管理提供了一个中心管理点
 *
 * 模块内事件亦可触发模块间事件，由于事件只是字符串而以 所以要用某种名称约定来避免eventKey的冲突！
 * 可能如：eventEmitter->triggerModuleEvent($eventName,$event);
 *
 * Class AbstractModuleEvent
 * @package year\base
 */
abstract class AbstractModuleEvent implements IModuleEvent{

    /**
     * @return string the module Id
     */
  abstract   public function moduleId();

}