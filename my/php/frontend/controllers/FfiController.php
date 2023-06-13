<?php
namespace my\php\frontend\controllers;

use my\php\v8\FFIDemo;
use yii\web\Controller;

/**
 * Undocumented class
 * 
 * 注意开启扩展： ffi.enable = true
 */
class FfiController extends Controller
{
    public function actionIndex()
    {
        ob_start();
            
       phpinfo();
       
       $content = ob_get_clean();

        return $this->renderContent($content);
    }
    public function actionCreational()
    {
        ob_start();
            
         FFIDemo::Creating() ;
        
        $content = ob_get_clean();

        return $this->renderContent($content);
    }
}
