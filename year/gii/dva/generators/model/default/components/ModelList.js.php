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
 * @var string[] $hints list of attribute comments (name => comment)
 * @var string[] $rules list of validation rules
 * @var array $relations list of relations (name => relation declaration)
 */


// print_r($labels);
// print_r($hints);

$attributes = implode(', ', array_keys($labels)) ;

// 根据选择的 modName 来计算呀
$constantsPath = '../../constants' ;

$stylePath = './'.$className.'.css';

$modalClassName = $className.'Modal' ;

$routePath =   '/'. Inflector::camel2id(StringHelper::basename($className)) ;

$deleteActionType = "{$generator->ns}/remove" ;
$editActionType = "{$generator->ns}/patch" ;
$createActionType = "{$generator->ns}/create" ;

?>
import React from 'react';
import { connect } from 'dva';
import { Table, Pagination, Popconfirm, Button } from 'antd';
import { routerRedux } from 'dva/router';
import styles from '<?= $stylePath ?>';
import { PAGE_SIZE } from '../../constants';
import <?= $modalClassName ?> from './<?= $modalClassName ?>';

function <?= $className ?>({ dispatch, list: dataSource, loading, total, page: current }) {
    function deleteHandler(id) {
        dispatch({
            type: '<?= $deleteActionType ?>',
            payload: id,
        });
    }

    function pageChangeHandler(page) {
        dispatch(routerRedux.push({
            pathname: '<?= $routePath ?>',
            query: { page },
        }));
    }

    function editHandler(id, values) {
        dispatch({
            type: '<?= $editActionType ?>',
            payload: { id, values },
        });
    }

    function createHandler(values) {
        dispatch({
            type: '<?= $createActionType ?>',
            payload: values,
        });
    }

    /**
     * 一列的配置：
     *  {
     *      title: 'Name',
     *       dataIndex: 'name',
     *       key: 'name',
     *      render: text => <a href="">{text}</a>,
     *  },
     *
     *
     * @type {[*]}
     */
    const columns = [

        <?php foreach ($labels as $attr => $label):  ?>
        {
            title: '<?= $label ?>',
            dataIndex: '<?= $attr ?>',
            key: '<?= $attr ?>',
        },
        <?php endforeach;  ?>
        {
            title: 'Operation',
            key: 'operation',
            render: (text, record) => (
            <span className={styles.operation}>
            <<?= $modalClassName ?> record={record} onOk={editHandler.bind(null, record.id)}>
            <a>Edit</a>
            </<?= $modalClassName ?>>
            <Popconfirm title="Confirm to delete?" onConfirm={deleteHandler.bind(null, record.id)}>
            <a href="">Delete</a>
            </Popconfirm>
            </span>
            ),
        },
    ];

return (
    <div className={styles.normal}>
        <div>
            <div className={styles.create}>
                <<?= $modalClassName ?> record={{}} onOk={createHandler}>
                    <Button type="primary">Create <?= $className ?></Button>
                </<?= $modalClassName ?>>
            </div>
            <Table
                columns={columns}
                dataSource={dataSource}
                loading={loading}
                rowKey={record => record.id}
                pagination={false}
            />
            <Pagination
                className="ant-table-pagination"
                total={total}
                current={current}
                pageSize={PAGE_SIZE}
                onChange={pageChangeHandler}
            />
        </div>
        </div>
        );
}

/**
 * @todo 状态名称 到底大写还是小写？
 *
 * @param state
 * @returns {{loading: (users|{john, tom}|User[]), list: users.list, total: users.total, page: users.page}}
 */
function mapStateToProps(state) {
    // 此处的键名 跟../models/<?= $className ?> 处的名空间一致 全局唯一
    const { list, total, page } = state.<?= $generator->ns ?>;
    return {
        loading: state.loading.models.<?= $generator->ns ?>,
        list,
        total,
        page,
    };
}

export default connect(mapStateToProps)(<?= $className ?>);
