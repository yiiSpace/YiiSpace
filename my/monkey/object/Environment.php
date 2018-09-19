<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/6
 * Time: 5:47
 */

namespace monkey\object;


use monkey\helpers\CreateWith;

class Environment
{
    use CreateWith;

    /**
     * @return static
     */
    public static function NewEnvironment() // : Evironment
    {
        // @see http://php.net/manual/en/class.splobjectstorage.php
        // php中数组可以当哈希用  不过如果想提供对象做键 需要使用splObjectStorage！
        $s = [];
        return static::CreateWith([
            'store' => $s,
        ]);
    }

    /**
     * @param Environment $out
     * @return Environment
     */
    public static function NewEnclosedEnvironment($outer) // :Environment
    {
        $env = static::NewEnvironment() ;
        $env->outer = $outer ;
        return $env ;

    }

    /**
     *
     * @var array|\SplObjectStorage
     *          string=>Object
     */
    protected $store = [] ;

    /**
     * 外侧环境
     * 在闭包计算时很有用
     *
     * @var Environment
     */
    protected $outer ;

    /**
     * @param string $name
     * @return bool
     */
    public function Exists($name)
    {
        return isset($this->store[$name]) || ( !empty($this->outer) && $this->outer->Exists($name) );
    }
    /**
     * @param string $name
     * @return Object|null
     *
     */
    public function Get($name) // :Object
    {
        if(isset($this->store[$name])){
            return $this->store[$name] ;
        } elseif(!empty($this->outer)){
            return $this->outer->Get($name) ;
        }
        // TODO 此处是否应该是 Nil对象 ?
        return  null ;
    }

    /**
     * @param string $name
     * @param Object $val
     * @return Object
     */
    public function Set($name='',/*Object*/ $val) // :Object
    {
        $this->store[$name] = $val ;
        return $val ;
    }
}