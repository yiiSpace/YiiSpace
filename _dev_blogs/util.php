<?php

class Util
{
    /**
     * 对整数id进行可逆混淆
     */
    public static function encodeId($id)
    {
        $sid = ($id & 0xff000000);
        $sid += ($id & 0x0000ff00) << 8;
        $sid += ($id & 0x00ff0000) >> 8;
        $sid += ($id & 0x0000000f) << 4;
        $sid += ($id & 0x000000f0) >> 4;
        $sid ^= 11184810;
        return $sid;
    }

    /**
     * 对通过encodeId混淆的id进行还原
     */
    public static function decodeId($sid)
    {
        if (!is_numeric($sid)) {
            return false;
        }
        $sid ^= 11184810;
        $id = ($sid & 0xff000000);
        $id += ($sid & 0x00ff0000) >> 8;
        $id += ($sid & 0x0000ff00) << 8;
        $id += ($sid & 0x000000f0) >> 4;
        $id += ($sid & 0x0000000f) << 4;
        return $id;
    }
}