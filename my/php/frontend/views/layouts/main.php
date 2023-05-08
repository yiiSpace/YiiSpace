<?php
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

?>
<?php $this->beginContent(Yii::$app->getLayoutPath().'/main.php'); ?>
<div class="row">
    <div class="col s3 z-depth-2 | col-md-3 col-sm-4">
        <div class="list-group">
            <?php

//            dump($this->context) ;// 也可以用
//            Yii::$app->controller ;
            $rc = new ReflectionClass(Yii::$app->controller);
            /**
             * own methods not defined in parent class

            $methods = [];
            foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
                if ($method['class'] == $rc->getName())
                    $methods[] = $method['name'];
             */
//            \Reflection::export( $rc );
            $actions = [];
            foreach ($rc->getMethods(\ReflectionMethod::IS_PUBLIC) as $method ){
                $methodName = $method->getName() ;

                if( $methodName !=='actions' && \yii\helpers\StringHelper::startsWith($methodName,'action')){
//                    print_r($methodName) ;
                    $actions[] = substr($methodName,strlen('action')) ;
                }
            }
//            print_r($actions) ;
            $actions = array_merge($actions,array_keys(Yii::$app->controller->actions()));
            //TODO 补上actions 里面声明的action


            $classes = ['collection-item', 'list-group-item', 'd-flex', 'justify-content-between', 'align-items-center'];

            echo Html::beginTag('div',[
                'class' => 'collection',
            ]);
            foreach ($actions as $action) {
                $actionId = \yii\helpers\Inflector::camel2id($action) ;
                $label = Html::tag('span', Html::encode($action)) . '<span class="icon"></span>';
                echo Html::a($label, [$actionId], [
                    // 注意控制器还有个getUniqueId action也有
                    'class' => Yii::$app->controller->action->id == $actionId  ? array_merge($classes, ['active']) : $classes,
                ]);
            }
            echo Html::endTag('div');
            ?>
        </div>
    </div>
    <div class=" col s9 | col-md-9 col-sm-8">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>
