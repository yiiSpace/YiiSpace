<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/1/30
 * Time: 13:21
 */

namespace year\web;


trait AjaxPartialAction {

    public function actionAjaxPartial($view)
    {
       return $this->renderAjax($view);
    }
}