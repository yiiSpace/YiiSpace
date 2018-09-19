https://getcomposer.org/doc/05-repositories.md#path

~~~json
{
    "repositories": [
        {
            "type": "path",
            "url": "../../packages/my-package"
        }
    ],
    "require": {
        "my/package": "*"
    }
}
~~~
还需要在你自己的 package 的composer中 添加version字段

```json
{
    "name": "year/gii-dva",
    "description": "this ext is used to generate dva module",
    "version": "1.0.0"
}
```

版本问题 后续继续研究?... 

本地包可能会使用 symlink 硬链接安装的！ 但可以强制不使用

如果项目类型是：yii2-extension
yii-composer 扩展会专门处理的！


注意路径 可以是相对跟绝对的 

最好在*项目的根目录*测试下
> cd ../../packages/my-package

如果路径确实存在 才证明你写对着 不然路径有可能写错呢