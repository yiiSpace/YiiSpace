<?php

namespace my\php\frontend\controllers;

use common\widgets\CodeViewer;
use my\php\common\features\GeneratorDemo;
use my\php\v8\Strings;
use yii\web\Controller;

class StrController extends Controller
{

    public function actionIndex()
    {
        ob_start();
        GeneratorDemo::run();
        $content = ob_get_clean();

        return $this->renderContent($content);
    }

    public function actionStartWith()
    {
        $msg = '';

        $url = "http://baidu.com";
        $start = 'https';
        if (substr($url, 0, strlen($start)) !== $start) {
            $msg .= "URL does not start with $start\n";
        }

        // not all code is shown

        $result = [
            'content',
        ];

        $widget = CodeViewer::widget(
            [
                // 'code'=> CodeViewer::GetMethodCode($this,'actionStartWith'),
                'code' => CodeViewer::GetMethodCode(__METHOD__),
            ]
        );
        return $this->renderContent($widget);
    }

    public function actionEndWith()
    {
        ob_start();
        // GeneratorDemo::run();
        $result = Strings::endWith();

        $content = ob_get_clean();
        $result = implode(', ', [
            $content,
            CodeViewer::widget([
                'code' => CodeViewer::GetMethodCode(Strings::class, 'endWith'),
            ]),
        ]);

        return $this->renderContent($result);

    }

    public function actionContains()
    {
        ob_start();
        // GeneratorDemo::run();
        $result = Strings::contains();

        $content = ob_get_clean();
        $result = implode(', ', [
            $content,
            CodeViewer::widget([
                'code' => CodeViewer::GetMethodCode(Strings::class, 'contains'),
            ]),
        ]);

        return $this->renderContent($result);

    }

}
