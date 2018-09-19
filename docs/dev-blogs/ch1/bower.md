composer 支持bower了

全局安装bower插件：
~~~

    composer global require "fxp/composer-asset-plugin:1.0.*@dev"

~~~

然后配置bower 资源下载的目标路径
~~~

    "extra": {
            "asset-installer-paths": {
                "npm-asset-library": "vendor/npm",
                "bower-asset-library": "vendor/bower"
            }
        },
~~~

上面的配置可以看出 composer 还支持npm 包下载

现在不是太清楚是否bower资源的安装需要自己独立安装nodejs 后再安装bower（npm -g install bower）因为我本机已经安装了nodejs
跟bower 所以无法断定是composer 调用bower | npm 命令去下载包 还是它自己下载的？

由于对bower的支持 某些js插件 css框架的引入方式可能有所变化了
~~~
    
    class BootstrapWizardAsset extends AssetBundle{
    
        public $sourcePath = '@bower/twitter-bootstrap-wizard';
        public $css = [
    
        ];
        public $js = [
    
        ];
        public $depends = [
            'yii\bootstrap\BootstrapAsset',
            'yii\bootstrap\BootstrapPluginAsset',
        ];
    
        public function init()
        {
          parent::init() ;
    
           if(YII_DEBUG){
               $this->js = [
                  'jquery.bootstrap.wizard.js'
               ];
           } else{
               $this->js = [
                   'jquery.bootstrap.wizard.min.js'
               ];
           }
        }
    
    }

~~~

@bower 是yii全局别名之一 可用来引用资源的源路径