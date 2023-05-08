<?php

namespace my\php\common\features;

/**
 * @see https://stackoverflow.com/questions/12825187/get-all-public-methods-declared-in-the-class-not-inherited
 */
class ReflectionDemo
{
    /**
     * Return class methods by scope
     *
     * @param string $class
     * @param bool $inherit
     * @static bool|null $static returns static methods | object methods | both
     * @param array $scope ['public', 'protected', 'private']
     * @return array
     *
     * 最后一个参数感觉不灵活 不如 \ReflectionMethod::IS_PUBLIC|\ReflectionMethod::IS_PROTECTED  这种语意好
     */
    public static function getClassMethods($class, $inherit = false, $static = null, $scope = ['public', 'protected', 'private'])
    {
        $return = [
            'public' => [],
            'protected' => [],
            'private' => []
        ];
        $reflection = new \ReflectionClass($class);
        foreach ($scope as $key) {
            $pass = false;
            switch ($key) {
                case 'public': $pass = \ReflectionMethod::IS_PUBLIC;
                    break;
                case 'protected': $pass = \ReflectionMethod::IS_PROTECTED;
                    break;
                case 'private': $pass = \ReflectionMethod::IS_PRIVATE;
                    break;
            }
            if ($pass) {
                $methods = $reflection->getMethods($pass);
                foreach ($methods as $method) {
                    $isStatic = $method->isStatic();
                    if (!is_null($static) && $static && !$isStatic) {
                        continue;
                    } elseif (!is_null($static) && !$static && $isStatic) {
                        continue;
                    }
                    if (!$inherit && $method->class === $reflection->getName()) {
                        $return[$key][] = $method->name;
                    } elseif ($inherit) {
                        $return[$key][] = $method->name;
                    }
                }
            }
        }
        return $return;
    }

}