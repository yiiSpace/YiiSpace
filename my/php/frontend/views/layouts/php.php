<?php



use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

/** @var \yii\web\Controller $controller */
$controller = null;



$rc = \Roave\BetterReflection\Reflection\ReflectionClass::createFromInstance(Yii::$app->controller);

?>
<?php $this->beginContent(__DIR__ . '/main.php'); ?>
<?php
//print_r($controllerClasses);
//print_r($controllerIds);
?>




<?= $content ?>

<?php $this->endContent(); ?>


