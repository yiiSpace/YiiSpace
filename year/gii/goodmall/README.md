yii2-gii-goodmall
===========

> "Goodmall is good!"

**PROJECT IS IN BETA STAGE!**


这是啥?
-------------

根据你的表结构 给你生对应的crud功能的代码



参考 
- [organizing-large-react-applications](http://engineering.kapost.com/2016/01/organizing-large-react-applications)
- [organizing-redux-application](https://jaysoo.ca/2016/02/28/organizing-redux-application/)
- [organize-your-ember-app-with-pods](http://cball.me/organize-your-ember-app-with-pods/)

Resources
---------



Features
--------

### Batch command

- `yii batch` creates all models and/or CRUDs for a set of tables sequentially with a single command

### Model generator

- generates separate model classes to customize and base models classes which can be regenerated on schema changes
- table prefixes can be stipped off model class names (not bound to `db` connection settings from Yii 2.0)

### CRUD generator

- input, attribute, column and relation customization with provider queues
- callback provider to inject any kind of code for inputs, attributes and columns via dependency injection
- virtual-relation support (non-foreign key relations)
- model, view and controller locations can be customized to use subfolders
- horizontal and vertical form layout
- options for tidying generated code
- action button class customization (Select "App Class" option on the  Action Button Class option on CRUD generator to customize)


Installation
------------

~~~
    	 'bootstrap' => [
                //  'queue', // The component registers own console commands
                [
                    'class'=>'year\gii\goodmall\Bootstrap',   // gii的goodmall 代码生成
                    'giiBaseUrl'=>'http://localhost:1323'  //  此处配置是应用参数注入 可以在其他地方访问：  Yii::$app->params['goodmall.giiBaseUrl']
                ],
            ],       
~~~


Configuration
-------------

It's recommended to configure a customized `batch` command in your application CLI configuration.

    'controllerMap' => [
        'batch' => [
            'class' => 'schmunk42\giiant\commands\BatchController',
            'overwrite' => true,
            'modelNamespace' => 'app\\modules\\crud\\models',
            'crudTidyOutput' => true,
        ]
    ],

> Note: `yii giiant-batch` is an alias for the default configuration of `BatchController` registered by this extension.

You can add the giiant specific configuration `config/giiant.php`, and include this from your `config/main.php`.

See the [batches](docs/20-batches.md) section for configuration details.


Usage
-----



### Core commands

 


goodmallnced
--------

### Provider usage and configuration via dependency injection 


### Using callbacks to provide code-snippets


### Troubleshooting



Extras
------



Screenshots
-----------


Built by [yiqing](http://gitbub.com/yiqing)

##  硬链接

克隆时： git clone -c core.symlinks=true <your-url>

创建链接：

需要admin权限哦

 例子
~~~win-cmd

mklink /J .src  C:"\Program Files\Java"

~~~
必须用 硬链接才可以  软连接符号链接不可行！  
请自行 搜索 "mklink /D和/J的区别"

参考： https://github.com/git-for-windows/git/wiki/Symbolic-Links#creating-symbolic-links

咋搞的！