function genUniqueId($num) {
    $num = str_pad(decbin($num + 2147483648), 32, 0, STR_PAD_LEFT);
    $num = substr($num, -16) . substr($num, 0, -16);
    return bindec($num);
}

【活跃】webees.net 2015/6/18 22:03:42
昨天的生成用户id的函数我分享下@海沙滩 
    /**
     * [getUId 更具id号生成唯一用户id]
     * @param  [type] $num [id]
     * @return [type]      [uid]
     */
    private function getUID($num) {
        $num = str_pad(decbin($num + 2147483648), 32, 0, STR_PAD_LEFT);
        $num = substr($num, -16) . substr($num, 0, -16);
        return bindec($num);
    }
