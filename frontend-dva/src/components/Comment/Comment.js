import React from 'react';
import { connect } from 'dva';
import { Table, Pagination, Popconfirm, Button } from 'antd';
import { routerRedux } from 'dva/router';
import styles from './Comment.css';
import { PAGE_SIZE } from '../../constants';
import CommentModal from './CommentModal';

function Comment({ dispatch, list: dataSource, loading, total, page: current }) {
    function deleteHandler(id) {
        dispatch({
            type: 'comment/remove',
            payload: id,
        });
    }

    function pageChangeHandler(page) {
        dispatch(routerRedux.push({
            pathname: '/comment',
            query: { page },
        }));
    }

    function editHandler(id, values) {
        dispatch({
            type: 'comment/patch',
            payload: { id, values },
        });
    }

    function createHandler(values) {
        dispatch({
            type: 'comment/create',
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

                {
            title: 'ID',
            dataIndex: 'id',
            key: 'id',
        },
                {
            title: 'User ID',
            dataIndex: 'user_id',
            key: 'user_id',
        },
                {
            title: 'Parent ID',
            dataIndex: 'parent_id',
            key: 'parent_id',
        },
                {
            title: 'Model',
            dataIndex: 'model',
            key: 'model',
        },
                {
            title: 'Model ID',
            dataIndex: 'model_id',
            key: 'model_id',
        },
                {
            title: 'Model Owner ID',
            dataIndex: 'model_owner_id',
            key: 'model_owner_id',
        },
                {
            title: 'Name',
            dataIndex: 'name',
            key: 'name',
        },
                {
            title: 'Url',
            dataIndex: 'url',
            key: 'url',
        },
                {
            title: 'Email',
            dataIndex: 'email',
            key: 'email',
        },
                {
            title: 'Text',
            dataIndex: 'text',
            key: 'text',
        },
                {
            title: 'Model Profile Data',
            dataIndex: 'model_profile_data',
            key: 'model_profile_data',
        },
                {
            title: 'Status',
            dataIndex: 'status',
            key: 'status',
        },
                {
            title: 'Create Time',
            dataIndex: 'create_time',
            key: 'create_time',
        },
                {
            title: 'Ip',
            dataIndex: 'ip',
            key: 'ip',
        },
                {
            title: 'Level',
            dataIndex: 'level',
            key: 'level',
        },
                {
            title: 'Root',
            dataIndex: 'root',
            key: 'root',
        },
                {
            title: 'Lft',
            dataIndex: 'lft',
            key: 'lft',
        },
                {
            title: 'Rgt',
            dataIndex: 'rgt',
            key: 'rgt',
        },
                {
            title: 'Operation',
            key: 'operation',
            render: (text, record) => (
            <span className={styles.operation}>
            <CommentModal record={record} onOk={editHandler.bind(null, record.id)}>
            <a>Edit</a>
            </CommentModal>
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
                <CommentModal record={{}} onOk={createHandler}>
                    <Button type="primary">Create Comment</Button>
                </CommentModal>
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
    // 此处的键名 跟../models/Comment 处的名空间一致 全局唯一
    const { list, total, page } = state.comment;
    return {
        loading: state.loading.models.comment,
        list,
        total,
        page,
    };
}

export default connect(mapStateToProps)(Comment);
