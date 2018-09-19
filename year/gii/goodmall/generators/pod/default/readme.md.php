<?php
/* @var $this yii\web\View */
/* @var $generator year\gii\goodmall\generators\pod\Generator */
?>
<?= $generator->podID ?>模块
==========

属于整个应用的一个Pod（多module结构中的一个模块  为了避免混淆 所以采用pod）
 
~~~

InitPod(app App , config Config , container Container)
~~~
 

## 目录结构说明

结构按照 bob大叔的 clean-arch 来规划

### hex|onion|clean-arch：

~~~

<?= $generator->podID ?>
|
├── usecase     application-service|usecases  interactor
|
├── domain      domain-model entity valueobject|events|exception/error|domain-service|repository-interface
| 
├── infra       infrastructure  repository implements will go here 
|
├── adapter     adapt to the end , such as web-ui cli-ui  desktop-ui ...
|               adapter/web/ | adapter/cli/ | adapter/desktop/                                       
|               controllers  handlers go here              

~~~


