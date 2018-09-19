<?php

namespace my\monkey\controllers;

use yii\console\Controller;


/**
 * Default controller for the `monkey` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        // $this->stdout('hi  here!');

        // $user = php_uname('r');
        //  echo $user ;
        // var_dump($_ENV) ;
        ///echo $current_user = trim(shell_exec('whoami')) ,PHP_EOL;
        // echo $username , PHP_EOL; // e.g. root or www-data
        // var_dump(getenv()) ;
        //  global $_ENV; var_dump($_ENV);
        // echo get_current_user();
        // $processUser = \posix_getpwuid(\posix_geteuid());
        /// print $processUser['name'];
        ///
        $username = getenv('USERNAME') ?: getenv('USER');
        $this->stdout(sprintf("Hello %s! This is the Monkey programming language!\n", $username));
        $this->stdout(sprintf("Feel free to type in commands\n"));


        \monkey\repl\Start(\STDIN,\STDOUT);
        return static::EXIT_CODE_NORMAL;
    }
}
