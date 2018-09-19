<?php
/**
 * This is the template for generating the model class of a specified table.
 * DO NOT EDIT THIS FILE! It may be regenerated with Gii.
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;


/**
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\model\Generator $generator
 * @var string $tableName full table name
 * @var string $className class name
 * @var yii\db\TableSchema $tableSchema
 * @var string[] $labels list of attribute labels (name => label)
 * @var string[] $rules list of validation rules
 * @var array $relations list of relations (name => relation declaration)
 */

?>
import React from 'react';
import { connect } from 'dva';
import styles from './<?= $className ?>.css';
import <?= $className ?>Component from '../components/<?= $className ?>/<?= $className ?>';
import MainLayout from '../components/MainLayout/MainLayout';

function <?= $className ?>({ location }) {
return (
<MainLayout location={location}>
    <div className={styles.normal}>
        <<?= $className ?>Component />
    </div>
</MainLayout>
);
}

export default connect()(<?= $className ?>);
