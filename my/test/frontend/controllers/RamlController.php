<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/7/23
 * Time: 17:48
 */

namespace my\test\frontend\controllers;


use yii\web\Controller;

class RamlController extends  Controller
{


    /**
     * @see http://json-schema.org/example2.html
     * @see http://jsonapi.org/schema
     * @see https://github.com/justinrainbow/json-schema
     *
     * @return string
     */
    public function actionIndex()
    {
        // die(\Yii::getAlias('@vendor')) ;
        $filename = \Yii::getAlias('@vendor/alecsammon/php-raml-parser/test/fixture') . '/simple.raml' ;
        $filename = \Yii::getAlias('@vendor/alecsammon/php-raml-parser/test/fixture') . '/rootSchemas.raml' ;

        $modulePath = $this->module->getBasePath() ;
        $filename =  dirname($modulePath) . '/runtime/simple.raml' ;

        $parser = new \Raml\Parser();
        $apiDef = $parser->parse($filename, true);

        $title = $apiDef->getTitle();

        return $this->renderContent($title) ;
    }

}