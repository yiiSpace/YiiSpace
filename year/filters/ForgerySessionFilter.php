<?php
/**
 * User: yiqing
 * Date: 2014/10/11
 * Time: 13:46
 */

namespace year\filters;


use yii\base\ActionFilter;

/**
 * @see https://github.com/yiiext/forgery-session-filter/blob/master/EForgerySessionFilter.php
 *
 * Class ForgerySessionFilter
 * @package year\filters
 */
class ForgerySessionFilter extends ActionFilter{

    /**
     * @var string the name of the parameter that stores session id.
     * Defaults to PHP_SESSION_ID
     */
    public $paramName='PHP_SESSION_ID';
    /**
     * @var string the method which sent the data. This should be either 'POST', 'GET' or 'AUTO'.
     * Defaults to 'POST'.
     */
    public $method='POST';

    /**
     *
     */
    protected function forgery()
    {
        /*
        switch(strtoupper($this->method))
        {
            case 'GET':$method='getQuery';break;
            case 'AUTO':$method='getParam';break;
            default:$method='getPost';
        }

        if(is_string($sessionId=Yii::app()->getRequest()->$method($this->paramName)))
        {
            $session=Yii::app()->getSession();
            $session->close();
            $session->setSessionId($sessionId);
            $session->open();
        }
        */
        return true;
    }

    public function beforeAction($action)
    {

        $this->forgery() ;
        return parent::beforeAction($action);
    }
} 