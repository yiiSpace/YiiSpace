可参考的设计思路
==============

- **近乎** 此项目的模块设计的相当好
- **dolphin** sns项目


参考：

http://www.phoenixframework.org/docs/routing

## Path Helpers

路径助手

比如user 模块的路径生成 

~~~elixir

    ex> import HelloPhoenix.Router.Helpers
    iex> alias HelloPhoenix.Endpoint
    iex> user_path(Endpoint, :index)
    "/users"
    
    iex> user_path(Endpoint, :show, 17)
    "/users/17"
    
    iex> user_path(Endpoint, :new)
    "/users/new"
    
    iex> user_path(Endpoint, :create)
    "/users"
    
    iex> user_path(Endpoint, :edit, 37)
    "/users/37/edit"
    
    iex> user_path(Endpoint, :update, 37)
    "/users/37"
    
    iex> user_path(Endpoint, :delete, 17)
    "/users/17"
~~~

>
    What about paths with query strings? By adding an optional fourth argument of key value pairs, the path helpers will return those pairs in the query string.
    
    iex> user_path(Endpoint, :show, 17, admin: true, active: false)
    "/users/17?admin=true&active=false"
    
    What if we need a full url instead of a path? Just replace _path by _url:
    
    iex(3)> user_url(Endpoint, :index)
    "http://localhost:4000/users"
    
##模块结构
   
[yii2-user](https://github.com/worstinme/yii2-user)
这里有一个模块结构比较大胆：
>
    backend
        controller
        views
        Module.php
    controller
    messages
    models
    Module.php
    ...

[yii2-user](https://github.com/yii2mod/yii2-user)
这里 的结构也很有意思
>
    actions
        LoginAction.php
        LogoutAction.php
        PasswordResetAction.php
        RequestPasswordReset.php
        SignupAction.php
    migrations
    models
    views
    composer.json
    ...
这种结构 使用了actions 你可以用自己的Module  只需要在控制器中配置 自由度比较大 侵入性较小：
>   
     /**
         * @return array
         */
        public function actions()
        {
            return [
                'login' => [
                    'class' => 'yii2mod\user\actions\LoginAction'
                ],
                'logout' => [
                    'class' => 'yii2mod\user\actions\LogoutAction'
                ],
                'signup' => [
                    'class' => 'yii2mod\user\actions\SignupAction'
                ],
                'request-password-reset' => [
                    'class' => 'yii2mod\user\actions\RequestPasswordResetAction'
                ],
                'password-reset' => [
                    'class' => 'yii2mod\user\actions\PasswordResetAction'
                ],
            ];
        }