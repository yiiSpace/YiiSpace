
js 中相似组件 或者功能相关的

https://github.com/bpmn-io/form-js



## 关于yii2中加载js文件

https://stackoverflow.com/questions/34964462/yii2-requires-bower-asset-jquery

https://asset-packagist.org/package/npm-asset/vue3-sfc-loader
https://asset-packagist.org/package/search?query=vue&platform=bower%2Cnpm

在这个网站搜索是不是有相关的js库被同步过来了

然后在composer.json 中添加到*require* 配置段 如同其他php库那样的添加js库
但是库名称可能需要添加前缀 : npm-asset|ower-asset

例子可以看：
https://www.yiiframework.com/extension/yiisoft/yii2-bootstrap4/doc/guide/2.0/en/assets-setup

下面这个是直接使用cdn路径 而不是下载到本地

Configure 'assetManager' application component, overriding Bootstrap asset bundles with CDN links:

~~~php

return [
    'components' => [
        'assetManager' => [
            // override bundles to use CDN :
            'bundles' => [
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1',
                    'css' => [
                        'css/bootstrap.min.css'
                    ],
                ],
                'yii\bootstrap4\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'baseUrl' => 'https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1',
                    'js' => [
                        'js/bootstrap.bundle.min.js'
                    ],
                ],
            ],
        ],
        // ...
    ],
    // ...
];

~~~


### yii2 加载react:
https://openitstudio.ru/blog/44

~~~php

class ReactAsset extends AssetBundle
{
    public $sourcePath = '@bower-asset/react';
    
    public $js = [
        'https://unpkg.com/babel-standalone@6/babel.min.js',
        'react.production.min.js',
        'react-dom.production.min.js',
    ];
}

class ReactAppAsset extends  AssetBundle
{
    public $css = [
        'css/Messenger.css'
    ];

    public $js = [
        'js/ReactApp.js'
    ];

    public $jsOptions = [
        'type' => 'text/babel'
    ];

    public $depends = [
        ReactAsset::class
    ];
}



<div id="react-app"></div>

class App extends React.PureComponent {

render() {
        return (
            <div>Hello world!</div>
        )
    }
}

ReactDOM.render(
    <App/>,
    document.getElementById('react-app')
);
~~~