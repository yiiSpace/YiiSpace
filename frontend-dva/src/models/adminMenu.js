import * as adminMenuService from '../services/adminMenu';

export default {
    namespace: 'admin_menu',
    state: {
        list: [],
        total: null,
        page: null,
    },
    reducers: {
        save(state, {payload}) {
            const {data : list , total, page} = payload ;
            return {...state, list, total, page};
        },
    },
    effects: {
        *fetch({payload: {page = 1}}, {call, put}) {
            const {data, headers} = yield call(adminMenuService.fetch, {page});
            // TODO 此处可以查看异步请求的数据格式哦 然后根据格式解析payload  console.log(data) ;
            yield put({
                type: 'save',
                payload: {
                    data:data.data,
                    total: parseInt(headers['x-total-count'], 10), // 此header头 在util/request.js 中被填充了
                    page: parseInt(page, 10),
                },
            });
        },
        *remove({payload: id}, {call, put}) {
            yield call(adminMenuService.remove, id);
            yield put({type: 'reload'});
        },
        *patch({payload: {id, values}}, {call, put}) {
            yield call(adminMenuService.patch, id, values);
            yield put({type: 'reload'});
        },
        *create({payload: values}, {call, put}) {
            yield call(adminMenuService.create, values);
            yield put({type: 'reload'});
        },
        *reload(action, {put, select}) {
            const page = yield select(state => state.admin_menu.page);
            yield put({type: 'fetch', payload: {page}});
        },
    },
    subscriptions: {
        setup({dispatch, history}) {
            return history.listen(({pathname, query}) => {
                if (pathname === '/admin-menu') {
                    dispatch({type: 'fetch', payload: query});
                }
            });
        },
    },
};
