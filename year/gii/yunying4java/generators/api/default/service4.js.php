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
/* @var $generator year\gii\yunying4java\generators\api\Generator */

 ;

?>
import axios from 'axios';
import { Todo } from './todo';

const api = 'api';

class TodoService {
    deleteTodo(todo: Todo) {
        return axios.delete(`${api}/todo/${todo.id}`);
    }
    getTodoes() {
        return axios.get<Todo[]>(`${api}/todoes`);
    }
    addTodo(todo: Todo) {
        return axios.post(`${api}/todo/`, { todo });
    }
    updateTodo(todo: Todo) {
        return axios.put(`${api}/todo/${todo.id}`, { todo });
    }
}

// Export a singleton instance in the global namespace
export const todoService = new TodoService();

