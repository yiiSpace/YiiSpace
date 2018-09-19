<?php
/**
 * This is the template for generating a CRUD controller class file.
 *
 * User: yiqing
 * Date: 2018/4/19
 * Time: 7:22
 */
?>
<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator year\gii\goodmall\generators\crud\Generator */

$interactorName = $generator->interactorName ;
$interactorType = $generator->interactorName.'Interactor' ;
$interactorImplType = lcfirst($interactorType) ; // interactor implement type name


$pkgName = 'controller' ;
$imports = [] ;

$interactorType = 'usecase.SomeInteractor' ;
?>

package <?= $pkgName ?>

for echo framework , not implemented yet ! JUST for placeHolder