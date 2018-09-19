// import request from '@/utils/request'
// @see https://blog.csdn.net/qq_28506819/article/details/75733601

var a = 'my name is qing'

var b = ' my name is yiqing'

var c = ' my name is yiqing'

var q = function() {
}

var all = { a, b, c, q }

export { a, b, c as x, q }

// 导出常量 单例特征
export const sqrt = Math.sqrt

export function add(x, y) {
  return x + y
}

export default all

// ============================================================
//       整个模块的导入：

// import * as lib from 'lib';
// lib.SomeId...
