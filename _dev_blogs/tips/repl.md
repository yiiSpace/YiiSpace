php中也是近几年才有的REPL功能！前几年难道一直没有实现么！

REPL  是一个缩写 代表（READ EVAL PRINT  LOOP），是比较标准的命令行交互模式。

       读入用户的输入  执行代码  打印结果  只要用户不退出就一直循环这个过程。
            R              E        P                 L

脚本类语言基本都有这样的实现。

## 缘起

最近在看python的一个flask框架（就是瞎看 不要有心理压力哦）。
这个框架其实跟yii也很像 至少使用经历上来说没有太大跨度（web类框架估计就那几种常见
的风格  用什么语言无所谓 底层思想都互抄！）

也是 建模型 -》 用migration 建表 --》然后建UI （他们也有一个表单类wtform类  功能地位等价
yii中的XxxForm 属于Model的子类  专门跟表单交互的 不过他们的视图层没有ActiveForm
这样强大的东西 需要手动敲原始的html 表单构造  wtform主要用来定义字段类型跟完成验证功能）
~~~python

    import wtforms
    from wtforms import validators
    from models import User
         class LoginForm(wtforms.Form):
         email = wtforms.StringField("Email",
         validators=[validators.DataRequired()])
         password = wtforms.PasswordField("Password",
         validators=[validators.DataRequired()])
         remember_me = wtforms.BooleanField("Remember me?",
          default=True)
~~~

跑题了 说的不是这个:)

开发流程也是表驱动 先建立表 然后建立模型 然后在模型上实现业务方法（静态或者实例化
方法） ， 在这一步的时候 需要验证一下业务方法是否实现正确。

此时 python用REPL 可以简单的验证逻辑是否实现正确。很是方便。
但这种功能要在php中 就有点麻烦了 要验证功能 你必须调用它 ，此时 要么你写一个视图
--》控制器 --》 action   这个流程来触发业务层的代码。 要么 从控制台程序中调用。
或者你自己写phpunit 等测试也可以。  但这些都嫌麻烦 不及REPL 直接插入业务逻辑层之上
随意调用业务层的接口。

现代php框架基本都是层模式（MVC是层模式的一种），开发流程无外乎 从底层向上 或者从
UI层往内（这种是用例驱动的 从边界类 到控制类 再到实体类），也有乱来的时而从上往下
时而从下往上。:d:

在层模式中 当你从外层往里侧开发时 为了验证功能 往往使用的是mock假对象 假数据，先
临时满足当前层的功能 所依赖的底层给你“喂“一些假数据（此时php中的faker库 就很有用了）

当你从底层db 往上开发时（yii 就这种风格），如果想验证下层某个功能api是否如预期那样
必须使用单元测试 或者临时写一个 控制器|action 来调用这个业务逻辑 。单元测试比较麻烦
写这些临时控制器，也感觉比较“脏” 会污染系统的纯洁性的 。此时就迫切需要一种随用随
消失的功能。OK 终于迁到正题了 该猪脚登场了“REPL” 

