<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/4
 * Time: 15:51
 */

namespace monkey\object;

use monkey\helpers\CreateWith;

/**
 * Null 类型  由于在php7中Null 是关键字 不可以做类名所以命名为Nil
 *
 * Class Nil
 * @package monkey\object
 */
class Nil  implements Object
{

    use CreateWith ;

    /**
     * @return string
     */
    public function Type(): string
    {
       return ObjectType::NULL_OBJ ;
    }

    /**
     * @return string
     */
    public function Inspect(): string
    {
        return 'null' ;
    }
}