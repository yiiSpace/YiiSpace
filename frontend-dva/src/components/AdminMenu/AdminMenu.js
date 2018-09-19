import React from 'react';
import { connect } from 'dva';
import { Table, Pagination, Popconfirm, Button } from 'antd';
import { routerRedux } from 'dva/router';
import styles from './AdminMenu.css';
import { PAGE_SIZE } from '../../constants';
import AdminMenuModal from './AdminMenuModal';

function AdminMenu({ dispatch, list: dataSource, loading, total, page: current }) {
    function deleteHandler(id) {
        dispatch({
            type: 'admin_menu/remove',
            payload: id,
        });
    }

    function pageChangeHandler(page) {
        dispatch(routerRedux.push({
            pathname: '/admin-menu',
            query: { page },
        }));
    }

    function editHandler(id, values) {
        dispatch({
            type: 'admin_menu/patch',
            payload: { id, values },
        });
    }

    function createHandler(values) {
        dispatch({
            type: 'admin_menu/create',
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
            title: 'Level',
            dataIndex: 'level',
            key: 'level',
        },
                {
            title: 'Label',
            dataIndex: 'label',
            key: 'label',
        },
                {
            title: 'Url',
            dataIndex: 'url',
            key: 'url',
        },
                {
            title: 'Params',
            dataIndex: 'params',
            key: 'params',
        },
                {
            title: 'Ajaxoptions',
            dataIndex: 'ajaxoptions',
            key: 'ajaxoptions',
        },
                {
            title: 'Htmloptions',
            dataIndex: 'htmloptions',
            key: 'htmloptions',
        },
                {
            title: 'Is Visible',
            dataIndex: 'is_visible',
            key: 'is_visible',
        },
                {
            title: 'Uid',
            dataIndex: 'uid',
            key: 'uid',
        },
                {
            title: 'Group Code',
            dataIndex: 'group_code',
            key: 'group_code',
        },
                {
            title: 'Operation',
            key: 'operation',
            render: (text, record) => (
            <span className={styles.operation}>
            <AdminMenuModal record={record} onOk={editHandler.bind(null, record.id)}>
            <a>Edit</a>
            </AdminMenuModal>
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
                <AdminMenuModal record={{}} onOk={createHandler}>
                    <Button type="primary">Create AdminMenu</Button>
                </AdminMenuModal>
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
    // 此处的键名 跟../models/AdminMenu 处的名空间一致 全局唯一
    const { list, total, page } = state.admin_menu;
    return {
        loading: state.loading.models.admin_menu,
        list,
        total,
        page,
    };
}

export default connect(mapStateToProps)(AdminMenu);
