<?php
namespace my\php\v8;

class Loader
{
    public const DEFAULT_SRC = __DIR__ . '/../..';
    public $src_dir = '';
    public function __construct($src_dir = null)
    {
        $this->src_dir = $src_dir ?? realpath(self::DEFAULT_SRC);
        spl_autoload_register([$this, 'autoload']);
    }

    public function autoload($class)
    {
        $fn = str_replace('\\', '/', $class);
        $fn = $this->src_dir . '/' . $fn . '.php';
        $fn = str_replace('//', '/', $fn);
        require_once $fn;
    }
}

function php7_spl_spl_autoload_register()
{
    try {
        spl_autoload_register('does_not_exist', true);
        // $data = ['A' => [1,2,3],'B' => [4,5,6],'C' => [7,8,9]];
        // $response = new \Application\Strategy\JsonResponse($data);
        // echo $response->render();
    } catch (\Exception $e) {
        // php8: the catch block was bypassed as it was designed to catch an Exception, not an Error. 
        echo "A program error has occurred\n";

    } 
    // 这个更通用的捕获
    catch(\Throwable $e){
        echo "A program error has occurred\n";
    }
}
