# YII SPACE
 for learning the yii2 php framework
 
## Directory structure

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
```

## 需要仔细研究的项目
* yii2-gii
* yii2-debug

## 神器

- rust 工具 rg  搜索速度极快！

- 简单绘图 (excalidraw)[https://excalidraw.com/]

## 参考

-  [jquery-手册](https://www.runoob.com/manual/jquery/)
- [yii useful modules and extensions](https://github.com/dmstr)
- [yiigist yii优秀库](https://yiigist.com/packages#!#%3Ftag=extension)
- [Universal web application built upon Docker, PHP & Yii 2.0 Framework](https://github.com/dmstr/phd5-app)
    此库有docker相关的配置     

## 一些注意点
- The CSS files are installed via Yii's recommended usage of the fxp/composer-asset-plugin v1.1.1 or later.
    通过yii安装css文件
~~~shell
  composer global require "fxp/composer-asset-plugin:~1.2.0"  
  ~~~

这个据说是不推荐的方式
~~~json5
{
  "extra": {
    "asset-installer-paths": {
      "npm-asset-library": "vendor/npm",
      "bower-asset-library": "vendor/bower"
    }
  },
}

~~~
新方法用这个：
~~~json5

{"config":{
    "fxp-asset": {
        "installer-paths": {
            "npm-asset-library": "vendor/npm",
            "bower-asset-library": "vendor/bower"
        },
    }
}
}
~~~

- bower｜bower-assert不存在问题
~~~
"config": {
    "process-timeout": 1800,
    "fxp-asset": {
        "enabled": true
    }
},
~~~
此方法未验证 ，配置完后需要删掉vendor composer重新安装下依赖

另一个方案 也未验证：
~~~

"config": {
        "fxp-asset": {
            "installer-paths": {
                "npm-asset-library": "vendor/npm",
                "bower-asset-library": "vendor/bower"
            }
        }
    },
~~~
有点乱的感觉 😄，
[Composer Yii2 Bower: The file or directory to be published does not exis](https://stackoverflow.com/questions/53116822/composer-yii2-bower-the-file-or-directory-to-be-published-does-not-exist-c-my)

- 检查依赖 
>  composer why -r nikic/php-parser


## 奇怪的bug

- "schmunk42/yii2-giiant":"@dev",  这个库会导致奇怪的问题 估计是版本引起的

## 安装npm js库
以composer方式 来做npm的事情

https://www.yiiframework.com/doc/guide/2.0/en/structure-assets

先去这里[asset-packagist](https://asset-packagist.org/)搜索 
按照php库的方式引入到composer.json  注意js库一般是npm|bower -asset 开头