<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2018/4/25
 * Time: 8:49
 */

namespace year\gii\goodmall\utils;


class GoUtils
{

    /**
     * @param string $qualifiedType
     * @return bool|string
     */
    public static function getPackagePath($qualifiedType)
    {
        // 全称限定 full qualified
        return substr($qualifiedType, 0, strrpos($qualifiedType, '.'));
    }

    /**
     * @param  string $qualifiedType
     * @return bool|string
     */
    public static function resolveType($qualifiedType)
    {
        $qualifiedType = str_replace(DIRECTORY_SEPARATOR, '/', $qualifiedType);
        $qualifiedType = trim($qualifiedType);

        $type = substr($qualifiedType, strrpos($qualifiedType, '.') + 1);
        // 形如： localName github.com/some-user/some-project/some-domain.SomeType
        $parts = preg_split("/[\s]+/", $qualifiedType);
        if (count($parts) > 1) {
            $type = $parts[0] . '.' . $type;
        } else {
            // FIXME 这里总有一些特殊包命名  如果真不是按照惯例的 那么就干脆手动指定localName 比如强哥的这个包名
            // 不含包别名：   gopkg.in/go-ozzo/ozzo-dbx.v1 | "gopkg.in/yaml.v2"
            $pkgName = substr($qualifiedType, strrpos($qualifiedType, '/') + 1);
            $pkgName = substr($pkgName, 0, strpos($pkgName, '.')); // 第一个dot : ozzo-dbx.v1.SomeType

            $type = $pkgName . '.' . $type;
        }
        return $type;
    }

}