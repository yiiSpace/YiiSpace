##  未完

-  解析出 route 到  某个类的方法的映射后  中间可以用aop 思想进行各种处理

比如使用  __call __callStatic  等魔术方法来动态代理到真实的 对象方法上

可以调用方法前 可以触发事件  或者钩子

## 服务类 CRUD 设计
- 参考 [ qiangxue/golang-restful-starter-kit
](https://github.com/qiangxue/golang-restful-starter-kit/blob/master/services/artist.go)