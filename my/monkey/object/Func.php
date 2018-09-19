<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/10/6
 * Time: 6:49
 */

namespace monkey\object;

use monkey\ast\BlockStatement;
use monkey\ast\Identifier;
use monkey\helpers\CreateWith;

/**
 * Function 在php中是关键词 所以改用Func
 *
 * Class Func
 * @package monkey\object
 */
class Func implements Object
{

    use CreateWith;
    /**
     * @var Identifier[]
     */
    public $Parameters;

    /**
     * @var BlockStatement
     */
    public $Body;

    /**
     * @var Environment
     */
    public $Env;

    /**
     * @return string
     */
    public function Type(): string
    {
        return ObjectType::FUNCTION_OBJ;
    }

    /**
     * @return string
     */
    public function Inspect(): string
    {
        $out = '';
        $params = [];
        foreach ($this->Parameters as $_ => $p) {
            $params[] = $p->String();
        }
        $out .= 'fn';
        $out .= '(';
        $out .= join(', ', $params);
        $out .= ") {\n";
        $out .= $this->Body->String();
        $out .= "\n}";

        return $out;
    }
}