<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2015/5/8
 * Time: 11:12
 */

namespace year\api\helpers;


use GuzzleHttp\Client;
use yii\base\InvalidCallException;

trait GuzzleClientTrait
{

    /**
     * api服务端端口号
     *
     * @var string
     */
    public static $apiHostPort = '8008';

    /**
     * @param array $config
     * @return Client
     */
    public static function newGuzzleClient(array $config = [])
    {
        $client = new Client($config);
        return $client;
    }

    /**
     *
     * @param null $route  endPoint for some specific api
     * @return Client
     */
    public function getGuzzleClient($route = null)
    {
        /*
        if(empty($route)){
            throw new InvalidCallException('must specify the route param for using method ：'.__METHOD__);
        }
        */

         $baseUrl = sprintf( 'http://localhost:%s/api.php',self::$apiHostPort);
       // $baseUrl = 'http://localhost:8088/api.php'; // tcpmon 监听的端口 8088 代理到原始真实的端口80或者8008

        $defaults = [
            // 'allow_redirects' => false,
            // 'query' => ['foo' => 'bar']
            'headers' => ['Accept' => 'application/json'],

        ];
        $route = empty($route) ? '' : '/'.ltrim($route,'/');

        $client = static::newGuzzleClient([
            'base_url' => $baseUrl.$route ,
            'defaults' => $defaults,
        ]);
        //  $client->setDefaultOption()
        return $client;
    }

    /**
     * @return string
     */
    public static function getRpcBaseUrl()
    {
        // $baseUrl = 'http://localhost:8088/api/v1';
        $baseUrl = sprintf('http://localhost:%s/api/v1',self::$apiHostPort);
        return $baseUrl ;
    }

    public function getRpcGuzzleClient()
    {
        /*
        if(empty($route)){
            throw new InvalidCallException('must specify the route param for using method ：'.__METHOD__);
        }
        */

        $baseUrl = sprintf('http://localhost:%s/api/v1',self::$apiHostPort);
        // $baseUrl = 'http://localhost:8088/api.php'; // tcpmon 监听的端口 8088 代理到原始真实的端口80或者8008

        $defaults = [
            // 'allow_redirects' => false,
            // 'query' => ['foo' => 'bar']
            'headers' => ['Accept' => 'application/json'],

        ];
        $route = empty($route) ? '' : '/'.ltrim($route,'/');

        $client = static::newGuzzleClient([
            'base_url' => $baseUrl.$route ,
            'defaults' => $defaults,
        ]);
        //  $client->setDefaultOption()
        return $client;
    }
}