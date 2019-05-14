import request from '@/utils/request'
// import { Blog } from 'Blog'
import { blogs } from './mock-blogs'

const db = blogs
const resourceUrl = '/article'
const batchDeleteUrl = '/article/batch-delete'
const batchEditUrl = '/article/batch-edit'

// -------------------------------------------------------------------------------------------------  +|
// ## helper method
function getIndexById(id) {
  let idx = 0 // 有人用-1 表示未找到
  for (idx in db) {
    if (db[idx]['id'] === id) {
      return idx
    }
  }
  return idx
}

function buildPromise(resolveRejectCallback) {
  var p = new Promise(function(resolve, reject) {
    setTimeout(function() {
      // TODO 参数必须是函数检测
      resolveRejectCallback(resolve, reject)
    }, 1000)
  })
  return p
}

function pagination(pageNo, pageSize, array) {
  var offset = (pageNo - 1) * pageSize
  return (offset + pageSize >= array.length) ? array.slice(offset, array.length) : array.slice(offset, offset + pageSize)
}
// -------------------------------------------------------------------------------------------------  +|

function query(query) {
  /*
    return request({
    url: '/article/list',
    method: 'get',
    params: query
  })
  */
  var p = new Promise(function(resolve, reject) {
    setTimeout(function() {
      // alert('hi im in promise !')
      if (query && query.page && query.pageSize) {
        resolve(pagination(query.page, query.pageSize, db))
      } else {
        resolve(db)
      }
      // alert('hi im in promise end !')
    }, 1000)
  })
  return p
}

function getOne(id) {
  let result = null
  var idx = getIndexById(id)
  if (idx) {
    result = db[idx]
  }
  var p = new Promise(function(resolve, reject) {
    // TODO 如果找到了 就resolve 否则就reject
    setTimeout(function() {
      // alert('hi im in promise !')
      resolve(result)
      // alert('hi im in promise end !')
    }, 1000)
  })
  return p
  /*
  return request({
    url: resourceUrl, // '/article/detail',
    method: 'get',
    params: { id: id }
  })
  */
}

function create(data) {
  return request({
    url: resourceUrl, // '/article/create',
    method: 'post',
    data
  })
}

function update(id, data) {
  return request({
    url: resourceUrl, // '/article/update',
    method: 'put',
    params: { id: id },
    data
  })
}

function remove(id) {
  var idx = getIndexById(id)
  if (idx) {
    db.splice(idx, 1)
  }
  return buildPromise(function(resolve, reject) {
    resolve('success')
  })
  /*
  return request({
    url: resourceUrl, // '/article/update',
    method: 'delete',
    params: { id: id }
  })
  */
}
function batchDelete(ids) {
  ids.forEach(function(id) {
    var idx = getIndexById(id)
    if (idx) {
      db.splice(idx, 1)
    }
  })
  console.log(batchDeleteUrl) // 读取下变量  消除"定义 未使用"的警告
  return buildPromise(function(resolve, reject) {
    resolve('success')
  })
  /*
  return request({
    url: batchDeleteUrl, // '/article/update',
    method: 'delete',
    params: { id: id }
  })
  */
}

function batchEdit(data) {
  //
  // return buildPromise(function(resolve, reject) {
  //   console.log(data)
  //   resolve('success')
  // })
  return request({
    url: batchEditUrl, // '/article/update',
    method: 'put',
    data: data
  })
}

export const service = {
  query,
  getOne,
  create,
  update,
  remove,
  batchDelete,
  batchEdit
}

export default service
