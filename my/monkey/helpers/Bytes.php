<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/9/28
 * Time: 14:14
 */

namespace monkey\helpers;


/**
 * @see http://blog.csdn.net/chunxiaqiudong5/article/details/48006841
 * @see http://www.hishenyi.com/archives/178
 *
 * byte数组与字符串转化类
 */
class Bytes
{

    /**
     * @see http://www.hishenyi.com/archives/178
     *
     * @param $num
     * @return float|int
     */
    public static function toByte($num) //$num 可以传数字
    {
        $num = decbin($num);  //decbin 是php自带的函数，可以把十进制数字转换为二进制

        $num = substr($num, -8); //取后8位
        $sign = substr($num, 0, 1); //截取 第一位 也就是高位，用来判断到底是负的还是正的
        if ($sign == 1)  //高位是1 代表是负数 ,则要减去256
        {
            return bindec($num) - 256; //bindec 也是php自带的函数，可以把二进制数转为十进制
        } else {
            return bindec($num);
        }
    }

    /**
     * 转换一个String字符串为byte数组
     * @param $str 需要转换的字符串
     * @param $bytes 目标byte数组
     * @author Zikie
     */
    public static function getBytes($string)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($string); $i++) {
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }


    /**
     * 将字节数组转化为String类型的数据
     *
     * @param $bytes 字节数组
     * @param $str 目标字符串
     * @return 一个String类型的数据
     */
    public static function toStr($bytes)
    {
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }

        return $str;
    }


    /**
     * 转换一个int为byte数组
     *
     * @param $byt 目标byte数组
     * @param $val 需要转换的字符串
     *
     */
    public static function integerToBytes($val)
    {
        $byt = array();
        $byt[0] = ($val & 0xff);
        $byt[1] = ($val >> 8 & 0xff);
        $byt[2] = ($val >> 16 & 0xff);
        $byt[3] = ($val >> 24 & 0xff);
        return $byt;
    }


    /**
     * 从字节数组中指定的位置读取一个Integer类型的数据
     *
     * @param $bytes 字节数组
     * @param $position 指定的开始位置
     * @return 一个Integer类型的数据
     */
    public static function bytesToInteger($bytes, $position)
    {
        $val = 0;
        $val = $bytes[$position + 3] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 2] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position + 1] & 0xff;
        $val <<= 8;
        $val |= $bytes[$position] & 0xff;
        return $val;
    }


    /**
     * 转换一个short字符串为byte数组
     *
     * @param $byt 目标byte数组
     * @param $val 需要转换的字符串
     *
     */
    public static function shortToBytes($val)
    {
        $byt = array();
        $byt[0] = ($val & 0xff);
        $byt[1] = ($val >> 8 & 0xff);
        return $byt;
    }


    /**
     * 从字节数组中指定的位置读取一个Short类型的数据。
     *
     * @param $bytes 字节数组
     * @param $position 指定的开始位置
     * @return 一个Short类型的数据
     */
    public static function bytesToShort($bytes, $position)
    {
        $val = 0;
        $val = $bytes[$position + 1] & 0xFF;
        $val = $val << 8;
        $val |= $bytes[$position] & 0xFF;
        return $val;
    }

}