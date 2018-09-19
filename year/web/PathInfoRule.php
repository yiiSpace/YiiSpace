<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/12/22
 * Time: 14:26
 */

namespace year\web;


 use yii\web\UrlRuleInterface;
use yii\base\Object;

 /**
  * copy from :
  * @see https://github.com/mike-kramer/Yii1LikeUrlRule/blob/master/Yii1LikeUrlRule.php
  *
  * Class PathInfoRule
  * @package year\web
  */
class PathInfoRule extends Object implements UrlRuleInterface {
    public function createUrl($manager, $route, $params) {
        $url = $route;
        foreach ($params as $name => $value) {
            $url .= "/$name/$value";
        }
        return $url;
    }
    public function parseRequest($manager, $request) {
        $params = [];
        $pathInfo = $request->getPathInfo();

        $segments = explode("/", $pathInfo);
        if (count($segments) < 3)
            return false;
        $controller = array_shift($segments);
        $action = array_shift($segments);

        while (count($segments)) {
            $paramName  = array_shift($segments);
            $paramValue = array_shift($segments);

            $params[$paramName] = $paramValue;
        }

        return ["$controller/$action", $params];
    }
}