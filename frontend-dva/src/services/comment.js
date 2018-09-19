import request from '../utils/request';
import { PAGE_SIZE } from '../constants';

export function fetch({ page }) {
    // return request(`/api_x/comment?_page=${page}&_limit=${PAGE_SIZE}`);
    return request(`/api_x/comment?page=${page}&per-page=${PAGE_SIZE}`); // 这里后端api的约定可能不一样 此处遵循yii的
}

export function view(id) {
    return request(`/api_x/comment/${id}`, {
        method: 'GET',
    });
}

export function remove(id) {
    return request(`/api_x/comment/${id}`, {
        method: 'DELETE',
    });
}

export function patch(id, values) {
    return request(`/api_x/comment/${id}`, {
        method: 'PATCH',
        body: JSON.stringify(values),
    });
}

export function create(values) {
    return request('/api_x/comment', {
        method: 'POST',
        body: JSON.stringify(values),
    });
}
