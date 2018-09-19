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

$modelName = $generator->interactorName ; // 模型名称 默认跟 interactor同名
$modelType = 'domain.'.$generator->interactorName ; // 带包名的模型类型名称
$modelRepositoryName =  $modelName.'Repo' ;
$modelRepositoryType =  'domain.'.$modelName.'Repo' ;

$searchModelType = 'domain.'.$modelName.'Search' ; // 带包名的模型类型名称
?>

package usecase

import (
    // "github.com/goodmall/goodmall/base"
    // "github.com/goodmall/goodmall/pods/demo"

    "github.com/asaskevich/EventBus"
)

// <?= $interactorType?> represents a service for managing <?= \yii\helpers\Inflector::pluralize($modelName) ?>.
// alias : <?= $interactorName ?>Service.
type <?= $interactorType ?> interface {

    //
    Create(m *<?= $modelType ?>) (*<?= $modelType ?>, error)

    //
    Update(id int, m *<?= $modelType ?>) (*<?= $modelType ?>, error)

    //
    Delete(id int) (*<?= $modelType ?>, error)

    //
    Get(id int) (*<?= $modelType ?>, error)

    //
    Query(sm  <?= $searchModelType ?>, fields []string , offset, limit int, sort string) ([]<?= $modelType?>, error)
    //
    Count(sm <?= $searchModelType?>) (int, error)

}

// Ensure 接口被实现了.
var _ <?= $interactorType ?> = &<?= $interactorImplType ?>{}

// New<?= $interactorType ?> create a <?= $interactorName ?> interactor .
func New<?= $interactorType ?>(rp <?= $modelRepositoryType ?>, eb EventBus.Bus) <?= $interactorType?> {
    return &<?= $interactorImplType?>{
        <?= lcfirst($modelRepositoryName) ?>: rp,
        eventBus: eb,
    }
}

// <?= $interactorType ?>  allows to interact with <?= $modelName ?> .
// dependencies : <?= $modelRepositoryType ?> ,EventBus.Bus .
type <?= $interactorImplType ?> struct {
    <?= lcfirst($modelRepositoryName)?>  <?= $modelRepositoryType ?> <?= "\n" ?>
    eventBus EventBus.Bus
}

// Get return a model by specified id.
func (itr *<?= $interactorImplType ?>)  Get(id int) (*<?= $modelType ?>, error) {
    return itr.<?= lcfirst($modelRepositoryName) ?>.Load(id)
}

// Query search models by your search criteria ,you can specify which fields you want ,limit or sort the results.
func (itr *<?= $interactorImplType ?>) Query(sm <?= $searchModelType ?>,  fields []string , offset, limit int, sort string) ([]<?= $modelType ?>, error) {

    return itr.<?= lcfirst($modelRepositoryName) ?>.Query(sm, offset, limit, sort)

}

// Create create a new model object.
func (itr *<?= $interactorImplType ?>) Create(model *<?= $modelType ?>) (*<?= $modelType ?>, error) {
    /*
    if err := model.Validate(); err != nil {
          return nil, err
    }
    */
    if err := itr.<?=  lcfirst($modelRepositoryName) ?>.Create(model); err != nil {
         return nil, err
    }
    return itr.<?=  lcfirst($modelRepositoryName) ?>.Load(model.Id) //  model.Id ==> model.GetID()  // 有些表名字不是id
}

// Update update the specified model by id.
func (itr *<?= $interactorImplType?>) Update(id int, model *<?= $modelType ?>) (*<?= $modelType ?>, error) {
    /*
    if err := model.Validate(); err != nil {
         return nil, err
    }
    */
    if err := itr.<?= lcfirst($modelRepositoryName) ?>.Update(id, model); err != nil {
         return nil, err
    }
    return itr.<?= lcfirst($modelRepositoryName) ?>.Load(id)
}

// Delete delete the specified model by id.
func (itr *<?= $interactorImplType ?>) Delete(id int) (*<?= $modelType ?>, error) {
    obj, err := itr.<?= lcfirst($modelRepositoryName) ?>.Load(id)
    if err != nil {
         return nil, err
    }
    err = itr.<?= lcfirst($modelRepositoryName) ?>.Remove(id)
    return obj, err

}

// Count count the search criteria , the result can be used by the Query function for pagination.
func (itr *<?= $interactorImplType ?>) Count(sm <?= $searchModelType ?>) (int, error) {
    return itr.<?= lcfirst($modelRepositoryName) ?>.Count(sm)
}

