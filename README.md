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

rust 工具 rg  搜索速度极快！


## 参考

-  [jquery-手册](https://www.runoob.com/manual/jquery/)
- [yii useful modules and extensions](https://github.com/dmstr)
- [yiigist yii优秀库](https://yiigist.com/packages#!#%3Ftag=extension)

## 奇怪的bug

- "schmunk42/yii2-giiant":"@dev",  这个库会导致奇怪的问题 估计是版本引起的