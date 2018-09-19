Yii2 dynamic page block solutions 
==================================
allow you  to pass page block to layout file  in view  files

Installation
------------



```"
repositories":[
    {
      "type": "path",
      "url": "./year/web/yii2-layout"
    }
  ],
"require": {
      "yiier/yii2-layout": "dev-master",
    },
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \yiier\web\AutoloadExample::widget(); ?>
```


the detail example you can find here
[dynamic-sidebar-using-cclipwidget Yii1 ](http://www.yiiframework.com/wiki/127/dynamic-sidebar-using-cclipwidget/#hh2)