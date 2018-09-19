import request from '../utils/request';
import { PAGE_SIZE } from '../constants';

export function fetch({ page }) {
    // return request(`/api_x/admin_menu?_page=${page}&_limit=${PAGE_SIZE}`);
    return request(`/api_x/admin_menu?page=${page}&per-page=${PAGE_SIZE}`); // 这里后端api的约定可能不一样 此处遵循yii的
}

export function view(id) {
    return request(`/api_x/admin_menu/${id}`, {
        method: 'GET',
    });
}

export function remove(id) {
    return request(`/api_x/admin_menu/${id}`, {
        method: 'DELETE',
    });
}

export function patch(id, values) {
    return request(`/api_x/admin_menu/${id}`, {
        method: 'PATCH',
        body: JSON.stringify(values),
    });
}

export function create(values) {
    return request('/api_x/admin_menu', {
        method: 'POST',
        body: JSON.stringify(values),
    });
}
