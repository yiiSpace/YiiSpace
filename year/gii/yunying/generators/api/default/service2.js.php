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
// see https://github.com/MarczakIO/netcore-vuejs-cosmosdb-crud/blob/master/App/Services/TodoService.js
export default {
    getAll: () => {
    return fetch('/api/Todo/GetAll', {
        method: 'get',
        headers: {'Content-Type': 'application/json'}
    }).then(function (response) {
        return response.json();
    }).then(function (response) {
        return response;
    });
},
create: (item) => {
    var data = JSON.stringify(item);
    return fetch('/api/Todo/Create', {
        method: 'post',
        headers: {'Content-Type': 'application/json'},
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (response) {
        return response;
    });
},
update: (item, newValue) => {
    var updateItem = { ...item, name: newValue }
    var data = JSON.stringify(updateItem);
    return fetch('/api/Todo/Update', {
        method: 'post',
        headers: {'Content-Type': 'application/json'},
        body: data
    }).then(function (response) {
        return response.json();
    }).then(function (response) {
        return response;
    });
},
delete: (item) => {
    var data = JSON.stringify(item);
    return fetch('/api/Todo/Delete', {
        method: 'post',
        headers: {'Content-Type': 'application/json'},
        body: data
    }).then(function (response) {
        return response;
    });
}
}

