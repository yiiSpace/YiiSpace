关于资源注册问题
==================

常规用法是 把需要发布的资源(js images css) 通过assetBundle类封装的形式发布出去的。 但对于条件性发布（有些情况下只需要发布
某个资源包中的一部分，依据当前环境 再次发布另一部分），有些棘手！

解决方案：

-   asset类中只发布核心的js css等  ，通过widget包装可以选择性的添加css js 到asset实例的js 跟css 属性中！至于你要根据什么
    条件来发布额外的js ，css 这些条件变量可以通过widget的public属性暴露给用户。
    参考某些XxxAsset 以及其对应的Xxx widget类。
-   另一种是这些额外的js css 可以单独封装为一个Asset(匿名asset 关于这个实现自己追踪源码吧) 但跟原始的asset有某种联系
    （至少要知道原始的asset baseUrl信息）：
    ~~~[php]
    
        $assetManager = $this->view->getAssetManager();
        $assetBundle = $assetManager->getBundle(InfiniteScrollAsset::className());
        $behaviorUrl = $assetManager->getAssetUrl($assetBundle, 'behaviors/' . $behaviorAsset);
        $this->view->registerJsFile($behaviorUrl, [
        'depends' => [InfiniteScrollAsset::className()]
        ]);
    ~~~
    上例中是来自InfiniteScrollAsset 扩展中的解决方法。
    