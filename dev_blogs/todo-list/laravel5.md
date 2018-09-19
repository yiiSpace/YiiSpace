以下特性有空实现为yii2扩展
=================

自动转化字段类型
----------------

```
    
    At the top of your model, add the following code:
    protected $casts = [
    'is_admin' => 'boolean',
    ];
    In this array, we define the attribute and what data type we actually want. Then,
    when we retrieve an attribute from the model, it will be cast to the specified data type.
    Other data types that model attributes can be cast to are as follows:
    • string
    • integer
    • real
    • float
    • double
    • array
    The array type can be used for columns that contain a serialized JSON string, which
    will de-serialize the data and present it as a plain PHP array.

```