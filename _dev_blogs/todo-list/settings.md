设置模块
========

每个网站基本都有设置功能 为了增强自定义功能 除了把配置写在配置文件中（程序员做这件事情）
另一种选择针对用户的友好方式是暴露UI接口  把配置写到db去

比较好的一些settings实现：
----------

- [yii2-settings @phemellc](https://github.com/phemellc/yii2-settings)
- [yii2-settings @yii2mod](https://github.com/yii2mod/yii2-settings)
- [yii2-settings @johnitvn](https://github.com/johnitvn/yii2-settings)
- [yii2-options @twisted1919](https://github.com/twisted1919/yii2-options)
- [yii2-settings @platx](https://github.com/platx/yii2-settings) yii1项目移植 比较简洁的一个实现


后续增强
----------
完整支持：
-  db存储支持  所有的settings实现基本都支持存储设置到db  个别的还支持存储类型多样化（string int boolean float 等）
    最简形式只需要string类型的值即可 存储时做序列化（serialize json化）  使用时反序列化
-  针对某个|组 配置设计一个表单模型 用来存储对应的value值 当存储的是数组时 其实隐含可以使用一个表单来让用户在UI上
    输入这些设置
-  再深入的做法 类似电商中类型设置 对于某个新增的商品类型  需要设置其字段 需要哪些属性 属性的类型  属性的表单输入类型
    属性的验证规则 ....  做的更完善些  就需要再用一个界面来完成动态配置表单的设计。可用扩展：
    [yii2-dynamicform](https://github.com/wbraganca/yii2-dynamicform)  还有 [yii2-form-builder](https://github.com/MetalGuardian/yii2-form-builder)