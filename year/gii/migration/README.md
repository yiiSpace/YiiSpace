yii2-migration
===========

> "yii2 is good!"

**PROJECT IS IN BETA STAGE!**


这是啥?
-------------

根据你的表  给你生对应的迁移类代码 



参考 
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
                    'class'=>'year\gii\migration\Bootstrap',   // gii的migration 代码生成
                    'giiBaseUrl'=>'http://localhost:1323'  //  此处配置是应用参数注入 可以在其他地方访问：  Yii::$app->params['migration.giiBaseUrl']
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

 


migrationnced
--------

### Provider usage and configuration via dependency injection 


### Using callbacks to provide code-snippets


### Troubleshooting



Extras
------



Screenshots
-----------


Built by [yiqing](http://gitbub.com/yiqing)

