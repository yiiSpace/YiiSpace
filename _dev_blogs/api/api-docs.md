生成api文档
=========

常见方案

- 提取代码注释来生成文档
- 手动从零编写文档
- 代码跟某个对应的文件夹关联形成文档

只说下第三中方法
--------------------

为某个api模块|类 在某个目录下对应存放其api文档描述，描述可以是该语言的一种数据结构（比如php的array， js 的json ...）
  也可采用通用的文件格式：xml,json,yaml 来描述。
  
联动修改，当api签名修改后文档一般跟着也要修改。 

这种方法见：[scylla-api-doc](https://github.com/scylladb/scylla/tree/master/api/api-doc)  
 
 
 - https://scotch.io/tutorials/speed-up-your-restful-api-development-in-node-js-with-swagger