php中的ERPL==> [PsySH](http://psysh.org/#usage) 
使用composer 全局安装一下 你就可以开始使用了！ 
~~~shell

    composer g require psy/psysh:@stable
    ...
    
    - Installing psy/psysh (v0.1.11)
    Downloading: 100%
    
    ...
    
    
    C:\Users\Lenovo\Documents>psysh
    Psy Shell v0.1.11 (PHP 5.6.3 鈥?cli) by Justin Hileman
    >>> echo "hello";
    hello鈴?
    => null
    >>> 1+2
    => 3
    >>>

~~~

吼吼是不是很帅 ！  当然 你可以在你项目目录下启动这个psysh  因为你毕竟是想借助它
来和你项目中的类 或者脚本来交互的：
~~~shell

    D:\Visual-AMP-x64\www\yii2-space\yii_blog>psysh
    Psy Shell v0.1.11 (PHP 5.6.3 鈥?cli) by Justin Hileman                                                                                                                                                             
    >>> require('config/params.php');
    => [
           "adminEmail" => "admin@example.com",
           "uploadsDir" => "@webroot/uploads"
       ]
    >>>

~~~
比如我上面就是在yii的一个项目中启动psysh命令 这样我可以根据当前目录 来做一些操作
。

psysh很是强大 可以前往官网 仔细阅读其能干啥哦。


## 跟YII的集成
yii官方扩展库中实际集成了它 !  就是[yii2-shell](https://github.com/yiisoft/yii2-shell)

看到它的代码很少，实际就是简单的对psysh做了个适配 搭个桥而已。底层还是使用人家
的功能。

但即便这样 这个桥也可以把psysh带人到当前yii的世界，因为是借助yii的console程序进入
的，所以为你带来的可访问东西 就是你在某个console的某个控制器下能访问的东西。

~~~[shell]

    D:\Visual-AMP-x64\www\yii2-space\yii_blog>yii shell
Psy Shell v0.7.2 (PHP 5.6.3 鈥?cli) by Justin Hileman                                                                                                                                                              
>>> my\user\models\User::create('yiqing_95@qq.com','yii2coder',['username'=>'yiqing'])
=> my\user\models\User {#183
     +currentPassword: null,
     +newPassword: null,
     +newPasswordConfirm: null,
     +module: amnah\yii2\user\Module {#188
       +alias: "@user",
       +requireEmail: true,
       +requireUsername: false,
       +useEmail: true,
       +useUsername: true,
       +loginEmail: true,
       +loginUsername: true,
       +loginDuration: 2592000,
       +loginRedirect: null,

~~~

我该方法的代码是（位于User 类中）：
~~~php

   
     /**
     * |+  ------------------------------------------------------------------------------   +
     */

    /**
     * @param string $email
     * @param string $password
     * @param array $attributes
     * @return static
     * @throws \yii\base\Exception
     */
    public static function create($email, $password, $attributes = [])
    {
        $model = new static();
        $model->email = $email;
        // 自动做加密
        $model->password = Yii::$app->security->generatePasswordHash($password);

        $model->setAttributes($attributes);

        return $model;

    }

    /**
     * @param string $email
     * @param string $passord
     * @return array|bool|null|ActiveRecord
     */
    public static function authenticate($email = '', $passord = '')
    {
        $user = static::find()->where([
            'email'=>$email,
        ])->one() ;
        if($user->validatePassword($passord)){
            return $user ;
        }

        return false ;
    }

    /**
     * +  ------------------------------------------------------------------------------   +|
     */
~~~
可以看到 直接可以跟模型层交互 ，通过psysh 直接就插入到 控制器层 和模型层中间了。

当然 yii shell 这个命令 是需要你安装扩展的 就是yii2-shell 用composer 安装后就可以玩耍了！

~~~shell

        
    D:\Visual-AMP-x64\www\yii2-space\yii_blog>yii shell
    Psy Shell v0.7.2 (PHP 5.6.3 鈥?cli) by Justin Hileman
    >>>
    >>> my\user\models\User::authenticate('yiqing_95@qq.com','yiqing')
    => my\user\models\User {#186
         +currentPassword: null,
         +newPassword: null,
         +newPasswordConfirm: null,
         +module: amnah\yii2\user\Module {#192
           +alias: "@user",
           +requireEmail: true,
           +requireUsername: false,
           +useEmail: true,
           +useUsername: true,
           +loginEmail: true,
           +loginUsername: true,
           +loginDuration: 2592000,
           +loginRedirect: null,
           +logoutRedirect: null,
           +emailConfirmation: true,
           +emailChangeConfirmation: true,
           +resetExpireTime: "2 days",
           +loginExpireTime: "15 minutes",
           +emailViewPath: "@user/mail",
           +modelClasses: [
             "User" => "app\models\User",
             "Profile" => "amnah\yii2\user\models\Profile",
             "Role" => "amnah\yii2\user\models\Role",
             "UserToken" => "amnah\yii2\user\models\UserToken",
             "UserAuth" => "amnah\yii2\user\models\UserAuth",
             "ForgotForm" => "amnah\yii2\user\models\forms\ForgotForm",
             "LoginForm" => "amnah\yii2\user\models\forms\LoginForm",
             "ResendForm" => "amnah\yii2\user\models\forms\ResendForm",
             "UserSearch" => "amnah\yii2\user\models\search\UserSearch",
             "LoginEmailForm" => "amnah\yii2\user\models\forms\LoginEmailForm",
           ],
           +params: [],
           +id: "user",
           +module: yii\console\Application {#2
             +defaultRoute: "help",
             +enableCoreCommands: true,
             +controller: yii\shell\ShellController {#23
               +include: [],
               +interactive: true,
               +color: null,
               +id: "shell",
               +module: yii\console\Application {#2},
               +defaultAction: "index",
               +layout: null,
               +action: yii\base\InlineAction {#22
                 +actionMethod: "actionIndex",
                 +id: "index",
                 +controller: yii\shell\ShellController {#23},
               },
             },
             +controllerNamespace: "app\commands",
             +name: "My Application",
             +version: "1.0",
             +charset: "UTF-8",
             +language: "en-US",
             +sourceLanguage: "en-US",
             +layout: "main",
             +requestedRoute: "shell",
             +requestedAction: yii\base\InlineAction {#22},
             +requestedParams: [],
             +extensions: [
               "yiisoft/yii2-swiftmailer" => [
                 "name" => "yiisoft/yii2-swiftmailer",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/swiftmailer" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-swiftmailer",
                 ],
               ],
               "yiisoft/yii2-codeception" => [
                 "name" => "yiisoft/yii2-codeception",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/codeception" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-codeception",
                 ],
               ],
               "yiisoft/yii2-debug" => [
                 "name" => "yiisoft/yii2-debug",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/debug" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-debug",
                 ],
               ],
               "yiisoft/yii2-gii" => [
                 "name" => "yiisoft/yii2-gii",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/gii" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-gii",
                 ],
               ],
               "yiisoft/yii2-faker" => [
                 "name" => "yiisoft/yii2-faker",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/faker" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-faker",
                 ],
               ],
               "yiisoft/yii2-bootstrap" => [
                 "name" => "yiisoft/yii2-bootstrap",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/bootstrap" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-bootstrap",
                 ],
               ],
               "cebe/yii2-gravatar" => [
                 "name" => "cebe/yii2-gravatar",
                 "version" => "1.1.0.0",
                 "alias" => [
                   "@cebe/gravatar" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/cebe/yii2-gravatar/cebe/gravatar",
                 ],
               ],
               "dmstr/yii2-adminlte-asset" => [
                 "name" => "dmstr/yii2-adminlte-asset",
                 "version" => "2.3.0.0",
                 "alias" => [
                   "@dmstr" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/dmstr/yii2-adminlte-asset",
                 ],
               ],
               "yiisoft/yii2-imagine" => [
                 "name" => "yiisoft/yii2-imagine",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/imagine" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-imagine",
                 ],
               ],
               "yiisoft/yii2-authclient" => [
                 "name" => "yiisoft/yii2-authclient",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/authclient" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-authclient",
                 ],
               ],
               "amnah/yii2-user" => [
                 "name" => "amnah/yii2-user",
                 "version" => "5.0.2.0",
                 "alias" => [
                   "@amnah/yii2/user" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/amnah/yii2-user",
                 ],
               ],
               "rmrevin/yii2-fontawesome" => [
                 "name" => "rmrevin/yii2-fontawesome",
                 "version" => "2.15.1.0",
                 "alias" => [
                   "@rmrevin/yii/fontawesome" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/rmrevin/yii2-fontawesome",
                 ],
               ],
               "yiisoft/yii2-shell" => [
                 "name" => "yiisoft/yii2-shell",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@yii/shell" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/yiisoft/yii2-shell",
                 ],
                 "bootstrap" => "yii\shell\Bootstrap",
               ],
               "bupy7/yii2-widget-cropbox" => [
                 "name" => "bupy7/yii2-widget-cropbox",
                 "version" => "9999999-dev",
                 "alias" => [
                   "@bupy7/cropbox" => "D:\Visual-AMP-x64\www\yii2-space\yii_blog\vendor/bupy7/yii2-widget-cropbox",
                 ],
               ],
             ],
             +bootstrap: [
               "log",
               "gii",
             ],
             +state: 3,
             +loadedModules: [
               "yii\console\Application" => yii\console\Application {#2},
               "yii\gii\Module" => yii\gii\Module {#18
                 +controllerNamespace: "yii\gii\controllers",
                 +allowedIPs: [
                   "127.0.0.1",
                   "::1",
                 ],
                 +generators: [],
                 +newFileMode: 438,
                 +newDirMode: 511,
                 +params: [],
                 +id: "gii",
                 +module: yii\console\Application {#2},
                 +layout: null,
                 +controllerMap: [],
                 +defaultRoute: "default",
               },
               "amnah\yii2\user\Module" => amnah\yii2\user\Module {#192},
             ],
             +params: [
               "adminEmail" => "admin@example.com",
               "uploadsDir" => "@webroot/uploads",
             ],
             +id: "basic-console",
             +module: null,
             +controllerMap: [
               "shell" => "yii\shell\ShellController",
               "gii" => [
                 "class" => "yii\gii\console\GenerateController",
                 "generators" => [
                   "model" => [
                     "class" => "yii\gii\generators\model\Generator",
                   ],
                   "crud" => [
                     "class" => "yii\gii\generators\crud\Generator",
                   ],
                   "controller" => [
                     "class" => "yii\gii\generators\controller\Generator",
                   ],
                   "form" => [
                     "class" => "yii\gii\generators\form\Generator",
                   ],
                   "module" => [
                     "class" => "yii\gii\generators\module\Generator",
                   ],
                   "extension" => [
                     "class" => "yii\gii\generators\extension\Generator",
                   ],
                 ],
                 "module" => yii\gii\Module {#18},
               ],
               "asset" => "yii\console\controllers\AssetController",
               "cache" => "yii\console\controllers\CacheController",
               "fixture" => "yii\console\controllers\FixtureController",
               "help" => "yii\console\controllers\HelpController",
               "message" => "yii\console\controllers\MessageController",
               "migrate" => "yii\console\controllers\MigrateController",
               "serve" => "yii\console\controllers\ServeController",
             ],
           },
           +layout: null,
           +controllerMap: [],
           +controllerNamespace: "amnah\yii2\user\controllers",
           +defaultRoute: "default",
         },
         鈿? Symfony\Component\VarDumper\Exception\ThrowingCasterException {#219
           #message: "Unexpected yii\base\ErrorException thrown from a caster: call_user_func() expects parameter 1 to be a valid callback, class 'yii\console\YiiCaster' not found",
         },
       }
    >>> my\user\models\User::authenticate('yiqing_95@qq.com','wrong password')
    => false
    
~~~

看到我上面两个业务方法直接可以使用yii2-shell 方便验证，太帅了！！ 

建议大家下下来用用 ，这个扩展 好像被很多人冷落 估计都是不知道咋玩耍吧。

> 本文由 [yiqing](http://www.getyii.com/member/yiqing) 创作，采用 [知识共享署名 3.0 中国大陆许可协议](http://creativecommons.org/licenses/by/3.0/cn) 进行许可。
可自由转载、引用，但需署名作者且注明文章出处。