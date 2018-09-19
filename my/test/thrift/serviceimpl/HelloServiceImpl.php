<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/4/13
 * Time: 15:24
 */

use HelloServiceIf;
use HelloLanguage ;

class HelloServiceImpl implements HelloServiceIf
{
    public function say_foreign_hello($language) {
        switch($language) {
            case HelloLanguage::ENGLISH:
                return "Hello World!";
                break;
            case HelloLanguage::FRENCH:
                return "Bonjour tout le monde!";
                break;
            case HelloLanguage::SPANISH:
                return "Hola Mundo!";
                break;
            default:
                return "You didn't specify a valid language!";
                break;
        }
    }
    public function say_hello_repeat($times) {
        $hellos = array();
        for($i=0;$i<$times;$i++) {
            $hellos[] = "$i Hello World!";
        }
        return $hellos;
    }

    public function say_hello() {
        return "Hello World!!!!!!!!";
    }

}