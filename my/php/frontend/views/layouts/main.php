<?php

use yii\helpers\Html;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;

/** @var \yii\web\View $this */
/** @var string $content */


//$reflection = (new BetterReflection())->reflectClass(
//    Yii::$app->controller
//);
$astLocator = (new BetterReflection())->astLocator();
$directoriesSourceLocator = new DirectoriesSourceLocator([
    Yii::$app->controller->module->getControllerPath(),
], $astLocator);
$reflector = new DefaultReflector($directoriesSourceLocator);
$classes = $reflector->reflectAllClasses();
$controllerClasses = [];
foreach ($classes as $class) {
    $controllerClasses[] =
        // $class->getName() ;
        $class->getShortName();
}
$controllerIds = [];
foreach ($controllerClasses as $controllerClass) {
    if (\yii\helpers\StringHelper::endsWith($controllerClass, 'Controller')) {

        $controllerClassWithoutSuffix = substr($controllerClass, 0, strrpos($controllerClass, 'Controller'));
//        print_r($controllerClassWithoutSuffix);
        $controllerIds[] = \yii\helpers\Inflector::camel2id($controllerClassWithoutSuffix);
    }
}

?>
<?php $this->beginContent(Yii::$app->getLayoutPath() . '/main.php'); ?>


<ul id="slide-out" class="sidenav">
<!--    <li>-->
<!--        <div class="user-view">-->
<!--            <div class="background">-->
<!--                <img src="images/office.jpg">-->
<!--            </div>-->
<!--            <a href="#user"><img class="circle" src="images/yuna.jpg"></a>-->
<!--            <a href="#name"><span class="white-text name">John Doe</span></a>-->
<!--            <a href="#email"><span class="white-text email">jdoe@example.com</span></a>-->
<!--        </div>-->
<!--    </li>-->
    <li><a href="#!"><i class="material-icons">cloud</i>First Link With Icon</a></li>

    <?php foreach ($controllerIds as $controllerId): ?>
        <li><a href="<?= \yii\helpers\Url::to([
//             \yii\helpers\StringHelper::dirname( Yii::$app->controller->getUniqueId()).'/'.$controllerId ,
//              ''.$controllerId ,
               '/'. Yii::$app->controller->module->getUniqueId().'/'.$controllerId ,
            ]) ?>"><?=  $controllerId ?></a></li>
    <?php endforeach; ?>

    <li>
        <div class="divider"></div>
    </li>
    <li><a class="subheader">Subheader</a></li>
<!--    --><?php //print_r($controllerIds) ; ?>

</ul>


<div class="row">
    <div class="col s3 z-depth-2 | col-md-3 col-sm-4">


        <ul class="collection with-header">
            <li class="collection-header">
<!--                <h4>First Names</h4>-->
            </li>

            <li class="collection-item">
                <div>
                    其他例子 ?
                    <a href="#" data-target="slide-out" class="sidenav-trigger secondary-content">
                         <i class="material-icons">menu</i>
                    </a>
                </div>
            </li>
        </ul>



        <div class="list-group">
            <?php

            //            dump($this->context) ;// 也可以用
            //            Yii::$app->controller ;
            $rc = new ReflectionClass(Yii::$app->controller);
            /**
             * own methods not defined in parent class
             *
             * $methods = [];
             * foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
             * if ($method['class'] == $rc->getName())
             * $methods[] = $method['name'];
             */
            //            \Reflection::export( $rc );
            $actions = [];
            foreach ($rc->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $methodName = $method->getName();

                if ($methodName !== 'actions' && \yii\helpers\StringHelper::startsWith($methodName, 'action')) {
//                    print_r($methodName) ;
                    $actions[] = substr($methodName, strlen('action'));
                }
            }
            //            print_r($actions) ;
            $actions = array_merge($actions, array_keys(Yii::$app->controller->actions()));
            //TODO 补上actions 里面声明的action


            $classes = ['collection-item', 'list-group-item', 'd-flex', 'justify-content-between', 'align-items-center'];

            echo Html::beginTag('div', [
                'class' => 'collection',
            ]);
            foreach ($actions as $action) {
                $actionId = \yii\helpers\Inflector::camel2id($action);
                $label = Html::tag('span', Html::encode($action)) . '<span class="icon"></span>';
                echo Html::a($label, [$actionId], [
                    // 注意控制器还有个getUniqueId action也有
                    'class' => Yii::$app->controller->action->id == $actionId ? array_merge($classes, ['active']) : $classes,
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
