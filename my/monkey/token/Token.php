<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 8:39
 */
namespace monkey\token;

use monkey\helpers\CreateWith;

/**
 * Class Token
 * @package monkey\token
 */
class Token
{
    use CreateWith ;

    /**
     * @var string
     */
    public $Type ;
    /**
     * @var string
     */
    public $Literal  ;
}