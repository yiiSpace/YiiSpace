<?php
/**
 * User: yiqing
 * Date: 14-8-27
 * Time: 上午11:13
 */

namespace year\api\base;

/**
 * 请求返回的响应码
 * 参考：
 *    - http://www.ruanyifeng.com/blog/2014/05/restful_api.html
 *    - http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
 *    - http://www.yiiframework.com/doc-2.0/guide-rest-error-handling.html
 *    - http://www.yiiframework.com/wiki/748/building-a-rest-api-in-yii2-0
 *    - http://www.gen-x-design.com/archives/create-a-rest-api-with-php/
 *    - https://github.com/lenbo-ma/jfinal-api-scaffold
 *
 * TODO 根据某些相应码 设计相关的异常
 *
 * Class Code
 * @package year\api\base
 */
class Code {

    const STATUS_200 = 200 ;

    const STATUS_201 = 201 ;

    const STATUS_202 = 202 ;

    const STATUS_204 = 204 ;


    const STATUS_304 = 304 ;


    const STATUS_400 = 400 ;

    const STATUS_401 = 401 ;

    const STATUS_403 = 403 ;

    const STATUS_404 = 404 ;

    const STATUS_405 = 405 ;

    const STATUS_406 = 406 ;

    const STATUS_410 = 410 ;

    const STATUS_415 = 415 ;

    const STATUS_422 = 422 ;

    const STATUS_429 = 429 ;

    const STATUS_500 = 410 ;


    /**
     * @var array
     */
    public static $statusInfoMapping = [
          self::STATUS_200 => [
              'short'=>'OK',
              'verb'=>'GET',
              'info'=>' Everything worked as expected.',
              'cn_info'=>'服务器成功返回用户请求的数据，该操作是幂等的（Idempotent）。',
          ],
        self::STATUS_201 => [
            'short'=>'CREATED ',
            'verb'=>'POST|PUT|PATCH',
            'info'=>'  A resource was successfully created in response to a POST request. The Location header contains the URL pointing to the newly created resource..',
            'cn_info'=>'用户新建或修改数据成功。',
        ],
        self::STATUS_202 => [
            'short'=>'Accepted  ',
            'verb'=>'*',
            'info'=>' 表示一个请求已经进入后台排队（异步任务）',
            'cn_info'=>'',
        ],
        self::STATUS_204 => [
            'short'=>'NO CONTENT ',
            'verb'=>'DELETE',
            'info'=>'  The request was handled successfully and the response contains no body content (like a DELETE request).',
            'cn_info'=>'',
        ],

        self::STATUS_304 => [
            'short'=>'NOT MODIFIED ',
            'verb'=>'*',
            'info'=>'  The resource was not modified. You can use the cached version.',
            'cn_info'=>'',
        ],

        self::STATUS_400 => [
            'short'=>'INVALID REQUEST ',
            'verb'=>'POST/PUT/PATCH',
            'info'=>'   This could be caused by various actions by the user, such as providing invalid JSON data in the request body, providing invalid action parameters, etc.',
            'cn_info'=>'',
        ],

        self::STATUS_401 => [
            'short'=>'Unauthorized  ',
            'verb'=>'*',
            'info'=>'  Authentication failed.',
            'cn_info'=>'',
        ],
        self::STATUS_403 => [
            'short'=>'Forbidden   ',
            'verb'=>'*',
            'info'=>'  The authenticated user is not allowed to access the specified API endpoint.',
            'cn_info'=>'',
        ],
        self::STATUS_404 => [
            'short'=>'NOT FOUND  ',
            'verb'=>'*',
            'info'=>'  The requested resource does not exist.',
            'cn_info'=>'',
        ],
        self::STATUS_405 => [
            'short'=>'Method not allowed  ',
            'verb'=>'*',
            'info'=>'  Method not allowed. Please check the Allow header for the allowed HTTP methods.',
            'cn_info'=>'',
        ],

        self::STATUS_406 => [
            'short'=>'Not Acceptable  ',
            'verb'=>'GET',
            'info'=>' 用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。',
            'cn_info'=>'用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。',
        ],

        self::STATUS_410 => [
            'short'=>'Gone   ',
            'verb'=>'GET',
            'info'=>' 用户请求的资源被永久删除，且不会再得到的。',
            'cn_info'=>'用户请求的资源被永久删除，且不会再得到的。',
        ],

        self::STATUS_422 => [
            'short'=>'UnProcessable entity   ',
            'verb'=>'POST/PUT/PATCH',
            'info'=>' 当创建一个对象时，发生一个验证错误。',
            'cn_info'=>'当创建一个对象时，发生一个验证错误。',
        ],

        self::STATUS_429 => [
            'short'=>'UToo many requests.   ',
            'verb'=>'*',
            'info'=>'  Too many requests. The request was rejected due to rate limiting.',
            'cn_info'=>'请求次数过多，请求因调用速率限制被拒绝。',
        ],
        self::STATUS_500 => [
            'short'=>'INTERNAL SERVER ERROR  ',
            'verb'=>'*',
            'info'=>'  Internal server error. This could be caused by internal program errors.',
            'cn_info'=>'服务器发生错误，用户将无法判断发出的请求是否成功。',
        ],
    ];

    /**
     * @param int $statusCode
     * @return array
     */
    public static function getStatusInfo($statusCode)
    {
        if(isset(static::$statusInfoMapping[$statusCode])){
            return static::$statusInfoMapping[$statusCode] ;
        }else{
            return [
                'short'=>'UNKNOWN',
                'verb'=>'*',
                'info'=>' undefined status .',
                'cn_info'=>'',
            ];
        }
    }
}