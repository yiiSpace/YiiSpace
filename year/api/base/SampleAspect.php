<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/12/4
 * Time: 9:54
 */

namespace year\api\base;

/**
 * 样例切面
 * AOP 中 切面由 切入点和Advice组成
 *
 * 在服务类中 用注解关联对应的切面类即可
 *
 * Class SampleAspect
 * @package year\api\base
 */
class SampleAspect
{
    /**
     * @var array|string
     */
    protected $joinPoints  ;

    /**
     * @param $joinPoints
     */
    public function setJoinPoints($joinPoints)
    {
        $this->joinPoints = $joinPoints ;
    }

    /**
     * @param $joinPoint
     */
    public function addJoinPoint($joinPoint)
    {
        $this->joinPoints[] = $joinPoint ;
    }

    /**
     * @param $method
     * @return bool
     */
    public function isJoinPoint($method)
    {
        foreach ($this->joinPoints as $idx=>$joinPoint){
            if(preg_match($joinPoint,$method)){
                return true ;
            }
        }
        return false ;
    }
    /**
     * ============================================================================== +|
     *          ## 业务方法  advice
     */
    /**
     *
     */
    public function checkUserLogin()
    {

    }
    public function doLog()
    {

    }
}