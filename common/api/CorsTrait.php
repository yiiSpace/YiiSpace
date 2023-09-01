<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2017/6/12
 * Time: 6:34
 */

 namespace common\api;


use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\web\Response;


trait CorsTrait 
{
    public $enableCsrfValidation = false;
/**
 * List of allowed domains.
 * Note: Restriction works only for AJAX (using CORS, is not secure).
 *
 * @return array List of domains, that can access to this API
 *
 * 通过Access-Control-Allow-Origin响应头，就告诉了浏览器。
 * 如果请求我的资源的页面是我这个响应头里记录了的"源"，则不要拦截此响应，
 * 允许数据通行。
 */
    public static function allowedDomains()
    {
        // 请求http头必须包含Origin。它将由浏览器自动添加在跨域 AJAX 。
        // 这个http-header也可以通过你的JS库添加。如果没有这个http-header，corsFilter将无法工作。
        return [
            // '*',                        // star allows all domains
            // 'http://test1.example.com',
            // 'http://test2.example.com',
            'https://xxx.yiispace.com:7086',
            'http://127.0.0.1:7086',
            'http://localhost:7086',
            // 域名、协议、端口 三者都指定了
            'http://localhost:5173',
        ];
    }

    public function behaviors()
    {
        // die(__METHOD__) ;
        $parentBehaviors = parent::behaviors();
        // remove authentication filter
        $auth = $parentBehaviors['authenticator'];
        unset($parentBehaviors['authenticator']);

        $behaviors = [
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                    //   'text/html' => Response::FORMAT_HTML, // 这顺序竟然也有影响😂
                ],
            ],
            // 机灵鬼可以用nginx做代理 😄 相当于中间人
            // 要解决跨域必须由后端来一起协同解决，且主要解决工作在后端。
            /*
            响应的 http header 应该包含Access-Control-* header。
            这个HTTP头将由corsFilter添加。
            1.如果你在响应中没有看到这些http头，可能意味着\yii\filters\Cors不工作或与其他过滤器冲突。
            1.检查控制器中的其他行为/过滤器。尝试添加corsFilter作为第一个行为**。可能是其他一些行为阻止了corsFilter的执行。
            1.尝试禁用此控制器的CSRF验证（可能会阻止外部访问）：
             */
            'corsFilter' => [
                // ⚠️ 不同的js http客户端可能有不同的表现 ；fetch可用 axios不一定成功
                // 有个 🐛困扰好久的就是  withCredentials: false, // 😂 这个鬼bug
                // 设置为true 就各种问题了
                // xhr｜ajax 也有个 crossDomain:true, 设置哦

                'class' => Cors::class,
                'cors' => [
                    // 这对配置也👌
                    //  Origin 和 'Access-Control-Allow-Credentials' 是有关联的 前者表示允许那些域访问 后者表示是否允许携带cookie信息
                    'Origin' => static::allowedDomains(), //  跨域的域名数组
                    'Access-Control-Allow-Credentials' => true, //当有origin数组配置时这里为true或者false影响不大了

                    // 👇这两个配置搭配也可以成功 👌
                    // 'Origin' => ['*'],//跨域的域名数组 * 表示允许任意域来访问
                    // 跨域请求中 不允许在请求头中携带凭证 如cookie
                    // 'Access-Control-Allow-Credentials' => false,

                    // 允许客户端的请求方法 跨域中Options 预请求是必须的  ；也有人这个设置用* 这里都列出来为了学习用
                    // NOTE: 在客户端非简单请求时 会先发送options请求的 有可能404哦😯 所以路由规则可能需要放行：‘OPTIONS <module>/<controller>/action’=>'<module>/<controller>/action'
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],

                    'Access-Control-Request-Headers' => ['*'],

                    // 上面👆的 Method|Headers 配置可以被客户端缓存多久
                    // 'Access-Control-Max-Age' => 86400,

                    // 那些头部可以作为响应暴露给外部
                    // 'Access-Control-Expose-Headers' => ['*'],

                    // 'Access-Control-Allow-Origin' => ['*'], //这个跟Origin配置一个意思！
                ],
            ],
        ];

        $behaviors = array_merge($parentBehaviors, $behaviors);

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;

        // return ArrayHelper::merge([
        //     [
        //         'class' => Cors::class,
        //         'cors' => [
        //             'Origin' => ['*'],
        //             'Access-Control-Request-Method' => ['*'],
        //             'Access-Control-Request-Headers' => ['*'],
        //         ],

        //     ],
        // ], parent::behaviors());
    }

}
