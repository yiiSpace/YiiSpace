如何写widget
============

## widget 如果是某个js插件 那么分隔为两部分
---------

一个 XxxAsset  用来指定该widget有哪些用到的公共资源  css js images
一个为Xxx 代表widget本身  一般会在该类的init 后者run方法中注册XxxAsset资源类（yii2的某些源码中 注册widget一般出现在run
方法中）

## 变量化 asset
-------------
assets 一般是在设计期 里面的变量就指定好了  但在某些场景中 我们可能需要根据环境来包含不同的js css 这时有几种选择：
-  通过XxxAsset的静态变量来控制 这个技巧可以参考yii jui 中widget 对皮肤资源的处理方式！
  ~~~

    namespace yii\jui;
    use yii\helpers\Json;
    class Widget extends \yii\base\Widget
    {

     ...
    public static $theme = 'yii\jui\ThemeAsset';
    ....

    /**
     * Registers a specific jQuery UI widget assets
     * @param string $assetBundle the asset bundle for the widget
     */
    protected function registerAssets($assetBundle)
    {
        /** @var \yii\web\AssetBundle $assetBundle */
        $assetBundle::register($this->getView());
        /** @var \yii\web\AssetBundle $themeAsset */
        $themeAsset = static::$theme;
        $themeAsset::register($this->getView());
    }
    .. ..
    }

  ~~~

  在使用之前通过指定Widget::$theme 就可以动态替换掉使用的皮肤资源了  每个皮肤需要指定一个皮肤Asset 也是比较费事的！

-  通过方法来指定变量 js css  这个可以参考kartik-v 的系列widget方法：
   ~~~
   class AssetBundle extends \yii\web\AssetBundle
   {

       public $depends = [
           'yii\web\JqueryAsset',
           'yii\bootstrap\BootstrapAsset',
       ];

       /**
        * Set up CSS and JS asset arrays based on the base-file names
        *
        * @param string $type whether 'css' or 'js'
        * @param array $files the list of 'css' or 'js' basefile names
        */
       protected function setupAssets($type, $files = [])
       {
           $srcFiles = [];
           $minFiles = [];
           foreach ($files as $file) {
               $srcFiles[] = "{$file}.{$type}";
               $minFiles[] = "{$file}.min.{$type}";
           }
           if (empty($this->$type)) {
               $this->$type = YII_DEBUG ? $srcFiles : $minFiles;
           }
       }

       /**
        * Sets the source path if empty
        *
        * @param string $path the path to be set
        */
       protected function setSourcePath($path)
       {
           if (empty($this->sourcePath)) {
               $this->sourcePath = $path;
           }
       }
   }

   // 然后再子类的init方法中修改 如：
   class TypeaheadBasicAsset extends AssetBundle
   {

       public function init()
       {
           $this->setSourcePath(__DIR__ . '/../assets');
           $this->setupAssets('css', ['css/typeahead', 'css/typeahead-kv']);
           $this->setupAssets('js', ['js/typeahead.jquery', 'js/typeahead-kv']);
           parent::init();
       }
   }

   ~~~

- 通过XxxAsset 的实例引用来修改  这个可以参考官网的[guide](https://github.com/yiisoft/yii2/blob/master/docs/guide/assets.md)
  ~~~
  class LanguageAsset extends AssetBundle
  {
      public $language;
      public $sourcePath = '@app/assets/language';
      public $js = [
      ];

      public function registerAssetFiles($view)
      {
          $language = $this->language ? $this->language : Yii::$app->language;
          $this->js[] = 'language-' . $language . '.js';
          parent::registerAssetFiles($view);
      }
  }

   LanguageAsset::register($this)->language = $language;
  ~~~
  这个很不好理解  实际上asset不是立即发布的 他先被放在一个hashMap（就是关联数组）中 类名==》实例
   注册后到视图后 得到该类的实例 然后修改其变量 只有在真正发布资源的时候 才会调用“registerAssetFiles” 方法的
   所以在此之前你有机会修改变量 ！
   这个技巧对于上面jui皮肤那个例子 可以在皮肤非常多的情况下 只需要修改下皮肤基路径即可 并不需要为每个皮肤建立一个Asset类
