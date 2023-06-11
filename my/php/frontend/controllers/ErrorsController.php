<?php

namespace my\php\frontend\controllers;

use common\widgets\CodeViewer;
use my\php\v8\ErrorHandlings;
use yii\web\Controller;

class ErrorsController extends Controller
{

    public function actionIndex()
    {
        ob_start();
            
        try{

            ErrorHandlings::UndefinedVariable();
        }catch(\Exception $e){
            dump($e) ;
        }
        
        $content = ob_get_clean();

        return $this->renderContent($content);
    }

    public function actionNonObject()
    {
        ob_start();
            ErrorHandlings::nullObject();
        $content = ob_get_clean();

        return $this->renderContent($content);
    }

   
    
    
 

}
