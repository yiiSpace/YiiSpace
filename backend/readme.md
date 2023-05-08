
后台设计
----

ui｜framework 选型考虑：

最小化代码编写 毕竟后台功能是给管理人员看的 不一定如前台那么花哨
所以一般选择原有的yii官方ui库就可以 比如bootstrap

前后分离 主要是考虑到后端如果做大了 可以换成其他语言比如go 这样关注点分离 也容易替换 各自进化发展 也有更多选择
不利点就是复杂度提高了 需要掌握多种技术栈 适合团队作战


## bootstrap框架

也有很多优秀的基于bootstrap的框架可以选择 常用的就是
adminlite 也有多个版本可以选择 最近的是[adminlte3](https://adminlte.io/docs/3.2/implementations.html)


composer.json 在require配置段天津依赖 或者
~~~sh

composer require "hail812/yii2-adminlte3=~1.1"

~~~
