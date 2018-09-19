<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/3/21
 * Time: 23:06
 */

namespace year\helpers;


class Web {

    /**
     * @param $path
     * @param string $toThat
     * @return bool|string
     */
    public static function getRelativeAlias($path,$toThat = '@app')
    {
        $path = realpath($path);
        $toThatPath = \Yii::getAlias($toThat);
        $toThatPath = realpath($toThatPath);
        /*
        print_r([
           $path,
            $toThatPath,
        ]);
        */
        if(strncmp($path, $toThatPath,strlen($toThatPath)) === 0){
            $relativeAlias = $toThat.str_replace('\\', '/', substr($path,strlen($toThatPath)))  ;
            return $relativeAlias ;
        }else{
            return false ;
        }
    }
    public static function getRelativePath()
    {

    }
}