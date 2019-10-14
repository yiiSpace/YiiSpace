<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var \year\gii\models\generators\gomodel\Generator $generator
 * @var string $tableName full table name
 */
$modelName = Inflector::id2camel($tableName,'_');

$urlBase =  Inflector::camel2id($modelName);
$getUrlPattern = $urlBase .'/{id:[0-9]+}' ;
$queryUrlPattern = $urlBase   ;
$createUrlPattern = $urlBase   ;
$updateUrlPattern = $urlBase .'/{id}'  ;
$deleteUrlPattern = $urlBase .'/{id}'  ;

?>

r := mux.NewRouter()
// <?= Inflector::pluralize($modelName) ,"\n" ?>
r.HandleFunc("<?= $getUrlPattern ?>", GetMachineHandler).Methods("GET")  // Get model by id
r.HandleFunc("<?= $queryUrlPattern ?>", ListMachinesHandler).Methods("GET") // list models
r.HandleFunc("<?= $createUrlPattern ?>", CreateMachineHandler).Methods("POST") // create model
r.HandleFunc("<?= $updateUrlPattern ?>", UpdateMachineHandler).Methods("PUT","POST") // update model
r.HandleFunc("<?= $deleteUrlPattern ?>", DeleteMachineHandler).Methods("DELETE","POST") // delete model
