<?php

namespace api\modules\v1\controllers;

use year\api\base\Runner;
use year\api\helpers\ResponseHelper;
use Yii;
use yii\rest\Controller;

/**
 * Default controller for the `content` module
 */
class RpcController extends Controller
{
    /**
     * 访问令牌参数名称
     *
     * @var string
     */
    public $accessTokenParam = 'access_token';

    public function behaviors()
    {
        // die(__METHOD__) 用此法断定beforeAction 先于behavior执行   ;

        $behaviors = parent::behaviors();
        /*
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
               // HttpBasicAuth::className(),
               // HttpBearerAuth::className(),
               [
                 'class'=>  QueryParamAuth::className(),
                   'tokenParam'=>$this->accessTokenParam,
               ],

            ],
        ];
        */
        return $behaviors;
        /*
           return [
               'contentNegotiator' => [
                   'class' => ContentNegotiator::className(),
                   'formats' => [
                       'application/json' => Response::FORMAT_JSON,
                       'application/xml' => Response::FORMAT_XML,
                   ],
               ],

               'verbFilter' => [
                   'class' => VerbFilter::className(),
                   'actions' => $this->verbs(),
               ],
               'authenticator' => [
                   'class' => CompositeAuth::className(),
               ],
               'rateLimiter' => [
                   'class' => RateLimiter::className(),
               ],

           ]; */
    }

    protected function forgerySession($sessionId)
    {
        if (!empty($sessionId) && is_string($sessionId)) {
            /*
            $session=Yii::app()->getSession();
            $session->close();
            $session->setSessionId($sessionId);
            $session->open();
            */
            $session = Yii::$app->getSession();
            $session->close();
            $session->setId($sessionId);
            $session->open();

        }
    }


    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        // post 请求要关闭crsf验证
        $this->enableCsrfValidation = false;

        /**
         * @see http://www.yiiframework.com/forum/index.php/topic/52882-yii2-tips-tricks/
         */
        \Yii::$app->response->format = 'json';

        //========================================================================================== begin \\
        /**
         * 如果传递了access-token 或者store-access-token 那么自动登录用户 这样在服务类中可以用Yii::$app->user->identity 访问当前用户|商户
         */
        // 禁用session功能
        \Yii::$app->user->enableSession = false;

        $request = Yii::$app->request;
        if (Yii::$app->request->get('access-token')) {
            Yii::$app->user->identityClass = User::className();
            Yii::$app->user->loginByAccessToken($request->get('access-token'));

        } elseif (Yii::$app->request->get('store-access-token')) {
            Yii::$app->user->identityClass = Store::className();
            $this->accessTokenParam = 'store-access-token';

            Yii::$app->user->loginByAccessToken($request->get('store-access-token'));
        }
        //========================================================================================== end //
        /*
        $items = ['some', 'array', 'of', 'values'];
        return \yii\helpers\Json::encode($items);
        */
        return parent::beforeAction($action);
    }

    public function actionCall()
    {
        /*
        return [
          'get'=>Yii::$app->request->get(),
          'post'=>Yii::$app->request->post(),
        ];
        */
        /**
         * @var Runner $apiRunner
         */
        $apiRunner = \Yii::$app->get('apiRunner');
        //return __METHOD__ ;
        try {
            $result = $apiRunner->run();

            //==================================================================================================\\
            /**
             * 序列化动作执行结果
             */
            $serializer = ResponseHelper::getSerializer();
            /*
            if($result instanceof DataProviderInterface){
                $serializer->collectionEnvelope = 'items';
                $result =  $serializer->serialize($result) ;
            }
            */
            $serializer->collectionEnvelope = 'items';
            $result = $serializer->serialize($result);

            //==================================================================================================//

            // 得到结果后按照格式进行format 现在只支持基本的json即可
            return (
            array(
                'status' => 1,
                'result' => $result,
            )
            );

        } catch (ApiClientException $ex) {
            // print_r($ex);
            return (
            array(
                'status' => 0,
                'error' => [
                    // 自定义业务码
                    'bizCode' => $ex->bizCode,
                    'code' => $ex->statusCode,
                    'msg' => $ex->getMessage(),
                ]
            )
            );
        } catch (HttpException $ex) {
            // print_r($ex);
            return (
            array(
                'status' => 0,
                'error' => [
                    'code' => $ex->statusCode,
                    'msg' => $ex->getMessage(),
                ]
            )
            );
        } catch (\Exception $ex) {
            // print_r($ex);
            return (
            array(
                'status' => 0,
                'error' => [
                    'code' => $ex->getCode(),
                    'msg' => $ex->getMessage(),
                ]
            )
            );
        }

    }

    public function actionTest()
    {
        $client = new \GuzzleHttp\Client();
        /*
        $response = $client->get('http://guzzlephp.org');
        $res = $client->get('https://api.github.com/user', ['auth' => ['user', 'pass']]);
        echo $res->getStatusCode();
// "200"
        echo $res->getHeader('content-type');
// 'application/json; charset=utf8'(
        echo $res->getBody();
// {"type":"User"...'
        var_export($res->json());
// Outputs the JSON decoded data
        */
        $apiUrl = \yii\helpers\Url::to(array('v1'), true);
        // die($apiUrl);
        $response = $client->get($apiUrl, [
            'query' => [
                'method' => 'user.helloTo',
                'params' => [
                    'name' => 'siya',
                ]
            ]
        ]);
        /*
       //  print_r($response->getBody());
        $body = $response->getBody();

        while (!$body->eof()) {
            echo $body->read(1024);
        }
        */
        print_r($response->json());


    }

    public function actionTestBatch()
    {
        $client = new \GuzzleHttp\Client();

        $apiUrl = \yii\helpers\Url::to(array('v1'), true);
        // die($apiUrl);
        $response = $client->get($apiUrl, [
            'query' => [
                'method' => 'batch',
                'params' => [
                    ['method' => 'recommend.preferenceStoreService', 'key' => 'top'],
                    ['method' => 'recommend.bannerSlides', 'key' => 'bottom']
                ]
            ]
        ]);
        return $response->json();
    }

    public function actionTestUrl()
    {
        $query = [
            'method' => 'batch',
            'params' => [
                ['method' => 'recommend.preferenceStoreService', 'key' => 'top'],
                ['method' => 'recommend.bannerSlides', 'key' => 'bottom']
            ]];
        return http_build_query($query);

    }
}
