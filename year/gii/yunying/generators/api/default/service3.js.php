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
/* @var $generator year\gii\yunying\generators\api\Generator */

 ;

?>
//  https://developer.okta.com/blog/2018/02/15/build-crud-app-vuejs-node

import Vue from 'vue'
import axios from 'axios'

const client = axios.create({
    baseURL: 'http://localhost:8081/',
    json: true
})

export default {
    async execute (method, resource, data) {
    // inject the accessToken for each request
    let accessToken = await Vue.prototype.$auth.getAccessToken()
    return client({
        method,
        url: resource,
        data,
        headers: {
            Authorization: `Bearer ${accessToken}`
        }
    }).then(req => {
        return req.data
    })
},
getPosts () {
    return this.execute('get', '/posts')
},
getPost (id) {
    return this.execute('get', `/posts/${id}`)
},
createPost (data) {
    return this.execute('post', '/posts', data)
},
updatePost (id, data) {
    return this.execute('put', `/posts/${id}`, data)
},
deletePost (id) {
    return this.execute('delete', `/posts/${id}`)
}
}

