<?php

namespace my\php\v8;

class Strings
{
    public static function run()
    {

    }

    public static function endWith()
    {
        $url = 'http://www.baidu.com';
        $end = 'baidu.com';

        $msg = '';
        if (!str_ends_with($url, $end)) {

            $msg .= "URL does not end with $end\n";
        }else{
            $msg .= "URL ends with {$end}" ;
        }

        echo $msg;
    }
    public static function contains()
    {

        $str = 'http://yiispace.com' ;
        $target = 'yiispace' ;

        if (str_contains($str, $target)){

            // printf("%25s : %12s : %4s\n", $city, $local1,
            // $iso);
            echo " {$str} contains {$target} " ;
        }else{
            echo " {$str} does not contains {$target} " ;

        }
    }


}
