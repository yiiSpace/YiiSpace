<?php
/**
 * This is the template for generating a CRUD controller class file.
 *
 * User: yiqing
 * Date: 2018/4/19
 * Time: 7:22
 *
 * @see https://jonathas.com/documenting-your-nodejs-api-with-apidoc/
 */
?>
<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator year\gii\goodmall\generators\api\Generator */

$modelName =  end( explode('.', $generator->modelType) ) ;
$pluralModelName = \yii\helpers\Inflector::pluralize($modelName);
$successObjectList = 'List'.$modelName ;

$controllerType = $generator->controllerType ;

$route = $generator->podId.'/'.\yii\helpers\Inflector::camel2id($modelName,'-');
$route4list = $generator->podId.'/'.\yii\helpers\Inflector::camel2id(
        \yii\helpers\Inflector::pluralize($modelName)
        ,'-');

$podId = $generator->podId ;

$tableSchema = $generator->getTableSchema() ;
$fieldsInfo = $generator->generateProperties($tableSchema);

$apiGetName = 'Get'.$modelName;
$apiQueryName = 'Query'.$modelName;
$apiCreateName = 'Create'.$modelName;
$apiUpdateName = 'Update'.$modelName;
$apiDeleteName = 'Delete'.$modelName;

/**
 *                     -------------生出一个样例数据来--------------                 ++|
 */
$row = $generator->genFakeRecord($tableSchema)  ;
$fakeRecord = function ()use($row){
    return \Zend\Json\Json::prettyPrint(json_encode($row)) ;
    // FIXME 自己做格式化输出比较困难点
    $rslt = '' ;
   foreach ($row as $field=>$val){
       // $rslt .= "\t\t".
   }
   return $rslt ;
};
$jsonLine  = explode("\n",$fakeRecord()) ;
/**
 * function callback($k, $v) { ... }
 * array_map( "callback", array_keys($array), $array);
 */
$rowData = array_map(function($v){
    return '*    '.$v ;
},$jsonLine) ;
// print_r($rowData) ;
$jsonRow = implode("\n",$rowData) ;
/**
 *                     -------------生出一个样例数据来--------------                 ++|
 */
?>
package docs

/**
* @apiDefine Success<?= $modelName ."\n" ?>
*
<?php foreach ($fieldsInfo as $colName => $colInfo ):?>
* @apiSuccess {<?= $colInfo['type'] ?>}   <?= $colName ?>           <?= $colInfo['comment'] ?>

<?php endforeach;  ?>
*/

/**
* @apiDefine <?= $successObjectList ."\n" ?>
* @apiSuccess {Object[]} <?= $pluralModelName ?>       List of <?= $pluralModelName ?>.
*
<?php foreach ($fieldsInfo as $colName => $colInfo ):
        $f = $pluralModelName.'.'. $colName ;
    ?>
    * @apiSuccess {<?= $colInfo['type'] ?>}   <?= $f ?>           <?= $colInfo['comment'] ?>

<?php endforeach;  ?>
*/

/**
* @apiDefine Params<?= $modelName ."\n" ?>
*
<?php foreach ($fieldsInfo as $colName => $colInfo ):
    $f = $colName ;
     if($colInfo['default'] !== null){
        $f .= '='.$colInfo['default'] ;
     }
     if($colInfo['isOptional']){
         $f = '['.$f.']' ;
     }

    ?>
    * @apiParam {<?= $colInfo['type'] ?>}   <?= $f ?>           <?= $colInfo['comment'] ?>

<?php endforeach;  ?>
*/

/**
* @apiDefine UserNotFoundError
*
* @apiError UserNotFound The id of the User was not found.
*
* @apiErrorExample Error-Response:
*     HTTP/1.1 404 Not Found
*     {
*       "error": "UserNotFound"
*     }
*/

<?php echo <<<DOC

/**
* @api {get} /$route/:id Find a {$modelName} .
* @apiVersion 0.0.1
* @apiName  $apiGetName .
* @apiGroup  $podId  .
* @apiPermission authenticated user
*
*
* @apiParam {String} id The  {$modelName}-ID.
*
* @apiExample {cmd} Example usage:
* curl -i http://localhost/$route/4711
*
* @apiSuccess {String}   id            The Users-ID.
* @apiUse Success{$modelName} 
* @apiSuccessExample {json} Success response:
*     HTTP 200 OK
{$jsonRow}
*
* @apiError NoAccessRight Only authenticated Admins can access the data.
* @apiError UserNotFound   The id of the User was not found.
* @apiErrorExample Response (example):
*     HTTP/1.1 401 Not Authenticated
*     {
*       "error": "NoAccessRight"
*     }
*/
func $apiGetName() { return; }

DOC;
?>

<?php echo <<<DOC

/**
 * @api {get} /{$route4list} Query all {$pluralModelName}
 * @apiGroup Tasks
 * @apiUse {$successObjectList}

 * @apiSuccessExample {json} Success
 *    HTTP/1.1 200 OK
 *    [
 {$jsonRow}
 *    ]
 * @apiErrorExample {json} List error
 *    HTTP/1.1 500 Internal Server Error
 */

DOC;
?>



<?php echo <<<DOC

/**
* @api {post} /$route  Create a new   $modelName  
* @apiVersion 0.0.1
* @apiName   $apiCreateName  
* @apiGroup  $podId 
* @apiPermission none
*
* @apiDescription In this case "apiUse" is defined and used.
* Define blocks with params that will be used in several functions, so you dont have to rewrite them.
*
* @apiUse   Params{$modelName}
*
* @apiSuccess {String} id         The new {$modelName}-ID.
*
* apiUse CreateUserError
*/
func {$apiCreateName}() { return; }

DOC;
?>





<?php echo <<<DOC

/**
* @api {put} /$route/:id Update a new {$modelName}
* @apiVersion 0.0.1
* @apiName {$apiUpdateName}
* @apiGroup {$podId}
* @apiPermission none
*
* @apiDescription This function has same errors like POST /user, but errors not defined again, they were included with "apiUse"
*
* @apiUse Params{$modelName}
*
*/
func  $apiUpdateName() { return; }

DOC;
?>

<?php echo <<<DOC

/**
* @api {delete} /$route/:id Remove a {$modelName}
* @apiVersion 0.0.1
* @apiName {$apiUpdateName}
* @apiGroup {$podId}
* @apiPermission none
* @apiParam {id} the {$modelName} id
* @apiSuccessExample {json} Success
*    HTTP/1.1 204 No Content
* @apiErrorExample {json} Delete error
*    HTTP/1.1 500 Internal Server Error
*
*/
func  $apiDeleteName() { return; }

DOC;
?>